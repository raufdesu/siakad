<?php
Class Simyudisium extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array("simyudisium_m"));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
	}
	function index(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata('cari_noyudisium', $this->input->post('txtCari'));
		}else{
			$this->session->set_userdata('cari_noyudisium', '');
		}
		$this->browse();
	}
	function browse(){
		$data['title'] = 'Daftar Nomor Yudisium';
		$data['no'] = $this->uri->segment(4, 0);
		$cari = $this->session->userdata('cari_noyudisium');
		$data['total_page']	= $this->simyudisium_m->count_all($cari);
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/simyudisium/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_simyudisium"] = $this->simyudisium_m->get_all($data['no'], $perpage, $cari);
		$this->load->view('admin/simyudisium/tsimyudisium_v', $data);
	}
	function input(){
		$data['title'] = 'Form Yudisium';
		$this->load->view('admin/simyudisium/isimyudisium_v', $data);
	}
	function edit(){
		$data['title'] = 'Form Edit Yudisium';
		$idyudisium = $this->uri->segment(4);
		$data['yud'] = $this->simyudisium_m->get_one($idyudisium);
		$this->load->view('admin/simyudisium/esimyudisium_v', $data);
	}
	function save(){
		$config = array(
				array(
					  'field'   => 'noyudisium',
					  'label'   => 'Nomor Yudisium',
					  'rules'   => 'required'
				   )
				 );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if ($this->form_validation->run() == FALSE){
			$this->input();
		}else{
			$this->simyudisium_m->insert();
			redirect('admin/simyudisium');
		}
	}
	function delete(){
		$this->db->where('idyudisium', $this->uri->segment(4));
		$this->db->delete('simyudisium');
		redirect('admin/simyudisium');
	}
	// function save(){
		// if($this->session->userdata('sesi_nimmhs')){
			// $this->simyudisium_m->insert();
			// redirect('admin/simtranskrip/cetak', 'refresh');
		// }else{
			// $this->simplival->alert('PERINGATAN\nSesi Habis, Harap Tentukan NIM Mahasiswa Lagi');
			// return false;
		// }
	// }
}
?>