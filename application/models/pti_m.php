<?php
	Class Pti_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit1, $limit2){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbpti");
			$this->db->limit($limit2, $limit1);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_cari($limit1, $limit2, $nmpti){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbpti");
			$this->db->like("nmptitbpti",$nmpti);
			$this->db->limit($limit2, $limit1);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
	}
?>