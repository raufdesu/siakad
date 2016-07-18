<?php
	Class Simfakultas extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simfakultas_m', 'simfakultas_m'));
			$this->load->library(array('simpliparse','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_simfakultas', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_simfakultas', '');			
			}
			$this->listview();
		}	
		function listview(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simfakultas_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simfakultas/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_simfakultas"] = $this->simfakultas_m->get_all($data['no'],$perpage);
			$this->load->view("admin/simfakultas/tsimfakultas_v",$data);
		}
		function add(){
			$data['title'] = 'Input Data Fakultas';
			$this->load->view('admin/simfakultas/isimfakultas_v', $data);
		}
		function edit($id = ''){
			if(!$id){
				$id = $this->uri->segment(4,0);
			}
			$data["title"]	= "Form Update Data Pegawai Dan Dosen";
			$data["detail_simfakultas"] = $this->simfakultas_m->detail($id);
			$this->load->view("admin/simfakultas/esimfakultas_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'kodefakultas',
						  'label'   => 'Kode fakultas',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'namafakultas',
						  'label'   => 'Nama fakultas',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'ijin',
						  'label'   => 'Ijin',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'status',
						  'label'   => 'Status',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'namadosen',
						  'label'   => 'Kepala fakultas',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				$id = $this->input->post('kodefakultas2');
				if($id){
					$this->edit($id);
				}else{
					$this->add();
				}
			}else{
				$this->simfakultas_m->insert();
				redirect("admin/simfakultas");		
			}
		}
		function detail(){
			$data["detail_simfakultas"] = $this->simfakultas_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdsimfakultas_v",$data);
		}

		function delete(){
			$this->simfakultas_m->delete($this->uri->segment(4,0));
			redirect('admin/simfakultas');
		}
	}
?>