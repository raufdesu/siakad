<?php
Class Pembayaran extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simambilmk_m','pembayaran_m','simtranskrip_m','simprodi_m', 'simdosenwali_m', 'simsetting_m', 'simkrs_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
		date_default_timezone_set("Asia/Jakarta");
	}
	function change_thajaranpembayaran(){
		$this->session->set_userdata('sesi_thajaranpembayaran', $this->uri->segment(4));
		$this->bayar();
	}
	
	function bayar(){
		if($this->session->userdata('sesi_thajaranpembayaran')){
			$data['thakad'] = $this->session->userdata('sesi_thajaranpembayaran');
		}else{
			$set = $this->simsetting_m->select_active();
			$data['thakad'] = $set['thajaran'];
		}
		$data['title'] = 'History Pembayaran';
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['browse_thajar'] = $this->pembayaran_m->get_thbynim($nim);
		$cek = $this->pembayaran_m->get_idbiaya_bynim($nim, $data['thakad']);
		//$data['cek_biaya'] = $cek['idbiaya'];
		$cek_kodeprodi = $this->simambilmk_m->get_kdprodibynim($nim);
		$data['kodeprodi'] = $cek_kodeprodi;
		$data['browse_bayar'] = $this->pembayaran_m->get_biaya($nim, $data['thakad']);
		$this->load->view('mhs/pembayaran/tpembayaran_v', $data);
	}
	
}


?>