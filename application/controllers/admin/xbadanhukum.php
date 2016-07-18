<?php
	Class Badanhukum extends Controller{
		function __construct(){
			parent::Controller();
			//if(!$this->session->userdata("sesi_user"))
			//	redirect("/");
			$this->load->model("badanhukum_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->library('form_validation');
		}
		
		function _tab(){
			$data = array(
				"badanhukum" => "active",
				"perguruantinggi" => ""
			);
			return $data;
		}
		
		function index(){
			//echo $this->_tab();
			//$data["badanhukum"] = "active";
			//$data["perguruantinggi"] = "";
			$data['main'] = "admin/tBadanHukum_v";
			$this->pagination->initialize($data);
			$data["browse_badanhukum"] = $this->badanhukum_m->select();
			$this->load->view("admin/main_v",$data);
		}
		
		function input(){
			$data["title"] 	= "Form Tambah badanhukum";
			$data["main"]  	= "admin/ibadanhukum_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){		
			$data["title"]	= "Form Pengubahan Data badanhukum";
			$data["main"]	= "admin/eBadanhukum_v";
			$data["id_badanhukum"]= $this->uri->segment(4);
			$data["detail_badanhukum"] = $this->badanhukum_m->detail($data["id_badanhukum"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_badanhukum"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			
		
			$this->form_validation->set_rules('nama_badanhukum', 'Nama', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				echo "<font size='6' color='red'>Mohon Untuk Menghidupkan Content Javascript Pada Browser anda</font>";
				exit;
			}
			$config['upload_path'] 	 = './images/Fotobadanhukum/';
			$config['allowed_types'] = 'gif|jpg|png|bmp';
			$config['max_size']		 = '10000000';
			$config['max_width']  	 = '10000000';
			$config['max_height']  	 = '8000000';
	        $this->load->library('upload', $config);

	        $this->upload->do_upload("foto");
	            $data = $this->upload->data("foto");
	            $foto = $data["file_name"];
	            $this->badanhukum_m->insert($foto);
				redirect("admin/badanhukum");
		}

		function ubah(){
			$this->badanhukum_m->update();
			redirect("admin/badanhukum");
		}

		function detail(){
			$data["title"] 	= "Detail Data badanhukum";
			$id_badanhukum = $this->uri->segment(4);
			$data["detail_badanhukum"] = $this->badanhukum_m->detail($id_badanhukum);
			$this->load->view("admin/tdbadanhukum_v",$data);
		}

		function hapus(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_badanhukum"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			
		
			$this->badanhukum_m->delete($this->uri->segment(4));
			redirect('admin/badanhukum/', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_badanhukum"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data badanhukum";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/sbadanhukum_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_badanhukum"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data badanhukum";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/sbadanhukum_v";
			$data["cari_badanhukum"]= $this->badanhukum_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>