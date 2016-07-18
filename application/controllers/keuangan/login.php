<?php
class Login extends Controller {
	function __construct(){
		parent::Controller();
		$this->load->library(array('table', 'pagination', 'form_validation', 'simpliparse', 'pquery'));
		$this->load->model(array("login_m", "settings_m"));
	}
	function index(){
		$data["alert"]	= "";
		$data["title"]	= "Form Login";
		$this->load->view("keuangan/login_v", $data);
	}
	function browse_username(){
		$cari = '';
		$this->db->where('status !=','keuangan');
		$this->db->from('login');
		$count = $this->db->count_all_results();
		$data['browse_login'] = $this->login_m->get_all(0, $count, $cari);
		$this->load->view('keuangan/login/blogin_v', $data);
	}
	function gantipassword(){
		$this->load->view('keuangan/login/elogin_v');
	}
	function gantipassword_dosen(){
		$this->load->view('keuangan/login/elogindosen_v');
	}
	function do_gantipassword(){
		$config = array(
				array(
					'field'   => 'username',
					'label'   => 'NPP / Username',
					'rules'   => 'required'
				),
				array(
					'field'   => 'usernamebaru',
					'label'   => 'Username baru',
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
				$this->login_m->update();
				$this->load->view('keuangan/login/confirmupdatelogin_v');
			}
		}
	}
	function update_passdosen(){
		$config = array(
				array(
					  'field'   => 'username',
					  'label'   => 'NPP atau username',
					  'rules'   => 'required'
				),
				array(
					  'field'   => 'passbaru',
					  'label'   => 'Password baru',
					  'rules'   => 'required'
				),
				array(
					  'field'   => 'upassbaru',
					  'label'   => 'Pengulangan password baru',
					  'rules'   => 'required|matches[passbaru]'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if ($this->form_validation->run() == FALSE){
			$this->gantipassword_dosen();
		}else{
			$this->login_m->update_passdosen();
			$this->load->view('dosen/login/confirmupdatelogin_v');
		}
	}
	function cari_password(){
		$this->session->set_userdata("sesi_caripassword", $this->input->post("txtCari"));
		redirect(base_url()."index.php/keuangan/login/tampil", "refresh");
	}
	function index_browse(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata("sesi_caripassword", $this->input->post("txtCari"));
		}else{
			$this->session->set_userdata("sesi_caripassword", '');
		}
		$this->browse();
	}
	function browse(){
		$data["title"] = "Daftar Password ".$this->config->item('project_company');
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->login_m->count_allmhs($this->session->userdata("sesi_caripassword"));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'keuangan/login/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_login"] = $this->login_m->get_allmhs($data['no'], $perpage, $this->session->userdata("sesi_caripassword"));
		$this->load->view("keuangan/login/tlogin_v", $data);
	}
	function cek_login(){
		$this->load->model('login_m','',true);
		$hasil = $this->login_m->login();
		if($hasil == true) {
			$this->_dropsesi();
			$dth = $this->login_m->getThajaran();
			/* $this->session->set_userdata('sesi_thajaran',$dth['thajaran']); */
			$log_sesi = array(
				"sesi_id"		=> $hasil['idlogin'],
				"sesi_user"		=> $hasil['username'],
				"sesi_status"	=> $hasil['status'],
				"sesi_keuangan"	=> $hasil['keuangan'],
				"sesi_thajaran"	=> $dth['thajaran']
			);
			$this->session->set_userdata($log_sesi);
			redirect("keuangan/main", "refresh");
		} else {
			$data['user'] = "0";
			$data['alert'] = "Login Failed";
			$this->load->view("keuangan/login_v",$data);
		}
	}
	/* PENGHAPUSAN SEMUA SESI */
	function _dropsesi(){
		$sesi_items = array(
			'sesi_user'		=> '',
			'sesi_thajaran'	=> '',
			'sesi_keuangan'	=> '',
			'sesi_status'	=> ''
		);
		$this->session->unset_userdata($sesi_items);	
	}
	/* KELUAR DARI keuanganISTRATOR */
	function logout(){
		$this->_dropsesi();
		redirect("keuangan/login/","refresh");
	}

	function edit(){
		$data["title"]	= "Form Pengubahan Password";
		$data["main"]	= "eLogin_v";
		$data["alert"]	= "";
		$data['sesi_user'] = $this->session->userdata('sesi_user');
		$this->load->view("keuangan/main",$data);
	}

	function ubah(){
        $cek_sama = "";
		//if($this->input->post(pass_lama) == $this->session->userdata("sesi
        if($this->input->post("passbaru")!=($this->input->post("upassbaru"))){
            $data["cek"] = "Password Baru Anda ditolak, Ulangi penulisan password dengan benar";
        }else{
            $hasil = $this->login_m->cek_ubah();
            if ($hasil == true) {
                $this->login_m->ubah();
                $data['cek'] = "Password Berhasil Di Update";
				die ('cek');
            } else {
                $data['kosong'] = "1";
                $data['cek'] = "Gagal Melakukan Perubahan Password";
            }
        }
		$data['title']	= 'Konfirmasi Perubahan Password';
		$data['main'] = "konf_eLogin";
		$this->load->view("keuangan/main",$data);
	}

	function home(){
		$data["main"] = "main/home";
		$this->load->view('main/index',$data);
	}
	function delete(){
		$this->login_m->hapus($this->uri->segment(4));
		redirect('keuangan/login/index_browse');
	}
}