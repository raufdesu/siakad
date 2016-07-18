<?php
	Class Khs extends Controller{
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
				"sesi_menu_khs" => "active",
				"sesi_menu_transkrip" => "",
				"sesi_menu_profil" => "",
				"sesi_menu_about" => "",
				"sesi_menu_help" => ""
			);
			$this->session->set_userdata($armenumhs);
		}
		
		function index(){
			/*$nim = $this->session->userdata("sesi_user_mhs");
			$rec = $this->settings_m->detail(); 
			$thn_akad2 = $rec["thn_akad"]+1;
			$data["thn_akad"] = $rec['thn_akad']."/".$thn_akad2;
			if($rec['semester'] == "1"){
				$data["semester"] = "Ganjil";			
			}else{
				$data["semester"] = "Genap";
			}
			$thakad = $rec['thn_akad'].$rec["semester"]; */
			$nim = $this->session->userdata('sesi_user_mhs');
			$thakad = $data['thakad'] = '20101';
			if($this->khs_m->khs_permahasiswa($nim, $thakad) == false){
				$data["main"] = "mhs/empty_v";
			}else{
				/* $jum = $this->khs_m->count_sks($nim, $thakad); */
				$jum = 20;
				$data["jum_sks"] = $jum['jumsks'];
				$data["browse_khs"] = $this->khs_m->khs_permahasiswa($nim, $thakad);
				$data["main"] = "mhs/tKhs_v";
			}
			$this->load->view("mhs/main_v",$data);
		}
	}
?>