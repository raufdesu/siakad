<?php
Class Presensimhs_m extends Model{
	function __construct(){
		parent::model();
	}
	
	function insert($nim, $status, $idpresensi){
		$data = array(
			'nim'	=> $nim,
			'status'	=> $status
		);
		$this->db->where('idpresensimhs', $idpresensi);
		$this->db->update('presensimhs', $data);
	}
}
?>