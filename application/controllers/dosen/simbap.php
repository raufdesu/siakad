<?php
Class Simbap extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simprodi_m','simsetting_m','simbap_m','simdosenampu_m','presensimhs_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals','html'));
	}
	function index(){
		$this->input();
	}
	function change_minus(){
		$this->session->set_userdata('sesi_minus', $this->uri->segment(4));
		$this->daftarmatkul_bydosen();
	}
	function daftarmatkul_bydosen(){
		$data['title'] = 'Cek Presensi Kurang Dari 75%';
		$data['browse_matakuliah'] = $this->simbap_m->get_bydosen($this->session->userdata('sesi_user'));
		$this->load->view('dosen/simbap/tpresensi_minus_v', $data);
	}
	function browse($idkelas=''){
		$data['title'] = 'Daftar BAP Matakuliah';
		if(!$idkelas){
			$data['id_kelas_dosen'] = $this->session->userdata('sesi_dosenampu');
		}else{
			$this->session->set_userdata('sesi_dosenampu', $idkelas);
			$data['id_kelas_dosen'] = $this->session->userdata('sesi_dosenampu');
		}
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= 3; //$this->simbap_m->count_byidkelas($this->session->userdata('sesi_dosenampu'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'dosen/simbap/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_bap'] = $this->simbap_m->get_byidkelas($data['id_kelas_dosen']);
		$this->load->view('dosen/simbap/tsimbap_v', $data);
	}
	function input($id_kelas){
			if(!$id_kelas)
				$id_kelas = $this->uri->segment(4,0);
			$this->session->set_userdata('sesi_dosenampu', $id_kelas);
			$sesi_dosenampu = $this->session->userdata('sesi_dosenampu');
			$ampu = $this->simdosenampu_m->get_one($sesi_dosenampu);
			$data['kodemk'] = $ampu->kodemk;
			$data['namamatkul'] = $ampu->namamatkul;
			$data['kelas'] = $ampu->kelas;
			$data['thajaran'] = $ampu->thajaran;
			$data['id_kelas_dosen'] = $ampu->id_kelas_dosen;
			
			
			
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= 3; //$this->simbap_m->count_byidkelas($this->session->userdata('sesi_dosenampu'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'dosen/simbap/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_bap'] = $this->simbap_m->get_byidkelas($data['id_kelas_dosen']);

		
		
		$this->load->view('dosen/simbap/isimbap_v', $data);
	}
	function edit($idbap = ''){
		if(!$idbap){
			$idbap = $this->uri->segment(4);
		}
		$idkelas = $this->simbap_m->get_idkelasbyidbap($idbap);
		$this->session->set_userdata('sesi_dosenampu', $idkelas);
		$data['idkelas'] = $idkelas;
		$sesi_dosenampu = $this->session->userdata('sesi_dosenampu');

		$data['ampu'] = $this->simdosenampu_m->get_one($sesi_dosenampu);
		$data['bap'] = $this->simbap_m->get_one($idbap);
		
		
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= 3; //$this->simbap_m->count_byidkelas($this->session->userdata('sesi_dosenampu'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'dosen/simbap/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_bap'] = $this->simbap_m->get_byidkelas($data['idkelas']);



		$this->load->view('dosen/simbap/esimbap_v', $data);
	}
	/* INI FUNCTION EDIT YANG LAMA KAYAKNYA GK KEPAKAI
	function edit(){
		$user = $this->session->userdata('sesi_user');
		$data['detail_simbap'] = $this->simbap_m->detail($user);
		$this->load->view('dosen/simbap/esimbap_v', $data);
	} */
	function input_presensi(){
		$lb = $this->simbap_m->last_bap();
		$data['idbap'] = $lb['idbap'];
		$data['materi'] = $lb['materi'];
		$data['tglkuliah'] = $lb['tglkuliah'];
		$data['id_kelas_dosen'] = $lb['id_kelas_dosen'];
		
		if($this->uri->segment(4)){
			$data['idbap'] = $this->uri->segment(4);
		}else{
			$data['idbap'] = $lb['idbap'];
		}
		$user = $this->session->userdata('sesi_user');
			$sesi_dosenampu = $this->session->userdata('sesi_dosenampu');
			$ampu = $this->simdosenampu_m->get_one($sesi_dosenampu);
			
			$data['kodemk'] = $ampu->kodemk;
			$data['namamatkul'] = $ampu->namamatkul;
			$data['kelas'] = $ampu->kelas;
			$data['thajaran'] = $ampu->thajaran;
			$data['id_kelas_dosen'] = $ampu->id_kelas_dosen;
			$this->session->set_userdata('sesi_kodemk', $data['kodemk']);
			/* kelas siang atau malam masih statis */
			$kelas = $this->session->userdata('sesi_kelas');
		if($sesi_dosenampu){
			$data['mahasiswaambilmk'] = $this->simbap_m->get_mhsbybap($data['idbap']);
			/* echo $this->db->last_query(); */
			$this->load->view('dosen/simbap/isimpresensimhs_v', $data);
		}
	}
	function save_presensi(){
		$n = $this->input->post('n');
		if($this->input->post('idbap')){
			for($i=1;$i<=$n;$i++){
				$this->presensimhs_m->insert($this->input->post('nim_'.$i),$this->input->post('status_'.$i), $this->input->post('idpresensimhs_'.$i));
			}
		}
		$data['title'] = 'Konfirmasi Simpan';
		$this->load->view('dosen/tsukses_simpan_v', $data);
	}
	function cetak(){
		$thajaran = $this->input->post('thajaran');
		$data['kodematkul'] = $this->simbap_m->getmatkul_byidkelas($this->uri->segment(4))->kodemk;
		$thajaran = $this->simbap_m->getmatkul_byidkelas($this->uri->segment(4))->thajaran;
		
		$data['ampu'] = $this->simdosenampu_m->get_dosenbyidkelas($this->uri->segment(4));
		$amp = $this->simdosenampu_m->get_kelasdosen($data['kodematkul'],$thajaran,$this->uri->segment(4));
			$data['namaprodi'] = $amp['namaprodi'];
			$data['sks'] = $amp['sks'];
			$data['semester'] = $amp['semester'];
			$data['kelas'] = $amp['kelas'];
			$data['namamk'] = $amp['namamk'];
		$data['browse_bap'] = $this->simbap_m->get_byidkelas($this->uri->segment(4));
		$this->load->view('dosen/simbap/cbap_v', $data);
	}
	function update(){
		$this->db->where('idbap', $this->input->post('idbap'));
		$this->db->update('simbap', array('materi'=>$this->input->post('materi'), 'tglkuliah' => tgl_ingg($this->input->post('tglkuliah'))));
		redirect('dosen/simbap/input/'.$this->input->post('id_kelas_dosen'));
	}
	function save(){
		$id_kelas_dosen = $this->input->post('id_kelas_dosen');
		$kodemk = $this->input->post('kodemk');
		$thajaran = $this->input->post('thajaran');
		/* $kelas = 2 atau 1; */
		/* Jika nantinya malah bermasalah, $kelas dikasih 1 atau 2 sesuai dengan sift-nya */
		$config = array(
				array(
					  'field'   => 'id_kelas_dosen',
					  'label'   => 'Kelas dosen',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'materi',
					  'label'   => 'Materi',
					  'rules'   => 'required'
				   )
				 );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<br /><span class="error"> * ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->input($id_kelas_dosen);
		}else{
			$this->simbap_m->insert();
			$this->simbap_m->insert_presensimhs($kodemk, $thajaran, $id_kelas_dosen);
				$bap = $this->simbap_m->last_bap();
				$last_bap = $bap['idbap'];
				$this->session->set_userdata('sesi_lastbap', $last_bap);
			redirect('dosen/simbap/input_presensi');
		}
	}
	function hapus(){
		$this->simbap_m->delete($this->uri->segment(4));
		redirect('dosen/simbap/input/'.$this->session->userdata('sesi_dosenampu'));
	}
}
?>