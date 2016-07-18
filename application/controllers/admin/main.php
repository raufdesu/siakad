<?php
Class Main extends Controller {

	function Main()
	{
		parent::Controller();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			//if(($this->session->userdata("sesi_user")==false)&&(!$this->session->userdata("sesi_status")=="2")){
			if(($this->session->userdata("sesi_status") <> "1") && ($this->session->userdata("sesi_user")==false)){
				redirect(base_url()."index.php/admin/login/");
			}

			$this->load->helper("globals");
			$this->load->library('form_validation');
			$this->load->model('profil_m');
			$this->load->model("admin/topmenu_m");
			$sesmain_mn = array(
				"mn_homepage" => "active",
				"mn_kurmatkul" => "",
				"mn_prodi" => "",
				"mn_dosen" => "",
				"mn_biodata" => "",
			);
			$this->session->set_userdata($sesmain_mn);
	}

	function index()
	{
		$data["main"] = "admin/home_v";
		/*$data['pt'] = $this->profil_m->get_one(); */
		$data["menu"] = $this->topmenu_m->select();
		$this->load->view("admin/main_v",$data);
	}
	function home()
	{
		$data["menu"] = $this->topmenu_m->select();
		$this->load->view("admin/home_v",$data);
	}
}