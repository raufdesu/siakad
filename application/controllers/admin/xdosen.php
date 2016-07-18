<?php
	Class Dosen extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("dosen_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->helper("globals");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_homepage" => "",
				"mn_kurmatkul" => "",
				"mn_prodi" => "",
				"mn_dosen" => "active",
				"mn_biodata" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}
		
		function index(){
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/dosen/index/";
			$data["per_page"]		= 10;
			$data["main"]			= "admin/tdosen_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   "sesi_dosen"  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}elseif($this->uri->segment(4) == "dosen"){
				$newdata = array(
	                   "sesi_dosen"  => ""
	               );
				$this->session->set_userdata($newdata);			
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_dosen")){
				$this->db->like('nama', $this->session->userdata("sesi_dosen"));
				$this->db->from('peg_biodata');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_dosen");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_dosen")){
				$data["browse_dosen"] = $this->dosen_m->select_cari($data["no"],$data["per_page"],$this->session->userdata("sesi_dosen"));
			}else{
				$data["browse_dosen"] = $this->dosen_m->select($data["no"],$data["per_page"]);
			}
			$this->load->view("admin/main_v",$data);
		}

		function browse(){
			if($this->uri->segment(4)=="dosen"){
				$newdata = array(
	                   'sesi_dosen'  => ""
	               );
				$this->session->set_userdata($newdata);				
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/dosen/browse/";
			$data["per_page"]		= 20;
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_dosen'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_dosen = $this->session->userdata("sesi_dosen");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_dosen")){
				$this->db->like('nama', $sesi_dosen);
				$this->db->from('peg_biodata');
				$data["total_rows"]	= $this->db->count_all_results();
				//$data["total_rows"]	= 8;
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_dosen");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_dosen")){
				$data["browse_dosen"] = $this->dosen_m->select_cari($data["no"],$data["per_page"],$sesi_dosen);
			}else{
				$data["browse_dosen"] = $this->dosen_m->select($data["no"],$data["per_page"]);			
			}
			//echo $this->db->last_query();
			$this->load->view("admin/browse_dosen_v",$data);
		}

		function browse2(){
			if($this->uri->segment(4)=="dosen"){
				$newdata = array(
	                   'sesi_dosen'  => ""
	               );
				$this->session->set_userdata($newdata);				
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/dosen/browse2/";
			$data["per_page"]		= 20;
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_dosen'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_dosen = $this->session->userdata("sesi_dosen");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_dosen")){
				$this->db->like('nama', $sesi_dosen);
				$this->db->from('peg_biodata');
				$data["total_rows"]	= $this->db->count_all_results();
				//$data["total_rows"]	= 8;
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_dosen");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_dosen")){
				$data["browse_dosen"] = $this->dosen_m->select_cari($data["no"],$data["per_page"],$sesi_dosen);
			}else{
				$data["browse_dosen"] = $this->dosen_m->select($data["no"],$data["per_page"]);			
			}
			//echo $this->db->last_query();
			$this->load->view("admin/browse_dosen2_v",$data);
		}

		function input(){
			$data["title"]	= "Form Tambah Program Studi";
			$data["browse_tbkod1"] = $this->kode_m->select_tbkod1();
			$data["browse_tbkod2"] = $this->kode_m->select_tbkod2();
			$data["browse_tbkod3"] = $this->kode_m->select_tbkod3();
			$data["browse_tbkod15"] = $this->kode_m->select_tbkod15();
			$data["main"]	= "admin/idosen_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
			$data["browse_tbkod1"] = $this->kode_m->select_tbkod1();
			$data["browse_tbkod2"] = $this->kode_m->select_tbkod2();
			$data["browse_tbkod3"] = $this->kode_m->select_tbkod3();
			$data["browse_tbkod15"] = $this->kode_m->select_tbkod15();

			$data["title"] = "Form Pengubahan Data Dosen";
			$data["main"]	= "admin/eDosen_v";
			$data["id_dosen"]= $this->uri->segment(4);
			$data["detail_dosen"] = $this->dosen_m->detail($data["id_dosen"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$this->dosen_m->insert();
			redirect("admin/dosen");
		}

		function ubah(){
			$this->dosen_m->update();
			redirect("admin/dosen");
		}

		function detail(){
			$data["title"] = "Detail Data dosen";
			$id_dosen		= $this->uri->segment(4);
			$data["detail_dosen"] = $this->dosen_m->detail($id_dosen);
			$this->load->view("admin/tdDosen_v",$data);
		}

		function hapus(){
			$this->dosen_m->delete($this->uri->segment(4));
			redirect('admin/dosen', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_dosen"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data dosen";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/sdosen_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_dosen"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data dosen";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/sdosen_v";
			$data["cari_dosen"]= $this->dosen_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>