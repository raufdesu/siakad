<?php
	Class Lulus extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("admin/skripsi_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->model("admin/lulus_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->helper("globals");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_mhs" => "",
				"mn_skripsi" => "",
				"mn_lulus" => "active",
				"mn_password" => "",
				"mn_khs" => "",
				"mn_dpa" => "",
				"mn_kuliah" => "",
				"mn_nilai" => "",
				"mn_set" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function index(){
			/*if(($this->input->post("cb_thn")) or ($this->input->post("cb_sem"))){
				$ses_akad = array(
					"sesi_cb_thn"=>$this->input->post("cb_thn"),
					"sesi_cb_sem"=>$this->input->post("cb_sem")
				);
				$this->session->set_userdata($ses_akad);
			}
			$thn_akad = $this->session->userdata("sesi_cb_thn").$this->session->userdata("sesi_cb_sem"); */
			if($this->uri->segment(4) == "lulus"){
				$drop_sesi = array(
					"sesi_cari_lulus" => ""
				);
				$this->session->set_userdata($drop_sesi);
			}
			if($this->input->post("txtCari")){
				$this->session->set_userdata("sesi_cari_lulus",$this->input->post("txtCari"));
			}
			$sesi_cari_skripsi = $this->session->userdata("sesi_cari_lulus");
			$data["base_url"]	= base_url()."index.php/admin/lulus/index/";
			$data["no"]	= 0;
			$data["per_page"]	= 5;
			$data["total_rows"]	= $this->lulus_m->count_lulus($data["no"],$data["per_page"],'',$sesi_cari_skripsi);
			$data["main"] = "admin/tlulus_v";
			$data["browse_lulus"] = $this->lulus_m->select($data["no"],$data["per_page"],'',$sesi_cari_skripsi);
			$this->load->view("admin/main_v",$data);
		}

		function browse(){
			if($this->uri->segment(4)=="skripsi"){
				$newdata = array(
	                   'sesi_skripsi'  => ""
	               );
				$this->session->set_userdata($newdata);				
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/skripsi/browse/";
			$data["per_page"]		= 20;
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_skripsi'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_skripsi = $this->session->userdata("sesi_skripsi");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_skripsi")){
				$this->db->like('nama', $sesi_skripsi);
				$this->db->from('peg_biodata');
				$data["total_rows"]	= $this->db->count_all_results();
				//$data["total_rows"]	= 8;
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_skripsi");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_skripsi")){
				$data["browse_skripsi"] = $this->skripsi_m->select_cari($data["no"],$data["per_page"],$sesi_skripsi);
			}else{
				$data["browse_skripsi"] = $this->skripsi_m->select($data["no"],$data["per_page"]);			
			}
			$this->load->view("admin/browse_skripsi_v",$data);
		}

		function input(){
			$data["main"]	= "admin/ilulus_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
		}
		
		function simpan(){
			$this->lulus_m->insert();
			redirect("admin/lulus","refresh");
		}

		function ubah(){
		}

		function detail(){
			$data["main"]		  = "admin/tdlulus_v";
			$data["detail_lulus"] = $this->lulus_m->detail($this->uri->segment(4));
			$this->load->view("admin/main_v", $data);
		}

		function hapus(){
			$this->lulus_m->delete($this->uri->segment(4));
			redirect("admin/lulus/","refresh");
		}

		function cari(){
		}
		
		function do_cari(){
		}
	}
?>