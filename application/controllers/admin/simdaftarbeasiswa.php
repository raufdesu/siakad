<?php
Class Simdaftarbeasiswa extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m','simdaftarbeasiswa_m','masmahasiswa_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata('cari_simdaftarbeasiswa', $this->input->post('txtCari'));
		}else{
			$this->session->set_userdata('cari_simdaftarbeasiswa', '');
		}
		$this->browse();
	}
	function browse(){
		$data['title'] = 'Daftar Data Pendaftar Beasiswa';
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->simdaftarbeasiswa_m->count_all($this->session->userdata('cari_simdaftarbeasiswa'));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/simdaftarbeasiswa_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_simdaftarbeasiswa"] = $this->simdaftarbeasiswa_m->get_all($data['no'],$perpage,$this->session->userdata('cari_simdaftarbeasiswa'));
		$this->load->view("admin/simdaftarbeasiswa/tsimdaftarbeasiswa_v",$data);
	}
	function save(){
		$config = array(
			array(
				'field'   => 'nim',
				'label'   => 'NIM',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jenisbeasiswa',
				'label'   => 'Jenis Beasiswa',
				'rules'   => 'required'
			),
			array(
				'field'   => 'status',
				'label'   => 'Status Pendaftaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'thajaran',
				'label'   => 'Tahun Ajaran',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('iddaftarbeasiswa');
		if ($this->form_validation->run() == FALSE){
			$this->edit($id);
		}else{
			$this->simdaftarbeasiswa_m->insert();
			redirect('admin/simdaftarbeasiswa/browse');
		}
	}
	function edit($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$gn = $this->simdaftarbeasiswa_m->get_nim($id);
		$nim = $gn['nim'];
		$this->detail_mahasiswa($nim);
		$data['title'] = 'Pendaftaran Beasiswa';
		$data['detail_simdaftarbeasiswa'] = $this->simdaftarbeasiswa_m->get_one2($id);
		$this->load->view('admin/simdaftarbeasiswa/esimdaftarbeasiswa_v', $data);
	}
	function detail_mahasiswa($nim){
		$dm = $this->masmahasiswa_m->get_one($nim);
		$arsesi = array(
			'sesi_krs_nim' => $dm['nim'],
			'sesi_krs_nama' => $dm['nama'],
			'sesi_krs_prodi' => $dm['nama_prodi'],
			'sesi_krs_prefprodi' => $dm['pref_prodi'],
			'sesi_krs_kelas' => $dm['kdkelas']
		);
		$this->session->set_userdata($arsesi);
		$data['nama_matkul'] = '';
	}
	function delete(){
		$this->simdaftarbeasiswa_m->delete($this->uri->segment(4));
		redirect('admin/simdaftarbeasiswa/browse');
	}
}
?>