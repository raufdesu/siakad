<?php
	Class Krs extends Controller{
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
			$this->load->model("mahasiswa_m","",TRUE);
			$this->load->model("settings_m","",TRUE);
			$this->load->model("peserta_m","",TRUE);
			$armenumhs = array(
				"sesi_menu_homepage" => "",
				"sesi_menu_krs" => "active",
				"sesi_menu_khs" => "",
				"sesi_menu_transkrip" => "",
				"sesi_menu_profil" => "",
				"sesi_menu_about" => "",
				"sesi_menu_help" => ""
			);
			$this->session->set_userdata($armenumhs);
		}
		
		function input(){
			$data["main"] = "mhs/ikrs_v";
			$this->load->view("mhs/main_v",$data);
		}
		
		function hapus(){
			$this->peserta_m->delete($this->uri->segment(4),$this->uri->segment(5));
			redirect("mhs/krs/input","refresh");
		}
		
		function cetak_krs(){
			$this->load->helper("html");
			$nim = $this->session->userdata("sesi_user_mhs");
			$rec = $this->settings_m->detail();
			$thn_akad2 = $rec["thn_akad"]+1;
			$data["thn_akad"] = $rec['thn_akad']."/".$thn_akad2;
			if($rec['semester'] == "1"){
				$data["semester"] = "Ganjil";			
			}else{
				$data["semester"] = "Genap";
			}
			$thakad = $rec['thn_akad'].$rec["semester"];
			$data["detail_settings"] = $this->settings_m->detail();
			$data["detail_mahasiswa"] = $this->mahasiswa_m->detail($nim);
			//echo $this->db->last_query();
			$data["detail_krs_peserta"] = $this->peserta_m->detail_krs_peserta($nim,$thakad);
			$this->load->view("mhs/laporan/ckrs_v",$data);
		}
	}
?>