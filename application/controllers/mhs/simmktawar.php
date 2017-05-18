<?php
	Class Simmktawar extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("simmktawar_m","simprodi_m","simsetting_m","masmahasiswa_m","simdosenampu_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		/* START BUAT PRESENSI */
		function download(){
			$this->session->userdata('sesi_user_mhs');
			$data['title'] = 'Matakuliah Tawaran';
			$kodeprodi = $this->auth->get_prodibynim($this->session->userdata('sesi_user_mhs'))->kodeprodi;
			$thajaran = $this->session->userdata('sesi_thajaran');
			$nim = $this->session->userdata('sesi_user_mhs');
			$semester = substr($thajaran,4,2);
			if($semester % 2 == 0){
				$data['semester'] = 'Genap';
			}else{
				$data['semester'] = 'Gasal';
			}
			$data['tahunajaran'] = substr($thajaran,0,4);
			$data['browse_mktawar'] = $this->simmktawar_m->get_byprodi($kodeprodi, $semester, $nim);
			$this->load->view('mhs/tdownload_v', $data);
		}
	}
?>