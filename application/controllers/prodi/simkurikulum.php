<?php
	Class Simkurikulum extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("simkurikulum_m","simprodi_m","ttambahan_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function thn_kurikulum(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_thnkurikulum', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_thnkurikulum', '');			
			}
			redirect('prodi/simkurikulum/listview');
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_simkurikulum', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_simkurikulum', '');			
			}
			redirect('prodi/simkurikulum/listview');
		}
		function listview(){
			$prodi = $this->session->userdata('sesi_prodi');
			$this->load->library(array('form_validation'));
			$data['browse_thn_kurikulum'] = $this->ttambahan_m->select();
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simkurikulum_m->count_all($prodi);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simkurikulum/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_simkurikulum"] = $this->simkurikulum_m->select($data['no'], $perpage, $prodi);
			$this->load->view("prodi/simkurikulum/tsimkurikulum_v",$data);
		}
		function add(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_thnkurikulum', $this->uri->segment(4,0));
			}
			$data['browse_thn_kurikulum'] = $this->ttambahan_m->select();
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data['detail_simkurikulum'] = $this->simkurikulum_m->detail($this->uri->segment(4,0));
			$data["title"]	= "Form Tambah Data Pegawai Dan Dosen";
			$this->load->view("prodi/simkurikulum/isimkurikulum_v",$data);
		}
		function edit(){
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data["detail_simkurikulum"] = $this->simkurikulum_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/simkurikulum/esimkurikulum_v",$data);
		}
		function save(){
			$cek_kodemk = $this->simkurikulum_m->cek_kodemk($this->input->post('kodemk'));
			$config = array(
					array(
						  'field'   => 'kodemk',
						  'label'   => 'Kode matakuliah',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'namamk',
						  'label'   => 'Nama Matakuliah',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'kodeprodi',
						  'label'   => 'PRODI',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'sks',
						  'label'   => 'SKS',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'teori_praktek',
						  'label'   => 'Teori/Praktek',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'wajib_pilihan',
						  'label'   => 'Wajib/Pilihan',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'semester',
						  'label'   => 'Semester',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'thnkur',
						  'label'   => 'Tahun kurikulum',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'sifat',
						  'label'   => 'Sifat',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				$this->add();
				// $this->load->view('prodi/isimkurikulum_v');
			}else{
				if($cek_kodemk == true){
					$this->simplival->alert('PERINGATAN\nKode Matakuliah Sudah Ada Sebelumnya');
					$this->add();
				}else{
					$this->simkurikulum_m->insert();
					redirect("prodi/simkurikulum");
				}
			}
		}
		function update(){
			$this->simkurikulum_m->update();
			redirect("prodi/simkurikulum");
		}

		function detail(){
			$data["detail_simkurikulum"] = $this->simkurikulum_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/tdsimkurikulum_v",$data);
		}

		function delete(){
			$this->simkurikulum_m->delete($this->uri->segment(4,0));
			redirect('prodi/simkurikulum');
		}
	}
?>