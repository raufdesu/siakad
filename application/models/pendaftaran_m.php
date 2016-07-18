<?php
	Class Pendaftaran_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_bynodaft($nodaft){
			$this->db->select("*, pendaftaran.biaya AS besarbiaya");
			$this->db->from("pendaftaran");
			$this->db->join("biayadaftar", "pendaftaran.idbiayadaftar = biayadaftar.idbiayadaftar");
			$this->db->where("nodaft", $nodaft);
			return $this->db->get();
		}
		function cek_sudahbayar($nodaft, $namabiaya){
			$this->db->from('pendaftaran');
			$this->db->where('nodaft', $nodaft);
			$this->db->where('idbiayadaftar', $namabiaya);
			return $this->db->count_all_results();
		}
		function get_byangkatan($angkatan = ''){
			$data = array();
			$this->db->select("*");
			$this->db->from("pendaftaran");
			$this->db->where("angkatan", $angkatan);
			//$this->db->group_by("jenisbayar");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		// function get_distinctall(){
			// $data = array();
			// $this->db->select("*");
			// $this->db->from("pendaftaran");
			// $this->db->group_by("jenisbayar");
			// $hasil = $this->db->get();
			// if($hasil->num_rows() > 0){
				// $data = $hasil->result();
			// }
			// $hasil->free_result();
			// return $data;
		// }
		// function get_all($limit2 = '', $limit1 = ''){
			// $data = array();
			// $this->db->select("*");
			// $this->db->from("pendaftaran");
			// $this->db->order_by('idjenisbayar', 'DESC');
			// if($limit1 || $limit2){
				// $this->db->limit($limit1,$limit2);
			// }
			// $hasil = $this->db->get();
			// if($hasil->num_rows() > 0){
				// $data = $hasil->result();
			// }
			// $hasil->free_result();
			// return $data;
		// }
		// function count_all(){
			// $data = array();
			// $this->db->select("*");
			// $this->db->from("pendaftaran");
			// return $this->db->count_all_results();
		// }
		function insert(){
			$status = 'Lunas';
			$data = array(
				'nodaft' => $this->input->post('nodaft'),
				'idbiayadaftar' => $this->input->post('namabiaya'),
				'biaya' => $this->input->post('biaya'),
				'status' => $status
			);
			if($this->input->post('idpendaftaran')){
				$this->db->where('idpendaftaran', $this->input->post('idpendaftaran'));
				$this->db->update('pendaftaran', $data);
			}else{
				$this->db->insert('pendaftaran', $data);	
			}
		}
	}
?>