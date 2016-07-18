<?php
	Class Simnamamk extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("simnamamk_m","",TRUE);
			$this->load->library(array('simpliparse','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			/*if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_simnamamk', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_simnamamk', '');			
			}
			$this->listview();*/
		}	
		function listview(){
			/*$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simnamamk_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simnamamk/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_simnamamk"] = $this->simnamamk_m->select($data['no'],$perpage);
			$this->load->view("admin/tsimnamamk_v",$data);*/
		}
		function add(){
			$this->load->view("admin/isimnamamk_v");
		}
		function edit(){
			$data["title"]	= "Form Update Data Pegawai Dan Dosen";
			$data["detail_simnamamk"] = $this->simnamamk_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/esimnamamk_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'namamk',
						  'label'   => 'Nama Matakuliah',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'namamkinggris',
						  'label'   => 'Nama Matakuliah Inggris',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				$this->add();
			}else{
				$this->simnamamk_m->insert();
				redirect("admin/simkurikulum/add");		
			}
		}
		function update(){
			$this->simnamamk_m->update();
			redirect("admin/simnamamk");
		}

		function detail(){
			$data["detail_simnamamk"] = $this->simnamamk_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdsimnamamk_v",$data);
		}

		function delete(){
			$this->simnamamk_m->delete($this->uri->segment(4,0));
			redirect('admin/simnamamk');
		}
	}
?>