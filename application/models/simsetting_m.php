<?php
	Class Simsetting_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_allactive(){
			$this->db->from('simsetting');
			$this->db->where('aktif', 'Aktif');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row();
			}else{
				return false;
			}
		}
		function get_active(){
			$this->db->from('simsetting');
			$this->db->where('aktif', 'Aktif');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row()->thajaran;
			}else{
				return false;
			}
		}
		function select_active(){
			$data = array();
			$this->db->from('simsetting');
			$this->db->where('aktif', 'Aktif');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function select($limit1='', $limit2=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("simsetting");
			if($limit1 && $limit2){
				$this->db->limit($limit2,$limit1);
			}
			$this->db->order_by('thajaran','DESC');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function detail($id){
			$data = array();
			$this->db->select("*");
			$this->db->where("thajaran",$id);
			$this->db->from("simsetting");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function cekada($id){
			$data = array();
			$this->db->select("*");
			$this->db->from("simsetting");
			$this->db->where('thajaran',$id);
			return $this->db->count_all_results();		
		}
		function count_all(){
			$data = array();
			$this->db->select("*");
			$this->db->from("simsetting");
			return $this->db->count_all_results();
		}
		function insert(){
			$data = array(
				"thajaran"	=> $this->input->post("thajaran"),
				"aktif"		=> $this->input->post("aktif"),
				"tglkrsawal"	=> tgl_ingg($this->input->post("tglkrsawal")),
				"tglkrsakhir"	=> tgl_ingg($this->input->post("tglkrsakhir")),
				"tglperubahankrsawal"	=> tgl_ingg($this->input->post("tglperubahankrsawal")),
				"tglperubahankrsakhir"	=> tgl_ingg($this->input->post("tglperubahankrsakhir")),
				"tglkspawal"	=> tgl_ingg($this->input->post("tglkspawal")),
				"tglkspakhir"	=> tgl_ingg($this->input->post("tglkspakhir"))
			);
			$this->db->insert("simsetting",$data);
		}
		function update(){
			$data = array(
				"thajaran"	=> $this->input->post("thajaran"),
				/*"aktif"		=> $this->input->post("aktif"),*/
				"tglkrsawal"	=> tgl_ingg($this->input->post("tglkrsawal")),
				"tglkrsakhir"	=> tgl_ingg($this->input->post("tglkrsakhir")),
				"tglperubahankrsawal"	=> tgl_ingg($this->input->post("tglperubahankrsawal")),
				"tglperubahankrsakhir"	=> tgl_ingg($this->input->post("tglperubahankrsakhir")),
				"tglkspawal"	=> tgl_ingg($this->input->post("tglkspawal")),
				"tglkspakhir"	=> tgl_ingg($this->input->post("tglkspakhir"))
			);
			$this->db->where("thajaran",$this->input->post("thajaran"));
			$this->db->update("simsetting",$data);
		}
		/*------------------- AKTIF KRS DAN NON AKTIF KRS -------------------*/
		function nonactive_all(){
			$this->db->update('simsetting', array('aktif'=>'Tidak Aktif'));
		}
		function nactive_one($thajaran = ''){
			$this->nonactive_all();
			$this->db->where('thajaran',$thajaran);
			$this->db->update('simsetting', array('aktif'=>'Aktif'));
		}
		/*function nonactive_one($thajaran = ''){
			$this->db->where('thajaran',$thajaran);
			$this->db->update('simsetting', array('aktif'=>'Tidak Aktif'));
		}*/
		function delete($thajaran){
			$this->db->where("thajaran",$thajaran);
			$this->db->delete("simsetting");
		}
	}
?>