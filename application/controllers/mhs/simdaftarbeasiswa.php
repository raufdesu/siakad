<?php
Class Simdaftarbeasiswa extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m','simdaftarbeasiswa_m','masmahasiswa_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function detail_mahasiswa($nim){
		$dm = $this->masmahasiswa_m->get_one($nim);
		$arsesi = array(
			'sesi_krs_nim' => $dm['nim'],
			'sesi_krs_nama' => $dm['nama'],
			'sesi_krs_prodi' => $dm['nama_prodi'],
			'sesi_krs_prefprodi' => $dm['pref_prodi'],
			'sesi_krs_kelas' => $dm['kdkelas']
		);
		$this->session->set_userdata($arsesi);
		$data['nama_matkul'] = '';
	}
	function input(){
		$thajar = $this->simsetting_m->select_active();
		$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
		$this->detail_mahasiswa($this->session->userdata('sesi_user_mhs'));
		$data['title'] = 'Pendaftaran Beasiswa';
		$this->load->view('mhs/simdaftarbeasiswa/isimdaftarbeasiswa_v', $data);
	}
	function save(){
		$config = array(
			array(
				'field'   => 'nim',
				'label'   => 'NIM',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jenisbeasiswa',
				'label'   => 'Jenis Beasiswa',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pekerjaanortu',
				'label'   => 'Pekerjan Orang Tua',
				'rules'   => 'required'
			),
			array(
				'field'   => 'penghasilanortu',
				'label'   => 'Penghasilan Orang Tua',
				'rules'   => 'required'
			),
			array(
				'field'   => 'ipk',
				'label'   => 'IPK',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if ($this->form_validation->run() == FALSE){
			$this->input();
		}else{
			$cek = $this->simdaftarbeasiswa_m->cekdaftar();
			if($cek){
				$this->input();
				$this->simplival->alert('PERINGATAN\nAnda Sudah Mendaftar '.$this->input->post('jenisbeasiswa').' Sebelumnya');
				return false;
			}else{
				$this->simdaftarbeasiswa_m->insert();
			}
			$this->confirm_simpan();
		}
	}
	function confirm_simpan(){
		$this->load->view('mhs/simdaftarbeasiswa/tconfirmsimpan_v');
		redirect('mhs/simdaftarbeasiswa/browse');
	}
	function browse(){
		$data['title'] = 'Pendaftaran Beasiswa';
		$data['detail_simdaftarbeasiswa'] = $this->simdaftarbeasiswa_m->get_one($this->session->userdata('sesi_krs_nim'));
		$this->load->view('mhs/simdaftarbeasiswa/tsimdaftarbeasiswa_v', $data);
	}
}
?>