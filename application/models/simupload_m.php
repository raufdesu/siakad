<?php
	Class Simupload_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_all(){
			$data = array();
			$this->db->select("*");
			$this->db->from("simupload");
			$this->db->order_by("tglupload", "DESC");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all(){
			$data = array();
			return $this->db->count_all("simupload");
		}
		function get_one(){
			$data = array();
			$this->db->select("*");
			$this->db->from("simupload");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row();
			}
		}
		function delete($kode){
			$this->db->where("idsimupload",$kode);
			$this->db->delete("simupload");
		}
		function insert(){
			$data = array(
				"namaupload"	=> $this->input->post("namaupload"),
				"file"	=> $this->input->post('file'),
				"untuk" => $this->input->post("untuk"),
				"tglupload"		=> tgl_ingg($this->input->post("tglupload")),
				"keterangan"	=> $this->input->post("keterangan")
			);
			if($this->input->post('idsimupload')){
				$this->db->where("idsimupload",$this->input->post('idsimupload'));
				$this->db->update("simupload",$data);
			}else{
				$this->db->insert("simupload",$data);
			}
		}
	}
?>