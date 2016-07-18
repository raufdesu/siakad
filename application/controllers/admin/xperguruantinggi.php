<?php
	Class Perguruantinggi extends Controller{
		function __construct(){
			parent::Controller();
			//if(!$this->session->userdata("sesi_user"))
			//	redirect("/");
			$this->load->model("perguruantinggi_m","",TRUE);
			$this->load->library("table");
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("globals");
			$this->load->library('form_validation');
		}
		
		function index(){
			$data['main'] = "admin/tperguruantinggi_v";
			$this->pagination->initialize($data);
			$data["browse_perguruantinggi"] = $this->perguruantinggi_m->select();
			$this->load->view("admin/main_v",$data);
		}
		
		function input(){
			$data["title"] 	= "Form Tambah perguruantinggi";
			$data["main"]  	= "admin/iperguruantinggi_v";
			$this->load->view("admin/main_v",$data);
		}
		
		function edit(){		
			$data["title"]			= "Form Pengubahan Data perguruantinggi";
			$data["main"]			= "admin/ePerguruantinggi_v";
			$data["id_perguruantinggi"]= $this->uri->segment(4);
			$data["detail_perguruantinggi"] = $this->perguruantinggi_m->detail($data["id_perguruantinggi"]);
			$this->load->view("admin/main_v",$data);
		}
		
		function simpan(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_perguruantinggi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			
		
			$this->form_validation->set_rules('nama_perguruantinggi', 'Nama', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				echo "<font size='6' color='red'>Mohon Untuk Menghidupkan Content Javascript Pada Browser anda</font>";
				exit;
			}
			$config['upload_path'] 	 = './images/Fotoperguruantinggi/';
			$config['allowed_types'] = 'gif|jpg|png|bmp';
			$config['max_size']		 = '10000000';
			$config['max_width']  	 = '10000000';
			$config['max_height']  	 = '8000000';
	        $this->load->library('upload', $config);

	        $this->upload->do_upload("foto");
	            $data = $this->upload->data("foto");
	            $foto = $data["file_name"];
	            $this->perguruantinggi_m->insert($foto);
				redirect("admin/perguruantinggi");
		}

		function ubah(){
			$this->perguruantinggi_m->update();
			redirect("admin/perguruantinggi");
		}

		function detail(){
			$data["title"] 	= "Detail Data perguruantinggi";
			$id_perguruantinggi = $this->uri->segment(4);
			$data["detail_perguruantinggi"] = $this->perguruantinggi_m->detail($id_perguruantinggi);
			$this->load->view("admin/tdperguruantinggi_v",$data);
		}

		function hapus(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_perguruantinggi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			
		
			$this->perguruantinggi_m->delete($this->uri->segment(4));
			redirect('admin/perguruantinggi/', 'refresh');
		}
		
		function cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_perguruantinggi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 	= "Form Pencarian Data perguruantinggi";
			$data["field"]	= "";
			$data["value"]	= "";
			$data["main"]  	= "admin/sperguruantinggi_v";
			$this->load->view("admin/template_v",$data);
		}
		
		function do_cari(){
			$data["dashboard"]	= "";
			$data["menu_profil"]= "";
			$data["menu_karyawan"]= "";
			$data["menu_perguruantinggi"] = "current";
			$data["menu_saran"] = "";
			$data["menu_relasi"] = "";			

			$data["title"] 		= "Form Pencarian Data perguruantinggi";
			$data["no"]			= 0;
			$data["title2"]		= "<h3>Hasil Pencarian</h3>";
			$data["field"]		= $this->input->post("cbKategori");
			$data["value"]		= $this->input->post("txtCari");
			$data["main"]		= "admin/sperguruantinggi_v";
			$data["cari_perguruantinggi"]= $this->perguruantinggi_m->cari($data["field"],$data["value"]);
			$this->load->view("admin/template_v",$data);
		}
	}
?>