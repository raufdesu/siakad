<?php
	Class Settings_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("settings");
			$this->db->order_by("id_settings","DESC");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail(){
			$data = array();
			$this->db->select("*");
			$this->db->from("settings");
			$this->db->where("aktif",1);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}

		function insert(){
			$this->non_aktif();
			$data = array(
				"thn_akad" => $this->input->post("thn_akad"),
				"semester" => $this->input->post("semester"),
				"aktif" => $this->input->post("aktif"),
			);
			$this->db->insert("settings",$data);
		}
		
		function non_aktif(){
			$data = array(
				"aktif" => ""
			);
			$this->db->update("settings",$data);
		}

		function aktifkan($id){
			$this->settings_m->non_aktif();
			$data = array(
				"aktif" => 1
			);
			$this->db->where("id_settings",$id);
			$this->db->update("settings",$data);
		}
	}
?>