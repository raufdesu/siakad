<?php
	Class Krs extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->library('form_validation');
			$this->load->model("mahasiswa_m","",TRUE);
			$this->load->model("dosen_m","",TRUE);
			$sesmain_mn = array(
				"mn_mhs" => "",
				"mn_skripsi" => "",
				"mn_password" => "",
				"mn_khs" => "",
				"mn_dpa" => "active",
				"mn_kuliah" => "",
				"mn_nilai" => "",
				"mn_set" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function penentuan_dpa(){
			if($this->input->post("cb_dpa")){
				$this->session->set_userdata("sesi_dosen_dpa", $this->input->post("cb_dpa"));
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]	= $this->uri->segment(4);
			}
			$data["base_url"]	= base_url()."index.php/admin/krs/penentuan_dpa/";
			$data["per_page"]	= 10;
			$data["total_rows"]	= $this->mahasiswa_m->count_mhs_yes_per_dpa(); //$this->db->count_all("peg_biodata");
			$this->pagination->initialize($data);
			
			$data["dosen_dpa"] = $this->dosen_m->select_dosen_dpa();
			if(!$this->session->userdata("sesi_dosen_dpa")){
				$data["mhs_yes_dpa"] = "";
			}else{
				$data["mhs_yes_dpa"] = $this->mahasiswa_m->select_yes_dpa($data["no"],$data["per_page"],$this->session->userdata("sesi_dosen_dpa"));
			}
			$data["main"] = "admin/tTentukan_dpa_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function browse_mhs_no_dpa(){
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}

			if($this->uri->segment(4) == "mahasiswa"){
				$this->session->set_userdata("sesi_mhs","");
			}
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_mhs'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$data["per_page"]	= 10;
			$sesi_mhs = $this->session->userdata("sesi_mhs");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_mhs")){
				$this->db->like('nmmhsmsmhs', $sesi_mhs);
				$this->db->from('akd_mhs');
				$data["total_rows"]	= $this->db->count_all_results();
				$data["mhs_no_dpa"] = $this->mahasiswa_m->select_cari_no_dpa($data["no"],$data["per_page"],$sesi_mhs);
			}else{
				$data["total_rows"]	= $this->mahasiswa_m->count_krs();
				$data["mhs_no_dpa"] = $this->mahasiswa_m->select_no_dpa($data["no"],$data["per_page"]);
			}
			$data["base_url"]	= base_url()."index.php/admin/krs/browse_mhs_no_dpa/";
			$this->pagination->initialize($data);
			$this->load->view("admin/browse_mhs_no_dpa_v",$data);
		}
		function simpan_dpa(){
			if($this->input->post("n") == "mahasiswa"){
				$awal = 0;
			}else{
				$awal = $this->input->post("n");
			}
			$akhir = $this->input->post("n")+10;
			//echo "simpan"; exit;
			for($i = $awal; $i <= $akhir; $i++){
				if($this->input->post("mhs".$i)){
					$nim = $this->input->post("mhs".$i);
					$this->mahasiswa_m->update_dpa($nim);
				}
			}
			redirect("admin/krs/close_window","refresh");
		}
		function hapus_dpa(){
			$this->mahasiswa_m->delete_dpa($this->uri->segment(4));
			redirect("admin/krs/penentuan_dpa","refresh");
		}
		function close_window(){
			$this->load->view("admin/tclose_v");
		}
	}
?>