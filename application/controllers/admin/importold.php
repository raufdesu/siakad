<?php
	Class Importold extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("importold_m","ttambahan_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			$this->import_old();
		}
		function import_old(){
			$data['title'] = 'Export Data KRS dari SIMAK lama ke SIMAK baru';
			$data['cek_krsmhs'] = $this->db->count_all('krsmhs');
			$data['cek_mastermk'] = $this->db->count_all('mastermk');
			$this->load->view("admin/timportold_v",$data);
		}
		function krs(){
			//$this->importold_m->import();
			$this->importold_m->import2();
			// $this->importold_m->import_krs();
			$data['title'] = 'Konfirmasi Import KRS';
			$this->load->view('admin/suksesimport_simak_v', $data);
		}
		function matakuliah(){
			$this->importold_m->import_matakuliah();
			$data['title'] = 'Konfirmasi Import Matakuliah';
			$this->load->view('admin/suksesimport_simak_v', $data);
		}
	}
?>