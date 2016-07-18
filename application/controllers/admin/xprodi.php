<?php
	Class Prodi extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("prodi_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("html");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_homepage" => "",
				"mn_kurmatkul" => "",
				"mn_prodi" => "active",
				"mn_dosen" => "",
				"mn_biodata" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function index(){
			$data["main"] = "admin/tprodi_v";
			$data["browse_prodi"] = $this->prodi_m->select();
			$this->load->view("admin/main_v",$data);
		}

		function browse(){
			//$nim_awal = $this->prodi_m->auto_nim();
			//$nim_awal['jumnim'];
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/prodi/browse/";
			$data["per_page"]		= 20;
			$data["total_rows"]	= $this->db->count_all("akd_prodi");
			$this->pagination->initialize($data);
			$data["browse_prodi"] = $this->prodi_m->select($data["no"],$data["per_page"]);
			$this->load->view("admin/browse_prodi_v",$data);
		}
		
		function input(){
			$data["title"]	= "Form Tambah Program Studi";
			$data["browse_tbkod30"] = $this->kode_m->select_tbkod30();
			$data["browse_tbkod29"] = $this->kode_m->select_tbkod29();
			$data["browse_tbkod7"] = $this->kode_m->select_tbkod7();
			$data["browse_tbkod4"] = $this->kode_m->select_tbkod4();
			$data["browse_tbkod14"] = $this->kode_m->select_tbkod14();
			$data["main"]	= "admin/iProdi_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
			$data["browse_tbkod30"] = $this->kode_m->select_tbkod30();
			$data["browse_tbkod29"] = $this->kode_m->select_tbkod29();
			$data["browse_tbkod7"] = $this->kode_m->select_tbkod7();
			$data["browse_tbkod4"] = $this->kode_m->select_tbkod4();
			$data["browse_tbkod14"] = $this->kode_m->select_tbkod14();

			$data["title"] = "Form Pengubahan Data prodi";
			$data["main"]	= "admin/eprodi_v";
			$data["id_prodi"]= $this->uri->segment(4);
			$data["detail_prodi"] = $this->prodi_m->detail($data["id_prodi"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$this->prodi_m->insert();
			$this->db->last_query();
			redirect("admin/prodi");
		}

		function ubah(){
			$this->prodi_m->update();
			redirect("admin/prodi");
		}

		function detail(){
			$data["title"]	= "Detail Data Prodi";
			$id_prodi		= $this->uri->segment(4);
			$data["detail_prodi"] = $this->prodi_m->detail($id_prodi);
			$this->load->view("admin/tdprodi_v",$data);
		}

		function hapus(){
			$this->prodi_m->delete($this->uri->segment(4));
			redirect('admin/prodi', 'refresh');
		}

		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_prodi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data prodi";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/sprodi_v";
			$this->load->view("admin/template_v",$data);
		}

		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_prodi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data prodi";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/sprodi_v";
			$data["cari_prodi"]= $this->prodi_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>