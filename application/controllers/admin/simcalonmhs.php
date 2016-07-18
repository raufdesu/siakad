<?php
	Class Simcalonmhs extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simcalonmhs_m', 'masmahasiswa_m', 'simprodi_m', 'pendaftaran_m', 'biayadaftar_m', 'keubayar_m'));
			$this->load->library(array('simpliparse','simplival', 'pquery','form_validation'));
			$this->load->library('fungsi');
			$this->load->helper(array('globals','html'));
		}
		function index(){
			$this->session->set_userdata('sesi_prodicalonmhs', '');
			$this->browse();
		}
		function simpan_nim(){
			$n = $this->input->post('n')+1;
			for($i=1; $i<$n; $i++){
				$nodaft = $this->input->post('nodaft'.$i);
				$nim = $this->input->post('nim'.$i);
				$this->simcalonmhs_m->update_nim($nodaft, $nim);
			}
			$this->browse();
			//redirect('admin/simcalonmhs/browse');
			// $this->simplival->alert('KONFIRMASI\nPenentuan NIM Bagi CAMABA Telah Tersimpan');
		}
		function cari_calonmhs(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('sesi_caricalonmhs', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('sesi_caricalonmhs', '');
			}
			$this->browse();
		}
		function notifikasi(){
			//echo "okedah";
		}
		function insert_nim(){
			$nodaft = $this->uri->segment(4);
			$nim = $this->uri->segment(5);
			//echo $nodaft.' : '.$nim;
			if($nim){
				$ceknim = $this->masmahasiswa_m->cek_nim($nim);
				if($ceknim == false){
					//$nodaft = $this->session->userdata('sesi_nodaft');
					$this->masmahasiswa_m->import_pmb($nodaft, $nim);
					redirect('admin/simcalonmhs/browse');

					//$this->simplival->alert('KONFIRMASI\nProses Berhasil. Data Sudah Tersimpan Dalam Daftar Mahasiswa');
					//$this->browse();
				}else{
					$data['nim'] = $nim;
					$this->load->view('admin/simcalonmhs/pesan_v', $data);
					$this->simplival->alert('PERINGATAN\nData Tidak Diproses, Karena NIM Sudah Ada. Harap Ganti Dengan NIM Yang Lain');
					//$this->browse();
				}
			}else{
				//$this->simplival->alert('PERINGATAN\nData Tidak Diproses, Tentukan NIM Terlebih Dahulu');
				//$this->load->view('admin/simcalonmhs/pesan_v');
				redirect('admin/simcalonmhs/browse');
			}
		}
		function change_prodi(){
			$this->session->set_userdata('sesi_prodicalonmhs', $this->uri->segment(4));
			redirect('admin/simcalonmhs/browse');
		}
		/* KEUANGAN START */
		function change_keuprodi(){
			$this->session->set_userdata('sesi_prodicalonmhs', $this->uri->segment(4));
			redirect('admin/simcalonmhs/browse_bayar');
		}
		function cari_bayarcalonmhs(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('sesi_caricalonmhs', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('sesi_caricalonmhs', '');
			}
			$this->browse_bayar();
		}
		function pembayaran(){
			$this->session->set_userdata('sesi_prodicalonmhs', '');
			$this->browse_bayar();
		}
		function browse_bayar(){
			$data['prodi'] = $this->session->userdata('sesi_prodicalonmhs');
			$data['cari'] = $this->session->userdata('sesi_caricalonmhs');
			$data['no'] = $this->uri->segment(4, 0);
			$data['browse_prodi'] = $this->simprodi_m->get_namaprodi();
			$data['total_page']	= $this->simcalonmhs_m->count_all($data['prodi'], $data['cari']);
			$data['perpage'] = $perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simcalonmhs/browse_bayar/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["sql"] = $this->simcalonmhs_m->get_all($data['no'], $perpage, $data['prodi'], $data['cari']);
			$this->load->view("admin/simcalonmhs/tbayarcalonmhs_v",$data);
		}
		/* KEUANGAN END */
		function browse($no = ''){
			//echo "okedah";exit;
			if($no == false){
				$data['no'] = $this->uri->segment(4, 0);
			}else{
				$data['no'] = $no;
			}
			$data['prodi'] = $this->session->userdata('sesi_prodicalonmhs');
			$data['cari'] = $this->session->userdata('sesi_caricalonmhs');
			$data['browse_prodi'] = $this->simprodi_m->get_namaprodi();
			$data['total_page']	= $this->simcalonmhs_m->count_all($data['prodi'], $data['cari']);
			$data['perpage'] = $perpage	= 20;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simcalonmhs/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["sql"] = $this->simcalonmhs_m->get_all($data['no'], $perpage, $data['prodi'], $data['cari']);
			$this->load->view("admin/simcalonmhs/tsimcalonmhs_v",$data);
		}
		function biaya_daftar(){
			if($this->uri->segment(4)){
				$daft = $this->biayadaftar_m->get_one($this->uri->segment(4));
				$data['biaya'] = $daft->biaya;
			}else{
				$data['biaya'] = '';
			}
			$this->load->view('admin/simcalonmhs/ibiayadaftar_v', $data);
		}
		function hapus_biayadaftar(){
			$this->db->where('idpendaftaran', $this->uri->segment(4));
			$this->db->delete('pendaftaran');
			$data['biaya_daftar'] = $this->pendaftaran_m->get_bynodaft($this->session->userdata('sesi_nodaft'));
			$this->load->view('admin/simcalonmhs/tbiayaby_nodaft_v', $data);
		}
		function save_biayadaftar(){
			$nodaft = $this->input->post('nodaft');
			$namabiaya = $this->input->post('namabiaya');
			$cek_bayar = $this->pendaftaran_m->cek_sudahbayar($nodaft, $namabiaya);
			if(!$cek_bayar){
				$this->pendaftaran_m->insert();
			}else{
				$this->simplival->alert('Konfirmasi\nJenis Pembayaran Ini Sudah dibayar');
			}
			$data['biaya_daftar'] = $this->pendaftaran_m->get_bynodaft($this->input->post('nodaft'));
			$this->load->view('admin/simcalonmhs/tbiayaby_nodaft_v', $data);
		}
		function input_nim(){
			$data['nodaft'] = $this->input->post('nodaft');
			$this->load->view('admin/simcalonmhs/inim_v', $data);
		}
		function detail($nodaft = ''){
			if($nodaft == false){
				$data['nodaftar'] = $this->uri->segment(4);
			}else{
				$data['nodaftar'] = $nodaft;
			}
			$nim = $this->simcalonmhs_m->nim_bynodaft($data['nodaftar']);
			$this->session->set_userdata('sesi_nimdaftar', $nim);
			$gelombang = $this->simcalonmhs_m->gelombang_bynodaft($data['nodaftar']);
			$data['angkatan'] = date('Y');
			
			$prodi = $this->simcalonmhs_m->prodi_bynodaft($data['nodaftar']);
			
			$data['browse_namabiaya'] = $this->biayadaftar_m->get_bygelangkatan($data['angkatan'], $gelombang, $prodi);
			$this->session->set_userdata('sesi_nodaft', $data['nodaftar']);
			$data['biaya_daftar'] = $this->pendaftaran_m->get_bynodaft($this->uri->segment(4));

			$data["sql"] = $this->simcalonmhs_m->get_one($data['nodaftar']);
			$this->load->view("admin/simcalonmhs/tdsimcalonmhs_v",$data);
		}
		function delete(){
			$this->simcalonmhs_m->delete($this->uri->segment(4,0));
			redirect('admin/simcalonmhs');
		}
		function cetak_absen(){
			$data['title'] = 'Cetak Presensi';
			$data['cari'] = $this->session->userdata('sesi_caricalonmhs');
			$data['prodi'] = $this->session->userdata('sesi_prodicalonmhs');
			$data['browse_prodi'] = $this->simprodi_m->get_namaprodi();
			$data['nama_prodi'] = $this->simprodi_m->get_namasimprodi($this->session->userdata('sesi_prodicalonmhs'));
			$data["sql"] = $this->simcalonmhs_m->get_all('', '', $data['prodi'], $data['cari']);
			$this->load->view('admin/simcalonmhs/cpresensi_ujianpmb_v', $data);
		}
		function detail_setuju($nodaft = ''){
			if($nodaft == false){
				$data['nodaftar'] = $this->uri->segment(4);
			}else{
				$data['nodaftar'] = $nodaft;
			}
			$data['nim'] = $this->auth->nim_bynodaft($data['nodaftar']);
			$prodi = $this->auth->get_mhsbynim($data['nim'])->kodeprodi;
			$gelombang = $this->simcalonmhs_m->gelombang_bynodaft($data['nodaftar']);
			if($this->session->userdata('sesi_newthajaran')){
				$thajaran = $this->session->userdata('sesi_newthajaran');
			}else{
				// NANTI DI DINAMISKAN
				$thajaran = '20121';
			}
			$data['angkatan'] = date('Y');
			$prodi = $this->simcalonmhs_m->prodi_bynodaft($data['nodaftar']);
			$data['browse_namabiaya'] = $this->biayadaftar_m->get_bygelangkatan($data['angkatan'], $gelombang, $prodi);
			$this->session->set_userdata('sesi_nodaft', $data['nodaftar']);
			$data['biaya_daftar'] = $this->pendaftaran_m->get_bynodaft($this->uri->segment(4));
			$data['biaya_spp'] = $this->keubayar_m->get_onemhsnew($data['nim'], 'SPP', $thajaran, $prodi, $gelombang);
			$data["sql"] = $this->simcalonmhs_m->get_one($data['nodaftar']);
			$this->load->view("admin/simcalonmhs/ckdaftarulang_v",$data);
		}
		function set_nim(){
			$nodaft = $this->uri->segment(4);
			$nim = $this->uri->segment(5);
			if($nim){
				$ceknim = $this->masmahasiswa_m->cek_nim($nim);
				if($ceknim == false){
					$this->masmahasiswa_m->import_pmb($nodaft, $nim);
					redirect('admin/simcalonmhs/add_spp/'.$nodaft.'/'.$nim);
				}else{
					$data['nim'] = $nim;
					$this->load->view('admin/simcalonmhs/pesan_v', $data);
					$this->simplival->alert('PERINGATAN\nData Tidak Diproses, Karena NIM Sudah Ada. Harap Ganti Dengan NIM Yang Lain');
				}
			}
		}
		function add_spp(){
			$data['nodaftar'] = $this->uri->segment(4);
			$data['nim'] = $this->uri->segment(5);
			$gelombang = $this->simcalonmhs_m->gelombang_bynodaft($data['nodaftar']);
			$prodi = $this->auth->get_mhsbynim($data['nim'])->kodeprodi;
			// NANTI DIGANTI DENGAN YANG DINAMIS
			if($this->session->userdata('sesi_newthajaran')){
				$thajaran = $this->session->userdata('sesi_newthajaran');
			}else{
				// NANTI DI DINAMISKAN
				$thajaran = '20121';
			}
			$dm = $this->keubayar_m->get_onemhs($data['nim'], 'SPP', $thajaran, $prodi, $gelombang);
			$data['tagihan'] = $dm['totalbiaya'];
			$this->load->view('admin/simcalonmhs/ispp_v', $data);
		}
		function save_spp(){
			$thajaran = $this->input->post('thajaran');
			$nim = $this->input->post('nim');
			$jenisbayar = 'SPP';
			$nodaftar = $this->input->post('nodaftar');
			if(strlen($thajaran) < 5){
				$this->simplival->alert('KONFIRMASI\nTahun Ajaran Salah. Data Tidak Tersimpan. Contoh yang benar : 20121');
			}
			$this->keubayar_m->insert_new($thajaran, $nim, $jenisbayar);
			$this->session->set_userdata('sesi_newthajaran', $this->input->post('thajaran'));
			redirect('admin/simcalonmhs/detail_setuju/'.$nodaftar);
		}
	}
?>