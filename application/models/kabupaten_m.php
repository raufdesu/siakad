<?php
	Class Kabupaten_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function get_all($idpro){
			$data = array();
			$sql = "SELECT * FROM tkabupaten WHERE LEFT(idkabupaten, 2) = '".$idpro."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
	}
?>