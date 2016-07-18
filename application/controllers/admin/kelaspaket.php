<?php
	Class Kelaspaket extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('kelaspaket_m', 'simprodi_m', 'masmahasiswa_m'));
		}
		function index(){
			$this->listview();
		}
		function cari_kelaspaket(){
			$this->session->set_userdata('cari_kelaspaket', $this->input->post('txtCari'));
			redirect('admin/kelaspaket/listview');
		}
		function change_prodi(){
			$this->session->set_userdata('cari_prodikelaspaket', $this->uri->segment(4));
			redirect('admin/kelaspaket/listview');
		}
		function change_angkatan(){
			$this->session->set_userdata('cari_angkatankelaspaket', $this->uri->segment(4));
			redirect('admin/kelaspaket/listview');
		}
		function change_kelas(){
			$this->session->set_userdata('cari_kelaskelaspaket', $this->uri->segment(4));
			redirect('admin/kelaspaket/listview');
		}
		function listview(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);

			$data['cari'] = $this->session->userdata('cari_kelaspaket');
			$data['prodi'] = $this->session->userdata('cari_prodikelaspaket');
			$data['angkatan'] = $this->session->userdata('cari_angkatankelaspaket');
			$data['kelas'] = $this->session->userdata('cari_kelaskelaspaket');
			$data['browse_prodi'] = $this->kelaspaket_m->get_prodi();
			$data['browse_angkatan'] = $this->kelaspaket_m->get_angkatan();

			$data['total_page']	= $this->kelaspaket_m->count_all($data['cari'], $data['prodi'], $data['angkatan'], $data['kelas']);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/kelaspaket/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_kelaspaket"] = $this->kelaspaket_m->get_all($data['no'], $perpage, $data['cari'], $data['prodi'], $data['angkatan'], $data['kelas']);
			$this->load->view("admin/kelaspaket/tkelaspaket_v",$data);
		}
		function add(){
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_angkatan'] = $this->masmahasiswa_m->get_disangkatan();
			$this->load->view('admin/kelaspaket/ikelaspaket_v', $data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'kodeprodi',
						  'label'   => 'Kode PRODI',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'kelas',
						  'label'   => 'Kelas',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'angkatan',
						  'label'   => 'Angkatan',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				$this->add();
			}else{
				$this->kelaspaket_m->insert();
				redirect("admin/kelaspaket");		
			}
		}
		function detail(){
			$data["detail_kelaspaket"] = $this->kelaspaket_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdkelaspaket_v",$data);
		}
		function delete(){
			$this->kelaspaket_m->delete($this->uri->segment(4,0));
			redirect('admin/kelaspaket');
		}
	}
?>