<?php
	Class Matakuliah extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("matakuliah_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->helper("html");
			$this->load->library('form_validation');
		}
		
		function index(){
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/matakuliah/index/";
			$data["per_page"]		= 10;
			$data["main"]			= "admin/tMatakuliah_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   "sesi_matkul"  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}elseif($this->uri->segment(4) == "matakuliah"){
				$newdata = array(
	                   "sesi_matkul"  => ""
	               );
				$this->session->set_userdata($newdata);			
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_matkul")){
				$this->db->like('nama1', $this->session->userdata("sesi_matkul"));
				$this->db->from('akd_matakuliah');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_matakuliah");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_matkul")){
				$data["browse_matakuliah"] = $this->matakuliah_m->select_cari($data["no"],$data["per_page"],$this->session->userdata("sesi_matkul"));
			}else{
				$data["browse_matakuliah"] = $this->matakuliah_m->select($data["no"],$data["per_page"]);
			}
			$this->load->view("admin/main_v",$data);
		}
		
		function browse(){
			if(!$this->uri->segment(3)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(3);
			}
			$data["base_url"]		= base_url()."index.php/admin/matakuliah/browse/";
			$data["per_page"]		= 20;
			if($this->uri->segment(4)=="matakuliah"){
				$newdata = array(
	                   "sesi_matkul"  => ""
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_matkul'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_matkul = $this->session->userdata("sesi_matkul");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_matkul")){
				$data["total_rows"]	= $this->matakuliah_m->count_matakuliah($sesi_matkul);
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_matakuliah");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_matkul")){
				$data["browse_matakuliah"] = $this->matakuliah_m->select_cari($data["no"],$data["per_page"],$sesi_matkul);
			}else{
				$data["browse_matakuliah"] = $this->matakuliah_m->select($data["no"],$data["per_page"]);			
			}
			//echo $this->db->last_query();
			$this->load->view("admin/browse_matakuliah_v",$data);
		}

		function input(){
			$data["title"] 	= "Form Tambah matakuliah";
			$data["main"]  	= "admin/iMatakuliah_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
			$data["title"]			= "Form Pengubahan Data matakuliah";
			$data["main"]			= "admin/eMatakuliah_v";
			$data["id_matakuliah"]	= $this->uri->segment(4);
			$data["detail_matakuliah"] = $this->matakuliah_m->detail($data["id_matakuliah"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			/*$this->form_validation->set_rules('nama_matakuliah', 'Nama', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				echo "<font size='6' color='red'>Mohon Untuk Menghidupkan Content Javascript Pada Browser anda</font>";
				exit;
			} */
			$this->matakuliah_m->insert();
			redirect("admin/matakuliah");
		}

		function ubah(){
			$this->matakuliah_m->update();
			redirect("admin/matakuliah");
		}

		function detail(){
			$data["title"] 	= "Detail Data matakuliah";
			$id_kurmatakuliah = $this->uri->segment(4);
			$data["detail_kurmatakuliah"] = $this->kurmatakuliah_m->detail($id_kurmatakuliah);
			$this->load->view("admin/tdKurmatakuliah_v",$data);
		}

		function hapus(){
			$this->matakuliah_m->delete($this->uri->segment(4));
			redirect('admin/matakuliah/', 'refresh');
		}

/*		function cari(){
			$data["title"] 	= "Form Pencarian Data Matakuliah";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/sMatakuliah_v";
			$this->load->view("template_v",$data);
		}
*/		
		function do_cari(){
			if(!$this->uri->segment(3)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(3);
			}
			$data["base_url"]		= base_url()."index.php/pst/browse/";
			$data["per_page"]		= 20;
			$data["main"]			= "admin/browse_pst_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_pst'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pst")){
				$this->db->like('nama1', $this->input->post("txtCari"));
				$this->db->from('akd_matakuliah');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_matakuliah");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pst")){
				$data["browse_pst"] = $this->pst_m->select_cari($data["no"],$data["per_page"],$this->input->post("txtCari"));
			}else{
				$data["browse_pst"] = $this->pst_m->select($data["no"],$data["per_page"]);			
			}
			$this->load->view("admin/browse_pst_v",$data);
		}
	}
?>