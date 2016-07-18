<?php
Class Simupload extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simupload_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals'));
	}
	function index(){
		$this->browse();
	}
	function browse($idkelas=''){
		$data['title'] = 'Daftar BAP Matakuliah';
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simupload_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'dosen/simupload/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_upload'] = $this->simupload_m->get_all($perpage, $data['no']);
		$this->load->view('dosen/simupload/tsimupload_v', $data);
	}
}
?>