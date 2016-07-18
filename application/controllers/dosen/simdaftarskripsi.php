<?php
Class Simdaftarskripsi extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simdaftarskripsi_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		$this->mhsbimbingan();
	}
	function change_jenisdaftar(){
		$this->session->set_userdata('sesi_jenisdaftar', $this->uri->segment(4));
		$this->mhsbimbingan();
	}
	function mhsbimbingan(){
		$npp = $this->session->userdata('sesi_user');
		$jenisdaftar = $this->session->userdata('sesi_jenisdaftar');
		$data['mhsdaftarskripsi'] = $this->simdaftarskripsi_m->get_bypembimbing($npp, $jenisdaftar);
		$this->load->view('dosen/simdaftarskripsi/tsimdaftarskripsi_v', $data);
	}
	function detail(){
		$id = $this->uri->segment(4);
		$data['dp'] = $this->simdaftarskripsi_m->get_byid($id);
		$this->load->view('dosen/simdaftarskripsi/tdsimdaftarskripsi_v', $data);
	}
}
?>