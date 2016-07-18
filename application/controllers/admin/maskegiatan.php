<?php
Class Maskegiatan extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m','maskegiatan_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata('cari_maskegiatan', $this->input->post('txtCari'));
		}else{
			$this->session->set_userdata('cari_maskegiatan', '');
		}
		$this->browse();
	}
	function browse(){
		$data['title'] = 'Daftar Kegiatan Mahasiswa';
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->maskegiatan_m->count_all($this->session->userdata('cari_maskegiatan'));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/maskegiatan_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_maskegiatan"] = $this->maskegiatan_m->get_all($data['no'],$perpage,$this->session->userdata('cari_maskegiatan'));
		$this->load->view("admin/maskegiatan/tmaskegiatan_v",$data);
	}
	function save(){
		$config = array(
			array(
				'field'   => 'namakegiatan',
				'label'   => 'Nama Kegiatan',
				'rules'   => 'required'
			),
			array(
				'field'   => 'tglmulai',
				'label'   => 'Tgl. Mulai',
				'rules'   => 'required'
			),
			array(
				'field'   => 'tglselesai',
				'label'   => 'Tgl. Selesai',
				'rules'   => 'required'
			),
			array(
				'field'   => 'thajaran',
				'label'   => 'Tahun Ajaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'tingkat',
				'label'   => 'Tingkat',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pembimbing1',
				'label'   => 'TTD 1',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('idbeasiswa');
		if ($this->form_validation->run() == FALSE){
			$this->add();
		}else{
			$this->maskegiatan_m->insert();
			redirect('admin/maskegiatan/browse');
		}
	}
	function edit($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$data['title'] = 'Edit Data Kegiatan';
		$data['detail_maskegiatan'] = $this->maskegiatan_m->get_one2($id);
		$this->load->view('admin/maskegiatan/emaskegiatan_v', $data);
	}
	function add(){
		$data['title'] = 'Tambah Daftar Kegiatan';
		$this->load->view('admin/maskegiatan/imaskegiatan_v', $data);
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
		$this->maskegiatan_m->delete($this->uri->segment(4));
		redirect('admin/maskegiatan/browse');
	}
}
?>