<?php
Class Masmahasiswa extends Controller{
	function __construct(){
		parent::Controller();
		header("cache-Control: no-store, no-cache, must-revalidate");
		header("cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		//if(($this->session->userdata("sesi_user")==false)&&(!$this->session->userdata("sesi_status")=="2")){
		if(($this->session->userdata("sesi_status_mhs") <> "2") && ($this->session->userdata("sesi_user_mhs")==false)){
			redirect(base_url());
		}
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->model("settings_m");
		$this->load->model("khs_m");
		$armenumhs = array(
			"sesi_menu_homepage" => "",
			"sesi_menu_krs" => "",
			"sesi_menu_khs" => "",
			"sesi_menu_transkrip" => "",
			"sesi_menu_profil" => "active",
			"sesi_menu_about" => "",
			"sesi_menu_help" => ""
		);
		$this->session->set_userdata($armenumhs);
		$this->load->model("masmahasiswa_m");
	}
	function index(){
	}
	function detail(){
		$data["detail_masmahasiswa"] = $this->masmahasiswa_m->detail($this->session->userdata("sesi_user_mhs"));
		$this->load->view("mhs/tdmasmahasiswa_v",$data);
	}
}
?>