<?php
	Class Keusetoran_m extends Model{
		function __construct(){
			parent::model();
		}
		function insert(){
			$idbiaya = $this->input->post('idbiaya');
			$data = array(
				'idbiaya'	=> $idbiaya,
				'jumsetoran'	=> angka_utuh($this->input->post('jumsetoran')),
				'petugas'	=> $this->input->post('petugas'),
				'tglsetor'	=> tgl_ingg($this->input->post('tglsetor')).' '.date('H:i:s'),
				'keterangan'=> $this->input->post('keterangan')
			);
			$this->db->insert('keusetoran', $data);
		}
		function status_semester($nim, $thajaran, $status=''){
			$data = array(
				'status' => $status,
				'tglaktifkan' => date('Y-m-d H:i:s')
			);
			$this->db->where('nim', $nim);
			$this->db->where('thajaran', $thajaran);
			$this->db->update('simaktifsemester', $data);
		}
		function tentukan_status($idbiaya, $nim='', $thajaran=''){
			$tagihan = $this->get_tagihan($idbiaya);
			$totalsetoran = $this->get_totalsetoran($idbiaya);
			if($tagihan == $totalsetoran){
				$data = array(
					'status' => 'Lunas'
				);
				$this->db->where('idbiaya', $idbiaya);
				$this->db->update('keubiaya', $data);

				$namabiaya = strtoupper($this->namabiaya_byidbiaya($idbiaya));
				if(preg_match("/\bSPP SEMESTER\b/i", $namabiaya)){
					$this->status_semester($nim, $thajaran, 'Aktif');
				}
			}
		}
		function namabiaya_byidbiaya($idbiaya){
			$sql	= 'SELECT namabiaya FROM keubiaya WHERE idbiaya = '.$idbiaya;
			$hasil	= $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->namabiaya;
			}else{
				return false;
			}
		}
		function get_tagihan($idbiaya){
			$sql	= 'SELECT jumbiaya FROM keubiaya WHERE idbiaya = '.$idbiaya;
			$hasil	= $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->jumbiaya;
			}else{
				return false;
			}
		}
		function get_totalsetoran($idbiaya){
			$sql	= 'SELECT SUM(jumsetoran) totalsetoran FROM keusetoran WHERE idbiaya = '.$idbiaya;
			$hasil	= $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->totalsetoran;
			}else{
				return false;
			}
		}
		function delete($id){
			$this->db->where('idsetoran', $id);
			$this->db->delete('keusetoran');
		}
		function get_lastidsetoran($idbiaya=''){
			$sql = 'SELECT * FROM keusetoran ';
			if($idbiaya){
				$sql .= ' WHERE idbiaya = '.$idbiaya;
			}
			$sql .= ' ORDER BY idsetoran DESC LIMIT 1';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->idsetoran;
			}else{
				return false;
			}
		}
		function delete_last($idbiaya, $nim='', $thajaran=''){
			$last_idsetoran = $this->get_lastidsetoran($idbiaya);
			$sql = 'DELETE FROM keusetoran WHERE idsetoran = '.$last_idsetoran;
			$this->db->query($sql);

			$data = array(
				'status' => 'Belum Lunas'
			);
			$this->db->where('idbiaya', $idbiaya);
			$this->db->update('keubiaya', $data);

			$namabiaya = strtoupper($this->namabiaya_byidbiaya($idbiaya));
			if(preg_match("/\bSPP SEMESTER\b/i", $namabiaya)){
				$this->status_semester($nim, $thajaran, 'Non Aktif');
			}
		}
	}
?>