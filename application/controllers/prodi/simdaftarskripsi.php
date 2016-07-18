<?php
Class Simdaftarskripsi extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simsetting_m','simprodi_m','simdaftarskripsi_m','masmahasiswa_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata('cari_simdaftarskripsi', $this->input->post('txtCari'));
		}else{
			$this->session->set_userdata('cari_simdaftarskripsi', '');
		}
		$this->browse();
	}
	function change_jenisdaftar(){
		$this->session->set_userdata('sesi_jenisdaftar', $this->uri->segment(4));
		redirect('prodi/simdaftarskripsi/browse');
	}
	function browse(){
		$data['title'] = 'Daftar Data Pendaftar KP/TA/Skripsi';
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->simdaftarskripsi_m->count_all($this->session->userdata('cari_simdaftarskripsi'));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'prodi/simdaftarskripsi_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_masmahasiswa"] = $this->simdaftarskripsi_m->get_all($data['no'], $perpage, $this->session->userdata('cari_simdaftarskripsi'));
		$this->load->view("prodi/simdaftarskripsi/tpendaftarskripsi_v",$data);
	}
	function tmp_pengambil(){
		$n = count($this->input->post('nim'));
		$nim = $this->input->post('nim');
		$hasil = '';
		for($i=0;$i<$n;$i++){
			$nim[$i];
			$hasil = $hasil.','.$nim[$i];
		}
		echo form_hidden('jum', $n);
		$this->session->set_userdata('sesi_tmppengambil', $hasil);
		$pengambil = substr($this->session->userdata('sesi_tmppengambil'),1,strlen($this->session->userdata('sesi_tmppengambil')));
		$tmp = explode(',', $pengambil);
		$n = count($tmp);
		for($i=0;$i<$n;$i++){
			echo '<div class="mini-list">'.$tmp[$i].'-'.$this->auth->get_namamhsbynim($tmp[$i]).'<div>';
		}
	}
	/* BELUM SUPPORT UNTUK PENGAMBIL YANG MENGULANG. NANTI BISA DITAMBAHKAN DAN KOMENTAR INI DIHILANGKAN */
	function browse_pendaftar(){
		$jenisdaftar = $this->uri->segment(4);
		$data['title'] = 'Daftar Data Pendaftar KP/TA/Skripsi';
		/* $data['no'] = $this->uri->segment(4, 0); */
		$data['nosk'] = good_segment($this->uri->segment(5));
		$data['total_page']	= $this->simdaftarskripsi_m->count_forbrowse($jenisdaftar);
		$perpage	= 100;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'prodi/simdaftarskripsi/browse_pendaftar/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		if($data['nosk']){
			$data["browse_simdaftarskripsi"] = $this->simdaftarskripsi_m->get_forbrowse($jenisdaftar, $data['nosk']);
		}
		$data["browse_simdaftarskripsino"] = $this->simdaftarskripsi_m->get_forbrowse_no($jenisdaftar);
		$this->load->view("prodi/simdaftarskripsi/tsimdaftarskripsi_v",$data);
	}
	/*function browse(){
		$data['title'] = 'Daftar Data Pendaftar KP/TA/Skripsi';
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->simdaftarskripsi_m->count_all($this->session->userdata('cari_simdaftarskripsi'));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'prodi/simdaftarskripsi_m/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_simdaftarskripsi"] = $this->simdaftarskripsi_m->get_all($data['no'],$perpage,$this->session->userdata('cari_simdaftarskripsi'));
		$this->load->view("prodi/simdaftarskripsi/tsimdaftarskripsi_v",$data);
	} */
	function change_sk(){
		$this->session->set_userdata('jenis_sk', $this->input->post('jenis_sk'));
		$this->browse_sk();
	}
	function browse_sk(){
		$data['title'] = 'Daftar Surat Keputusan';
		$data['no'] = $this->uri->segment(4, 0);
		$jenis_sk = $this->session->userdata('jenis_sk');
		$data['total_page']	= $this->simdaftarskripsi_m->count_sk($jenis_sk);
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'prodi/simdaftarskripsi_m/browse_sk/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_sk"] = $this->simdaftarskripsi_m->get_sk($data['no'], $perpage, $jenis_sk);
		$this->load->view("prodi/simdaftarskripsi/tsk_v",$data);
	}
	function add_sk(){
		$data[''] = '';
		$this->load->view('prodi/simdaftarskripsi/isk_v', $data);
	}
	function detail_sk($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$nosk = good_segment($id);

		$data['daftar'] = $this->simdaftarskripsi_m->get_bynosk($nosk);
		$data['browse_daftar'] = $this->simdaftarskripsi_m->get_allbynosk($nosk);
		$data['namaprodi'] = $this->auth->get_namaprodi($this->session->userdata('sesi_prodi'));
		$data['prodi'] = $this->auth->get_prodi($this->session->userdata('sesi_prodi'));
		$jenis = strtoupper($data['daftar']->jenisdaftar);
		$ins_prodi = inisial($this->auth->get_namaprodi($this->session->userdata('sesi_prodi')));
		$data['nosk'] = 'xx/'.$ins_prodi.'/SK-'.$jenis.'/V/'.substr(date('Y'),2,2);
		$this->load->view('prodi/simdaftarskripsi/tdsk_v', $data);
		
		
		
		// if(!$id){
			// $id = $this->uri->segment(4);
		// }
		// $gn = $this->simdaftarskripsi_m->get_nim($id);
		// $nim = $gn['nim'];
		// $this->detail_mahasiswa($nim);
		
		// $data['daftar'] = $this->simdaftarskripsi_m->get_byid($id);
		// $jenis = strtoupper($data['daftar']->jenisdaftar);
		// $ins_prodi = inisial($data['prodi']->namaprodi);
		// $data['nosk'] = 'xx/'.$ins_prodi.'/SK-'.$jenis.'/V/'.substr(date('Y'),2,2);

		// $data['title'] = 'Pendaftaran KP/TA/Skripsi';
		// $data['detail_simdaftarskripsi'] = $this->simdaftarskripsi_m->get_one2($id);
		// $this->load->view('prodi/simdaftarskripsi/esimdaftarskripsi_v', $data);
		
	}
	function edit_sk($id=''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$id = good_segment($id);
		$nim_pendaftar = $this->simdaftarskripsi_m->get_arrbysk($id);
		$this->session->set_userdata('sesi_tmppengambil', $nim_pendaftar);
		$data['pengambil'] = $this->session->userdata('sesi_tmppengambil');
		$data['jd'] = $this->auth->get_enum('simdaftarskripsi', 'jenisdaftar');
		$data['sk'] = $this->simdaftarskripsi_m->get_onesk($id);
		$this->load->view('prodi/simdaftarskripsi/esk_v', $data);
	}
	function simpan(){
		$config = array(
			array(
				'field'   => 'nosk',
				'label'   => 'Nomor SK',
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$id = $this->input->post('iddaftarskripsi');
		if($this->form_validation->run() == FALSE){
			if($id){
				$this->edit_sk($id);
			}else{
				$this->add_sk();
			}
		}else{
			$tmp = explode(',', $this->session->userdata('sesi_tmppengambil'));
			$n	 = $this->input->post('jum')+1;
			for($i=1;$i<$n;$i++){
				if($tmp[$i]){
					$this->simdaftarskripsi_m->update_sk($tmp[$i]);
				}
			}
			redirect('prodi/simdaftarskripsi/browse_sk');
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
		$id = $this->input->post('iddaftarskripsi');
		if ($this->form_validation->run() == FALSE){
			$this->edit($id);
		}else{
			$this->simdaftarskripsi_m->insert_byprodi();
			//echo $this->db->last_query();
			redirect('prodi/masmahasiswa/pendaftaran/'.$this->input->post('nim'));
		}
	}
	function edit($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$gn = $this->simdaftarskripsi_m->get_nim($id);
		$nim = $gn['nim'];
		$this->detail_mahasiswa($nim);
		
		$data['daftar'] = $this->simdaftarskripsi_m->get_byid($id);
		$data['prodi'] = $this->auth->get_prodibynim($nim);
		$jenis = strtoupper($data['daftar']->jenisdaftar);
		$ins_prodi = inisial($data['prodi']->namaprodi);
		$data['nosk'] = 'xx/'.$ins_prodi.'/SK-'.$jenis.'/V/'.substr(date('Y'),2,2);

		$data['title'] = 'Pendaftaran KP/TA/Skripsi';
		$data['detail_simdaftarskripsi'] = $this->simdaftarskripsi_m->get_one2($id);
		$this->load->view('prodi/simdaftarskripsi/esimdaftarskripsi_v', $data);
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
	function delete(){
		$this->simdaftarskripsi_m->delete($this->uri->segment(4));
		redirect('prodi/simdaftarskripsi/browse');
	}
	function cetak_sk(){
		$nim = $this->uri->segment(5);
		if($nim){
			$id = $this->uri->segment(4);
			$data['daftar'] = $this->simdaftarskripsi_m->get_byid($id);
			$data['prodi'] = $this->auth->get_prodibynim($nim);
			$jenis = strtoupper($data['daftar']->jenisdaftar);
			$ins_prodi = inisial($data['prodi']->namaprodi);
			$data['nosk'] = 'xx/'.$ins_prodi.'/SK-'.$jenis.'/V/'.substr(date('Y'),2,2);
			$this->load->view('prodi/simdaftarskripsi/csk_v', $data);
		}else{
			$this->simplival->alert('KONFIRMASI\nHarap diulang kembali. Sesi sudah terhapus');
		}
	}
	function delete_sk(){
		$nosk = good_segment($this->uri->segment(4));
		$this->simdaftarskripsi_m->reset_sk($nosk);
		redirect('prodi/simdaftarskripsi/browse_sk');
	}
}
?>