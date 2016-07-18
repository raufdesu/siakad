<?php
	Class Kuliah extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("kuliah_m","",TRUE);
			$this->load->model("settings_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->library('form_validation');
		}

		function browse(){
			if(!$this->uri->segment(3)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(3);
			}
			$data["base_url"]		= base_url()."index.php/kuliah/browse/";
			$data["per_page"]		= 20;
			if($this->uri->segment(4)=="kuliah"){
				$newdata = array(
	                   "sesi_kuliah"  => ""
	               );
				$this->session->unset_userdata($newdata);
			}
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_kuliah'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_kuliah = $this->session->userdata("sesi_kuliah");
			$rec = $this->settings_m->detail();
			$thakad = $rec['thn_akad'].$rec['semester'];
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_kuliah")){
				//$this->db->like('nama1', $sesi_kuliah);
				//$this->db->from('akd_kurmk akur');
				//$this->db->join('akd_matakuliah amat','akur.id_mk = amat.id_mk');
				$data["total_rows"]	= count($this->kuliah_m->select_cari($data["no"],$data["per_page"],$thakad,$sesi_kuliah));
			}else{
				$data["total_rows"]	= count($this->kuliah_m->select($data["no"],$data["per_page"],$thakad));
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_kuliah")){
				$data["browse_kuliah"] = $this->kuliah_m->select_cari($data["no"],$data["per_page"],$thakad,$sesi_kuliah);
			}else{
				$data["browse_kuliah"] = $this->kuliah_m->select($data["no"],$data["per_page"],$thakad);
			}
			//echo $this->db->last_query();
			$this->load->view("mhs/browse_kuliah_v",$data);
		}

		function index(){
			$data["mahasiswa"] = "";
			$data["kuliah"] = "active";
			if($this->uri->segment(3)=="kuliah"){
				$this->session->set_userdata("sesi_kuliah","");
			}
			if(!$this->uri->segment(3)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(3);
			}
			$data["base_url"]		= base_url()."index.php/kuliah/index/";
			$data["per_page"]		= 10;
			$data["main"]			= "tkuliah_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   "sesi_kuliah"  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_kuliah")){
				$this->db->like('amat.nama1', $this->session->userdata("sesi_kuliah"));
				$this->db->from('akd_kuliah akul');
				$this->db->join("akd_kurmk akur","akul.kdmk = akur.kdkmk");
				$this->db->join("akd_matakuliah amat","akur.id_mk = amat.id_mk");
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_kuliah");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_kuliah")){
				$data["browse_kuliah"] = $this->kuliah_m->select_cari($data["no"],$data["per_page"],$this->session->userdata("sesi_kuliah"));
			}else{
				$data["browse_kuliah"] = $this->kuliah_m->select($data["no"],$data["per_page"]);
			}
			$this->load->view("main_v",$data);
		}

		function input(){
			$data["title"]	= "Form Tambah Perkuliahan";
			$data["main"]	= "ikuliah_v";
			$this->load->view("main_v",$data);
		}
		
		function edit(){
			$kd_kuliah		= $this->uri->segment(3);
			$data["detail_kuliah"] = $this->kuliah_m->detail($kd_kuliah);
			$data["main"]	= "ekuliah_v";
			//$data["kd_kuliah"]= $this->uri->segment(3);
			$this->load->view("main_v",$data);
		}
		
		function simpan(){
			$this->kuliah_m->insert();
			redirect("kuliah");
		}

		function ubah(){
			$this->kuliah_m->update();
			redirect("kuliah");
		}

		function detail(){
			$data["title"] = "Detail Data kuliah";
			$id_kuliah		= $this->uri->segment(3);
			$data["detail_kuliah"] = $this->kuliah_m->detail($id_kuliah);
			$this->load->view("tdkuliah_v",$data);
		}

		function hapus(){
			$this->kuliah_m->delete($this->uri->segment(3));
			redirect('kuliah', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_kuliah"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data kuliah";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/skuliah_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_kuliah"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data kuliah";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/skuliah_v";
			$data["cari_kuliah"]= $this->kuliah_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>