<?php
Class Paket extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('paket_m', 'simkurikulum_m', 'masmahasiswa_m', 'simprodi_m'));
		$this->load->library(array('simpliparse'));
	}
	function index(){
		$this->listview();
	}
	function change_prodi(){
		$this->session->set_userdata('sesi_prodipaket', $this->uri->segment(4));
		redirect('admin/paket/listview');
	}
	function change_angkatan(){
		$this->session->set_userdata('sesi_angkatanpaket', $this->uri->segment(4));
		redirect('admin/paket/listview');
	}
	function change_kelas(){
		$this->session->set_userdata('sesi_kelaspaket', $this->uri->segment(4));
		redirect('admin/paket/listview');
	}
	function change_thajaran(){
		$this->session->set_userdata('sesi_thajaranpaket', $this->uri->segment(4));
		redirect('admin/paket/listview');
	}
	function cari_paket(){
		$this->session->set_userdata('sesi_caripaket', $this->input->post('txtCari'));
		redirect('admin/paket/listview');
	}
	function listview(){
		$cari		= $this->session->userdata('sesi_caripaket');
		$prodi		= $this->session->userdata('sesi_prodipaket');
		$angkatan	= $this->session->userdata('sesi_angkatanpaket');
		$kelas		= $this->session->userdata('sesi_kelaspaket');
		$thajaran	= $this->session->userdata('sesi_thajaranpaket');
		$perpage	= 10;
		$data['no'] = $this->uri->segment(4, 0);
		$data['browse_prodi'] = $this->simprodi_m->select();
		$data["browse_angkatan"] = $this->masmahasiswa_m->get_disangkatan();
		$data['browse_thajaran'] = $this->paket_m->get_thajaran();
		$data['total_page']	= $this->paket_m->count_all($cari, $prodi, $angkatan, $kelas, $thajaran);
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/paket/listview/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_paket"] = $this->paket_m->get_all($data['no'], $perpage, $cari, $prodi, $angkatan, $kelas, $thajaran);
		$this->load->view('admin/paket/tpaket_v', $data);
	}
	function add($baru=''){
		$data['baru'] = $baru;
		if(!$this->input->post('kodeprodi')){
			$data['kodeprodi'] = $this->session->userdata('sesi_prodipaket');
		}else{
			$data['kodeprodi'] = $this->input->post('kodeprodi');
		}
		if(!$this->input->post('angkatan')){
			$data['angkatan'] = $this->session->userdata('sesi_angkatanpaket');
		}else{
			$data['angkatan'] = $this->input->post('angkatan');
		}
		if(!$this->input->post('kelas')){
			$data['kelas'] = $this->session->userdata('sesi_kelaspaket');
		}else{
			$data['kelas'] = $this->input->post('kelas');
		}
		$data['browse_prodi'] = $this->simprodi_m->select();
		$data["browse_angkatan"] = $this->masmahasiswa_m->get_disangkatan();
		$this->load->view('admin/paket/ipaket_v', $data);
	}
	function save(){
		$config = array(
				array(
					  'field'   => 'kodeprodi',
					  'label'   => 'Prodi',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'angkatan',
					  'label'   => 'Angkatan',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'kelas',
					  'label'   => 'Kelas',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'thajaran',
					  'label'   => 'Tahun ajaran',
					  'rules'   => 'required|min_length[5]'
				   ),
				array(
					  'field'   => 'kodemk',
					  'label'   => 'Kode matakuliah',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'namamk',
					  'label'   => 'Nama matakuliah',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'sks',
					  'label'   => 'SKS',
					  'rules'   => 'required'
				   )
				 );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->add();
		}else{
			$this->paket_m->insert();
			$arsesi = array(
				'sesi_prodipaket' => $this->input->post('kodeprodi'),
				'sesi_angkatanpaket' => $this->input->post('angkatan'),
				'sesi_kelaspaket' => $this->input->post('kelas'),
				'sesi_thajaranpaket' => $this->input->post('thajaran')
			);
			$this->session->set_userdata($arsesi);
			$this->add('new');
		}
	}
	function cari(){
		$this->session->set_userdata('sesi_carimk', $this->input->post('carimk'));
		$this->browse_matakuliah();
	}
	function browse_matakuliah(){
		$data['kodeprodi'] = $this->uri->segment(4);
		$data['angkatan'] = $this->uri->segment(5);
		$data['kelas'] = $this->uri->segment(6);
		$data['thajaran'] = $this->uri->segment(7);
		$data['carimk']	= $this->session->userdata('sesi_carimk');
		$data['browse_matakuliah'] = $this->simkurikulum_m->get_all(50, 0, $data['carimk'], $data['kodeprodi'], $data['angkatan'], $data['kelas'], $data['thajaran']);
		$this->load->view('admin/paket/bmatkul_v', $data);
	}
	function delete(){
		$this->paket_m->deletedetail($this->uri->segment(4), $this->uri->segment(5));
		redirect('admin/paket/listview');
	}
}
?>