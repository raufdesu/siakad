<?php
Class Main extends Controller {
	function __construct()
	{
		parent::Controller();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			date_default_timezone_set("Asia/Jakarta");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			//if(($this->session->userdata("sesi_user")==false)&&(!$this->session->userdata("sesi_status")=="2")){
			if(($this->session->userdata("sesi_status_mhs") <> "2") && ($this->session->userdata("sesi_user_mhs")==false)){
				redirect(base_url());
			}
			$this->load->helper("globals");

			$armenumhs = array(
				"sesi_menu_homepage" => "active",
				"sesi_menu_krs" => "",
				"sesi_menu_khs" => "",
				"sesi_menu_transkrip" => "",
				"sesi_menu_profil" => "",
				"sesi_menu_about" => "",
				"sesi_menu_help" => ""
			);
			$this->session->set_userdata($armenumhs);
			$this->load->library(array('simpliparse','simplival','fungsi','pquery'));
	}
	function index(){
		$this->load->model(array("masmahasiswa_m", "profil_m"));
		$this->load->model("simaktifsemester_m");
		$this->load->model("simaktifksp_m");
		$data['pt'] = $this->profil_m->get_one();
		$data["aktifsemester"] = $this->simaktifsemester_m->cek_aktifsemester($this->session->userdata("sesi_user_mhs"));
		$data["aktifksp"] = $this->simaktifksp_m->cek_aktifsemester($this->session->userdata("sesi_user_mhs"));
		$data["browse_mahasiswa"] = $this->masmahasiswa_m->detail_awal($this->session->userdata("sesi_user_mhs"));
		$this->load->view("mhs/main_v",$data);
	}
	function home(){
		$this->load->view("mhs/home_v");
	}
}