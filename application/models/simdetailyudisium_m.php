<?php
Class Simdetailyudisium_m extends Model{
	function __construct(){
		parent::model();
	}
	// function get_all($limit2='', $limit1=''){
		// $data = array();
		// $this->db->select("*");
		// $this->db->from("simdetailyudisium");
		// if($this->session->userdata('cari_maspegawai'))
			// $this->db->like('nama',$this->session->userdata('cari_maspegawai'));
		// $this->db->limit($limit1,$limit2);
		// $hasil = $this->db->get();
		// if($hasil->num_rows() > 0){
			// $data = $hasil->result();
		// }
		// $hasil->free_result();
		// return $data;
	// }
	// function count_all(){
		// $this->db->get('simdetailyudisium');
		// return $this->db->count_all_results();
	// }
	function cek($nim){
		$sql = "SELECT * FROM simdetailyudisium WHERE nim = '".$nim."'";
		$que = $this->db->query($sql);
		return $que->num_rows();
	}
	function get_bynim($nim){
		$sql = "SELECT * FROM simdetailyudisium WHERE nim = '".$nim."'";
		$hasil = $this->db->query($sql);
		if($hasil->num_rows() > 0){
			return $hasil->row();
		}
	}
	function insert(){
		$data = array(
			'idyudisium'	=> $this->input->post('idyudisium'),
			'nim'			=> $this->session->userdata('sesi_nimmhs'),
			'judulskripsi'	=> $this->input->post('judulskripsi'),
			'totalsks'		=> $this->input->post('totalsks'),
			'ipk'			=> $this->input->post('ipk'),
			'noijazah'		=> $this->input->post('noijazah'),
			'notranskrip'	=> $this->input->post('notranskrip'),
			'tglijazah'		=> tgl_ingg($this->input->post('tglijazah'))
		);
		if($this->input->post('iddetailyudisium')){
			$this->db->where('iddetailyudisium', $this->input->post('iddetailyudisium'));
			$this->db->update('simdetailyudisium', $data);
		}else{
			$this->db->insert('simdetailyudisium', $data);
		}
	}
}
?>