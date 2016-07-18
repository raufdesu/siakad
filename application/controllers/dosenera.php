<?php
class Dosenera extends Controller {
	function __construct(){
		parent::Controller();
	}
	function index(){
		redirect(base_url().'index.php/admin/login', 'refresh');
	}
}