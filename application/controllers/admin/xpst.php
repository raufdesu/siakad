<?php
	Class Pst extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("pst_m","",TRUE);
			$this->load->model("pst_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->library('form_validation');
			$this->load->helper("html");
		}
		
		function index(){
			$data["main"] = "tpst_v";
			$data["browse_pst"] = $this->pst_m->select();
			$this->load->view("main_v",$data);
		}

		function browse(){
			if(!$this->uri->segment(3)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(3);
			}
			$data["base_url"]		= base_url()."index.php/pst/browse/";
			$data["per_page"]		= 20;
			$data["main"]			= "browse_pst_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_pst'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			//$data["sesi_pst"] = $this->session->userdata("sesi_pst");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pst")){
				$this->db->like('nmpsttbpst', $this->input->post("txtCari"));
				$this->db->from('tbpst');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("tbpst");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pst")){
				$data["browse_pst"] = $this->pst_m->select_cari($data["no"],$data["per_page"],$this->input->post("txtCari"));
			}else{
				$data["browse_pst"] = $this->pst_m->select($data["no"],$data["per_page"]);			
			}
			$this->load->view("browse_pst_v",$data);
		}

		function input(){
			$data["title"]	= "Form Tambah Program Studi";
			$data["browse_tbpst"] = $this->pst_m->select_tbpst();
			$data["browse_tbkod4"] = $this->kode_m->select_tbkod4();
			$data["browse_tbkod4"] = $this->kode_m->select_tbkod4();
			$data["browse_tbkod14"] = $this->kode_m->select_tbkod14();
			$data["main"]	= "ipst_v";
			$this->load->view("main_v",$data);
		}
		
		function edit(){
			$data["title"] = "Form Pengubahan Data pst";
			$data["main"]	= "epst_v";
			$data["id_pst"]= $this->uri->segment(3);
			$data["detail_pst"] = $this->pst_m->detail($data["id_pst"]);
			$this->load->view("main_v",$data);
		}
		
		function simpan(){
			$this->pst_m->insert();
			echo $this->db->last_query();
			//redirect("pst");
		}

		function ubah(){
			$this->pst_m->update();
			redirect("pst");
		}

		function detail(){
			$data["title"] = "Detail Data pst";
			$id_pst		= $this->uri->segment(4);
			$data["detail_pst"] = $this->pst_m->detail($id_pst);
			$this->load->view("tdpst_v",$data);
		}

		function hapus(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_pst"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			
		
			$this->pst_m->delete($this->uri->segment(4));
			redirect('admin/pst/', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_pst"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data pst";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/spst_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_pst"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data pst";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/spst_v";
			$data["cari_pst"]= $this->pst_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>