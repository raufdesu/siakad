<?php
	Class Maskegiatan_m extends Model{
		function __construct(){
			parent::model();
		}
		function cekdaftar(){
			$sql = "SELECT * FROM maskegiatan WHERE nim = '".$this->input->post('nim')."' AND jenisdaftar = '".$this->input->post('jenisdaftar')."'";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function count_all($cari = ''){
			$data = array();
			if($cari){
				$this->db->like('namakegiatan', $cari);
			}
			$this->db->from('maskegiatan');
			return $this->db->count_all_results();
		}
		function get_all($limit1, $limit2, $cari = ''){
			$data = array();
			$sql = "SELECT *,
					(SELECT nama FROM maspegawai WHERE npp = ttd1) namadosen1,
					(SELECT nama FROM maspegawai WHERE npp = ttd2) namadosen2
					FROM maskegiatan keg";
			if($cari){
				$sql .= " WHERE namakegiatan LIKE '%".$cari."%' ";
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
					(SELECT nama FROM maspegawai WHERE npp = keg.ttd1)nmpembimbing1,
					(SELECT nama FROM maspegawai WHERE npp = keg.ttd2)nmpembimbing2
					FROM maskegiatan keg";
			$sql .= " WHERE idkegiatan = '".$id."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_one($nim){
			$data = array();
			$sql = "SELECT iddaftarskripsi, nim, jenisdaftar, tgldaftar, statusdaftar,
					judulskripsi,thajaran,nosk,tglsk,tglakhir,
					(SELECT nama FROM masmahasiswa WHERE nim = daf.nim)namamhs,
					(SELECT nama FROM maspegawai WHERE npp = daf.pembimbing1)nmpembimbing1,
					(SELECT nama FROM maspegawai WHERE npp = daf.pembimbing2)nmpembimbing2
					FROM maskegiatan daf";
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
				'namakegiatan'	=> $this->input->post('namakegiatan'),
				'thajaran'		=> $this->input->post('thajaran'),
				'tglmulai'		=> tgl_ingg($this->input->post('tglmulai')),
				'tglselesai'	=> tgl_ingg($this->input->post('tglselesai')),
				'tingkat'		=> $this->input->post('tingkat'),
				'ttd1'			=> $this->input->post('npp1'),
				'ttd2'			=> $this->input->post('npp2')
			);
			if($this->input->post('idkegiatan')){
				$this->db->where('idkegiatan', $this->input->post('idkegiatan'));
				$this->db->update('maskegiatan', $data);
			}else{
				$this->db->insert('maskegiatan', $data);
			}
		}
		function delete($id){
			$this->db->where('idkegiatan', $id);
			$this->db->delete('maskegiatan');
		}
	}
?>