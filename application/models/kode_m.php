<?php
	Class Kode_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select_tbkod1(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod1");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod2(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod2");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod3(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod3");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod5(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod5");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod6(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod6");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod30(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod30");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod29(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod29");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod10(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod10");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod11(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod11");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod14(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod14");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod15(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod15");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod28(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod28");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod7(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod7");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_tbkod4(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbkod4");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
	}
?>