<?php
	Class Propinsi extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("propinsi_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("html");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->library('form_validation');
		}
		
		function index(){
			$data["main"] = "admin/tpropinsi_v";
			$data["browse_propinsi"] = $this->propinsi_m->select();
			$this->load->view("admin/main_v",$data);
		}

		function browse(){
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/propinsi/browse/";
			$data["per_page"]		= 20;
			if($this->uri->segment(4)=="propinsi"){
				$newdata = array(
	                   "sesi_pro"  => ""
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_pro'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_pro = $this->session->userdata("sesi_pro");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pro")){
				$this->db->like('nmprotbpro', $sesi_pro);
				$this->db->from('tbpro');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("tbpro");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pro")){
				$data["browse_propinsi"] = $this->propinsi_m->select_cari($data["no"],$data["per_page"],$sesi_pro);
			}else{
				$data["browse_propinsi"] = $this->propinsi_m->select($data["no"],$data["per_page"]);			
			}
			//echo $this->db->last_query();
			$this->load->view("admin/browse_propinsi_v",$data);
		}
	}
?>