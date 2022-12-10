<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Settings extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->appsetting = $this->db->get_where('pengaturan', ['statusSetting' => 1])->row_array();
    }

    public function init_setting($typeinit)
    {
        if ($typeinit == 1) {
            $data = [
                'statusSetting' => 1,
                'namaInstansi' => '[Ubah Nama Instansi]',
                'jumbotronLeadSet' => '[Ubah Text Berjalan Halaman Depan Disini Pada Setting Aplikasi]',
                'namaAppAbsensi' => 'Absensi Online',
                'logoInstansi' => 'default-logo.png',
                'timezone' => 'Asia/Jakarta',
                'absenMulai' => '06:00:00',
                'absenMulaiTo' => '11:00:00',
                'absenPulang' => '16:00:00',
                'mapsUse' => 0
            ];
            $old_image = $this->appsetting['logoInstansi'];
            if ($old_image != 'default-logo.png') {
                unlink(FCPATH . 'storage/setting/' . $old_image);
            }
            $this->db->get_where('pengaturan', ['statusSetting' => 1])->row_array();
            $this->db->update('pengaturan', $data);
            $this->db->update('pengguna', ['instansi' => '[Ubah Nama Instansi]']);
        } elseif ($typeinit == 2) {
            $data = [
                'statusSetting' => 1,
                'namaInstansi' => '[Ubah Nama Instansi]',
                'jumbotronLeadSet' => '[Ubah Text Berjalan Halaman Depan Disini Pada Setting Aplikasi]',
                'namaAppAbsensi' => 'Absensi Online',
                'logoInstansi' => 'default-logo.png',
                'timezone' => 'Asia/Jakarta',
                'absenMulai' => '06:00:00',
                'absenMulaiTo' => '11:00:00',
                'absenPulang' => '16:00:00',
                'mapsUse' => 0
            ];
            $this->db->insert('pengaturan', $data);
        }
    }
    public function update_setting()    //ganti jd atur()  cek ke controller jg jdkan atur()
    {

        $sendsave = [
            'namaInstansi' => htmlspecialchars($this->input->post('nama_instansi')),
            'jumbotronLeadSet' =>  htmlspecialchars($this->input->post('pesan_jumbotron')),
            'namaAppAbsensi' =>  htmlspecialchars($this->input->post('nama_app_absen')),
            'timezone' =>  htmlspecialchars($this->input->post('timezone_absen')),
            'absenMulai' =>  htmlspecialchars($this->input->post('absen_mulai')),
            'absenMulaiTo' =>  htmlspecialchars($this->input->post('absen_sampai')),
            'absenPulang' =>  htmlspecialchars($this->input->post('absen_pulang_sampai')),
            'mapsUse' =>  htmlspecialchars($this->input->post('lokasi_absensi'))
        ];

        $upload_image = $_FILES['logoInstansi']['name'];

        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
            $config['max_size']      = '2048';
            $config['encrypt_name'] = TRUE;
            $config['upload_path'] = '../public/storage/setting/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logoInstansi')) {
                $gbr = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = '../public/storage/setting/' . $gbr['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 300;
                $config['height'] = 300;
                $config['new_image'] = '../public/storage/setting/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $old_image = $this->appsetting['logoInstansi'];
                if ($old_image != 'default-logo.png') {
                    unlink(FCPATH . 'storage/setting/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('logoInstansi', $new_image);
            } else {
                return "default-logo.png";
            }
        }
        $this->db->set($sendsave);
        $this->db->where('statusSetting', 1);
        $this->db->update('pengaturan', $sendsave);
        $this->db->update('pengguna', ['instansi' => htmlspecialchars($this->input->post('nama_instansi'))]);
    }
}
