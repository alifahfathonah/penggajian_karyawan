<?php 

class LaporanAbsensi extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('hak_akses') != '1')
		{
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Anda Belum Login!
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
				redirect('welcome');
		}
	}

	public function index()
	{
		$data['title'] = "Laporan Absensi Pegawai";

		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/filterLaporanAbsensi');
		$this->load->view('templates_admin/footer');
	}

	public function cetakLaporanAbsensi()
	{
		$data['title'] = "Cetak Laporan Absensi Pegawai";
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$bulantahun = $bulan.$tahun;

		$data['lap_kehadiran']  = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin, data_jabatan.jabatan, data_kehadiran.hadir, data_kehadiran.sakit, data_kehadiran.alpha FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.jabatan=data_pegawai.jabatan
			WHERE data_kehadiran.bulan='$bulantahun'
			ORDER BY data_pegawai.nama_pegawai ASC
			")->result();

		$this->load->view('templates_admin/header',$data);
		$this->load->view('admin/cetakLaporanAbsensi',$data);
	}

}

?>