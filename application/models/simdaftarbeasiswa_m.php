<?php
	Class Simdaftarbeasiswa_m extends Model{
		function __construct(){
			parent::model();
		}
		function cekdaftar(){
			$sql = "SELECT * FROM simdaftarbeasiswa WHERE nim = '".$this->input->post('nim')."' AND jenisbeasiswa = '".$this->input->post('jenisbeasiswa')."'";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function count_all($cari = ''){
			$data = array();
			if($cari){
				$this->db->where('nim', $cari);
			}
			$this->db->from('simdaftarbeasiswa');
			return $this->db->count_all_results();
		}
		function get_all($limit1, $limit2, $cari = ''){
			$data = array();
			$sql = "SELECT *,
					(SELECT nama FROM masmahasiswa WHERE nim=daf.nim)nama
					FROM simdaftarbeasiswa daf ";
			if($cari){
				$sql .= " WHERE nim LIKE '%".$cari."%' ";
			}
			$sql .= " LIMIT ".$limit1;
			if($limit2 == true){
				$sql .= " ,".$limit2;
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_one2($id){
			$data = array();
			$sql = "SELECT *,
					(SELECT nama FROM masmahasiswa WHERE nim = daf.nim)namamhs
					FROM simdaftarbeasiswa daf";
			$sql .= " WHERE iddaftarbeasiswa = '".$id."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_one($nim){
			$data = array();
			$sql = "SELECT *,
					(SELECT nama FROM masmahasiswa WHERE nim = daf.nim)namamhs
					FROM simdaftarbeasiswa daf";
			$sql .= " WHERE nim = '".$nim."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function insert(){
			$data = array(
				'nim'			=> $this->session->userdata('sesi_krs_nim'),
				'tgldaftar'		=> $this->input->post('tgldaftar'),
				'jenisbeasiswa'	=> $this->input->post('jenisbeasiswa'),
				'pekerjaanortu'	=> $this->input->post('pekerjaanortu'),
				'penghasilanortu' => $this->input->post('penghasilanortu'),
				'thajaran'		=> $this->input->post('thajaran'),
				'ipk'			=> $this->input->post('ipk'),
				'keterangan'	=> $this->input->post('keterangan'),
				'status'		=> $this->input->post('status'),
			);
			if($this->input->post('iddaftarbeasiswa')){
				$this->db->where('iddaftarbeasiswa', $this->input->post('iddaftarbeasiswa'));
				$this->db->update('simdaftarbeasiswa', $data);
			}else{
				$this->db->insert('simdaftarbeasiswa', $data);
			}
		}
		function get_nim($id){
			$sql = "SELECT nim FROM simdaftarbeasiswa WHERE iddaftarbeasiswa = ".$id;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function delete($id){
			$this->db->where('iddaftarbeasiswa', $id);
			$this->db->delete('simdaftarbeasiswa');
		}
	}
?>