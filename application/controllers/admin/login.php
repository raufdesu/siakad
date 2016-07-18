<?php
class Login extends Controller {
	function __construct(){
		parent::Controller();
		$this->load->library(array('table', 'pagination', 'form_validation', 'simpliparse', 'pquery'));
		$this->load->model(array('login_m', 'simprodi_m', 'maspegawai_m', 'loginmhs_m', 'settings_m'));
	}
	function index($alert=''){
		date_default_timezone_set("Asia/Jakarta");
		$data["alert"]	= "";
		$data["title"]	= "Form Login";
		$data['a'] = substr(date('s'),0,1);
		$data['b'] = substr(date('s'),1,1);
		$data['c'] = $data['a']+$data['b'];
		$data['alert'] = $alert;
		$this->load->view("admin/login_v", $data);
	}
	function browse_username(){
		$cari = '';
		$this->db->where('status !=','admin');
		$this->db->from('login');
		$count = $this->db->count_all_results();
		$data['browse_login'] = $this->login_m->get_all(0, $count, $cari);
		$this->load->view('admin/login/blogin_v', $data);
	}
	function gantipassword(){
		$this->load->view('admin/login/elogin_v');
	}
	function input(){
		$data['status'] = $this->auth->get_enum('login', 'status');
		$data['browse_prodi'] = $this->simprodi_m->select('','');
		$this->load->view('admin/login/ilogin_v', $data);
	}
	function edit_operator($username = ''){
		if(!$username){
			$username = $this->uri->segment(4);
		}
		$data['status'] = $this->auth->get_enum('login', 'status');
		$data['browse_prodi'] = $this->simprodi_m->select('','');
		$data['login'] = $this->login_m->get_onebyusername($username);
		$this->load->view('admin/login/eloginoperator_v', $data);
	}
	function gantipassword_dosen($username=''){
		if(!$username){
			$username = $this->uri->segment(4);
		}
		$data['username'] = $username;
		$this->load->view('admin/login/elogindosen_v', $data);
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
				$this->load->view('admin/login/confirmupdatelogin_v');
			}
		}
	}
	function savemhs(){
		$config = array(
				array(
					'field'   => 'nim',
					'label'   => 'NIM/Username',
					'rules'   => 'required'
				)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->edit($this->input->post('nim'));
		}else{
			$this->loginmhs_m->insert();
			$this->load->view('admin/login/confirmupdatelogin_v');
		}
	}
	function save_operator(){
		$config = array(
				array(
					  'field'   => 'username',
					  'label'   => 'NPP atau Username',
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
		if ($this->form_validation->run() == FALSE){
			$this->input();
		}else{
			$cekada = $this->login_m->cek_byusername($this->input->post('username'));
			if(!$cekada || $this->input->post('username2')){
				$this->login_m->insert();
				$this->load->view('admin/login/confirmsimpanlogin_v');
			}else{
				echo $this->simplival->alert('Konfirmasi\nUsername sudah ada sebelumnya');
				$this->input();
			}
		}
	}
	function nama_operator(){
		$username = $this->uri->segment(4);
		$nama = $this->maspegawai_m->get_namabynpp($username);
		$arnama = array(
			'name'	=> 'nama',
			'value'	=> $nama,
			'size'	=> 50,
			'readonly' => 'readonly'
		);
		echo form_input($arnama);
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
			$this->gantipassword_dosen($this->input->post('username'));
		}else{
			$this->login_m->update_passdosen();
			$this->load->view('dosen/login/confirmupdatelogin_v');
		}
	}
	function cari_password(){
		$this->session->set_userdata("sesi_caripassword", $this->input->post("txtCari"));
		redirect(base_url()."index.php/admin/login/tampil", "refresh");
	}
	function index_browse(){
		if($this->input->post('txtCari')){
			$this->session->set_userdata("sesi_caripassword", $this->input->post("txtCari"));
		}else{
			$this->session->set_userdata("sesi_caripassword", '');
		}
		$this->browse();
	}
	function cari_operator(){
		// echo "dor"; exit;
		$this->session->set_userdata('sesi_carioperator', $this->input->post('txtCari'));
		$this->browse_admin();
	}
	function browse_admin(){
		$data["title"] = "Daftar Akun Operator/Administrator";
		$data['no'] = $this->uri->segment(4, 0);
		$cari = $this->session->userdata('sesi_carioperator');
		$data['total_page']	= $this->login_m->count_alladm($cari);
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/login/browse_admin/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_login"] = $this->login_m->get_all($data['no'], $perpage, $cari);
		$this->load->view("admin/login/tlogin_v", $data);
	}
	function browse(){
		$data["title"] = "Daftar Akun Mahasiswa";
		$data['no'] = $this->uri->segment(4, 0);
		$data['total_page']	= $this->login_m->count_allmhs($this->session->userdata("sesi_caripassword"));
		$perpage	= 10;
		$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
			$perpage,'admin/login/browse/',4,'#center-column');
		$data['paging'] = $data3['paging'];
		$data["browse_login"] = $this->login_m->get_allmhs($data['no'], $perpage, $this->session->userdata("sesi_caripassword"));
		$this->load->view("admin/login/tloginmhs_v", $data);
	}
	function cek_login(){
		$this->load->model('login_m','',true);
		$hasil = $this->login_m->login();
		$config = array(
				array(
					  'field'   => 'username',
					  'label'   => 'Username',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'password',
					  'label'   => 'Password',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'jawaban',
					  'label'   => 'jawabannya',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'c',
					  'label'   => 'Hasil',
					  'rules'   => 'required|matches[jawaban]'
				   )
				 );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if ($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			if($hasil == true) {
				$this->_dropsesi();
				$dth = $this->login_m->getThajaran();
				/* $this->session->set_userdata('sesi_thajaran',$dth['thajaran']); */
				$log_sesi = array(
					"sesi_id"		=> $hasil['idlogin'],
					"sesi_user"		=> $hasil['username'],
					"sesi_status"	=> $hasil['status'],
					"sesi_prodi"	=> $hasil['prodi'],
					"sesi_thajaran"	=> $dth['thajaran']
				);
				$this->session->set_userdata($log_sesi);
				redirect("admin/main", "refresh");
			}else{
				$data['user'] = "0";
				$alert = "Login failed";
				$this->index($alert);
			}
		}
	}
	/* PENGHAPUSAN SEMUA SESI */
	function _dropsesi(){
		$sesi_items = array(
			'sesi_user'		=> '',
			'sesi_thajaran'	=> '',
			'sesi_prodi'	=> '',
			'sesi_status'	=> ''
		);
		$this->session->unset_userdata($sesi_items);	
	}
	/* KELUAR DARI ADMINISTRATOR */
	function logout(){
		$this->_dropsesi();
		redirect("admin/login/","refresh");
	}

	function edit($id = ''){
		if(!$id){
			$id = $this->uri->segment(4);
		}
		$data['title']	= 'Form Update Password';
		$data['alert']	= '';
		$data['dp'] = $this->loginmhs_m->get_one($id);
		$this->load->view('admin/login/elogin_v', $data);
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
		$this->load->view("admin/main",$data);
	}

	function home(){
		$data["main"] = "main/home";
		$this->load->view('main/index',$data);
	}
	function delete(){
		$this->login_m->delete($this->uri->segment(4));
		redirect('admin/login/browse_admin');
	}
}