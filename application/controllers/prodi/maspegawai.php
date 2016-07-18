<?php
	Class Maspegawai extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('maspegawai_m', 'simprodi_m'));
			$this->load->library(array('simpliparse','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_maspegawai', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_maspegawai', '');			
			}
			$this->listview();
		}	
		function listview(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->maspegawai_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/maspegawai/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_maspegawai"] = $this->maspegawai_m->select($data['no'],$perpage);
			$this->load->view("prodi/maspegawai/tmaspegawai_v",$data);
		}
		function add(){
			$data['statuspegawai'] = $this->auth->get_enum('maspegawai', 'statuspegawai');
			$data["title"]	= "Form Tambah Data Pegawai Dan Dosen";
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$this->load->view("prodi/maspegawai/imaspegawai_v",$data);
		}
		function browse_dosen(){ // BROWSE UNTUK MEMILIH KETUA PRODI
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->maspegawai_m->count_all();
			$perpage	= 200;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/maspegawai/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_maspegawai"] = $this->maspegawai_m->select($data['no'],$perpage);
			$this->load->view("prodi/maspegawai/bmaspegawai_v",$data);
		}
		function edit($id = ''){
			if(!$id){
				$id = $this->uri->segment(4);
			}
			$data["title"]	= "Form Update Data Pegawai Dan Dosen";
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data["detail_maspegawai"] = $this->maspegawai_m->detail($id);
			$this->load->view("prodi/maspegawai/emaspegawai_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'npp',
						  'label'   => 'NPP',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'nama',
						  'label'   => 'Nama Pegawai',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'pendidikanterakhir',
						  'label'   => 'Pendidikan Terakhir',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'statuspegawai',
						  'label'   => 'Status Pegawai',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'bagian',
						  'label'   => 'Bagian',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run() == FALSE){
				if($this->input->post('npp2')){
					$this->edit($this->input->post('npp2'));
				}else{
					$this->add();
				}
			}else{
				$this->maspegawai_m->insert();
				redirect("prodi/maspegawai");		
			}
		}
		function detail(){
			$data["detail_maspegawai"] = $this->maspegawai_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/tdmaspegawai_v",$data);
		}

		function delete(){
			$this->maspegawai_m->delete($this->uri->segment(4,0));
			redirect('prodi/maspegawai');
		}
	}
?>