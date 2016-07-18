<?php
	Class Skripsi extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("admin/skripsi_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->helper("globals");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_mhs" => "",
				"mn_skripsi" => "active",
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

		function index(){
			if($this->uri->segment(4) == "skripsi"){
				$drop_sesi = array(
					"sesi_cari_skripsi" => ""
				);
				$this->session->set_userdata($drop_sesi);
			}
			if($this->input->post("txtCari")){
				$this->session->set_userdata("sesi_cari_skripsi",$this->input->post("txtCari"));
			}
			if($this->input->post("cb_dpa")){
				$this->session->set_userdata("sesi_akad", $this->input->post("cb_dpa"));
			}
			if($this->input->post("cb_semester")){
				$this->session->set_userdata("sesi_semester", $this->input->post("cb_semester"));
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]	= $this->uri->segment(4);
			}
			$sesi_cari_skripsi = $this->session->userdata("sesi_cari_skripsi");
			$data["base_url"]	= base_url()."index.php/admin/skripsi/index/";
			$data["per_page"]	= 8;
			if($sesi_cari_skripsi == true){
				$this->db->select("*");
				$this->db->from("akd_trskripsi");
				$this->db->where("thakad",$this->session->userdata("sesi_akad").$this->session->userdata("sesi_semester"));
				$this->db->like("judul",$sesi_cari_skripsi);
				$data["total_rows"] = $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_trskripsi");
			}
			$this->pagination->initialize($data);

			if(!$this->session->userdata("sesi_akad")){
				$data["browse_skripsi"] = "";
			}else{
				$thakad = $this->session->userdata("sesi_akad").$this->session->userdata("sesi_semester");
				$data["browse_skripsi"] = $this->skripsi_m->select($data["no"],$data["per_page"],$thakad,$sesi_cari_skripsi);
			}
			$data["main"] = "admin/tskripsi_v";
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
			//echo $this->db->last_query();
			$this->load->view("admin/browse_skripsi_v",$data);
		}

		function input(){
			/*$data["title"]	= "Form Tambah Program Studi";
			$data["browse_tbkod1"] = $this->kode_m->select_tbkod1();
			$data["browse_tbkod2"] = $this->kode_m->select_tbkod2();
			$data["browse_tbkod3"] = $this->kode_m->select_tbkod3();
			$data["browse_tbkod15"] = $this->kode_m->select_tbkod15();*/
			$data["main"]	= "admin/iskripsi_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
			$data["main"]	= "admin/eskripsi_v";
			$nim		= $this->uri->segment(4);
			$tglselesai	= $this->uri->segment(5);
			$data["detail_skripsi"] = $this->skripsi_m->detail($nim, $tglselesai);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$tgl_next =  next_date($this->input->post("tglawal"));
			$this->skripsi_m->insert($tgl_next);
			redirect("admin/skripsi");
		}

		function ubah(){
			$this->skripsi_m->update();
			redirect("admin/skripsi");
		}

		function detail(){
			$id_skripsi		= $this->uri->segment(4);
			$tglawal		= $this->uri->segment(5);
			$data["detail_skripsi"] = $this->skripsi_m->detail($id_skripsi,$tglawal);
			$this->load->view("admin/tdskripsi_v",$data);
		}

		function hapus(){
			$this->skripsi_m->delete($this->uri->segment(4),$this->uri->segment(5));
			redirect('admin/skripsi', 'refresh');
		}

		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_skripsi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data skripsi";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/sskripsi_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_skripsi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data skripsi";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/sskripsi_v";
			$data["cari_skripsi"]= $this->skripsi_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>