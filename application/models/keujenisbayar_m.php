<?php
	Class Keujenisbayar_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_one($id){
			$data = array();
			$this->db->select("*");
			$this->db->where("idjenisbayar", $id);
			$this->db->from("keujenisbayar");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row();
			}else{
				return false;
			}
		}
		function get_byangkatan($angkatan = ''){
			$data = array();
			$this->db->select("*");
			$this->db->from("keujenisbayar");
			$this->db->where("angkatan", $angkatan);
			$this->db->group_by("jenisbayar");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_distinctall(){
			$data = array();
			$this->db->select("*");
			$this->db->from("keujenisbayar");
			$this->db->group_by("jenisbayar");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_all($limit2 = '', $limit1 = '', $prodi = ''){
			$data = array();
			$this->db->select("*");
			$this->db->from("keujenisbayar");
			if($prodi){
				$this->db->where("kodeprodi", $prodi);
			}
			$this->db->order_by('idjenisbayar', 'DESC');
			if($limit1 || $limit2){
				$this->db->limit($limit1,$limit2);
			}
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all($prodi = ''){
			$data = array();
			$this->db->select("*");
			if($prodi){
				$this->db->where('kodeprodi', $prodi);
			}
			$this->db->from("keujenisbayar");
			return $this->db->count_all_results();
		}
		function insert(){
			$data = array(
				'jenisbayar' => $this->input->post('jenisbayar'),
				'totalbiaya' => $this->input->post('totalbiaya'),
				'kodeprodi'	=> $this->input->post('kodeprodi'),
				'angkatan'	=> $this->input->post('angkatan'),
				'gelombang'	=> $this->input->post('gelombang')
			);
			if($this->input->post('idjenisbayar')){
				$this->db->where('idjenisbayar', $this->input->post('idjenisbayar'));
				$this->db->update('keujenisbayar', $data);	
			}else{
				$this->db->insert('keujenisbayar', $data);	
			}
		}
	}
?>