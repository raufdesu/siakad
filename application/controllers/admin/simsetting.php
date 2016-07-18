<?php
	Class Simsetting extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("simsetting_m","ttambahan_m", "profil_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			$this->listview();
		}
		function listview(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simsetting_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simsetting/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_tambahan"] = $this->ttambahan_m->select();
			$data["browse_simsetting"] = $this->simsetting_m->select($data['no'],$perpage);
			$data['pt'] = $this->profil_m->get_one();
			$this->load->view("admin/tsimsetting_v",$data);
		}
		function add(){
			$this->load->view("admin/isimsetting_v");
		}
		function add_tambahan(){
			$this->load->view("admin/ithkurikulum_v");
		}
		function edit(){
			$data["title"]	= "Form Update Setting SIMAK";
			$data["detail_simsetting"] = $this->simsetting_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/esimsetting_v",$data);
		}
		function save_thkurikulum(){
			$config = array(
					array(
						  'field'   => 'thkurikulum',
						  'label'   => 'Thn Kurikulum',
						  'rules'   => 'required'
					   )
					);
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			$cek = $this->ttambahan_m->cekada($this->input->post('thkurikulum'));
			if ($this->form_validation->run() == FALSE){
				$this->add_tambahan();
			}else{
				if($cek){
					$this->simplival->alert('PERINGATAN\nTahun Kurikulum '.$this->input->post('thkurikulum').' Sudah Ada Sebelumnya');					
					$this->add_tambahan();
				}else{
					$this->ttambahan_m->insert();
					redirect("admin/simsetting");			
				}
			}
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'thajaran',
						  'label'   => 'Thn Ajaran',
						  'rules'   => 'required|numeric|required|min_length[5]|max_length[5]'
					   ),
					array(
						  'field'   => 'aktif',
						  'label'   => 'Aktif',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglkrsawal',
						  'label'   => 'Tgl. KRS Awal',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglkrsakhir',
						  'label'   => 'Tgl. KRS Akhir',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglperubahankrsawal',
						  'label'   => 'Tgl. Perubahan KRS Awal',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglperubahankrsakhir',
						  'label'   => 'Tgl. Perubahan KRS Akhir',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			$cek = $this->simsetting_m->cekada($this->input->post('thajaran'));
			if ($this->form_validation->run() == FALSE){
				$this->add();
			}else{
				if($cek){
					$this->simplival->alert('PERINGATAN\nTahun Ajaran '.$this->input->post('thajaran').' Sudah Ada Sebelumnya');					
					$this->add();
				}else{
					$this->simsetting_m->insert();
					redirect("admin/simsetting");
				}
			}
		}
		function update(){
			$config = array(
					array(
						  'field'   => 'thajaran',
						  'label'   => 'Thn Ajaran',
						  'rules'   => 'required'
					   ),
					/*array(
						  'field'   => 'aktif',
						  'label'   => 'Aktif',
						  'rules'   => 'required'
					   ),*/
					array(
						  'field'   => 'tglkrsawal',
						  'label'   => 'Tgl. KRS Awal',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglkrsakhir',
						  'label'   => 'Tgl. KRS Akhir',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglperubahankrsawal',
						  'label'   => 'Tgl. Perubahan KRS Awal',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglperubahankrsakhir',
						  'label'   => 'Tgl. Perubahan KRS Akhir',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			// $cek = $this->simsetting_m->cekada($this->input->post('thajaran'));
			if ($this->form_validation->run() == FALSE){
				$this->add();
			}else{
				/*if($cek){
					$this->simplival->alert('PERINGATAN\nTahun Ajaran '.$this->input->post('thajaran').' Sudah Ada Sebelumnya');					
					$this->add();
				}else{*/
					$this->simsetting_m->update();
					redirect("admin/simsetting");
				/*}*/
			}
		}

		function detail(){
			$data["detail_simsetting"] = $this->simsetting_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdsimsetting_v",$data);
		}
		function nonactive_all(){
			$this->simsetting_m->nonactive_all();
			redirect('admin/simsetting/index');
			// $this->listview();
		}
		function active_one(){
			$this->simsetting_m->nactive_one($this->uri->segment(4,0));
			redirect('admin/simsetting/index');
			// $this->index();
		}
		function delete(){
			$this->simsetting_m->delete($this->uri->segment(4,0));
			redirect('admin/simsetting');
		}
		function delete_thkurikulum(){
			$this->ttambahan_m->delete($this->uri->segment(4,0));
			redirect('admin/simsetting');
		}
	}
?>