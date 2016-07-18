<?php
	Class Simaktifsemester extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simaktifsemester_m','simprodi_m','simsetting_m'));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			$this->_empty_sesi();
			if($this->simaktifsemester_m->cek_to_move()){
				redirect('prodi/simaktifsemester/listview');
			}else{
				redirect('prodi/simaktifsemester/input_move');
			}
		}
		function akumulasi(){
			$data['title'] = 'Rekap TA '.$this->session->userdata('sesi_thajaran');
			$data['aktif'] = 2;
			$data['nonaktif'] = 3;
			$data['cuti'] = 4;
			$data['keluar'] = 5;
			$data['count_ti'] = $this->simaktifsemester_m->get_jumstatus(12);
			$data['count_si'] = $this->simaktifsemester_m->get_jumstatus(11);
			$data['count_mi'] = $this->simaktifsemester_m->get_jumstatus(23);
			$data['count_tk'] = $this->simaktifsemester_m->get_jumstatus(24);
			$data['count_ka'] = $this->simaktifsemester_m->get_jumstatus(25);
			$this->load->view('prodi/takumulasi_v', $data);
		}
		function input(){
			$this->load->view('admin/simaktifsemester/isimaktifsemesterone_v');
		}
		function input_move(){
			/*$this->load->view('prodi/isimaktifsemester_v');*/
			echo('Harap mengkonfirmasikan ke prodi untuk ekspor data mahasiswa aktif');
		}
		function save_move(){
			$this->simaktifsemester_m->export_toaktifsemester();
			redirect('prodi/simaktifsemester/listview');
		}
		function _empty_sesi(){
			$arsesi = array(
				'cari_simaktifsemester'=>'',
				'sesi_statussem'=>''
			);
			$this->session->set_userdata($arsesi);
		}
		function cari(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_simaktifsemester', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_simaktifsemester', '');
			}
			redirect('prodi/simaktifsemester/listview');
		}
		function change_status(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_statussem', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_statussem', '');
			}
			redirect('prodi/simaktifsemester/listview');
		}
		function status(){
			$data = array(
				'status' => $this->uri->segment(5,0),
				'tglaktifkan' => date('Y-m-d H:i:s')
			);
			$this->db->where("nim",$this->uri->segment(4,0));
			$this->db->update("simaktifsemester",$data);
			/* echo $this->db->last_query(); exit; */
			redirect('prodi/simaktifsemester/listview');
		}
		function listview(){
			$data["title"]	= "Daftar Mahasiswa Aktif Semester";
			$thajaran = $this->simsetting_m->select_active();
			$data['thajaran'] = $thajaran['thajaran'];
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['prodi'] = $this->session->userdata('sesi_prodi');
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simaktifsemester_m->count_all_mhs($data['prodi']);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simaktifsemester/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_masmahasiswa"] = $this->simaktifsemester_m->select_mhs($data['no'], $perpage, $data['prodi']);
			$this->load->view("prodi/simaktifsemester/tsimaktifsemester_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'nim',
						  'label'   => 'NIM',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'status',
						  'label'   => 'Status',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				$this->input();
			}else{
				$this->simaktifsemester_m->insert_one();
				redirect('prodi/simaktifsemester');
			}
		}
		/*
		function change_prodi(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_prodi', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_prodi', '');			
			}
			$this->add();
		}
		function change_thajaran(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_thajaran', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_thajaran', '');
			}
			$this->add();
		}
		function change_thajaran2(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_thajaran', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_thajaran', '');
			}
			$this->listview();
		}
		function change_semester(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_semester', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_semester', '');
			}
			$this->add();
		}
		function cari_matakuliah(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesicari_matakuliah', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesicari_matakuliah', '');
			}
			$this->add();
		}
		function cari_matakuliahtawar(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('sesicari_matakuliahtawar', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('sesicari_matakuliahtawar', '');
			}
			$this->listview();
		}
		function add(){
			$this->_empty_sesi();
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$data['browse_mk'] = $this->simaktifsemester_m->select_mk();
			
			$data['total_page']	= $this->simaktifsemester_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simaktifsemester/add/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data['browse_aktifsemester'] = $this->simaktifsemester_m->select();
			$data["title"]	= "Form Tambah Penawaran Matakuliah";
			$this->load->view("prodi/isimaktifsemester_v",$data);
		}
		function edit(){
			$data['browse_namamk']	= $this->simnamamk_m->select();
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data["detail_simaktifsemester"] = $this->simaktifsemester_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/esimaktifsemester_v",$data);
		}
		function update(){
			$this->simaktifsemester_m->update();
			redirect("prodi/simaktifsemester");
		}
		function detail(){
			$data["detail_simaktifsemester"] = $this->simaktifsemester_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/tdsimaktifsemester_v",$data);
		}
		function delete(){
			$this->simaktifsemester_m->delete($this->uri->segment(4,0));
			redirect('prodi/simaktifsemester/add');
		}*/
	}
?>