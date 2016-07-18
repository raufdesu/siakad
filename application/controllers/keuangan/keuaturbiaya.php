<?php
Class Keuaturbiaya extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('keubiaya_m', 'keuaturbiaya_m', 'simprodi_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		/* $encoded = "JHRoaXMtPmJyb3dzZSgpOw==";
		eval(base64_decode($encoded)); */
		$this->browse();
	}
	function tentukan_pembayaran(){
		$aturbiaya = $this->keuaturbiaya_m->get_one($this->uri->segment(4));
		$namabiaya = $aturbiaya->namabiaya;
		$jenis = $aturbiaya->jenis;
		$kategori = $aturbiaya->kategori;
		if($kategori == 'Persemester'){
			$thajaran = $aturbiaya->thajaran;
		}else{
			$thajaran = $this->session->userdata('sesi_thajaran');
		}
		$jumbiaya = angka_utuh($aturbiaya->jumbiaya);
		if($thajaran){
			$this->keubiaya_m->import($aturbiaya->kodeprodi, $aturbiaya->angkatan, $aturbiaya->gelombang, $namabiaya, $thajaran, $jumbiaya, $jenis, $kategori);
		}
		$this->keuaturbiaya_m->update_status($aturbiaya->idaturbiaya, $aturbiaya->status);
		redirect('keuangan/keuaturbiaya');
	}
	function prodi(){
		$this->session->set_userdata('sesi_jbprodi', $this->uri->segment(4));
		redirect('keuangan/keuaturbiaya/browse');
	}
	/* function kategori(){
		$this->session->set_userdata('sesi_namaktegori', $this->uri->segment(4));
		redirect('keuangan/keuaturbiaya/browse');
	} */
	function angkatan(){
		$this->session->set_userdata('sesi_angkatan', $this->uri->segment(4));
		redirect('keuangan/keuaturbiaya/browse');
	}
	function browse(){
		$data['title'] = 'Daftar Biaya-Biaya';
		$data['no'] = $this->uri->segment(4, 0);
		/* $data['namakategori'] = $this->session->userdata('sesi_namaktegori'); */
		$data['angkatan'] = $this->session->userdata('sesi_angkatan');
		$data['prodi'] = $this->session->userdata('sesi_jbprodi');
		$data['total_page']	= $this->keuaturbiaya_m->count_all($data['prodi'], $data['angkatan']);
		$data['browse_angkatan'] = $this->keuaturbiaya_m->get_angkatan();;
		/* $data['kategori'] = $this->auth->get_enum('keuaturbiaya', 'kategori'); */
		$data['browse_prodi'] = $this->simprodi_m->select();
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'keuangan/keuaturbiaya/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data['browse_keuaturbiaya'] = $this->keuaturbiaya_m->get_all($data['no'],$perpage, $data['prodi'], $data['angkatan']);
		$this->load->view("keuangan/keuaturbiaya/tkeuaturbiaya_v",$data);
	}
	function cetak(){
		$data['title'] = 'Daftar Biaya-Biaya';
		$data['no'] = $this->uri->segment(4, 0);
		$data['angkatan'] = $this->session->userdata('sesi_angkatan');
		$data['prodi'] = $this->session->userdata('sesi_jbprodi');
		$data['total_page']	= $this->keuaturbiaya_m->count_all($data['prodi'], $data['angkatan']);
		$data['browse_angkatan'] = $this->keuaturbiaya_m->get_angkatan();;
		$data['browse_prodi'] = $this->simprodi_m->select();
		$perpage	= $data['total_page'];
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'keuangan/keuaturbiaya_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data['browse_keuaturbiaya'] = $this->keuaturbiaya_m->get_all($data['no'],$perpage, $data['prodi'], $data['angkatan']);
		$this->load->view("keuangan/keuaturbiaya/laporan/exportpengaturanbiaya_v", $data);
	}
	function add(){
		$data['title'] = 'Tambah Daftar Penentuan Biaya';
		$data['kategori'] = $this->auth->get_enum('keuaturbiaya', 'kategori');
		$data['browse_prodi'] = $this->simprodi_m->select();
		$this->load->view('keuangan/keuaturbiaya/ikeuaturbiaya_v', $data);
	}
	function edit($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$data['title'] = 'Ubah Daftar Penentuan Biaya';
		$data['kategori'] = $this->auth->get_enum('keuaturbiaya', 'kategori');
		$data['browse_prodi'] = $this->simprodi_m->select();
		$data['biaya'] = $this->keuaturbiaya_m->get_one($id);
		$this->load->view('keuangan/keuaturbiaya/ekeuaturbiaya_v', $data);
	}
	function save(){
		$config = array(
			array(
				'field'   => 'namabiaya',
				'label'   => 'Nama biaya',
				'rules'   => 'required'
			),
			array(
				'field'   => 'kodeprodi',
				'label'   => 'PRODI',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jumbiaya',
				'label'   => 'Besar biaya',
				'rules'   => 'required'
			),
			array(
				'field'   => 'kategori',
				'label'   => 'Kategori',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('idaturbiaya');
		if($this->form_validation->run() == FALSE){
			if($this->input->post('idaturbiaya')){
				$this->edit($this->input->post('idaturbiaya'));
			}else{
				$this->add();
			}
		}else{
			$this->keuaturbiaya_m->insert();
			$this->session->set_userdata('sesi_jbprodi', $this->input->post('kodeprodi'));
			redirect('keuangan/keuaturbiaya');
		}
	}
	function delete(){
		$idaturbiaya = $this->uri->segment(4);
		$this->keuaturbiaya_m->delete($idaturbiaya);
		redirect('keuangan/keuaturbiaya');
	}
}
?>