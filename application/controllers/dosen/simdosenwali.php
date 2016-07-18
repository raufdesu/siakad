<?php
Class Simdosenwali extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('masmahasiswa_m','simprodi_m','simsetting_m','simdosenwali_m','simdosenampu_m','masmahasiswa_m','simkurikulum_m'));
		$this->load->library(array('simpliparse','simplival','auth', 'pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		$this->session->set_userdata('sesi_mhs', $this->input->post('txtCari'));
		$this->browse();
	}
	function browse(){
		$cari = $this->session->userdata('sesi_mhs');
		$data['title'] = 'Daftar Mahasiswa Bimbingan Akademik';
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simdosenwali_m->count_bydosen($this->session->userdata('sesi_user'), $cari);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'dosen/simdosenwali/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_mhs'] = $this->simdosenwali_m->get_bydosen($data['no'], $perpage,$this->session->userdata('sesi_user'), $cari);
		$this->load->view('dosen/simdosenwali/tsimdosenwali_v', $data);
	}
	function detail_mhs($nim){
		$data['title'] = 'Detail Mahasiswa';
		$data['title'] = 'Detail Mahasiswa';
		$data['detail_masmahasiswa'] = $this->masmahasiswa_m->detail($nim);
		$this->load->view('dosen/tdmasmahasiswa_v', $data);
	}
}
?>