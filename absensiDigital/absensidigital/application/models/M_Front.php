<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Front extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $this->get_today_date = $hari[(int)date("w")] . ', ' . date("j ") . $bulan[(int)date('m')] . date(" Y");
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->appsetting = $this->db->get_where('pengaturan', ['statusSetting' => 1])->row_array();
    }

    public function fetchsetupapp()
    {
        return $this->db->get_where('pengaturan')->row_array();
    }

    public function fetchdashboard()
    {
        return $this->db->get_where('pengguna')->row_array();
    }

    public function fetchdbabsen($kode_pegawai)         //ini ragu jd $kodeGtk apa engga
    {
        $today = $this->get_today_date;
        return $this->db->get_where('absensi', ['kodeGtk' => $kode_pegawai, 'tglAbsen' => $today])->row_array();
    }

    public function crudabs($typesend)
    {
        if ($typesend == 'delabs') {
            $this->db->delete('absensi', ['idAbsen' => htmlspecialchars($this->input->post('absen_id', true))]);
        } elseif ($typesend == 'delallabs') {
            $this->db->truncate('absensi');
        }
    }

    public function do_absen()
    {
        $appsettings = $this->appsetting;
        $today = $this->get_today_date;
        $clocknow = date("H:i:s");
        if (strtotime($clocknow) >= strtotime($appsettings['absenMulai']) && strtotime($clocknow) <= strtotime($appsettings['absenMulaiTo'])) {
            if ($this->db->get_where('absensi', ['tglAbsen' => $today, 'kodeGtk' => $this->get_datasess['kodeGtk']])->row_array()) {
                $data = [
                    'jamMasuk' => $clocknow
                ];
                $this->db->where('tglAbsen', $today)->where('kodeGtk', $this->get_datasess['kodeGtk']);
                $this->db->update('absensi', $data);
            } else {
                $data = [
                    'namaGtk' => $this->get_datasess['namaLengkap'],
                    'kodeGtk' => $this->get_datasess['kodeGtk'],
                    'jamMasuk' => $clocknow,
                    'idAbsen' => uniqid('absen_'),
                    'tglAbsen' => $today,
                    'keteranganAbsen' => htmlspecialchars($this->input->post('ket_absen', true)),
                    'statusGtk' => 1,
                    'mapsAbsen' => $appsettings['mapsUse'] == TRUE ? htmlspecialchars($this->input->post('maps_absen', true)) : 'No Location'
                ];
                $this->db->insert('absensi', $data);
            }
        } elseif (strtotime($clocknow) > strtotime($appsettings['absenMulaiTo']) && strtotime($clocknow) >= strtotime($appsettings['absenPulang'])) {
            if ($this->db->get_where('absensi', ['tglAbsen' => $today, 'kodeGtk' => $this->get_datasess['kodeGtk']])->row_array()) {
                $data = [
                    'jamPulang' => $clocknow
                ];
                $this->db->where('tglAbsen', $today)->where('kodeGtk', $this->get_datasess['kodeGtk']);
                $this->db->update('absensi', $data);
            } else {
                $data = [
                    'namaGtk' => $this->get_datasess['namaLengkap'],
                    'kodeGtk' => $this->get_datasess['kodeGtk'],
                    'jamMasuk' => $clocknow,
                    'idAbsen' => uniqid('absen_'),
                    'tglAbsen' => $today,
                    'keteranganAbsen' => htmlspecialchars($this->input->post('ket_absen', true)),
                    'statusGtk  ' => 2,
                    'mapsAbsen' => $appsettings['mapsUse'] == TRUE ? htmlspecialchars($this->input->post('maps_absen', true)) : 'No Location'
                ];
                $this->db->insert('absensi', $data);
            }
        } elseif (strtotime($clocknow) > strtotime($appsettings['absenMulaiTo']) && strtotime($clocknow) <= strtotime($appsettings['absenPulang'])) {
            $data = [
                'namaGtk' => $this->get_datasess['namaLengkap'],
                'kodeGtk' => $this->get_datasess['kodeGtk'],
                'jamMasuk' => $clocknow,
                'idAbsen' => uniqid('absen_'),
                'tglAbsen' => $today,
                'keteranganAbsen' => htmlspecialchars($this->input->post('ket_absen', true)),
                'statusGtk' => 2,
                'mapsAbsen' => $appsettings['mapsUse'] == TRUE ? htmlspecialchars($this->input->post('maps_absen', true)) : 'No Location'
            ];
            $this->db->insert('absensi', $data);
        }
    }
}
