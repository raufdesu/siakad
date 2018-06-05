<?php
Class Keubiaya extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m', 'keusetoran_m', 'keubiaya_m', 'masmahasiswa_m', 'keuaturbiaya_m', 'simprodi_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		$this->header_add();
	}
	function cari_mhspembayaran(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata('cari_pembayaran', $this->input->post('txtCari'));
		}else{
			$this->session->set_userdata('cari_pembayaran', '');
		}
		$this->daftar_pembayaran();
	}
	function batalkan_lastbayar(){
		$idbiaya = $this->uri->segment(4);
		$nim = $this->uri->segment(5);
		$thajaran = $this->uri->segment(6);
		$this->keusetoran_m->delete_last($idbiaya, $nim, $thajaran);
		/* $this->keubiaya_m->update_status($idbiaya, 'Belum Lunas'); */
		redirect('keuangan/keubiaya/pilih_mahasiswa/'.$nim);
	}
	function change_prodi(){
		$this->session->set_userdata('sesi_prodipembayaran', $this->uri->segment(4));
		redirect('keuangan/keubiaya/daftar_pembayaran/');
	}
	function change_statuspembayaran(){
		$this->session->set_userdata('sesi_statuspembayaran', $this->uri->segment(4));
		redirect('keuangan/keubiaya/daftar_pembayaran/');
	}
	function change_angkatanpembayaran(){
		$this->session->set_userdata('sesi_angkatanpembayaran', $this->uri->segment(4));
		redirect('keuangan/keubiaya/daftar_pembayaran/');
	}
	function change_thajaranpembayaran(){
		$this->session->set_userdata('sesi_thajaranpembayaran', $this->uri->segment(4));
		redirect('keuangan/keubiaya/daftar_pembayaran/');
	}
	function index_daftar_pembayaran(){
		$thajaran_bayar = $this->simsetting_m->get_active();
		$data_sesi = array(
			'cari_pembayaran' => '',
			'sesi_thajaranpembayaran' => '',
			'sesi_prodipembayaran' => '',
			'sesi_statuspembayaran' => '',
			'sesi_angkatanpembayaran' => ''
		);
		$this->session->set_userdata($data_sesi);
		$this->daftar_pembayaran();
	}
	function index_daftar_pembayaran_prodi(){
		$thajaran_bayar = $this->simsetting_m->get_active();
		$data_sesi = array(
			'cari_pembayaran' => '',
			'sesi_thajaranpembayaran' => $thajaran_bayar,
			'sesi_prodipembayaran' => $this->session->userdata('sesi_prodi'),
			'sesi_statuspembayaran' => '',
			'sesi_angkatanpembayaran' => ''
		);
		$this->session->set_userdata($data_sesi);
		$this->daftar_pembayaran();
	}
	function daftar_pembayaran(){
		/* $data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya');
		$data['browse_jenis'] = $this->keuaturbiaya_m->get_jenis(); */
		$data['browse_thajaran'] = $this->simsetting_m->select();
		$data['prodi'] = $this->session->userdata('sesi_prodipembayaran');
		/* if(!$this->session->userdata('sesi_thajaranpembayaran')){
			$this->session->set_userdata('sesi_thajaranpembayaran', $this->simsetting_m->get_active());
		} */
		$data['thajaran'] = $this->session->userdata('sesi_thajaranpembayaran');
		$data['angkatan'] = $this->session->userdata('sesi_angkatanpembayaran');
		$data['status'] = $this->session->userdata('sesi_statuspembayaran');
		$data['browse_angkatan'] = $this->keuaturbiaya_m->get_angkatan();
		$data['browse_prodi'] = $this->simprodi_m->select();
		$data['cari'] = $this->session->userdata('cari_pembayaran');
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->keubiaya_m->count_allpembayaran($data['thajaran'], $data['cari'], $data['prodi'], $data['angkatan'], $data['status']);
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'keuangan/keubiaya/daftar_pembayaran/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data['browse_pembayaran'] = $this->keubiaya_m->get_allpembayaran($data['no'], $perpage, $data['thajaran'], $data['cari'], $data['prodi'], $data['angkatan'], $data['status']);
		$this->load->view('keuangan/keubiaya/tpembayaran_v', $data);
	}
	function cetak_pembayaran(){
		$data['prodi'] = $this->session->userdata('sesi_prodipembayaran');
		$data['thajaran'] = $this->session->userdata('sesi_thajaranpembayaran');
		$data['angkatan'] = $this->session->userdata('sesi_angkatanpembayaran');
		$data['status'] = $this->session->userdata('sesi_statuspembayaran');
		$data['cari'] = $this->session->userdata('cari_pembayaran');
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->keubiaya_m->count_allpembayaran($data['thajaran'], $data['cari'], $data['prodi'], $data['angkatan'], $data['status']);
		$perpage	= $data['total_page'];
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'keuangan/keubiaya/daftar_pembayaran/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data['browse_pembayaran'] = $this->keubiaya_m->get_allpembayaran($data['no'], $perpage, $data['thajaran'], $data['cari'], $data['prodi'], $data['angkatan'], $data['status']);
		if($this->uri->segment(5) == 'xls'){
			$namafile = 'Daftar Pembayaran '.$this->auth->get_namaprodi($data['prodi']).' '.$data['angkatan'].' '.$data['status'];
			$file = url_title($namafile).".xls";
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment;filename=".$file );
			header('Pragma: no-cache');
			header('Expires: 0');
		}
		$this->load->view('keuangan/keubiaya/laporan/export_pembayaran_v', $data);
	}
	function header_add(){
		$data['title'] = 'Form Input Pembayaran';
		/* start Kepakai gk ya? */
		if(!$this->session->userdata('sesi_thajaranbiaya')){
			$this->session->set_userdata('sesi_thajaranbiaya', $this->simsetting_m->get_active());
		}
		/* selesai */

		$data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya');
		$data['browse_jenis'] = $this->keuaturbiaya_m->get_jenis();
		$data['browse_thajaran'] = $this->simsetting_m->select();
		$this->load->view('keuangan/keubiaya/theadkeubiaya_v', $data);
	}
	function batal_setor(){
		$idsetoran = $this->uri->segment(4);
		$idbiaya = $this->uri->segment(5);
		$nim = $this->uri->segment(6);
		$this->keusetoran_m->delete($idsetoran);
		$this->keubiaya_m->update_status($idbiaya, 'Belum Lunas');
		redirect('keuangan/keubiaya/detail_bynim/'.$nim);
	}
	function pilih_mahasiswa($nim=''){
		if($nim){
			$this->session->set_userdata('sesi_nimbiaya', $nim);
		}else{
			$this->session->set_userdata('sesi_nimbiaya', $this->input->post('txtNim'));
		}
		$this->session->set_userdata('sesi_thajaranbiaya', $this->input->post('thajaran'));
		$this->session->set_userdata('sesi_jenisbiaya', $this->input->post('jenis'));
		$this->add();
	}
	/* function thajaran_bayar(){
		$data['namabiaya'] = good_karakter($this->uri->segment(4));
		$data['browse_thajaran'] = $this->simsetting_m->select();
		$this->load->view('keuangan/keubiaya/kombothajaran_v', $data);
	} */
	function change_namabiaya(){
		$namabiaya = good_karakter($this->uri->segment(4));
		$this->session->set_userdata('sesi_namabiaya', $namabiaya);
		redirect('keuangan/keubiaya/add');
	}
	function add(){
		$data['nim'] = $this->session->userdata('sesi_nimbiaya');
		$data['namabiaya'] = $this->session->userdata('sesi_namabiaya');
		/* $data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya'); */
		$data['jenis'] = $this->session->userdata('sesi_jenisbiaya');
		$data['browse_namabiaya'] = $this->keubiaya_m->get_namabiayabynim($data['nim'], $data['jenis']);
		$ptg = $this->auth->get_namauser($this->session->userdata('sesi_user'));
		if($ptg){
			$data['petugas'] = $this->auth->get_namauser($this->session->userdata('sesi_user'));
		}else{
			$data['petugas'] = 'keuangan';
		}
		
		$data['biaya'] = $this->keubiaya_m->get_onebiaya($data['nim'], $data['namabiaya'], $data['jenis']);
		/* $data['biaya'] = $this->keubiaya_m->get_onebiaya($data['nim'], $data['namabiaya'], $data['thajaran']); */
		
		$data['browse_thajaran'] = $this->simsetting_m->select();
		$data['title'] = 'Form Input Pembayaran';
		$this->load->view('keuangan/keubiaya/formpembayaran_v', $data);
	}
	function detail_bynim($nim = ''){
		if(!$nim){
			$nim = $this->uri->segment(4);
		}
		$data['mhs'] = $this->masmahasiswa_m->get_one($nim);
		$data['browse_jenis'] = $this->keubiaya_m->get_jenisbynim($nim);
		$this->load->view("keuangan/keubiaya/tdbiayabynim_v", $data);
	}
	function atur_bynim($nim = ''){
		if(!$nim){
			$nim = $this->uri->segment(4);
		}
		$data['mhs'] = $this->masmahasiswa_m->get_one($nim);
		$data['browse_biaya'] = $this->keubiaya_m->get_bynim($nim);
		$this->load->view("keuangan/keubiaya/taturbiayabynim_v", $data);
	}
	function biayasks($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$data['js'] = $this->keubiaya_m->get_one($id);
		$this->load->view('keuangan/keubiaya/ebiayasks_v', $data);
	}
	function edit_biaya($id = '', $nim = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		if(!$nim){
			$data['nim'] = $this->uri->segment(5);
		}else{
			$data['nim'] = $nim;
		}
		$data['biaya'] = $this->keubiaya_m->get_one($id);
		$this->load->view('keuangan/keubiaya/ekeubiaya_v', $data);
	}
	function update_biayasks(){
		$idbiaya = $this->input->post('idbiaya');
		$nim = $this->input->post('nim');
		$this->keubiaya_m->update_biayasks();
		redirect('keuangan/keubiaya/edit_biaya/'.$idbiaya.'/'.$nim);
	}
	function add_biaya($nim = ''){
		if(!$nim){
			$nim = $this->uri->segment(4);
		}
		$data['mhs'] = $this->masmahasiswa_m->get_one($nim);
		$this->load->view('keuangan/keubiaya/ikeubiaya_v', $data);
	}
	function hapus_biaya(){
		$nim = $this->uri->segment(5);
		$this->keubiaya_m->delete_drop($idbiaya = $this->uri->segment(4));
		redirect('keuangan/keubiaya/atur_bynim/'.$nim);
	}
	function simpan_biaya(){
		$config = array(
			array(
				'field'   => 'jenis',
				'label'   => 'Junis',
				'rules'   => 'required'
			),
			array(
				'field'   => 'namabiaya',
				'label'   => 'Nama biaya',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jumbiaya',
				'label'   => 'Besar biaya',
				'rules'   => 'required|is_natural_no_zero'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('idbiaya');
		$nim = $this->input->post('nim');
		if($this->form_validation->run() == FALSE){
			if($this->input->post('idbiaya')){
				$this->edit_biaya($id, $nim);
			}else{
				$this->add_biaya();
			}
		}else{
			$this->keubiaya_m->insert();
			redirect('keuangan/keubiaya/atur_bynim/'.$nim);
		}
	}
	
	/* Untuk Proses Simpan Form Pembayaran */
	function save(){
		$config = array(
			array(
				'field'   => 'nim',
				'label'   => 'NIM',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jumsetoran',
				'label'   => 'Besar setoran',
				'rules'   => 'required|decimal'
			),
			/*array(
				'field'   => 'thajaran',
				'label'   => 'Tahun Ajaran',
				'rules'   => 'required'
			), */
			array(
				'field'   => 'petugas',
				'label'   => 'Petugas',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('idbiaya');
		if($this->form_validation->run() == FALSE){
			$this->add();
		}else{
			if(angka_utuh($this->input->post('jumsetoran')) <= angka_utuh($this->input->post('kekurangan'))){
				/*
				if(angka_utuh($this->input->post('jumlah')) && angka_utuh($this->input->post('kekurangan')) != angka_utuh($this->input->post('jumsetoran'))){
					$this->simplival->alert('Konfirmasi\nBiaya diangsur maksimal 2 kali. Anda harus melunasi pada angsurang kedua ini.');
					$this->add();
				}else{ */
					$this->keusetoran_m->insert();
					/* NIM DAN THAJARAN Ditambahkan untuk penstatusan aktif semester*/
					$nim = $this->input->post('nim');
					$thajaran = $this->input->post('thajaran');
					$this->keusetoran_m->tentukan_status($this->input->post('idbiaya'), $nim, $thajaran);
					$this->keusetoran_m->aktif_setengah($this->input->post('idbiaya'), $nim, $thajaran);
					redirect('keuangan/keubiaya/add');
				/* } */
			}else{
				$this->simplival->alert('Konfirmasi\nInput besar setoran terlalu besar');
				$this->add();
			}
		}
	}
	function namamhs_bynim(){
		$nim = $this->uri->segment(4);
		$this->session->set_userdata('sesi_nimbiaya', $nim);
		$namamhs = $this->masmahasiswa_m->get_namabynim($nim);
		echo '<input type="text" name="namamhs" size="35" value="'.$namamhs.'" />';
	}
	function laporan_nim($nim = ''){
		if(!$nim){
			$nim = $this->uri->segment(4);
		}
		$data['mhs'] = $this->masmahasiswa_m->get_one($nim);
		$data['browse_jenis'] = $this->keubiaya_m->get_jenisbynim($nim);
		/*$data['browse_biaya'] = $this->keubiaya_m->get_bynim($nim); */
		$this->load->view("keuangan/keubiaya/lapbiayabynim_v", $data);
	}
	function edit($id = ''){
		/*if(!$id){
			$id = $this->uri->segment(4);
		}
		$data['title'] = 'Edit Data Kegiatan';
		$data['detail_keubiaya'] = $this->keubiaya_m->get_one2($id);
		$this->load->view('keuangan/keubiaya/ekeubiaya_v', $data); */
	}
	function change_thajaran(){
		$this->session->set_userdata('sesi_thajaranbiaya', $this->uri->segment(4));
		$this->add();
	}
	function change_thajaran2(){
		$this->session->set_userdata('sesi_thajaranbiaya', $this->uri->segment(4));
		redirect('keuangan/keubiaya/laporan');
	}
	function change_thajaran3(){
		$this->session->set_userdata('sesi_thajaranbiaya', $this->uri->segment(4));
		$this->detail_bynim();
	}
	function prodi(){
		$this->session->set_userdata('sesi_prodikeumhs', $this->uri->segment(4));
		redirect('keuangan/keubiaya/laporan');
	}
	function angkatan(){
		$this->session->set_userdata('sesi_angkatankeumhs', $this->uri->segment(4));
		redirect('keuangan/keubiaya/laporan');
	}
	function laporan(){
		$prodi = $this->session->userdata('sesi_prodikeumhs');
		$angkatan = $this->session->userdata('sesi_angkatankeumhs');
		$data['browse_angkatan'] = $this->masmahasiswa_m->get_disangkatan();
		$data['browse_prodi'] = $this->simprodi_m->select();
		$data['browse_thajaran'] = $this->simsetting_m->select();
		if($this->session->userdata('sesi_thajaranbiaya')){	
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->keubiaya_m->count_all($prodi, $angkatan, $data['thajaran']);
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'keuangan/keubiaya/laporan/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data['browse_keubiaya'] = $this->keubiaya_m->get_all($data['no'], $perpage, $prodi, $angkatan, $data['thajaran']);
		$this->load->view("keuangan/keubiaya/tkeubiaya_v", $data);
	}
	function export(){
		$data['extensi'] = $this->uri->segment(4);
		$prodi = $this->session->userdata('sesi_prodikeumhs');
		$angkatan = $this->session->userdata('sesi_angkatankeumhs');
		if($this->session->userdata('sesi_thajaranbiaya')){
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}
		$data['browse_keubiaya'] = $this->keubiaya_m->get_all('', '', $prodi, $angkatan, $data['thajaran']);
		$this->load->view("keuangan/keubiaya/ckeubiaya_v", $data);
	}
	function export2(){
		$data['extensi'] = $this->uri->segment(4);
		$prodi = $this->session->userdata('sesi_prodikeumhs');
		$angkatan = $this->session->userdata('sesi_angkatankeumhs');
		if($this->session->userdata('sesi_thajaranbiaya')){
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}
		$data['browse_keubiaya'] = $this->keubiaya_m->get_allbiaya('', '', $prodi, $angkatan, $data['thajaran']);
		$this->load->view("keuangan/keubiaya/ckeubiaya2_v", $data);
	}
	function browse(){
		$data['title'] = 'Daftar Kegiatan Mahasiswa';
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->keubiaya_m->count_all($this->session->userdata('cari_keubiaya'));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'keuangan/keubiaya_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_keubiaya"] = $this->keubiaya_m->get_all($data['no'],$perpage,$this->session->userdata('cari_keubiaya'));
		$this->load->view("keuangan/keubiaya/tkeubiaya_v",$data);
	}
	function from_pendaftaran(){
		$this->session->set_userdata('sesi_aturbiaya', 'SPP');
		redirect('keuangan/keubiaya/add');
	}
	function cari_mhs(){
		$data['browse_thajaran'] = $this->simsetting_m->select();
		if($this->session->userdata('sesi_thajaranbiaya')){	
			$data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya');
		}else{
			$data['thajaran'] = $this->simsetting_m->get_active();
		}

		$data['title'] = 'Browse Daftar Pembiayaan';
		$data['thajaran'] = $this->session->userdata('sesi_thajaranbiaya');
		$this->load->view('keuangan/keubiaya/theadkeubiaya_v', $data);
	}
	function cari_nim(){
		$namabiaya = $this->session->userdata('sesi_namabiaya');
		if($this->session->userdata('sesi_thajaranbiaya')){
			$thbiaya = $this->session->userdata('sesi_thajaranbiaya');
		}else{
			$thbiaya = $this->simsetting_m->get_active();
		}
		$nim = $this->uri->segment(4);
		// NANTI DITAMBAHKAN PRODI DAN GELOMBANG (SIFATNYA BISA KOSONG)
		$dm = $this->keubiaya_m->get_onemhs($nim, $namabiaya, $thbiaya);
		$lunas = $this->keubiaya_m->cek_lunas($thbiaya, $nim, $aturbiaya);
		if($lunas){
			$data['konfirmasi'] = '<b>KONFIRMASI</b>, Untuk Jenis Pembiayaan <b>'.$aturbiaya.'</b> pada tahun ajaran '.$thbiaya.' sudah <b>LUNAS</b>';
		}else{
			$data['konfirmasi'] = '';
		}
		if($dm){
			$data['nama'] = $dm['nama'];
			$data['prodi'] = $dm['nama_prodi'];
			$data['totalbiaya'] = $dm['totalbiaya'];
			$data['jumbiaya'] = $dm['jumbiaya'];
			$data['status'] = $dm['status'];
		}else{
			$data['nama'] = "";
			$data['prodi'] = "";
			$data['totalbiaya'] = 0;
			$data['jumbiaya'] = 0;
			$data['status'] = '';
		}
		$this->load->view('keuangan/keubiaya/nama_mahasiswa_v', $data);
	}
	function cetak_kwitansione(){
		$id = $this->uri->segment(4);
		$data['dkw'] = $this->keubiaya_m->get_one($id);
		$nim = $data['dkw']->nim;
		$data['namaprodi'] = $this->simprodi_m->get_namaprodibynim($nim);
		$this->load->view('keuangan/keubiaya/ckwitansione_v', $data);
	}
	function hapus(){
		$this->keubiaya_m->delete($this->uri->segment(4), $this->uri->segment(5));
		redirect('keuangan/keubiaya/detail_bynim');
	}
	function delete(){
		$this->keubiaya_m->delete_drop($this->uri->segment(4));
		redirect('keuangan/keubiaya/daftar_pembayaran');
	}
}
?>