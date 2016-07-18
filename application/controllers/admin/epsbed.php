<?php
Class Epsbed extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array("epsbed_m"));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
	}
	function index(){
		$this->browse();
	}
	function export_kurikulum(){
		$data['namafile'] = "TBKMK";
		$data['browse_kurikulum'] = $this->epsbed_m->get_kurikulum($this->session->userdata('sesi_tahunajar'));
		$this->load->view('admin/epsbed/exkurikulum_v', $data);
	}
	function export_nilai(){
		$data['namafile'] = "TRNLM";
		$data['browse_nilai'] = $this->epsbed_m->get_nilai($this->session->userdata('sesi_tahunajar'));
		$this->load->view('admin/epsbed/exnilai_v', $data);
	}
	function export_kuliahmhs(){
		$data['namafile'] = "TRAKM";
		$data['browse_kuliah'] = $this->epsbed_m->get_kuliahmhs($this->session->userdata('sesi_tahunajar'));
		$this->load->view('admin/epsbed/exkuliahmhs_v', $data);
	}
	function export_mhs(){
		$data['namafile'] = "MSMHS";
		$data['browse_krs'] = $this->epsbed_m->get_mhs_all($this->session->userdata('sesi_tahunajar'));
		$this->load->view('admin/epsbed/exmhs_v', $data);
	}
	function export_krs(){
		$data['namafile'] = "TRKRS";
		$data['browse_krs'] = $this->epsbed_m->get_krs_all($this->session->userdata('sesi_tahunajar'));
		$this->load->view('admin/epsbed/exkrs_v', $data);
	}
	/* EXPORT STATUS BELUM JADI... PROGRAMMERNYA LEMES......*/
	function export_status(){
		$data['namafile'] = "TRLSM";
		$data['browse_status'] = $this->epsbed_m->get_status_all($this->session->userdata('sesi_tahunajar'));
		$this->load->view('admin/epsbed/exstatus_v', $data);
	}
	function form_eksport(){
		if(!$this->session->userdata('sesi_tahunajar')){
			$sesi_thajaran = $this->session->userdata('sesi_thajaran');
			$this->session->set_userdata('sesi_tahunajar', $sesi_thajaran);
		}
		$data['title'] = 'Form Eksport To PDPT';
		$data['tahun'] = substr($this->session->userdata('sesi_tahunajar'), 0, 4);
		$data['semester'] = substr($this->session->userdata('sesi_tahunajar'), 4, 1);
		$this->load->view('admin/epsbed/fexport_v', $data);
	}
	function changethajaran(){
		if($this->uri->segment(4)){
			$this->session->set_userdata('sesi_tahunajar', $this->uri->segment(4));
		}
	}
}
?>