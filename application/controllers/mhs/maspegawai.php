<?php
Class Maspegawai extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model("maspegawai_m","",TRUE);
		$this->load->library(array('simpliparse','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata('cari_maspegawai', $this->input->post('txtCari'));
		}else{
			$this->session->set_userdata('cari_maspegawai', '');
		}
		$this->listview();
	}
	function browse_dosen(){ // BROWSE UNTUK MEMILIH DOSEN PEMBIMBING SKRIPSI KP TA
		if($this->uri->segment(4)){
			$this->session->set_userdata('sesi_pembimbing', $this->uri->segment(4));
		}
		$data['pilih'] = $this->session->userdata('sesi_pembimbing');
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->maspegawai_m->count_all();
		$perpage	= 50;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/maspegawai/listview/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_maspegawai"] = $this->maspegawai_m->select($data['no'],$perpage);
		$this->load->view("mhs/maspegawai/tdosen_v",$data);
	}
}
?>