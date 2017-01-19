<?php
	Class Feeder extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('feeder_m'));
			$this->load->library(array('simpliparse','pquery','form_validation'));
			$this->load->library('fungsi');
			$this->load->helper(array('globals','html'));
		}
		function status(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_statusakademik', $this->uri->segment(4));
			}else{
				$this->session->set_userdata('sesi_statusakademik', '');			
			}
			redirect('admin/masmahasiswa/listview');
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_masmahasiswa', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_masmahasiswa', '');			
			}
			$this->listview();
		}
		function angkatan(){
			$this->session->set_userdata('sesi_angkatanmhs', $this->uri->segment(4));
			redirect('admin/masmahasiswa/listview');
		}
		function shift(){
			$this->session->set_userdata('sesi_shiftmhs', $this->uri->segment(4));
			redirect('admin/masmahasiswa/listview');
		}
		function prodi(){
			$this->session->set_userdata('sesi_prodimhs', $this->uri->segment(4));
			redirect('admin/masmahasiswa/listview');
		}
		function listview(){
			$data["browse_user"] = $this->feeder_m->select();
			$this->load->view("admin/tfeeder_v",$data);
		}
		function add(){
			$data['propinsi'] = $this->db->get('tpropinsi');
			$data['kabupaten'] = $this->db->get('tkabupaten');
			$data['pendidikan'] = $this->db->get('jenjang_pendidikan');
			$data['pekerjaan'] = $this->db->get('pekerjaan');
			$data['penghasilan'] = $this->db->get('penghasilan');
			$data['jenis_tinggal'] = $this->db->get('jenis_tinggal');
			$data['alat_transport'] = $this->db->get('alat_transport');
			$data['wilayah'] = $this->db->get('wilayah');
			$data['browse_prodi'] = $this->simprodi_m->select('','');
			$data["title"]	= "Form Tambah Data Mahasiswa";
			$this->load->view("admin/imasmahasiswa_v",$data);
		}
		function edit($id = ''){
			if($this->uri->segment(4) == false){
				$id = $id;
			}else{
				$id = $this->uri->segment(4);
			}
			$data["feeder"] = $this->feeder_m->select();
			$this->load->view("admin/efeeder_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'username',
						  'label'   => 'Username',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'password',
						  'label'   => 'Password',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'url',
						  'label'   => 'URL',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'port',
						  'label'   => 'Port',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'id_sp',
						  'label'   => 'ID Perguruan Tinggi',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'live',
						  'label'   => 'Live',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				if($this->input->post('id')){
					$id = $this->input->post('id');
					$this->edit($id);
				}else{
					$this->add();
				}
			}else{
				$this->feeder_m->insert();
				redirect("admin/feeder");		
			}
		}
		function update(){
			$this->masmahasiswa_m->update();
			redirect("admin/masmahasiswa");
		}
		function delete(){
			$this->masmahasiswa_m->delete($this->uri->segment(4,0));
			redirect('admin/masmahasiswa');
		}
	}
?>