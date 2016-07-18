<?php
	Class Transkrip extends Controller{
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
				"sesi_menu_transkrip" => "active",
				"sesi_menu_profil" => "",
				"sesi_menu_about" => "",
				"sesi_menu_help" => ""
			);
			$this->session->set_userdata($armenumhs);
			$this->load->model("kuliah_m","",TRUE);
			$this->load->model("peserta_m","",TRUE);
		}
		
		function index(){
			$nim = $this->session->userdata('sesi_user_mhs');
			$data['browse_transkrip'] = $this->kuliah_m->select_by($nim);
			$data["main"] = "mhs/ttranskrip_v";
			$this->load->view("mhs/main_v",$data);
		}

		function cetak_transkrip_generate($nim){
			$data["transkrip_generate"] = $this->peserta_m->transkrip_generate();
		}
		
		function generate(){
			$nim = $data["nim"] = $this->session->userdata("sesi_user_mhs");
			$data["transkrip_atas"] = $this->peserta_m->hit_ipk($nim);
			// Kayaknya bisa dihapus ;) ntar kalo error, di uncomment
			//$rec = $this->settings_m->detail();
			// Menghitung Total SKS dan IPKomulatif
			$data["transkrip_generate"] = $this->peserta_m->transkrip_generate($nim);
			//echo $this->db->last_query();
			// Tampilkan Tahun Akademik yang diikuti mahasiswa terpilih
			//$data["thn_akademik"] = $this->kuliah_m->thn_akads($nim);
			//echo $this->db->last_query();
			$data["main"] = "mhs/ttranskrip_generate_v";
			$this->load->view("mhs/main_v",$data);		
		}		
	}
?>