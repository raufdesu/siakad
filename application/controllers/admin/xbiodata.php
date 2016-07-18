<?php
	Class Biodata extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("biodata_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			//$this->load->helper("globals");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_homepage" => "",
				"mn_kurmatkul" => "",
				"mn_prodi" => "",
				"mn_dosen" => "",
				"mn_biodata" => "active",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function browse(){
			if($this->uri->segment(4) == "biodata"){
				$this->session->set_userdata("sesi_bio","");
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/biodata/browse/";
			$data["per_page"]		= 20;
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_bio'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_bio = $this->session->userdata("sesi_bio");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_bio")){
				$this->db->like('nama', $sesi_bio);
				$this->db->from('peg_biodata');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("peg_biodata");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_bio")){
				$data["browse_biodata"] = $this->biodata_m->select_cari($data["no"],$data["per_page"],$sesi_bio);
			}else{
				$data["browse_biodata"] = $this->biodata_m->select($data["no"],$data["per_page"]);			
			}
			//echo $this->db->last_query();
			$this->load->view("admin/browse_biodata_v",$data);
		}

		function index(){
			$data["mahasiswa"] = "";
			$data["biodata"] = "active";
			if($this->uri->segment(4)=="biodata"){
				$this->session->set_userdata("sesi_biodata","");
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/biodata/index/";
			$data["per_page"]		= 10;
			$data["main"]			= "admin/tBiodata_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   "sesi_biodata"  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_biodata")){
				$this->db->like('nama', $this->session->userdata("sesi_biodata"));
				$this->db->from('peg_biodata');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("peg_biodata");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_biodata")){
				$data["browse_biodata"] = $this->biodata_m->select_cari($data["no"],$data["per_page"],$this->session->userdata("sesi_biodata"));
			}else{
				$data["browse_biodata"] = $this->biodata_m->select($data["no"],$data["per_page"]);
			}
			$this->load->view("admin/main_v",$data);
		}

		function input(){
			$data["title"]	= "Form Tambah Program Studi";
			$kode = $this->biodata_m->auto_kdpeg();
			$data["auto_code"] = $kode['kdpeg']+1;
			$data["browse_tbkod30"] = $this->kode_m->select_tbkod30();
			$data["browse_tbkod29"] = $this->kode_m->select_tbkod29();
			$data["browse_tbkod7"] = $this->kode_m->select_tbkod7();
			$data["browse_tbkod4"] = $this->kode_m->select_tbkod4();
			$data["browse_tbkod14"] = $this->kode_m->select_tbkod14();
			$data["main"]	= "admin/iBiodata_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
			$id_biodata		= $this->uri->segment(4);
			$data["detail_biodata"] = $this->biodata_m->detail($id_biodata);

			$data["main"]	= "admin/eBiodata_v";
			$data["id_biodata"]= $this->uri->segment(4);
			$data["detail_biodata"] = $this->biodata_m->detail($data["id_biodata"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$this->biodata_m->insert();
			redirect("admin/biodata");
		}

		function ubah(){
			$this->biodata_m->update();
			redirect("admin/biodata");
		}

		function detail(){
			$data["title"] = "Detail Data Biodata";
			$id_biodata		= $this->uri->segment(4);
			$data["detail_biodata"] = $this->biodata_m->detail($id_biodata);
			$this->load->view("admin/tdBiodata_v",$data);
		}

		function hapus(){
			$this->biodata_m->delete($this->uri->segment(4));
			redirect('admin/biodata', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_biodata"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data biodata";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/sbiodata_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_biodata"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data biodata";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/sbiodata_v";
			$data["cari_biodata"]= $this->biodata_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>