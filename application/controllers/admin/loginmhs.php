<?php
class Loginmhs extends Controller {
	function __construct(){
		parent::Controller();
		$this->load->library(array('pquery', 'form_validation'));
		$this->load->model(array('loginmhs_m', 'masmahasiswa_m'));
	}
	function delete(){
		$this->loginmhs_m->delete($this->uri->segment(4));
		redirect('admin/login/index_browse');
	}
	function input(){
		$data['title']	= 'Form Input Password Mahasiswa';
		$this->load->view('admin/login/iloginmhs_v', $data);
	}
	function savemhs(){
		$config = array(
				array(
					  'field'   => 'nim',
					  'label'   => 'NIM',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'nama',
					  'label'   => 'Nama',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'password',
					  'label'   => 'Password',
					  'rules'   => 'required'
				   )
				 );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->input();
		}else{
			/* Harus ada pengecekan - ada apa belum nim yang diinputkan. */
			/* Harus ada pengecekan NIM yang ada di mahasiswa. */
			$cekada = $this->loginmhs_m->cek_ada($this->input->post('nim'));
			if(!$cekada){
				$this->loginmhs_m->insert();
			}
			redirect('admin/login/index_browse');
		}
	}
	function namamhs(){
		$nim = $this->uri->segment(4);
		$nama = $this->masmahasiswa_m->get_namabynim($nim);
		$arnama = array(
			'name'	=> 'nama',
			'value'	=> $nama,
			'size'	=> 45,
			'readonly'	=> 'readonly'
		);
		echo form_input($arnama);
	}
}