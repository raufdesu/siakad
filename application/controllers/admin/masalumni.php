<?php
	Class Masalumni extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('masalumni_m','simprodi_m'));
			$this->load->library(array('simpliparse','pquery','form_validation'));
			$this->load->library('fungsi');
			$this->load->helper(array('globals','html'));
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_masalumni', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_masalumni', '');			
			}
			$this->browse();
		}	
		function browse(){
			$cari = $this->session->userdata('cari_masalumni');
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->masalumni_m->count_all($cari);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/masalumni/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_masalumni"] = $this->masalumni_m->get_all($data['no'], $perpage, $cari);
			$this->load->view("admin/masalumni/tmasalumni_v",$data);
		}
		function add(){
			$data['propinsi'] = $this->db->get('tpropinsi');
			$data['propinsi'] = $this->db->get('tpropinsi');
			$data['browse_prodi'] = $this->simprodi_m->select('','');
			$data["title"]	= "Form Tambah Data alumni";
			$this->load->view("admin/imasalumni_v",$data);
		}
		function edit($id = ''){
			if($this->uri->segment(4) == false){
				$id = $id;
			}else{
				$id = $this->uri->segment(4);
			}
			$data["title"]	= "Form Update Data alumni";
			$data['browse_prodi'] = $this->simprodi_m->select('','');
			$data["detail_masalumni"] = $this->masalumni_m->detail($id);
			$this->load->view("admin/emasalumni_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'nim',
						  'label'   => 'NIM',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'nama',
						  'label'   => 'Nama alumni',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				if($this->input->post('nim2')){
					$id = $this->input->post('nim2');
					$this->edit($id);
				}else{
					$this->add();
				}
			}else{
				$this->masalumni_m->insert();
				redirect("admin/masalumni");		
			}
		}
		function update(){
			$this->masalumni_m->update();
			redirect("admin/masalumni");
		}

		function detail(){
			$data["detail_masalumni"] = $this->masalumni_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdmasalumni_v",$data);
		}

		function delete(){
			$this->masalumni_m->delete($this->uri->segment(4,0));
			redirect('admin/masalumni');
		}
	}
?>