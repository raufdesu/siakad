<?php
	Class Simdosenampu extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simruang_m','simdosenampu_m','simbap_m','simkurikulum_m','maspegawai_m','simkrs_m','simmktawar_m'));
			$this->load->library(array('simplival','simpliparse','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
			if($this->session->userdata('sesi_thajaran') == false){
				redirect(base_url().'index.php/prodi/login','refresh');
			}
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_maspegawai', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_maspegawai', '');			
			}
			$this->listview();
		}
		function edit_ampuan($idkelas=''){
			if(!$idkelas){
				$idkelas = $this->uri->segment(4);
			}
			$data['browse_simruang'] = $this->simruang_m->getAll();
			$data['dosenampu'] = $this->simdosenampu_m->get_one($idkelas);
			$this->load->view('prodi/simdosenampu/esimdosenampu_v', $data);
		}
		function update(){
			$config = array(
				array(
					  'field'   => 'kodemk',
					  'label'   => 'Kode Matakuliah',
					  'rules'   => 'required'
				),
				array(
					  'field'   => 'npp',
					  'label'   => 'NPP Dosen',
					  'rules'   => 'required'
				),
				array(
					  'field'   => 'thajaran',
					  'label'   => 'Tahun Ajaran',
					  'rules'   => 'required'
				)
			);
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run() == FALSE){
				$this->edit_ampuan($this->input->post('id_kelas_dosen'));
			}else{
				$this->simdosenampu_m->update();
				$this->add($this->input->post('npp'));
			}
		}
		function listview(){
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->maspegawai_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simdosenampu/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_maspegawai"] = $this->maspegawai_m->select($data['no'],$perpage);
			$this->load->view("prodi/simdosenampu/tsimdosenampu_v",$data);
		}
		function index_ceknilai(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_maspegawai', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_maspegawai', '');			
			}
			$this->listview();
		}
		function browse_ceknilai(){
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->maspegawai_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simdosenampu/browse_ceknilai/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_maspegawai"] = $this->maspegawai_m->select($data['no'],$perpage);
			$this->load->view("prodi/tceknilai_v",$data);
		}
		function cari_matakuliah(){
			$this->session->set_userdata('sesi_kodemk', $this->uri->segment(4,0));
			$cekada = $this->simkurikulum_m->cek_likemkprodi($this->uri->segment(4,0));
			if($cekada){
				if($this->session->userdata('sesi_kodemk')){
					$nm = $this->simmktawar_m->get_namamatkul_one($this->session->userdata('sesi_kodemk'));
					$data['nama_matkul'] = $nm['namamk'];
					$data['kode_matkul'] = $nm['kodemk'];
					$data['kode_prodi'] = $nm['kodeprodi'];
				}else{
					$data['nama_matkul'] = '';
					$data['kode_matkul'] = '';
					$data['sks'] = '';
					$data['kode_prodi'] = '';
					}
				$data['browse_simruang'] = $this->simruang_m->getAll();
				$this->load->view('prodi/simdosenampu/isimdosenampu2_v', $data);
			}else{
				$prodi = 'xxxx';
				echo '<div style="color:brown">KONFIRMASI, Kode matakuliah yang anda inputkan tidak ditemukan</div>';
			}
		}
		function add($id = ''){
			if(!$id){
				$this->session->set_userdata('sesi_dosenampu', $this->uri->segment(4,0));
				$id = $this->session->userdata('sesi_dosenampu');
			}else{
				$this->session->set_userdata('sesi_dosenampu', $id);
				$id = $this->session->userdata('sesi_dosenampu');
			}
			/* echo 'idnya:'.$id; */
			$data["title"]	= "Form Tambah Ampu Matakuliah";
			$data["detail_dosen"] = $this->maspegawai_m->getOne($id);
			$data["detail_simdosenampu"] = $this->simdosenampu_m->getOne($id, $this->session->userdata('sesi_prodi'));
			$this->load->view("prodi/simdosenampu/isimdosenampu_v",$data);
		}
		function edit(){
			$data["title"]	= "Form Update Data Pegawai Dan Dosen";
			$data["detail_maspegawai"] = $this->maspegawai_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/emaspegawai_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'txt_kode_mk',
						  'label'   => 'Kode Matakuliah',
						  'rules'   => 'required'
					)
			);
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			$npp = $this->input->post('npp');
			if($this->form_validation->run() == FALSE){
				$this->add($npp);
			}else{
				$cek = $this->simdosenampu_m->cek_inputsama($this->input->post('npp'), $this->input->post("txt_kode_mk"), $this->input->post("kelas"));
				if($cek){
					redirect("prodi/simdosenampu/add/".$npp);
				}else{
					$this->simdosenampu_m->insert();
					redirect("prodi/simdosenampu/add/".$npp);
				}
			}
		}
		function delete(){
			$dipakai = $this->simdosenampu_m->cek_idkelasdipakai($this->uri->segment(4));
			if($dipakai){
				// PENOLAKAN PENGHAPUSAN DATA.
				// $this->load->
				$this->simdosenampu_m->delete($this->uri->segment(4,0));
				$this->add($this->session->userdata('sesi_dosenampu'));
			}else{
				$this->simdosenampu_m->delete($this->uri->segment(4,0));
				$this->add($this->session->userdata('sesi_dosenampu'));
			}
		}
	}
?>