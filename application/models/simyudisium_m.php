<?php
Class Simyudisium_m extends Model{
	function __construct(){
		parent::model();
	}
	function get_lastnoyudisium(){
		$sql = "SELECT * FROM simyudisium ORDER BY idyudisium DESC";
		$que = $this->db->query($sql);
		if($que->num_rows() > 0){
			return $que->row_array();
		}
	}
	function _getMaxId(){
		$sql = "SELECT MAX(idyudisium) AS max_id FROM simyudisium";
		$que = $this->db->query($sql);
		if($que->num_rows() > 0){
			return $que->row_array();
		}
	}
	function get_noyudisium(){
		$data = array();
		$sql = "SELECT * FROM simyudisium ORDER BY idyudisium DESC";
		$hasil = $this->db->query($sql);
		if($hasil->num_rows() > 0){
			$data = $hasil->result();
		}
		$hasil->free_result();
		return $data;
	}
	function get_all($limit2='', $limit1='', $cari = ''){
		$data = array();
		$this->db->select("*");
		$this->db->from("simyudisium");
		if($cari)
			$this->db->like('noyudisium', $cari);
		$this->db->order_by('idyudisium', 'DESC');
		$this->db->limit($limit1,$limit2);
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0){
			$data = $hasil->result();
		}
		$hasil->free_result();
		return $data;
	}
	function count_all($cari=''){
		if($cari)
			$this->db->like('noyudisium', $cari);
		$this->db->from('simyudisium');
		return $this->db->count_all_results();
	}
	function get_one($id){
		$sql = "SELECT * FROM simyudisium WHERE idyudisium = ".$id;
		$hasil = $this->db->query($sql);
		return $hasil->row();
	}
	function insert(){
		$data = array(
			'tglyudisium'	=> tgl_ingg($this->input->post('tglyudisium')), //date('Y-m-d'),
			'thajaran'		=> $this->input->post('thajaran'), // $this->session->userdata('sesi_thajaran'),
			'noyudisium'	=> $this->input->post('noyudisium')
		);
		if($this->input->post('idyudisium')){
			$this->db->where('idyudisium', $this->input->post('idyudisium'));
			$this->db->update('simyudisium', $data);
		}else{
			$this->db->insert('simyudisium', $data);
			$d = $this->_getMaxId();
			$id = $d['max_id'];
			$this->insert_detailyudisium($id);
		}
	}
	function insert_detailyudisium($id){
		$data = array(
			'idyudisium'	=> $id,
			'nim'			=> $this->session->userdata('sesi_nimmhs'),
			'judulskripsi'	=> $this->input->post('judulskripsi'),
			'totalsks'		=> $this->input->post('totalsks'),
			'ipk'			=> $this->input->post('ipk'),
			'noijazah'		=> $this->input->post('noijazah'),
			'notranskrip'	=> $this->input->post('notranskrip'),
			'tglijazah'		=> date('Y-m-d')
		);
		$this->db->insert('simdetailyudisium', $data);
	}
}
?>