<?php
	Class Simruang_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function getAll($limit2='',$limit1=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("simruang");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		/* YG DIUPDATE */
		function get_all($limit2='',$limit1=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("simruang");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all(){
			$this->db->select("*");
			$this->db->from("simruang");
			return $this->db->count_all_results();
		}
		/* SELESAI YANG DIUPDATE*/
		function select_simruang_dpa(){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_simruang ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			$this->db->join("tbkod3 t3","ad.statuskerja = t3.kdkodtbkod");
			$this->db->join("tbkod15 t15","ad.statusaktif = t15.kdkodtbkod");
			$this->db->where("t3.kdkodtbkod","A");
			$this->db->where("t15.kdkodtbkod","A");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_cari($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab");
			$this->db->from("akd_simruang ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			$this->db->join("tbkod2 t2","ad.jabakad = t2.kdkodtbkod");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($id){
			$data = array();
			$this->db->select('*');
			$this->db->from("simruang");
			$this->db->where("id_ruang",$id);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function delete($id){
			$this->db->where("id_ruang", $id);
			$this->db->delete("simruang");
		}
		function insert(){
			$data = array(
				"nama" => $this->input->post("nama"),
				"lantai" => $this->input->post("lantai"),
				"nomor" => $this->input->post("nomor"),
				"kapasitas" => $this->input->post("kapasitas"),
				"jenisruang" => $this->input->post("jenisruang")
			);
			if($this->input->post('id_ruang')){
				$this->db->where("id_ruang",$this->input->post("id_ruang"));
				$this->db->update("simruang",$data);
			}else{
				$this->db->insert("simruang",$data);
			}
		}
	}
?>