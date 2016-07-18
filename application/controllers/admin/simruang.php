<?php
	Class Simruang extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model("simruang_m","",TRUE);
			$this->load->library(array('simpliparse','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_simruang', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_simruang', '');			
			}
			$this->listview();
		}	
		function listview(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simruang_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simruang/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_simruang"] = $this->simruang_m->get_all($data['no'],$perpage);
			$this->load->view("admin/simruang/tsimruang_v",$data);
		}
		function add(){
			$this->load->view("admin/simruang/isimruang_v");
		}
		function edit($id = ''){
			if(!$id){
				$id = $this->uri->segment(4,0);
			}
			$data["title"]	= "Form Update Data Pegawai Dan Dosen";
			$data["detail_simruang"] = $this->simruang_m->detail($id);
			$this->load->view("admin/simruang/esimruang_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'nama',
						  'label'   => 'Nama ruangan',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'lantai',
						  'label'   => 'Lantai',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'nomor',
						  'label'   => 'Nomor ruangan',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'kapasitas',
						  'label'   => 'Kapasitas',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run() == FALSE){
				if($this->input->post('id_ruang')){
					$id = $this->input->post('id_ruang');
					$this->edit($id);
				}else{
					$this->add();
				}
			}else{
				$this->simruang_m->insert();
				redirect("admin/simruang");		
			}
		}
		function update(){
			$this->simruang_m->update();
			redirect("admin/simruang");
		}

		function detail(){
			$data["detail_simruang"] = $this->simruang_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdsimruang_v",$data);
		}

		function delete(){
			$this->simruang_m->delete($this->uri->segment(4,0));
			redirect('admin/simruang');
		}
	}
?>