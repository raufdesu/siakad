<?php
	Class Transkrip extends Controller{
		function __construct(){
			parent::Controller();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			$this->load->model("mahasiswa_m");
			$this->load->library("pagination");
			$this->load->model("settings_m");
			$this->load->model("peserta_m");
			$this->load->model("khs_m");
			$sesmain_mn = array(
				"mn_mhs" => "",
				"mn_skripsi" => "",
				"mn_password" => "",
				"mn_khs" => "active",
				"mn_dpa" => "",
				"mn_kuliah" => "",
				"mn_nilai" => "",
				"mn_set" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function index(){
			if($this->input->post("txtCari")){
				$newdata = array(
	                   "sesi_mahasiswa"  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}elseif($this->uri->segment(4) == "mahasiswa"){
				$newdata = array(
	                   "sesi_mahasiswa"  => "",
					   "sesi_mhs_status" => ""
	               );
				$this->session->set_userdata($newdata);
			}
			$data["status_mhs"] = $this->mahasiswa_m->status_mhs();
			if($this->input->post("cb_status_mhs")){
				$this->session->set_userdata("sesi_mhs_status",$this->input->post("cb_status_mhs"));
			}
			$status_mhs = $this->session->userdata("sesi_mhs_status");
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/khs/index/";
			$data["per_page"]		= 10;
			$data["main"]			= "admin/tMahasiswa_khs_v";
			if(($this->input->post("cmdCari")) || ($this->session->userdata("sesi_mahasiswa")) || ($status_mhs)){
				$this->db->like('nmmhsmsmhs', $this->session->userdata("sesi_mahasiswa"));
				$this->db->from('akd_mhs');
				if($status_mhs){
					$this->db->where("stmhsmsmhs",$status_mhs);
				}
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_mhs");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_mahasiswa")){
				$data["browse_mahasiswa"] = $this->mahasiswa_m->select_cari($data["no"],$data["per_page"],$this->session->userdata("sesi_mahasiswa"),$status_mhs);
			}else{
				$data["browse_mahasiswa"] = $this->mahasiswa_m->select($data["no"],$data["per_page"],$status_mhs);
			}
			$this->load->view("admin/main_v",$data);
//			$data["main"] = "admin/tMhs_khs_v";
//			$this->load->view("admin/main_v",$data);
		}

	}
?>