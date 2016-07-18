<?php
	Class Pti extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("pti_m","",TRUE);
			$this->load->model("pti_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->library('form_validation');
			$this->load->helper("html");
		}
		
		function index(){
			$data["main"] = "tpti_v";
			$data["browse_pti"] = $this->pti_m->select();
			$this->load->view("main_v",$data);
		}

		function browse(){
			if(!$this->uri->segment(3)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(3);
			}
			$data["base_url"]		= base_url()."index.php/pti/browse/";
			$data["per_page"]		= 20;
			$data["main"]			= "browse_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_pti'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			//$data["sesi_pti"] = $this->session->userdata("sesi_pti");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pti")){
				$this->db->like('nmptitbpti', $this->input->post("txtCari"));
				$this->db->from('tbpti');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("tbpti");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pti")){
				$data["browse_pti"] = $this->pti_m->select_cari($data["no"],$data["per_page"],$this->input->post("txtCari"));
			}else{
				$data["browse_pti"] = $this->pti_m->select($data["no"],$data["per_page"]);			
			}
			$this->load->view("browse_v",$data);
		}

		function input(){
			$data["title"]	= "Form Tambah Program Studi";
			$data["browse_tbpti"] = $this->pti_m->select_tbpti();
			$data["browse_tbkod4"] = $this->kode_m->select_tbkod4();
			$data["browse_tbkod4"] = $this->kode_m->select_tbkod4();
			$data["browse_tbkod14"] = $this->kode_m->select_tbkod14();
			$data["main"]	= "ipti_v";
			$this->load->view("main_v",$data);
		}
		
		function edit(){
			$data["title"] = "Form Pengubahan Data pti";
			$data["main"]	= "epti_v";
			$data["id_pti"]= $this->uri->segment(3);
			$data["detail_pti"] = $this->pti_m->detail($data["id_pti"]);
			$this->load->view("main_v",$data);
		}
		
		function simpan(){
			$this->pti_m->insert();
			echo $this->db->last_query();
			//redirect("pti");
		}

		function ubah(){
			$this->pti_m->update();
			redirect("pti");
		}

		function detail(){
			$data["title"] = "Detail Data pti";
			$id_pti		= $this->uri->segment(4);
			$data["detail_pti"] = $this->pti_m->detail($id_pti);
			$this->load->view("tdpti_v",$data);
		}

		function hapus(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_pti"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			
		
			$this->pti_m->delete($this->uri->segment(4));
			redirect('admin/pti/', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_pti"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data pti";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/spti_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_pti"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data pti";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/spti_v";
			$data["cari_pti"]= $this->pti_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>