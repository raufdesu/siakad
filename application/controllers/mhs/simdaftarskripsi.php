<?php
Class Simdaftarskripsi extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m','simdaftarskripsi_m','masmahasiswa_m'));
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
	function input($jenisdaftar = '', $iddaftarskripsi = ''){
		if(!$jenisdaftar){
			$jenisdaftar = $this->uri->segment(4);
		}
		$data['jenisdaftar'] = $jenisdaftar;
		$data['iddaftarskripsi'] = $iddaftarskripsi;
		$nim = $this->session->userdata('sesi_user_mhs');
		$cekstatus = $this->simdaftarskripsi_m->cekstatus($nim);
		if(!$cekstatus){
			echo '<div class="alert"><b>KONFIRMASI</b>, Untuk saat ini anda tidak mendapatkan akses fitur ini.
			Untuk melakukan pendaftaran KP, TA/SKRIPSI online anda dapat menghubungi pihak akademik dan keuangan.</div>';
		}else{
			$thajar = $this->simsetting_m->select_active();
			$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
			$this->detail_mahasiswa($nim);
			$data['title'] = 'Pendaftaran KP/TA/Skripsi';
			$this->load->view('mhs/simdaftarskripsi/isimdaftarskripsi_v', $data);
		}
	}
	function save_mahasiswa(){
		$config = array(
			array(
				'field'   => 'nim',
				'label'   => 'NIM',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pembimbing1',
				'label'   => 'Pembimbing 1',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pembimbing2',
				'label'   => 'Pembimbing 2',
				'rules'   => 'required'
			),
			array(
				'field'   => 'judulskripsi',
				'label'   => 'Judul',
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
			$this->input($this->input->post('jenisdaftar'), $this->input->post('iddaftarskripsi'));
		}else{
			$this->simdaftarskripsi_m->insert_mahasiswa();
			redirect('mhs/simdaftarskripsi/browse');
		}
	}
	function save(){
		$config = array(
			array(
				'field'   => 'nim',
				'label'   => 'NIM',
				'rules'   => 'required'
			),
			array(
				'field'   => 'jenisdaftar',
				'label'   => 'Jenis Pendaftaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'statusdaftar',
				'label'   => 'Status Pendaftaran',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pembimbing1',
				'label'   => 'Pembimbing 1',
				'rules'   => 'required'
			),
			array(
				'field'   => 'pembimbing2',
				'label'   => 'Pembimbing 2',
				'rules'   => 'required'
			),
			array(
				'field'   => 'judulskripsi',
				'label'   => 'Judul',
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
			$this->input();
		}else{
			$cek = $this->simdaftarskripsi_m->cekdaftar();
			if($cek){
				$this->input();
				$this->simplival->alert('PERINGATAN\nAnda Sudah Mendaftar '.$this->input->post('jenisdaftar').' Sebelumnya');
				return false;
			}else{
				$this->simdaftarskripsi_m->insert();
			}
			$this->confirm_simpan();
		}
	}
	function confirm_simpan(){
		$this->load->view('mhs/simdaftarskripsi/tconfirmsimpan_v');
		redirect('mhs/simdaftarskripsi/browse');
	}
	function browse(){
		$data['title'] = 'Pendaftaran TA/KP/Skripsi';
		$nim = $this->session->userdata('sesi_user_mhs');
		$data['cek_daftar'] = $this->simdaftarskripsi_m->count_all($nim);
		$data['detail_simdaftarskripsi'] = $this->simdaftarskripsi_m->get_one($nim);
		$this->load->view('mhs/simdaftarskripsi/tsimdaftarskripsi_v', $data);
	}
	function cetak_sk(){
		$nim = $this->session->userdata('sesi_user_mhs');
		if($nim){
			$id = $this->uri->segment(4);
			$data['daftar'] = $this->simdaftarskripsi_m->get_byid($id);
			$data['prodi'] = $this->auth->get_prodibynim($nim);
			$jenis = strtoupper($data['daftar']->jenisdaftar);
			$ins_prodi = inisial($data['prodi']->namaprodi);
			$data['nosk'] = 'xx/'.$ins_prodi.'/SK-'.$jenis.'/V/'.substr(date('Y'),2,2);
			$this->load->view('mhs/simdaftarskripsi/csk_v', $data);
		}else{
			$this->simplival->alert('KONFIRMASI\nHarap diulang kembali. Sesi sudah terhapus');
		}
	}
}
?>