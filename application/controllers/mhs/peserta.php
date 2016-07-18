<?php
	Class Peserta extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("peserta_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->library('form_validation');
		}

		function index(){
			$data["mahasiswa"] = "";
			$data["peserta"] = "active";
			if($this->uri->segment(3)=="peserta"){
				$this->session->set_userdata("sesi_peserta","");
			}
			if(!$this->uri->segment(3)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(3);
			}
			$data["base_url"]		= base_url()."index.php/peserta/index/";
			$data["per_page"]		= 10;
			$data["main"]			= "tpeserta_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   "sesi_peserta"  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_peserta")){
				$this->db->like('amat.nama1', $this->session->userdata("sesi_peserta"));
				$this->db->from('akd_peserta akul');
				$this->db->join("akd_kurmk akur","akul.kdmk = akur.kdkmk");
				$this->db->join("akd_matapeserta amat","akur.id_mk = amat.id_mk");
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_peserta");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_peserta")){
				$data["browse_peserta"] = $this->peserta_m->select_cari($data["no"],$data["per_page"],$this->session->userdata("sesi_peserta"));
			}else{
				$data["browse_peserta"] = $this->peserta_m->select($data["no"],$data["per_page"]);
			}
			$this->load->view("main_v",$data);
		}

		function input(){
			$data["title"]	= "Form Tambah Perpesertaan";
			$data["main"]	= "ipeserta_v";
			$this->load->view("main_v",$data);
		}
		
		function edit(){
			$kd_peserta		= $this->uri->segment(3);
			$data["detail_peserta"] = $this->peserta_m->detail($kd_peserta);
			$data["main"]	= "epeserta_v";
			//$data["kd_peserta"]= $this->uri->segment(3);
			$this->load->view("main_v",$data);
		}
		
		function simpan(){
			$this->form_validation->set_rules('nama1', 'Nama Matakuliah', 'required');
			$this->load->library('form_validation');
			if($this->form_validation->run() == FALSE){
				redirect("mhs/krs/input/Masukkan Kode Matakuliah","Refresh");
			}
			$this->peserta_m->insert();
			redirect("mhs/krs/input");
		}

		function ubah(){
			$this->peserta_m->update();
			redirect("peserta");
		}

		function detail(){
			$data["title"] = "Detail Data peserta";
			$id_peserta		= $this->uri->segment(3);
			$data["detail_peserta"] = $this->peserta_m->detail($id_peserta);
			$this->load->view("tdpeserta_v",$data);
		}

		function hapus(){
			$this->peserta_m->delete($this->uri->segment(3));
			redirect('peserta', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_peserta"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data peserta";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/speserta_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_peserta"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data peserta";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/speserta_v";
			$data["cari_peserta"]= $this->peserta_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>