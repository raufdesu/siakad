<?php
Class Keujenisbayar extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('keujenisbayar_m', 'simprodi_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		$this->browse();
	}
	function prodi(){
		$this->session->set_userdata('sesi_jbprodi', $this->uri->segment(4));
		redirect('admin/keujenisbayar/browse');
	}
	function browse(){
		$data['title'] = 'Daftar Penentuan Pembayaran';
		$data['no'] = $this->uri->segment(4, 0);
		$data['prodi'] = $this->session->userdata('sesi_jbprodi');
		$data['total_page']	= $this->keujenisbayar_m->count_all($data['prodi']);
		$data['browse_prodi'] = $this->simprodi_m->select();
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/keujenisbayar_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_keujenisbayar"] = $this->keujenisbayar_m->get_all($data['no'],$perpage, $data['prodi']);
		$this->load->view("admin/keujenisbayar/tkeujenisbayar_v",$data);
	}
	function add(){
		$data['title'] = 'Tambah Daftar Penentuan Pembayaran';
		$data['browse_prodi'] = $this->simprodi_m->select();
		$this->load->view('admin/keujenisbayar/ikeujenisbayar_v', $data);
	}
	function edit(){
		$id = $this->uri->segment(4);
		$data['browse_prodi'] = $this->simprodi_m->select();
		$data['tk'] = $this->keujenisbayar_m->get_one($id);
		$data['title'] = 'Tambah Daftar Penentuan Pembayaran';
		$this->load->view('admin/keujenisbayar/ekeujenisbayar_v', $data);
	}
	function save(){
		$config = array(
			array(
				'field'   => 'jenisbayar',
				'label'   => 'Jenis Pembayaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'kodeprodi',
				'label'   => 'PRODI',
				'rules'   => 'required'
			),
			array(
				'field'   => 'totalbiaya',
				'label'   => 'Total Biaya',
				'rules'   => 'required'
			),
			array(
				'field'   => 'angkatan',
				'label'   => 'Tahun Angkatan',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('idjenisbayar');
		if($this->form_validation->run() == FALSE){
			$this->add();
		}else{
			$this->keujenisbayar_m->insert();
			$this->session->set_userdata('sesi_jbprodi', $this->input->post('kodeprodi'));
			redirect('admin/keujenisbayar');
		}
	}
	function delete(){
		$this->db->where('idjenisbayar', $this->uri->segment(4));
		$this->db->delete('keujenisbayar');
		redirect('admin/keujenisbayar');
	}
}
?>