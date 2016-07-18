<?php
Class Profil_m extends Model{
	function __construct(){
		parent::model();
	}	
	function get_one(){
		$data = array();
		$sql = "SELECT *,
				(SELECT npp FROM maspegawai WHERE npp = nppdekan)npp,
				(SELECT nip FROM maspegawai WHERE npp = nppdekan)nip,
				(SELECT nama FROM maspegawai WHERE npp = nppdekan)namadekan
				FROM simprofil ORDER BY idprofil DESC LIMIT 1";
		$que = $this->db->query($sql);
		if($que->num_rows() > 0){
			return $que->row();
		}else{
			return false;
		}
	}
	function insert(){
		$data = array(
			'nama' => $this->input->post('nama'),
			'alamat' => $this->input->post('alamat'),
			'idkabupaten' => $this->input->post('idkabupaten'),
			'notelp' => $this->input->post('notelp'),
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website'),
			'nppdekan' => $this->input->post('npp')
		);
		if($this->input->post('idprofil')){
			$this->db->where('idprofil', $this->input->post('idprofil'));
			$this->db->update('simprofil', $data);
		}else{
			$this->db->insert('simprofil', $data);
		}
	}
}
?>