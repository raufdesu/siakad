<?php
	Class Mastermk extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("mastermk_m","",TRUE);
			$this->load->model("prodi_m","",TRUE);
			$this->load->model("kode_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->helper("html");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_homepage" => "",
				"mn_kurmatkul" => "active",
				"mn_prodi" => "",
				"mn_dosen" => "",
				"mn_biodata" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function index(){
			if($this->input->post('txtCari')){
				$data['sesicari'] = $this->session->set_userdata('sesi_carimastermk', $this->input->post('txtCari'));
			}else{
				$data['sesicari'] = $this->session->set_userdata('sesi_carimastermk', '');			
			}
			$this->browse();
		}
		function browse(){
			$data['main'] = 'admin/tmastermk_v';
			$data["base_url"] = base_url()."index.php/admin/mastermk/browse/";
			$data["per_page"] = 20;
			$data["total_rows"]	= $this->mastermk_m->count_all();
			$data["no"]	= $this->uri->segment(4,0);
			$this->pagination->initialize($data);
			$data['browse_mastermk'] = $this->mastermk_m->select($data['no'], $data['per_page']);
			$this->load->view('admin/main_v', $data);
		}
		/* CADANGAN NTAR KALO DAH SELESAI DIHAPUS */
		function browse2(){
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/mastermk/browse/";
			$data["per_page"]		= 20;
			if($this->uri->segment(4)=="mastermk"){
				$newdata = array(
	                   "sesi_kurmatkul"  => ""
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_kurmatkul'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			$sesi_kurmatkul = $this->session->userdata("sesi_kurmatkul");
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_kurmatkul")){
				$this->db->like('nama1', $sesi_kurmatkul);
				$this->db->from('akd_kurmk akur');
				$this->db->join('akd_matakuliah amat','akur.id_mk = amat.id_mk');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_kurmk");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_kurmatkul")){
				$data["browse_mastermk"] = $this->mastermk_m->select_cari($data["no"],$data["per_page"],$sesi_kurmatkul);
			}else{
				$data["browse_mastermk"] = $this->mastermk_m->select($data["no"],$data["per_page"]);			
			}
			//echo $this->db->last_query();
			$this->load->view("admin/browse_mastermk_v",$data);
		}

		function input(){
			/*$data["browse_prodi"] = $this->prodi_m->select();
			$data["browse_wpl"] = $this->kode_m->select_tbkod28();
			$data["browse_kur"] = $this->kode_m->select_tbkod11();
			$data["browse_kel"] = $this->kode_m->select_tbkod10();*/

			$data["title"] 	= "Form Tambah Data Matakuliah";
			$data["main"]  	= "admin/imastermk_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){
			$data["browse_prodi"] = $this->prodi_m->select();
			$data["browse_wpl"] = $this->kode_m->select_tbkod28();
			$data["browse_kur"] = $this->kode_m->select_tbkod11();
			$data["browse_kel"] = $this->kode_m->select_tbkod10();

			$data["title"]				= "Form Pengubahan Data Matakuliah";
			$data["main"]				= "admin/emastermk_v";
			$data["id_mastermk"]	= $this->uri->segment(4);
			$data["detail_mastermk"] = $this->mastermk_m->detail($data["id_mastermk"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$cek = $this->mastermk_m->cek_kode();
			if(!$cek["kdmk"]){
				$this->mastermk_m->insert();
				redirect("admin/mastermk");
			}else{
				$this->input();
			}
		}

		function ubah(){
			$this->mastermk_m->update();
			redirect("admin/mastermk");
		}

		function detail(){
			$data["title"] 	= "Detail Data mastermk";
			$id_mastermk = $this->uri->segment(4);
			$data["detail_mastermk"] = $this->mastermk_m->detail($id_mastermk);
			$this->load->view("admin/tdmastermk_v",$data);
		}

		function hapus(){
			$this->mastermk_m->delete($this->uri->segment(4));
			redirect('admin/mastermk/', 'refresh');
		}

/*		function cari(){
			$data["title"] 	= "Form Pencarian Data mastermk";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/smastermk_v";
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
			$data["main"]			= "browse_pst_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   'sesi_pst'  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pst")){
				$this->db->like('nama1', $this->input->post("txtCari"));
				$this->db->from('akd_kurmk');
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_kurmk");
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