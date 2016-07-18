<?php
	Class Mahasiswa extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("mahasiswa_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->model("prodi_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->helper("globals");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_mhs" => "active",
				"mn_skripsi" => "",
				"mn_lulus" => "",
				"mn_password" => "",
				"mn_khs" => "",
				"mn_dpa" => "",
				"mn_kuliah" => "",
				"mn_nilai" => "",
				"mn_set" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}
		function prodi(){
			$this->session->set_userdata("sesi_kdprodi", $this->uri->segment(4));
			if($this->uri->segment(4) == "all"){
				$this->session->set_userdata("sesi_kdprodi", "");
			}
			redirect(base_url()."index.php/admin/mahasiswa/","refresh");
		}

		function status_mhs(){
			$this->session->set_userdata("sesi_mhs_status", $this->input->post("cb_status_mhs"));
			redirect(base_url()."index.php/admin/mahasiswa/","refresh");
		}

		function cari_mhs(){
			$this->session->set_userdata("sesi_carimhs", $this->input->post("txtCari"));
			redirect(base_url()."index.php/admin/mahasiswa/","refresh");			
		}
		
		function index(){
			$sesi_carimhs = $this->session->userdata("sesi_carimhs");
			$sesi_statusmhs = $this->session->userdata("sesi_mhs_status");
			$sesi_kdprodi = $this->session->userdata("sesi_kdprodi");
			if($this->uri->segment(4) == "mahasiswa"){
				$rem_sesi = array(
					"sesi_carimhs" => "",
					"sesi_mhs_status" => "",
					"sesi_kdprodi" => ""
				);
				$this->session->set_userdata($rem_sesi);
				redirect(base_url()."index.php/admin/mahasiswa/","refresh");			
			}
			$data["base_url"] = base_url()."index.php/admin/mahasiswa/index/";
			$data['no'] = $this->uri->segment(4);
			$data["per_page"] = 10;
			$data["total_rows"] = $this->mahasiswa_m->count_mhs($sesi_kdprodi, $sesi_statusmhs, $sesi_carimhs);
			$data["main"] = "admin/tmahasiswa_v";
			$this->pagination->initialize($data);
			$data["status_mhs"] = $this->mahasiswa_m->status_mhs();
			$data["browse_mahasiswa"] = $this->mahasiswa_m->select($data['no'],$data['per_page'],$sesi_kdprodi, $sesi_statusmhs, $sesi_carimhs);
			/*echo $this->db->last_query();*/
			$this->load->view("admin/main_v", $data);
		}

		function aktifkan_krs(){
			$nim = $this->uri->segment(4);
			$this->mahasiswa_m->aktifkan_krs($nim);
			$this->load->view("admin/confirm_v");
		}
		
		function nonaktifkan_krs(){
			$nim = $this->uri->segment(4);
			$this->mahasiswa_m->nonaktifkan_krs($nim);
			$this->load->view("admin/confirm_v");
		}
				
		function browse(){
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/mahasiswa/browse/";
			$data["per_page"]		= 10;
			if($this->uri->segment(4) == "mahasiswa"){
				$this->session->set_userdata("sesi_mahasiswa","");
			}
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_mahasiswa'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_mahasiswa = $this->session->userdata("sesi_mahasiswa");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_mahasiswa")){
				$this->db->like('nmmhsmsmhs', $sesi_mahasiswa);
				$this->db->from('akd_mhs');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_mhs");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_mahasiswa")){
				$data["browse_mahasiswa"] = $this->mahasiswa_m->cari_mhs($data["no"],$data["per_page"],$sesi_mahasiswa);
			}else{
				$data["browse_mahasiswa"] = $this->mahasiswa_m->select_mhs($data["no"],$data["per_page"]);
			}
			$this->load->view("admin/browse_mhs_v",$data);
		}

		function browse2(){
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/mahasiswa/browse/";
			$data["per_page"]		= 10;
			if($this->uri->segment(4) == "mahasiswa"){
				$this->session->set_userdata("sesi_mahasiswa","");
			}
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_mahasiswa'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_mahasiswa = $this->session->userdata("sesi_mahasiswa");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_mahasiswa")){
				$this->db->like('nmmhsmsmhs', $sesi_mahasiswa);
				$this->db->from('akd_mhs');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_mhs");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_mahasiswa")){
				$data["browse_mahasiswa"] = $this->mahasiswa_m->cari_mhs($data["no"],$data["per_page"],$sesi_mahasiswa);
			}else{
				$data["browse_mahasiswa"] = $this->mahasiswa_m->select_mhs_transkrip($data["no"],$data["per_page"]);
			}
			$this->load->view("admin/browse_mhs2_v",$data);
		}

		function input(){
			if($this->input->post("cmdSimpan") && ($this->input->post("kdpstmsmhs"))){
				$this->simpan();
			}elseif($this->input->post("kdpstmsmhs")){
				$atr_sprodi = array(
					"sesi_prodi" => $this->input->post("kdpstmsmhs")
				);
				$this->session->set_userdata($atr_sprodi);
				$sesi_prodi = $this->session->userdata("sesi_prodi");
				$auto = $this->mahasiswa_m->auto_nim($sesi_prodi);
				$data["auto_nim"] = $auto["jumnim"]+1;
			}elseif($this->input->post("cmdSimpan")){
				$this->simpan();
			}else{
				$data["auto_nim"] = "";
			}
			/*if(!$this->session->userdata("sesi_prodi")){
				$data["auto_nim"] = "";
			}*/
				$data["title"]	= "Form Tambah Program Studi";
				$data["browse_tbkod1"] = $this->kode_m->select_tbkod1();
				$data["browse_tbkod2"] = $this->kode_m->select_tbkod2();
				$data["browse_tbkod3"] = $this->kode_m->select_tbkod3();
				$data["browse_tbkod15"] = $this->kode_m->select_tbkod15();
				$data["browse_tbkod5"] = $this->kode_m->select_tbkod5();
				$data["browse_prodi"] = $this->prodi_m->select();
				$data["main"]	= "admin/iMahasiswa_v";
				$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
			$data["browse_tbkod1"] = $this->kode_m->select_tbkod1();
			$data["browse_tbkod2"] = $this->kode_m->select_tbkod2();
			$data["browse_tbkod3"] = $this->kode_m->select_tbkod3();
			$data["browse_tbkod15"] = $this->kode_m->select_tbkod15();
			$data["browse_tbkod5"] = $this->kode_m->select_tbkod5();
			$data["browse_tbkod6"] = $this->kode_m->select_tbkod6();

			$data["title"] = "Form Pengubahan Data mahasiswa";
			$data["main"]	= "admin/emahasiswa_v";
			$data["id_mahasiswa"]= $this->uri->segment(4);
			$data["detail_mahasiswa"] = $this->mahasiswa_m->detail_awal($data["id_mahasiswa"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$this->mahasiswa_m->insert();
			redirect("admin/mahasiswa");
		}

		function ubah(){
			$this->mahasiswa_m->update();
			redirect("admin/mahasiswa");
		}

		function detail(){
			$data["title"] = "Detail Data mahasiswa";
			$id_mahasiswa		= $this->uri->segment(4);
			$data["detail_mahasiswa"] = $this->mahasiswa_m->detail_awal($id_mahasiswa);
			$this->load->view("admin/tdMahasiswa_v",$data);
		}

		function hapus(){
			$this->mahasiswa_m->delete($this->uri->segment(3));
			redirect('admin/mahasiswa', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_mahasiswa"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data mahasiswa";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/smahasiswa_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_mahasiswa"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data mahasiswa";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/smahasiswa_v";
			$data["cari_mahasiswa"]= $this->mahasiswa_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>