<?php
Class Simambilmk extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simambilmk_m','simtranskrip_m','simprodi_m', 'simdosenwali_m', 'simsetting_m', 'simkrs_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
		date_default_timezone_set("Asia/Jakarta");
	}
	function change_thajarankhs(){
		$this->session->set_userdata('sesi_thajarankhs', $this->uri->segment(4));
		$this->khs();
	}
	function change_thajarankrs(){
		$this->session->set_userdata('sesi_thajarankhs', $this->uri->segment(4));
		$this->krs();
	}
	function jadwal_bynim(){
		$data['nim'] = $this->session->userdata('sesi_user_mhs');
		$set = $this->simsetting_m->select_active();
		$data['thajaran'] = $set['thajaran'];
		$this->load->view('mhs/simambilmk/tdjadwal_v', $data);
	}
	function detailkhs(){
		if($this->session->userdata('sesi_thajarankhs')){
			$data['thakad'] = $this->session->userdata('sesi_thajarankhs');
		}else{
			$set = $this->simsetting_m->select_active();
			$data['thakad'] = $set['thajaran'];
		}
		$data['title'] = 'Kartu Hasil Studi';
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['browse_thajar'] = $this->simkrs_m->get_thbynim($nim);
		$cek = $this->simambilmk_m->get_idkrs_bynim($nim, $data['thakad']);
		$data['cek_khs'] = $cek['idkrsnya'];
		$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
		$this->load->view('mhs/simambilmk/tdkhs_v', $data);
	}
	function khs(){
		if($this->session->userdata('sesi_thajarankhs')){
			$data['thakad'] = $this->session->userdata('sesi_thajarankhs');
		}else{
			$set = $this->simsetting_m->select_active();
			$data['thakad'] = $set['thajaran'];
		}
		$data['title'] = 'Kartu Hasil Studi';
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['browse_thajar'] = $this->simkrs_m->get_thbynim($nim);
		$cek = $this->simambilmk_m->get_idkrs_bynim($nim, $data['thakad']);
		$data['cek_khs'] = $cek['idkrsnya'];
		$cek_kodeprodi = $this->simambilmk_m->get_kdprodibynim($nim);
		$data['kodeprodi'] = $cek_kodeprodi;
		$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
		$this->load->view('mhs/simambilmk/tkhs_v', $data);
	}
	function krs(){
		if($this->session->userdata('sesi_thajarankhs')){
			$data['thakad'] = $this->session->userdata('sesi_thajarankhs');
		}else{
			$set = $this->simsetting_m->select_active();
			$data['thakad'] = $set['thajaran'];
		}
		$data['title'] = 'Kartu Rencana Studi';
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['browse_thajar'] = $this->simkrs_m->get_thbynim($nim);
		$cek = $this->simambilmk_m->get_idkrs_bynim($nim, $data['thakad']);
		$data['cek_khs'] = $cek['idkrsnya'];
		$cek_kodeprodi = $this->simambilmk_m->get_kdprodibynim($nim);
		$data['kodeprodi'] = $cek_kodeprodi;
		$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
		$this->load->view('mhs/simambilmk/tkrs_v', $data);
	}
	function cetak_khs(){
		$this->load->model('simkrs_m');
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['nim'] = $nim;
		$set = $this->simsetting_m->select_active();
		if(!$this->session->userdata('sesi_thajarankhs')){
			$data['thakad'] = $set['thajaran'];
		}else{
			$data['thakad'] = $this->session->userdata('sesi_thajarankhs');
		}
		$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $data['thakad']);
		$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
		$dpa = $this->simdosenwali_m->get_namakaprodi($nim, $data['thakad']);
		$cek = $this->simambilmk_m->get_idkrs_bynim($nim, $data['thakad']);
		$data['cek_khs'] = $cek['idkrsnya'];
		$data['nama_kaprodi'] = $dpa['nama'];

		/*
			$data['max_pengambilan_sks'] = $this->simkrs_m->res_sks($nim, $data['thakad']);
		
			$data['ipkabeh'] = $this->simkrs_m->get_ipk($nim);
			$data['sksini'] = $this->simkrs_m->get_total($nim, $data['thakad'])->jumsks;
			$data['skskabeh'] = $this->simkrs_m->get_total($nim)->jumsks;
			$data['mutuini'] = $this->simkrs_m->get_total($nim, $data['thakad'])->mutu;
			$data['mutukabeh'] = $this->simkrs_m->get_total($nim)->mutu;
		*/
		
		if(!$data['cek_khs']){
			echo "Anda tidak mempunyai kartu hasil studi pada tahun ajaran ".$data['thakad'];
		}else{
			$this->load->view('mhs/laporan/ckhs_v', $data);
		}
	}
	function cetak_krs(){
		$this->load->model('simkrs_m');
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['nim'] = $nim;
		$set = $this->simsetting_m->select_active();
		if(!$this->session->userdata('sesi_thajarankhs')){
			$data['thakad'] = $set['thajaran'];
		}else{
			$data['thakad'] = $this->session->userdata('sesi_thajarankhs');
		}
			$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($this->session->userdata('sesi_user_mhs'), $data['thakad']);
			$data['detail_krs_peserta'] = $this->simkrs_m->get_one_krs($this->session->userdata('sesi_user_mhs'), $data['thakad']);
			$data['dpa'] = $this->simdosenwali_m->get_namadpa($this->session->userdata('sesi_user_mhs'),$data['thakad']);
			$this->load->view('mhs/laporan/ckrs_v2', $data);
	}
	function change_thajarantrans(){
		$this->session->set_userdata('sesi_thajarantrans', $this->uri->segment(4));
		$this->transkrip();
	}
	function transkrip(){
		$set = $this->simsetting_m->select_active();
		if($this->session->userdata('sesi_thajarantrans')){
			$data['thakad'] = $this->session->userdata('sesi_thajarantrans');
		}else{
			$data['thakad'] = $set['thajaran'];
		}

		$data['nim'] = $this->session->userdata('sesi_user_mhs');
		$data['kodeprodi'] = $this->simambilmk_m->get_kdprodibynim($data['nim']);
		$data['browse_thajar'] = $this->simsetting_m->select();
		$data['browse_transkrip'] = $this->simambilmk_m->get_transkrip_bythajaran($data['nim'], $data['thakad']);
		$data['browse_matrikulasi'] = $this->simtranskrip_m->get_onetranskrip($data['nim']);
		$this->load->view('mhs/simambilmk/ttranskrip_v', $data);
	}
	
	function cetak_transkrip(){
		$this->load->model('simkrs_m');
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['nim'] = $nim;
		$set = $this->simsetting_m->select_active();
		if(!$this->session->userdata('sesi_thajarankhs')){
			$data['thakad'] = $set['thajaran'];
		}else{
			$data['thakad'] = $this->session->userdata('sesi_thajarankhs');
		}
		$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $data['thakad']);
		$data['browse_thajar'] = $this->simsetting_m->select();
		$data['browse_transkrip'] = $this->simambilmk_m->get_transkrip_bythajaran($data['nim'], $data['thakad']);
		$dpa = $this->simdosenwali_m->get_namakaprodi($nim, $data['thakad']);
		$cek = $this->simambilmk_m->get_idkrs_bynim($nim, $data['thakad']);
		$data['cek_khs'] = $cek['idkrsnya'];
		$data['nama_kaprodi'] = $dpa['nama'];

		/*
			$data['max_pengambilan_sks'] = $this->simkrs_m->res_sks($nim, $data['thakad']);
		
			$data['ipkabeh'] = $this->simkrs_m->get_ipk($nim);
			$data['sksini'] = $this->simkrs_m->get_total($nim, $data['thakad'])->jumsks;
			$data['skskabeh'] = $this->simkrs_m->get_total($nim)->jumsks;
			$data['mutuini'] = $this->simkrs_m->get_total($nim, $data['thakad'])->mutu;
			$data['mutukabeh'] = $this->simkrs_m->get_total($nim)->mutu;
		*/
		
		if(!$data['cek_khs']){
			echo "Anda tidak mempunyai kartu hasil studi pada tahun ajaran ".$data['thakad'];
		}else{
			$this->load->view('mhs/laporan/ctranskrip_v', $data);
		}
	}
}
?>