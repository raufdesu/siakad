<?php
	Class Utility extends Controller{
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
			$this->load->model("settings_m");
			$this->load->model("khs_m");
			$armenumhs = array(
				"sesi_menu_homepage" => "",
				"sesi_menu_krs" => "",
				"sesi_menu_khs" => "",
				"sesi_menu_transkrip" => "",
				"sesi_menu_profil" => ""
			);
			$this->session->set_userdata($armenumhs);
		}
		
		function about(){
			$this->session->set_userdata("sesi_menu_about","active");
			$this->session->set_userdata("sesi_menu_help","");
			$data['title'] = 'About Mahasiswa';
			// $data["main"] = "mhs/tabout_v";
			$this->load->view("mhs/tabout_v",$data);
		}
		
		function help(){
			$data["title"] = "Bantuan SIMAK STMIK EL RAHMA";
			$this->load->view("mhs/thelp_v",$data);
		}
	}
?>