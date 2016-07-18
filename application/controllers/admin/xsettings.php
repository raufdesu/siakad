<?php
	Class Settings extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("settings_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->library('form_validation');
			$this->load->view("admin/aut_v");
			$sesmain_mn = array(
				"mn_mhs" => "",
				"mn_skripsi" => "",
				"mn_password" => "",
				"mn_khs" => "",
				"mn_dpa" => "",
				"mn_kuliah" => "",
				"mn_nilai" => "",
				"mn_set" => "active",
			);
			$this->session->set_userdata($sesmain_mn);
		}
		
		function aktifkan_akses_krs_mhs(){
			$this->settings_m->aktifkan_akses_krs_mhs();
			redirect("admin/settings/","refresh");
		}
		
		function nonaktifkan_akses_krs_mhs(){
			$this->settings_m->nonaktifkan_akses_krs_mhs();
			redirect("admin/settings/","refresh");
		}
		
		function index(){
			$data["cek_aktifkan_akses_krs_mhs"] = $this->settings_m->cek_aktif_krs_akademik();
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
				$data["base_url"]		= base_url()."index.php/admin/settings/index/";
				$data["per_page"]		= 10;
				$data["main"]			= "admin/tsettings_v";
				$data["total_rows"]	= $this->db->count_all("settings");
				$this->pagination->initialize($data);
			$data["browse_settings"] = $this->settings_m->select($data["no"],$data["per_page"]);
			$this->load->view("admin/main_v",$data);
		}

		function input(){
			//$data["title"]	= "Form Tambah Persettingsan";
			$data["main"]	= "admin/isettings_v";
			$this->load->view("admin/main_v",$data);
		}

		function no_aktif(){
			$this->settings_m->non_aktif();
			redirect("admin/settings");
		}

		function aktif(){
			$id = $this->uri->segment(4);
			$this->settings_m->non_aktif();
			$this->settings_m->aktifkan($id);
			$akt = $this->settings_m->detail();
			$ar_settings = array(
					"sesi_semester" => $akt["semester"],
					"sesi_thn_akad" => $akt["thn_akad"]

//					"sesi_thn_akademik" => $akt["thn_akad"],
//				"sesi_semester" => $akt["semester"]
			);
			$this->session->set_userdata($ar_settings);
			redirect("admin/settings");
		}

		function edit(){
			$kd_settings	= $this->uri->segment(4);
			$data["detail_settings"] = $this->settings_m->detail($kd_settings);
			$data["main"]	= "esettings_v";
			//$data["kd_settings"]= $this->uri->segment(3);
			$this->load->view("admin/main_v",$data);
		}

		function simpan(){
			$this->settings_m->insert();
			redirect("admin/settings");
		}

		function ubah(){
			$this->settings_m->update();
			redirect("admin/settings");
		}

		function detail(){
			$data["title"]	= "Detail Data settings";
			$id_settings	= $this->uri->segment(4);
			$data["detail_settings"] = $this->settings_m->detail($id_settings);
			$this->load->view("admin/tdsettings_v",$data);
		}

		function hapus(){
			$this->settings_m->delete($this->uri->segment(4));
			redirect('settings', 'refresh');
		}
				
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_settings"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data settings";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/ssettings_v";
			$data["cari_settings"]= $this->settings_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>