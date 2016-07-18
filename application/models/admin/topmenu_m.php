<?php
	Class Topmenu_m extends Model{
		function __construct(){
			parent::model();
		}	
		function select(){
			$data = array();
			$hasil = $this->db->get('topmenu');
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function activation($alamat){
			$alamat = 'maspegawai';
			$data = array(
				'active'=>'active'
			);
			$this->db->where("alamat",$alamat);
			$this->db->update("topmenu",$data);
		}
	}
?>