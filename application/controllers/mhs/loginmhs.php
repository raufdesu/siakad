<?php
class Loginmhs extends Controller {
	function __construct()
	{
		parent::Controller();
		$this->load->library('session');
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->model(array("settings_m","loginmhs_m"));
	}
	function index()
	{
		$data["alert"]	= "";
		$data["title"]	= "Form loginmhs";
		$this->load->view("mhs/loginmhs_v",$data);  
	}
	function show_pengumuman(){
		$this->load->view('mhs/loginmhs/tpengumuman_v');
	}
	function thajaran_active(){
		$this->db->select('thajaran');
		$this->db->from('simsetting');
		$this->db->where('aktif', 'Aktif');
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		}
	}
	function cek_loginmhs(){
		$config = array(
				array(
					'field'   => 'username',
					'label'   => 'NIM Mahasiswa',
					'rules'   => 'required'
				)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if ($this->form_validation->run() == FALSE){
			$data['alert'] = '';
			$this->load->view('mhs/loginmhs_v',$data);
			return false;
		}
		// echo $this->input->post('username');
		// exit;
		$thaktif = $this->thajaran_active();
		$thakad = $thaktif['thajaran'];
		$hasil = $this->loginmhs_m->loginmhs();
		// echo $this->db->last_query();
		if ($hasil == true) {
			$data['user'] = $hasil;
			$data['cek'] = "Anda Berhasil loginmhs";
			$ahapus = array(
				"sesi_user_mhs" => "",
				"sesi_status_mhs" => "",
				"sesi_nama_mhs" => ""
			);
			$this->session->set_userdata($ahapus);
			$this->session->set_userdata('sesi_user_mhs', $hasil['nim']);
			$this->session->set_userdata('sesi_status_mhs', $hasil['status']);
			$this->session->set_userdata('sesi_nama_mhs', $hasil['namamhs']);
			$this->session->set_userdata('sesi_thajaran', $thakad);
			/*$data['sesi_user_mhs_mhs']	= $this->session->userdata('sesi_user_mhs');
			$data['sesi_status_mhs']= $this->session->userdata('sesi_status_mhs');
			$data['sesi_nama_mhs']= $this->session->userdata('sesi_status_mhs'); */
			redirect("mhs/main",$data);
			if($this->session->userdata("sesi_status_mhs")=="2"){
				$akt = $this->settings_m->detail();
				$arset = array(
					"sesi_semester" => $akt["semester"],
					"sesi_thn_akad" => $akt["thn_akad"]
				);
				$this->session->set_userdata($arset);
				redirect("mhs/main",$data);
			}
		} else {
			//echo $this->db->last_query(); exit;
			$data['user'] = "0";
			$data['alert'] = "Acces Denied";
			//echo $this->db->last_query();
			$this->load->view("mhs/loginmhs_v",$data);
		}
	}
	function logout(){
		$sesi_items = array('sesi_user_mhs' => '', 'sesi_status_mhs' => '');
		$this->session->unset_userdata($sesi_items);
		redirect(base_url(),"refresh");
	}

	function edit(){
		$data["title"]	= "Form Pengubahan Password";
		$data["main"]	= "eloginmhs_v";
		$data["alert"]	= "";
		$data['sesi_user_mhs'] = $this->session->userdata('sesi_user_mhs');
		$this->load->view("mhs/loginmhs/eloginmhs_v",$data);
	}

	function ubah(){
		$config = array(
				array(
					'field'   => 'username',
					'label'   => 'NIM Mahasiswa',
					'rules'   => 'required'
				),
				array(
					'field'   => 'password',
					'label'   => 'Password',
					'rules'   => 'required'
				),
				array(
					'field'   => 'newpassword',
					'label'   => 'Password Baru',
					'rules'   => 'required'
				),
				array(
					'field'   => 'renewpassword',
					'label'   => 'Konfirmasi Password',
					'rules'   => 'required|matches[newpassword]'
				)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error"><br />', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->edit();
		}else{
			if($this->loginmhs_m->cekcount_loginmhs() == 0){
				$this->simplival->alert('PERINGATAN !\nNIM dan Password Anda Tidak Sesuai');
				$this->edit();
			}else{
				$this->loginmhs_m->update();
				$this->load->view('mhs/loginmhs/confirmupdate_v');
			}
		}
	}
	function home(){
		$data["main"] = "main/home";
		$this->load->view('main/index',$data);
	}
}