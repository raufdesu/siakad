<?php
	Class Simdosenwali_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_dosen($limit2, $limit1='', $prodi='', $cari=''){
			$data = array();
			$this->db->select('*');
			$this->db->from('maspegawai');
			if($prodi){
				$this->db->where('kodeprodi', $prodi);
			}
			if($cari){
				$this->db->like('nama', $cari);
			}
			/* $this->db->order_by('tglinput', 'DESC'); */
			$this->db->limit($limit1, $limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_dosen($prodi='', $cari=''){
			$this->db->select('*');
			$this->db->from('maspegawai');
			if($prodi){
				$this->db->where('kodeprodi', $prodi);
			}
			if($cari){
				$this->db->like('nama', $cari);
			}
			return $this->db->count_all_results();			
		}
		function select($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("simdosenwali");
			$this->db->order_by("id_simdosenwali","DESC");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_namakaprodi($nim, $thajaran){
			$sql = 'SELECT * FROM simdosenwali INNER JOIN maspegawai ON simdosenwali.npp=maspegawai.npp WHERE nim = "'.$nim.'" AND thajaran = "'.$thajaran.'"';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_mhsnodpa($limit1='', $limit2='', $prodi='', $angkatan='', $cari=''){
			$sql = "SELECT nim, nama, angkatan FROM masmahasiswa
					WHERE nim NOT IN (SELECT nim FROM simdosenwali) ";
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."' ";
			}
			if($angkatan){
				$sql .= " AND angkatan = '".$angkatan."' ";
			}
			if($cari){
				$sql .= " AND nama LIKE '%".$cari."%'";
			}
			$sql .= " ORDER BY angkatan LIMIT ".$limit1;
			if($limit2 == true){
				$sql .= " ,".$limit2;
			}
			return $this->db->query($sql);
		}
		/* get_bydosen($data['no'], $perpage, $npp, $data['angkatan'], $cari); */
		function get_bydosen($limit1='', $limit2='', $npp, $angkatan='', $cari=''){
			$sql = "SELECT masmahasiswa.nim, nama AS namamhs, angkatan, thajaran, npp
					FROM simdosenwali INNER JOIN masmahasiswa 
					ON simdosenwali.nim = masmahasiswa.nim WHERE npp = '".$npp."' ";
			if($angkatan){
				$sql .= " AND angkatan LIKE '%".$angkatan."%'";
			}
			if($cari){
				$sql .= " AND nama LIKE '%".$cari."%'";
			}
			$sql .= " GROUP BY nim LIMIT ".$limit1;
			if($limit2 == true){
				$sql .= " ,".$limit2;
			}
			return $this->db->query($sql);
		}
		function count_bydosen($npp, $angkatan, $cari = ''){
			$sql = "SELECT * FROM simdosenwali INNER JOIN masmahasiswa ON simdosenwali.nim = masmahasiswa.nim WHERE npp = '".$npp."' ";
			$sql .= " AND angkatan = '".$angkatan."' ";
			if($cari){
				$sql .= " AND nama LIKE '%".$cari."%' ";
			}
			$sql .= " GROUP BY simdosenwali.nim ";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function get_last_nppdpa($nim){
			$this->db->select('npp');
			$this->db->from('simdosenwali');
			$this->db->where('nim', $nim);
			$this->db->order_by('thajaran', 'DESC');
			$hasil = $this->db->get();
			if($hasil){
				return $hasil->row()->npp;
			}else{
				return false;
			}
		}
		function get_namadpa($nim, $thajaran = ''){
			$this->db->select("*");
			$this->db->from("simdosenwali");
			$this->db->join("maspegawai","simdosenwali.npp = maspegawai.npp");
			if($thajaran):
			$this->db->where("simdosenwali.thajaran", $thajaran);
			endif;
			$this->db->where("simdosenwali.nim", $nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		function insert_fromprodi($nim){
			$data = array(
				'nim'	=> $nim,
				'thajaran' => $this->session->userdata('sesi_thajaran'),
				'npp'	=> $this->input->post('npp'),
				'tglinput' => date('Y-m-d H:i:s')
			);
			$this->db->insert('simdosenwali', $data);
		}
		/* UNTUK ADMIN */
		function cek_dosenwali($nim, $thajaran = ''){
			$this->db->where('nim', $nim);
			if($thajaran){
				$this->db->where('thajaran', $thajaran);
			}
			$this->db->from('simdosenwali');
			return $this->db->count_all_results();
		}
		function insert_dpa($nim, $thajaran, $dpa){
			$data = array(
				'nim'		=> $nim,
				'thajaran'	=> $thajaran,
				'npp'		=> $dpa,
			);
			$cekada = $this->cek_dosenwali($nim, $thajaran);
			if(!$cekada){
				$this->db->insert("simdosenwali",$data);
			}
		}
		function insert_dosenwali($nim, $thajaran){
			$data = array(
				"nim" => $nim,
				"thajaran" => $thajaran,
				"npp" => $this->input->post("id_dpa"),
			);
			$cekada = $this->cek_dosenwali($nim, $thajaran);
			if(!$cekada){
				$this->db->insert("simdosenwali",$data);
			}
		}
		function insert(){
			$data = array(
				"nim" => $this->session->userdata('sesi_user_mhs'),
				"thajaran" => $this->session->userdata('sesi_thajaran'),
				"npp" => $this->input->post("id_dpa"),
			);
			$this->db->insert("simdosenwali",$data);
		}
		function delete($nim, $thajaran){
			$this->db->where('nim', $nim);
			$this->db->where('thajaran', $thajaran);
			$this->db->delete('simdosenwali');
		}
	}
?>