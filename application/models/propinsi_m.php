<?php
	Class Propinsi_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbpro tp");
			$this->db->group_by("kdprotbpro");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_cari($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbpro tp");
			$this->db->like("nmprotbpro",$cari);
			$this->db->group_by("kdprotbpro");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
	}
?>