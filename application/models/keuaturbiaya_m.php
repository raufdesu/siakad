<?php
	Class Keuaturbiaya_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_lastangkatan(){
			$this->db->select('angkatan');
			$this->db->from('keuaturbiaya');
			$this->db->where('status', 'Selesai');
			$this->db->order_by('idaturbiaya', 'DESC');
			$this->db->limit(1);
			$hasil = $this->db->get();
			if($hasil->num_rows()){
				return $hasil->row()->angkatan;
			}else{
				return false;
			}
		}
		function update_status($idaturbiaya, $status_awal){
			if($status_awal == 'Pending'){
				$status = 'Selesai';
			}else{
				$select = 'Pending';
			}
			$data = array(
				'status' => $status
			);
			$this->db->where('idaturbiaya', $idaturbiaya);
			$this->db->update('keuaturbiaya', $data);
		}
		function get_one($id){
			$data = array();
			$this->db->select("*");
			$this->db->where("idaturbiaya", $id);
			$this->db->from("keuaturbiaya");
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
			$this->db->from("keuaturbiaya");
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
			$this->db->from("keuaturbiaya");
			$this->db->group_by("namabiaya");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_jenis(){
			$data = array();
			$this->db->select("jenis");
			$this->db->from("keuaturbiaya");
			$this->db->group_by("jenis");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_angkatan(){
			$data = array();
			$this->db->select('angkatan');
			$this->db->from('keuaturbiaya');
			$this->db->group_by('angkatan');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		/* function get_all($limit2 = '', $limit1 = '', $prodi = '', $kategori = ''){ */
		function get_all($limit2 = '', $limit1 = '', $prodi = '', $angkatan = ''){
			$data = array();
			$this->db->select("*");
			$this->db->from("keuaturbiaya");
			if($prodi){
				$this->db->where("kodeprodi", $prodi);
			}
			if($angkatan){
				$this->db->where("angkatan", $angkatan);
			}
			$this->db->order_by('idaturbiaya', 'DESC');
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
		/* function count_all($prodi = '', $kategori = ''){ */
		function count_all($prodi = '', $angkatan = ''){
			$data = array();
			$this->db->select("*");
			if($prodi){
				$this->db->where('kodeprodi', $prodi);
			}
			if($angkatan){
				$this->db->where("angkatan", $angkatan);
			}
			$this->db->from("keuaturbiaya");
			return $this->db->count_all_results();
		}
		function insert(){
			if($this->input->post('kategori')){
				$thajaran = $this->input->post('thajaran');
			}else{
				$thajaran = '';
			}
			$data = array(
				'namabiaya' => $this->input->post('namabiaya'),
				'kodeprodi'	=> $this->input->post('kodeprodi'),
				'angkatan'	=> $this->input->post('angkatan'),
				'gelombang'	=> $this->input->post('gelombang'),
				'jenis'	=> $this->input->post('jenis'),
				'jumbiaya' => angka_utuh($this->input->post('jumbiaya')),
				'kategori' => $this->input->post('kategori'),
				'thajaran' => $thajaran
			);
			if($this->input->post('idaturbiaya')){
				$this->db->where('idaturbiaya', $this->input->post('idaturbiaya'));
				$this->db->update('keuaturbiaya', $data);
			}else{
				$this->db->insert('keuaturbiaya', $data);	
			}
		}
		function delete($idaturbiaya){
			$this->db->where('idaturbiaya', $idaturbiaya);
			$this->db->delete('keuaturbiaya');
			$hapusjuga = 1;
			
			if($hapusjuga){
				/*
				$this->db->where('namabiaya', $atur['namabiaya']);
				$this->db->where('jenis', $atur['jenis']);
				$this->db->where('thajaran', $atur['thajaran']);
				$this->db->where_in('angkatan', $array_angkatan);
				$this->db->delete('keubiaya');
				*/
			}
		}
	}
?>