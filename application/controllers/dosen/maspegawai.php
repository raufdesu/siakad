<?php
Class Maspegawai extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('masmahasiswa_m','simprodi_m','simsetting_m','maspegawai_m','simdosenampu_m','masmahasiswa_m','simkurikulum_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		$this->browse();
	}
	function browse(){
		$data['title'] = 'Daftar Mahasiswa Bimbingan Akademik';
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->maspegawai_m->count_bydosen($this->session->userdata('sesi_user'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'dosen/maspegawai/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_mhs'] = $this->maspegawai_m->get_bydosen($data['no'], $perpage,$this->session->userdata('sesi_user'));
		$this->load->view('dosen/tmaspegawai_v', $data);
	}
	function edit(){
		$user = $this->session->userdata('sesi_user');
		$data['detail_maspegawai'] = $this->maspegawai_m->detail($user);
		$this->load->view('dosen/maspegawai/emaspegawai_v', $data);
	}
	function update(){
		$config = array(
				array(
					  'field'   => 'npp',
					  'label'   => 'NPP',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'nama',
					  'label'   => 'Nama',
					  'rules'   => 'required'
				   )
				 );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error"> * ', '</span><br />');
		if($this->form_validation->run() == FALSE){
			$this->edit();
		}else{
			$this->maspegawai_m->update();
			redirect('dosen/maspegawai/biodata');
		}
	}
	function biodata(){
		$user = $this->session->userdata('sesi_user');
		$data['title'] = 'Detail Mahasiswa';
		$data['detail_maspegawai'] = $this->maspegawai_m->detail($user);
		$this->load->view('dosen/maspegawai/tdbiodata_v', $data);
	}
}
?>