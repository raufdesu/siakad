<?php
Class Simambilmk extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simdosenampu_m','simambilmk_m','simkrs_m','simprodi_m','simsetting_m','simmktawar_m','simdosenwali_m','maspegawai_m','masmahasiswa_m','simkurikulum_m','simmatrikulasi_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function change_thajarankhs(){
		$this->session->set_userdata('sesi_thajarankhs', $this->uri->segment(4));
		$this->khs();
	}
	function pilih_khs(){
		if($this->uri->segment(4)){
			$this->session->set_userdata('sesi_nimmhs', $this->uri->segment(4));
			$this->khs();
		}
	}
	function khs(){
		$nim = $this->session->userdata('sesi_nimmhs');
		if($this->session->userdata('sesi_thajarankhs')){
			$data['thakad'] = $this->session->userdata('sesi_thajarankhs');
		}else{
			$set = $this->simsetting_m->select_active();
			$data['thakad'] = $set['thajaran'];
		}
		$data['title'] = 'Kartu Hasil Studi';
		$data['browse_thajar'] = $this->simsetting_m->select();
		$cek = $this->simambilmk_m->get_idkrs_bynim($nim, $data['thakad']);
		$data['cek_khs'] = $cek['idkrsnya'];
		$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
		//echo $this->db->last_query();
		$this->load->view('dosen/simambilmk/tkhs_v', $data);
	}
	function cetak_khs(){
		$this->load->model('simkrs_m');
		$nim = $this->session->userdata('sesi_nimmhs');
		$set = $this->simsetting_m->select_active();
		/*$data['thakad'] = $set['thajaran']; */
		$data['thakad'] = '20111';
		$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $data['thakad']);
		$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
		$dpa = $this->simprodi_m->get_namakaprodi($nim, $data['thakad']);
		$data['nama_kaprodi'] = $dpa['nama'];
		$this->load->view('mhs/laporan/ckhs_v', $data);
	}
	function change_thajarantrans(){
		$this->session->set_userdata('sesi_thajarantrans', $this->uri->segment(4));
		$this->transkrip();
	}
	
	function pilih_transkrip(){
		if($this->uri->segment(4)){
			$this->session->set_userdata('sesi_nimtranskrip', $this->uri->segment(4));
			$this->transkrip();
		}
	}
	function transkrip(){
		$data['nim'] = $this->session->userdata('sesi_nimtranskrip');
		$set = $this->simsetting_m->select_active();
		if($this->session->userdata('sesi_thajarantrans')){
			$data['thakad'] = $this->session->userdata('sesi_thajarantrans');
		}else{
			$data['thakad'] = $set['thajaran'];
		}

		/*$data['nim'] = $this->session->userdata('sesi_user_mhs');*/
		$data['browse_thajar'] = $this->simsetting_m->select();
		$data['browse_transkrip'] = $this->simambilmk_m->get_transkrip_bythajaran($data['nim'], $data['thakad']);
		$this->load->view('dosen/simambilmk/ttranskrip_v', $data);
	}
	function cetak_transkrip(){
			$nim = $this->session->userdata('sesi_nimtranskrip');
			$data['cetak_transkrip'] = $this->simambilmk_m->get_transkrip($nim);
			$data['cetak_matrikulasi'] = $this->simmatrikulasi_m->get_nolimit($nim);
			if($this->session->userdata('sesi_khsthajaran') == false){
				$set = $this->simsetting_m->select_active();
				$data['thakad'] = $set['thajaran'];
			}else{
				$data['thakad'] = $this->session->userdata('sesi_khsthajaran');
			}
			$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $data['thakad']);
			$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
			$dpa = $this->simdosenwali_m->get_namadpa($nim, $data['thakad']);
			$data['nama_dpa'] = $dpa['nama'];
			$this->load->view('dosen/simambilmk/ctranskrip_s', $data);
		}
}
?>