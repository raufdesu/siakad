<?php
	Class About extends Controller{
		function __construct(){
			parent::Controller();
		}
		function index(){
			$data = 'About Mahasiswa';
			$this->load->view("mhs/tabout_v",$data);
		}
	}
?>