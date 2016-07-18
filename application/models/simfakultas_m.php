<?php
	Class Simfakultas_m extends Model{
		function __construct(){
			parent::model();
		}
		function cek_nimfakultas($kodefakultas, $nim){
			$sql = 'SELECT kodefakultas FROM masmahasiswa WHERE nim = "'.$nim.'"';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				if(trim($hasil->row()->kodefakultas) == trim($kodefakultas)){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		function get_namafakultasbynim($nim){
			$sql = "SELECT namafakultas FROM simfakultas LEFT JOIN masmahasiswa ON simfakultas.kodefakultas = masmahasiswa.kodefakultas WHERE masmahasiswa.nim = '".$nim."'";
			$que = $this->db->query($sql);
			if($que->num_rows > 0){
				return $que->row()->namafakultas;
			}else{
				return 'Keseluruhan';
			}
		}
		function get_namabykode($kodefakultas){
			$sql = "SELECT namafakultas FROM simfakultas WHERE kodefakultas = '".$kodefakultas."'";
			$que = $this->db->query($sql);
			if($que->num_rows > 0){
				return $que->row()->namafakultas;
			}else{
				return '';
			}
		}
		function get_namafakultas(){
			$data = array();
			$sql = "SELECT * FROM simfakultas GROUP BY namafakultas";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				$data = $que->result();
			}
			$que->free_result();
			return $data;
		}
		function get_all($limit1='', $limit2=''){
			$data = array();
			$this->db->select('*');
			$this->db->from('simfakultas');
			if($limit1 || $limit2)
				$this->db->limit($limit2,$limit1);
			
			$this->db->order_by('kodefakultas','DESC');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function detail($kodefakultas){
			$data = array();
			$this->db->select("*,(SELECT nama FROM maspegawai WHERE simfakultas.npp=maspegawai.npp) as kafakultas");
			$this->db->from("simfakultas");
			$this->db->where("kodefakultas",$kodefakultas);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all(){
			$data = array();
			$this->db->select("*");
			$this->db->from("simfakultas");
			return $this->db->count_all_results();
		}
		function insert(){
			$data = array(
				"kodefakultas" => $this->input->post("kodefakultas"),
				"namafakultas" => $this->input->post("namafakultas"),
				"ijin" => $this->input->post("ijin"),
				"status" => $this->input->post("status"),
				"npp" => $this->input->post("npp")
			);
			if($this->input->post('kodefakultas2')){
				$this->db->where("kodefakultas",$this->input->post('kodefakultas2'));
				$this->db->update("simfakultas",$data);
			}else{
				$this->db->insert("simfakultas",$data);
			}
		}
		/*function get_one($kodefakultas){
			$sql = "SELECT *,(SELECT nama FROM maspegawai WHERE npp = simfakultas.npp)kafakultas FROM simfakultas WHERE kodefakultas = '".$kodefakultas."'";
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}*/
		function delete($kodefakultas){
			$this->db->where("kodefakultas",$kodefakultas);
			$this->db->delete("simfakultas");
		}
	}
?>