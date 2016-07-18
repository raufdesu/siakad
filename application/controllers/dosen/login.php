<?php
class Login extends Controller {
	function __construct(){
		parent::Controller();
		$this->load->library('session');
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->model(array("settings_m","login_m"));
	}
	function index(){
		$data["alert"]	= "";
		$data["title"]	= "Form login";
		$this->load->view("dosen/login_v",$data);  
	}
	function gantipassword(){
		$data = '';
		$this->load->view("dosen/login/elogin_v", $data);
	}
	function edit(){
	}

	function do_gantipassword(){
		$config = array(
				array(
					'field'   => 'username',
					'label'   => 'NPP / Username',
					'rules'   => 'required'
				),
				array(
					'field'   => 'password',
					'label'   => 'Password',
					'rules'   => 'required'
				),
				array(
					'field'   => 'passbaru',
					'label'   => 'Password Baru',
					'rules'   => 'required'
				),
				array(
					'field'   => 'renewpassword',
					'label'   => 'Konfirmasi Password',
					'rules'   => 'required|matches[passbaru]'
				)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->gantipassword();
		}else{
			if($this->login_m->ceklogin_dosen() == 0){
				$this->simplival->alert('PERINGATAN !\nNPP/Username dan Password Anda Tidak Sesuai');
				$this->gantipassword();
			}else{
				$this->login_m->ubah();
				$this->load->view('dosen/login/confirmupdatelogin_v');
			}
		}
	}
	function home(){
		$data["main"] = "main/home";
		$this->load->view('main/index',$data);
	}
}