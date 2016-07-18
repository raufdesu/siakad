<?php
Class Profil extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('profil_m', 'kabupaten_m'));
		$this->load->library(array('simpliparse','pquery','form_validation'));
	}
	function index(){
	}
	function edit(){
		$data['propinsi'] = $this->db->get('tpropinsi');
		$data['dp'] = $this->profil_m->get_one();
		$this->load->view('admin/profil/eprofil_v', $data);
	}
	function save(){
		$this->profil_m->insert();
		redirect('admin/simsetting');
	}
	function tampilkan_kabupaten(){
		$kabupaten = $this->kabupaten_m->get_all($this->uri->segment(4));
		echo '<select name="idkabupaten">';
			foreach($kabupaten as $kab):
				echo '<option value="'.$kab->idkabupaten.'">'.$kab->namakabupaten.'</option>';
			endforeach;
		echo '</select>';
	}
}
?>