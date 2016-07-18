<?php
	Class Simmatrikulasi extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("simmatrikulasi_m","simprodi_m","simkrs_m","simsetting_m","masmahasiswa_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation','cart'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('sesicari_mhsmatrik', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('sesicari_mhsmatrik', '');
			}
			$this->listview();
		}
		function cari_matakuliah(){
			$this->session->set_userdata('sesi_kodemk', $this->uri->segment(4,0));
			if($this->session->userdata('sesi_kodemk')){
				$nm = $this->simmatrikulasi_m->get_namamatkul_one($this->session->userdata('sesi_kodemk'));
				// echo $this->db->last_query();
				$nama_matkul = $nm['namamk'];
				$kode_matkul = $nm['kodemk'];
				$sks = $nm['sks'];
			}else{
				$nama_matkul = '';
				$kode_matkul = '';
				$sks = '';
			}
			echo "<input type='hidden' readonly name='txt_kode_mk' value='".$kode_matkul."' size='8' style='float:left'>";
			echo "<input type='text' readonly name='txt_nama_mk' value='".$nama_matkul."' size='45' style='float:left'>";
			echo "<input type='hidden' name='txt_sks' value='".$sks."'>";
		}
		function listview(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simmatrikulasi_m->count_all($this->session->userdata('sesicari_mhsmatrik'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simmatrikulasi/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_mhsmatrikulasi"] = $this->simmatrikulasi_m->get_all($data['no'],$perpage,$this->session->userdata('sesicari_mhsmatrik'));
			$this->load->view("admin/tsimmatrikulasi_v",$data);
		}
		function input_awal(){
			$atrs = array(
				'sesi_krs_nim' => '',
				'sesi_krs_nama' => '',
				'sesi_krs_kelas' => '',
				'sesi_krs_prodi' => ''
			);
			$this->session->set_userdata($atrs);
			$this->input();
		}
		function input(){
			$thajar = $this->simsetting_m->select_active();
			$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
			$data['nim'] = $this->session->userdata('sesi_krs_nim');
			$data['nama'] = '';
			$data[''] = '';
			//$data['browse_matrikulasi'] = $this->simmatrikulasi_m->get_bynim($nim);
			if($data['nim'])
				$data['detail_matrikulasi'] = $this->simmatrikulasi_m->get_one($data['nim']);
			
			$this->load->view("admin/isimmatrikulasi_v",$data);
		}
		function detail_mahasiswa(){
			$this->session->set_userdata('sesi_jumgab','');
			if($this->input->post('nim')){
				$nim = $this->input->post('nim');
			}
			if($this->uri->segment(4)){
				$nim = $this->uri->segment(4);
			}
			$dm = $this->simkrs_m->detail_mahasiswa($nim);
			$this->session->set_userdata('sesi_jumgab', $this->simkrs_m->res_sks($nim));
			$arsesi = array(
				'sesi_krs_nim' => $dm['nim'],
				'sesi_krs_nama' => $dm['nama'],
				'sesi_krs_prodi' => $dm['nama_prodi'],
				/* 'sesi_krs_prefprodi' => $dm['pref_prodi'], */
				'sesi_krs_kelas' => $dm['kdkelas']
			);
			$this->session->set_userdata($arsesi);
			$data['nama_matkul'] = '';
			$this->input($data);
		}
		function edit(){
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data["detail_simkurikulum"] = $this->simkurikulum_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/esimkurikulum_v",$data);
		}
		function save(){
			$cek_kodemk = $this->simmatrikulasi_m->cek_ada($this->session->userdata('sesi_krs_nim'), $this->input->post('txt_kode_mk'));
			$config = array(
					array(
						  'field'   => 'txt_kodemk',
						  'label'   => 'Kode Matakuliah',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'nilai',
						  'label'   => 'Nilai Matakuliah',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'txt_sks',
						  'label'   => 'SKS',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error"> * ', '</span><br />');
			if ($this->form_validation->run() == FALSE){
				$this->input();
				// $this->load->view('admin/isimkurikulum_v');
			}else{
				if($cek_kodemk == true){
					// $this->simplival->alert('PERINGATAN\nKode Matakuliah Sudah Ada Sebelumnya');
					$this->input();
				}else{
					$this->simmatrikulasi_m->insert();
					redirect("admin/simmatrikulasi/input");
				}
			}
		}
		function delete(){
			$this->db->where('kodemk', $this->uri->segment(4));
			$this->db->where('nim', $this->uri->segment(5));
			$this->db->delete('simmatrikulasi');

			$this->db->where('kodemk', $this->uri->segment(4));
			$this->db->where('nim', $this->uri->segment(5));
			$this->db->delete('simtranskrip');
			redirect('admin/simmatrikulasi/input');
		}
	}
?>