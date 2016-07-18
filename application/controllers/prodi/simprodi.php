<?php
	Class Simprodi extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simprodi_m','simfakultas_m'));
			$this->load->library(array('simpliparse','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			$this->detail();
		}	
		function listview(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simprodi_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simprodi/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_simprodi"] = $this->simprodi_m->select($data['no'],$perpage);
			$this->load->view("simprodi/tsimprodi_v",$data);
		}
		function edit(){
			$data["title"]	= "Form Update PRODI";
			$kodeprodi = $this->session->userdata('sesi_prodi');
			$data['jenjang'] = $this->auth->get_enum('simprodi', 'jenjang');
			$data["detail_simprodi"] = $this->simprodi_m->detail($kodeprodi);
			$this->load->view("prodi/simprodi/esimprodi_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'kodeprodi',
						  'label'   => 'Kode PRODI',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'namaprodi',
						  'label'   => 'Nama PRODI',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'jenjang',
						  'label'   => 'Jenjang',
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
						  'label'   => 'Kepala Prodi',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				$this->add();
			}else{
				$this->simprodi_m->insert();
				redirect("prodi/simprodi");		
			}
		}
		function update(){
			$this->simprodi_m->update();
			redirect("prodi/simprodi");
		}
		function detail(){
			$data["detail_prodi"] = $this->simprodi_m->detail($this->session->userdata('sesi_prodi'));
			$this->load->view("prodi/simprodi/tdsimprodi_v",$data);
		}
		function delete(){
			$this->simprodi_m->delete($this->uri->segment(4,0));
			redirect('prodi/simprodi');
		}
	}
?>