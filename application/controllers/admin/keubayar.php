<?php
Class Keubayar extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m', 'keubayar_m', 'masmahasiswa_m', 'keujenisbayar_m', 'simprodi_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		if($this->session->userdata('sesi_status') == 'ketua'){
			redirect('admin/keubayar/laporan');
		}else{
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_keubayar', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_keubayar', '');
			}
			$this->add();
		}
	}
	function change_thajaran(){
		$this->session->set_userdata('sesi_thajaranbayar', $this->uri->segment(4));
		$this->add();
	}
	function change_thajaran2(){
		$this->session->set_userdata('sesi_thajaranbayar', $this->uri->segment(4));
		redirect('admin/keubayar/laporan');
	}
	function change_thajaran3(){
		$this->session->set_userdata('sesi_thajaranbayar', $this->uri->segment(4));
		$this->detail_bynim();
	}
	function prodi(){
		$this->session->set_userdata('sesi_prodikeumhs', $this->uri->segment(4));
		redirect('admin/keubayar/laporan');
	}
	function angkatan(){
		$this->session->set_userdata('sesi_angkatankeumhs', $this->uri->segment(4));
		redirect('admin/keubayar/laporan');
	}
	function laporan(){
		$prodi = $this->session->userdata('sesi_prodikeumhs');
		$angkatan = $this->session->userdata('sesi_angkatankeumhs');
		$data['browse_angkatan'] = $this->masmahasiswa_m->get_disangkatan();
		$data['browse_prodi'] = $this->simprodi_m->select();
		$data['browse_thajaran'] = $this->simsetting_m->select();
		if($this->session->userdata('sesi_thajaranbayar')){	
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbayar');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->keubayar_m->count_all($prodi, $angkatan, $data['thajaran']);
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/keubayar/laporan/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data['browse_keubayar'] = $this->keubayar_m->get_all($data['no'], $perpage, $prodi, $angkatan, $data['thajaran']);
		$this->load->view("admin/keubayar/tkeubayar_v", $data);
	}
	function export(){
		$data['extensi'] = $this->uri->segment(4);
		$prodi = $this->session->userdata('sesi_prodikeumhs');
		$angkatan = $this->session->userdata('sesi_angkatankeumhs');
		if($this->session->userdata('sesi_thajaranbayar')){
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbayar');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}
		$data['browse_keubayar'] = $this->keubayar_m->get_all('', '', $prodi, $angkatan, $data['thajaran']);
		$this->load->view("admin/keubayar/ckeubayar_v", $data);
	}
	function export2(){
		$data['extensi'] = $this->uri->segment(4);
		$prodi = $this->session->userdata('sesi_prodikeumhs');
		$angkatan = $this->session->userdata('sesi_angkatankeumhs');
		if($this->session->userdata('sesi_thajaranbayar')){
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbayar');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}
		$data['browse_keubayar'] = $this->keubayar_m->get_allbayar('', '', $prodi, $angkatan, $data['thajaran']);
		$this->load->view("admin/keubayar/ckeubayar2_v", $data);
	}
	function browse(){
		$data['title'] = 'Daftar Kegiatan Mahasiswa';
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->keubayar_m->count_all($this->session->userdata('cari_keubayar'));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/keubayar_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_keubayar"] = $this->keubayar_m->get_all($data['no'],$perpage,$this->session->userdata('cari_keubayar'));
		$this->load->view("admin/keubayar/tkeubayar_v",$data);
	}
	function save(){
		$config = array(
			array(
				'field'   => 'nim',
				'label'   => 'NIM',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jenisbayar',
				'label'   => 'Jenis pembayaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jumbayar',
				'label'   => 'Jumlah Bayar',
				'rules'   => 'required|is_natural_no_zero'
			),
			array(
				'field'   => 'thajaran',
				'label'   => 'Tahun Ajaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'petugas',
				'label'   => 'Petugas',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('idbayar');
		if($this->form_validation->run() == FALSE){
			$this->add();
		}else{
			$this->keubayar_m->insert();
			$this->simplival->alert('Konfirmasi\nData telah berhasil tersimpan');
			$this->add();
		}
	}
	function from_pendaftaran(){
		$this->session->set_userdata('sesi_jenisbayar', 'SPP');
		redirect('admin/keubayar/add');
	}
	function add(){
		$data['browse_jenisbayar'] = $this->keujenisbayar_m->get_distinctall();
		if($this->session->userdata('sesi_thajaranbayar')){
			$thbayar = $this->session->userdata('sesi_thajaranbayar');
		}else{
			$thbayar = $this->simsetting_m->get_active();
		}
		$data['thajaran'] = $thbayar;
		$ptg = $this->auth->get_namauser($this->session->userdata('sesi_user'));
		if($ptg){
			$data['petugas'] = $this->auth->get_namauser($this->session->userdata('sesi_user'));
		}else{
			$data['petugas'] = 'admin';
		}
		$data['thajaran_bayar'] = $thbayar;
		$data['browse_thajaran'] = $this->simsetting_m->select();
		$data['title'] = 'Tambah Daftar Pembayaran';
		$this->load->view('admin/keubayar/ikeubayar_v', $data);
	}
	function edit($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$data['title'] = 'Edit Data Kegiatan';
		$data['detail_keubayar'] = $this->keubayar_m->get_one2($id);
		$this->load->view('admin/keubayar/ekeubayar_v', $data);
	}
	function change_jenisbayar(){
		$this->session->set_userdata('sesi_jenisbayar', $this->uri->segment(4));
		redirect('admin/keubayar/add');
	}
	function detail_bynim(){
		if($this->session->userdata('sesi_thajaranbayar')){
			$thbayar = $this->session->userdata('sesi_thajaranbayar');
		}else{
			$thbayar = $this->simsetting_m->get_active();
		}
		$data['thajaran'] = $thbayar;
	
		if($this->input->post('txtNimMhs')){
			$this->session->set_userdata('sesi_keunimmhs', $this->input->post('txtNimMhs'));
		}
		$nim = $this->session->userdata('sesi_keunimmhs');
		$data['cek_bayar'] = $this->keubayar_m->cek_bayar($nim, $thbayar);
		$data['browse_detail'] = $this->keubayar_m->get_bynim($nim, $thbayar);
		$this->load->view('admin/keubayar/tdkeubayar_bynim_v', $data);
	}
	function cari_mhs(){
		$data['browse_thajaran'] = $this->simsetting_m->select();
		if($this->session->userdata('sesi_thajaranbayar')){	
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbayar');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}

		$data['title'] = 'Browse Daftar Pembayaran';
		$data['thajaran'] = $this->session->userdata('sesi_thajaranbayar');
		$this->load->view('admin/keubayar/theadkeubayar_v', $data);
	}
	function cari_nim(){
		$jenisbayar = $this->session->userdata('sesi_jenisbayar');
		if($this->session->userdata('sesi_thajaranbayar')){
			$thbayar = $this->session->userdata('sesi_thajaranbayar');
		}else{
			$thbayar = $this->simsetting_m->get_active();
		}
		$nim = $this->uri->segment(4);
		// NANTI DITAMBAHKAN PRODI DAN GELOMBANG (SIFATNYA BISA KOSONG)
		$dm = $this->keubayar_m->get_onemhs($nim, $jenisbayar, $thbayar);
		$lunas = $this->keubayar_m->cek_lunas($thbayar, $nim, $jenisbayar);
		if($lunas){
			$data['konfirmasi'] = '<b>KONFIRMASI</b>, Untuk Jenis Pembayaran <b>'.$jenisbayar.'</b> pada tahun ajaran '.$thbayar.' sudah <b>LUNAS</b>';
		}else{
			$data['konfirmasi'] = '';
		}
		if($dm){
			$data['nama'] = $dm['nama'];
			$data['prodi'] = $dm['nama_prodi'];
			$data['totalbiaya'] = $dm['totalbiaya'];
			$data['jumbayar'] = $dm['jumbayar'];
			$data['status'] = $dm['status'];
		}else{
			$data['nama'] = "";
			$data['prodi'] = "";
			$data['totalbiaya'] = 0;
			$data['jumbayar'] = 0;
			$data['status'] = '';
		}
		$this->load->view('admin/keubayar/nama_mahasiswa_v', $data);
	}
	function cetak_kwitansione(){
		$id = $this->uri->segment(4);
		$data['dkw'] = $this->keubayar_m->get_one($id);
		$nim = $data['dkw']->nim;
		$data['namaprodi'] = $this->simprodi_m->get_namaprodibynim($nim);
		$this->load->view('admin/keubayar/ckwitansione_v', $data);
	}
	function hapus(){
		$this->keubayar_m->delete($this->uri->segment(4), $this->uri->segment(5));
		redirect('admin/keubayar/detail_bynim');
	}
}
?>