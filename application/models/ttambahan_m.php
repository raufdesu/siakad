<?php
	Class Ttambahan_m extends Model{
		function __construct(){
			parent::model();
		}
		function select(){
			$data = array();
			$this->db->select("thkurikulum");
			$this->db->from("ttambahan");
			$this->db->group_by('thkurikulum');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function cekada($thkurikulum){
			$data = array();
			$this->db->select("*");
			$this->db->where("thkurikulum", $thkurikulum);
			$this->db->from("ttambahan");
			return $this->db->count_all_results();
		}
		function delete($thkurikulum){
			$this->db->where('thkurikulum', $thkurikulum);
			$this->db->delete('ttambahan');
		}
		function insert(){
			$data = array(
				'thkurikulum' => $this->input->post('thkurikulum')
			);
			$this->db->insert('ttambahan', $data);
		}
	}
?>