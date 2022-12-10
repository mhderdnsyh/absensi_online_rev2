<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Docs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_moderator();
        $this->get_datasess = $this->db->get_where('pengguna', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('M_Front');
        $this->get_datasetupapp = $this->M_Front->fetchsetupapp();
        $timezone_all = $this->get_datasetupapp;
        date_default_timezone_set($timezone_all['timezone']);
    }

    //Fitur Print
    public function print()
    {
        if (!empty($this->input->get('idAbsen'))) {
            $id_absen = $this->input->get('idAbsen');       //ini ragu klo diubah jd $idAbsen tp error
            $querydata = $this->db->get_where('absensi', ['idAbsen' => $id_absen])->row_array();
            $data = [
                'dataapp' => $this->get_datasetupapp,
                'dataabsensi' => $querydata
            ];
            ob_clean();
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('layout/dataabsensi/printselfabsensi', $data, true);
            //$pdfFilePath = "storage/pdf_cache/absensipegawai_" . time() . "_download.pdf";
            $stylesheet = file_get_contents(FCPATH . 'assets/css/mpdf-bootstrap.css');
            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML(utf8_encode($html), \Mpdf\HTMLParserMode::HTML_BODY);
            $mpdf->SetTitle('Cetak Absen Pegawai');
            //$mpdf->Output(FCPATH . $pdfFilePath, "F");
            $mpdf->Output("absensipegawai_" . time() . "_self" . "_download.pdf", "I");
        } else {
            redirect(base_url('absensi'));
        }
    }

    public function export()
    {
        $validation = [
            [
                'field' => 'absen_tahun',
                'label' => 'Tahun Absen',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'absen_bulan',
                'label' => 'Bulan Absen',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ],
            [
                'field' => 'method_export_file',
                'label' => 'Metode Export File',
                'rules' => 'trim|required|xss_clean',
                'errors' => ['required' => 'You must provide a %s.', 'xss_clean' => 'Please check your form on %s.']
            ]
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $data = [
                'title' => 'Export Data',
                'user' => $this->get_datasess,
                'dataapp' => $this->get_datasetupapp
            ];
            $this->load->view('layout/header', $data);
            $this->load->view('layout/navbar', $data);
            $this->load->view('layout/sidebar', $data);
            $this->load->view('admin/exportfile', $data);
            $this->load->view('layout/footer', $data);
        } else {
            if (empty($this->input->post('nama_pegawai'))) {            //ini ragu mo diubah jd namaGtk sebelumnya nama_pegawai
                $querydata = $this->db->like('tglAbsen', htmlspecialchars($this->input->post('absen_bulan', true)))->like('tglAbsen', htmlspecialchars($this->input->post('absen_tahun', true)))->get_where('absensi')->result();
            } else {
                $querydata = $this->db->like('tglAbsen', htmlspecialchars($this->input->post('absen_bulan', true)))->like('tglAbsen', htmlspecialchars($this->input->post('absen_tahun', true)))->get_where('absensi', ['namaGtk' => htmlspecialchars($this->input->post('nama_pegawai', true))])->result();
            }
            if ($this->input->post('method_export_file') === 'pdf') {
                $data = [
                    'dataapp' => $this->get_datasetupapp,
                    'dataabsensi' => $querydata
                ];
                ob_clean();
                $mpdf = new \Mpdf\Mpdf();
                $html = $this->load->view('layout/dataabsensi/printallabsensi', $data, true);
                //$pdfFilePath = "storage/pdf_cache/absensipegawai_" . time() . "_download.pdf";
                $stylesheet = file_get_contents(FCPATH . 'assets/css/mpdf-bootstrap.css');
                $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
                $mpdf->WriteHTML(utf8_encode($html), \Mpdf\HTMLParserMode::HTML_BODY);
                $mpdf->SetTitle('Cetak Absen Pegawai');
                //$mpdf->Output(FCPATH . $pdfFilePath, "F");
                $mpdf->Output("absensipegawai_" . time() . "_bulanan" . "_download.pdf", "I");
            } elseif ($this->input->post('method_export_file') === 'excel') {

                $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $styleJudul = [
                    'font' => [
                        'bold' => true,
                        'size' => 15,
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'wrap' => true,
                    ],
                ];
                $dataapp = $this->get_datasetupapp;

                $sheet->setCellValue('A1', 'Rekap Data Absensi: ' . $dataapp['namaInstansi'] . '');
                $sheet->mergeCells('A1:H2');
                $sheet->getStyle('A1')->applyFromArray($styleJudul);
                $sheet->setCellValue('A3', 'Excel was generated on ' . date("Y-m-d H:i:s") . '');
                $sheet->mergeCells('A3:H3');
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('A5', 'No');
                $sheet->setCellValue('B5', 'Nama GTK');
                $sheet->setCellValue('C5', 'Tanggal Absensi');
                $sheet->setCellValue('D5', 'Jam Datang');
                $sheet->setCellValue('E5', 'Jam Pulang');
                $sheet->setCellValue('F5', 'Status Kehadiran');
                $sheet->setCellValue('G5', 'Keterangan Absensi');
                $sheet->setCellValue('H5', 'Titik Lokasi Maps');
                $sheet->getStyle('A5:F5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $dataabsensi = $querydata;
                $no = 1;
                $rowx = 6;
                foreach ($dataabsensi as $rowabsen) {
                    $sheet->setCellValue('A' . $rowx, $no++);
                    $sheet->setCellValue('B' . $rowx, $rowabsen->namaGtk);
                    $sheet->setCellValue('C' . $rowx, $rowabsen->tglAbsen);
                    $sheet->setCellValue('D' . $rowx, $rowabsen->jamMasuk);
                    $sheet->setCellValue('E' . $rowx, (empty($rowabsen->jamPulang)) ? 'Belum Absensi Pulang' : $rowabsen->jamPulang);
                    $sheet->setCellValue('F' . $rowx, ($rowabsen->statusGtk == 1) ? 'Sudah Absensi' : (($rowabsen->statusGtk == 2) ? 'Absensi Terlambat' : 'Belum Absensi'));
                    $sheet->setCellValue('G' . $rowx, $rowabsen->keteranganAbsen);
                    $sheet->setCellValue('H' . $rowx, (empty($rowabsen->mapsAbsen)) ? 'Lokasi Tidak Ditemukan' : (($rowabsen->mapsAbsen == 'No Location') ? 'Lokasi Tidak Ditemukan' : $rowabsen->mapsAbsen));
                    $rowx++;
                }
                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(28);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(38);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(38);

                $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $filename = "absensipegawai_" . time() . "_bulanan" . "_download";

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
            } else {
                $this->session->set_flashdata('exportinfo', '<div class="alert alert-danger" role="alert">Untuk export dengan metode ini belum tersedia!</div>');
                redirect(base_url('export'));
            }
        }
    }
}
