<?php
	Class Utility extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			$this->load->view('dosen/utility/tpanduan_v');
		}
	}
?>