<?php
Class Simdaftarskripsi extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m','simdaftarskripsi_m','masmahasiswa_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata('cari_simdaftarskripsi', $this->input->post('txtCari'));
		}else{
			$this->session->set_userdata('cari_simdaftarskripsi', '');
		}
		$this->browse();
	}
	function browse(){
		$data['title'] = 'Daftar Data Pendaftar KP/TA/Skripsi';
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->simdaftarskripsi_m->count_all($this->session->userdata('cari_simdaftarskripsi'));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/simdaftarskripsi_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_simdaftarskripsi"] = $this->simdaftarskripsi_m->get_all($data['no'],$perpage,$this->session->userdata('cari_simdaftarskripsi'));
		$this->load->view("admin/simdaftarskripsi/tsimdaftarskripsi_v",$data);
	}
	function save_admin(){
		$config = array(
			array(
				'field'   => 'nim',
				'label'   => 'NIM',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jenisdaftar',
				'label'   => 'Jenis Pendaftaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'statusdaftar',
				'label'   => 'Status Pendaftaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pembimbing1',
				'label'   => 'Pembimbing 1',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pembimbing2',
				'label'   => 'Pembimbing 2',
				'rules'   => 'required'
			),
			array(
				'field'   => 'judulskripsi',
				'label'   => 'Judul',
				'rules'   => 'required'
			),
			array(
				'field'   => 'thajaran',
				'label'   => 'Tahun Ajaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'nosk',
				'label'   => 'Nomor SK',
				'rules'   => 'required'
			),
			array(
				'field'   => 'tglsk',
				'label'   => 'Tgl. SK',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('iddaftarskripsi');
		if($this->form_validation->run() == FALSE){
		
		}else{
			
		}
	}
	function save(){
		$this->simdaftarskripsi_m->insert();
		redirect('admin/simdaftarskripsi/browse');
	}
	function edit($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$gn = $this->simdaftarskripsi_m->get_nim($id);
		$nim = $gn['nim'];
		$this->detail_mahasiswa($nim);
		$data['title'] = 'Pendaftaran KP/TA/Skripsi';
		$data['detail_simdaftarskripsi'] = $this->simdaftarskripsi_m->get_one2($id);
		$this->load->view('admin/simdaftarskripsi/esimdaftarskripsi_v', $data);
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
		$this->simdaftarskripsi_m->delete($this->uri->segment(4));
		redirect('admin/simdaftarskripsi/browse');
	}
}
?>