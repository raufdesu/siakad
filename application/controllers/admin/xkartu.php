<?php
	Class Kartu extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->library("pagination");
			$this->load->helper("file");
			$this->load->helper("html");
			$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_mhs" => "",
				"mn_skripsi" => "",
				"mn_password" => "",
				"mn_khs" => "active",
				"mn_dpa" => "",
				"mn_kuliah" => "",
				"mn_nilai" => "",
				"mn_set" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function krs(){
			$data["main"] = "tKrs_v";
			$this->load->view("main_v",$data);
		}
	}
?>