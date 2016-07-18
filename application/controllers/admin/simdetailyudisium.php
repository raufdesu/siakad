<?php
Class Simdetailyudisium extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array("simdetailyudisium_m", "simyudisium_m","simtranskrip_m","masalumni_m"));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
	}
	function pracetak(){
		$data['title'] = 'Form Yudisium';
		$nim = $this->session->userdata('sesi_nimmhs');
		$cek = $this->simdetailyudisium_m->cek($nim);
		$edit = $this->uri->segment(4);
		if($nim && $cek && $edit){
			$data['jum_sks'] = $this->simtranskrip_m->get_jumsks($nim);
			$data['jum_ipk'] = $this->simtranskrip_m->get_ipk($nim);
			$data['browse_ny'] = $this->simyudisium_m->get_noyudisium();
			$data['yud'] = $this->simdetailyudisium_m->get_bynim($nim);
			$this->load->view('admin/simdetailyudisium/esimdetailyudisium_v', $data);
		}elseif($nim && !$cek){
			$data['jum_sks'] = $this->simtranskrip_m->get_jumsks($nim);
			$data['jum_ipk'] = $this->simtranskrip_m->get_ipk($nim);
			$data['browse_ny'] = $this->simyudisium_m->get_noyudisium();
			$yud = $this->simyudisium_m->get_lastnoyudisium();
			$data['noyudisium'] = $yud['noyudisium'];
			$data['idyudisium'] = $yud['idyudisium'];
			$this->load->view('admin/simdetailyudisium/isimdetailyudisium_v', $data);
		}elseif($nim && $cek){
			$data['nim'] = $nim;
			$this->load->view('admin/simtranskrip/tcetak_v', $data);
		}else{
			echo "<div style='margin:10px'><h2>PERINGATAN</h2>Harap Tentukan NIM Mahasiswa yang akan dicetak terlebih dahulu<br />
			<input type='button' style='float:right;' onclick='jQuery.facebox.close();' value='Tutup'></div><br />";
		}
	}
	function input(){
		$data['title'] = 'Form Yudisium';
		$this->load->view('admin/simdetailyudisium/isimdetailyudisium_v', $data);
	}
	function save(){
		if($this->session->userdata('sesi_nimmhs')){
			$this->simdetailyudisium_m->insert();
			/* $this->masalumni_m->auto_insert($this->session->userdata('sesi_nimmhs')); */
			redirect('admin/simtranskrip/cetak');
		}else{
			$this->simplival->alert('PERINGATAN\nSesi Habis, Harap Tentukan NIM Mahasiswa Lagi');
			return false;
		}
	}
}
?>