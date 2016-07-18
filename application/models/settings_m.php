<?php
	Class Settings_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function cek_aktif_krs_akademik(){
			$filename = base_url()."tmp/keaktifan_krs_akademik.txt";
			$fb = fopen($filename, "r");
			$cek = fread($fb, 1);
			return $cek;
		}
		
		function aktifkan_akses_krs_mhs(){
			$filename = "./tmp/keaktifan_krs_akademik.txt";
			$fb = fopen($filename, "w");
			$cek = fwrite($fb, "1");
			return $cek;
		}
		
		function nonaktifkan_akses_krs_mhs(){
			$filename = "./tmp/keaktifan_krs_akademik.txt";
			$fb = fopen($filename, "w");
			$cek = fwrite($fb, "0");
			return $cek;
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
		function get_aktif(){
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