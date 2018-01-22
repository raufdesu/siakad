<?php
	Class Paket_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_all($limit1='', $limit2='', $cari = '', $prodi = '', $angkatan = '', $kelas = '', $thajaran = ''){
			$data = array();
			$sql = 'SELECT *,(SELECT namaprodi FROM simprodi WHERE kodeprodi = k.kodeprodi)namaprodi FROM paket p
					INNER JOIN detpaket d ON p.idpaket = d.idpaket INNER JOIN matkul k ON d.kodemk = k.kodemk WHERE 1 ';
			if($cari){
				$sql .= ' AND (k.namamk LIKE "%'.$cari.'%" OR k.kodemk LIKE "%'.$cari.'%")';
			}
			if($prodi){
				$sql .= ' AND p.kodeprodi = "'.$prodi.'" ';
			}
			if($angkatan){
				$sql .= ' AND p.angkatan = "'.$angkatan.'" ';
			}
			if($kelas){
				$sql .= ' AND p.kelas = "'.$kelas.'" ';
			}
			if($thajaran){
				$sql .= ' AND p.thajaran = "'.$thajaran.'" ';
			}
			$sql .= 'group by k.kodemk ORDER BY k.kodemk DESC ';
			if($limit1 || $limit2){
				$sql .= " LIMIT ".$limit1;
				if($limit2 == true){
					$sql .= " ,".$limit2;
				}
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_thajaran(){
			$data = array();
			$sql = 'SELECT DISTINCT(thajaran) FROM paket WHERE 1 ';
			$sql .= ' ORDER BY thajaran DESC ';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all($cari = '', $prodi = '', $angkatan = '', $kelas = '', $thajaran = ''){
			$data = array();
			$sql = 'SELECT * FROM paket p INNER JOIN detpaket d ON p.idpaket = d.idpaket
					INNER JOIN matkul k ON d.kodemk = k.kodemk WHERE 1 ';
			if($cari){
				$sql .= ' AND (k.namamk LIKE "%'.$cari.'%" OR k.kodemk LIKE "%'.$cari.'%")';
			}
			if($prodi){
				$sql .= ' AND k.kodeprodi = "'.$prodi.'" ';
			}
			if($angkatan){
				$sql .= ' AND p.angkatan = "'.$angkatan.'" ';
			}
			if($kelas){
				$sql .= ' AND p.kelas = "'.$kelas.'" ';
			}
			if($thajaran){
				$sql .= ' AND p.thajaran = "'.$thajaran.'" ';
			}
			return $this->db->query($sql)->num_rows();
		}
		function get_one($nim){
			$sql = "SELECT *, kodeprodi kdprod,
					(SELECT LEFT(nim,2) FROM simprodi WHERE kodeprodi=mhs.kodeprodi) pref_prodi,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi
					FROM paket mhs ";
			$sql .= " WHERE nim ='".$nim."' ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		function jumpaket($idpaket){
			$this->db->from('detpaket');
			$this->db->where('idpaket', $idpaket);
			return $this->db->count_all_results();
		}
		function deletedetail($idpaket, $iddetpaket){
			$jumdetpaket = $this->jumpaket($idpaket);
			if($jumdetpaket < 2){
				$this->db->where('idpaket', $idpaket);
				$this->db->delete('paket');
			}
			$this->db->where('iddetpaket', $iddetpaket);
			$this->db->delete('detpaket');
		}
		function get_idpaket($kodeprodi, $angkatan, $thajaran, $kelas){
			$this->db->select('idpaket');
			$this->db->from('paket');
			$this->db->where('kodeprodi', $kodeprodi);
			$this->db->where('angkatan', $angkatan);
			$this->db->where('thajaran', $thajaran);
			$this->db->where('kelas', $kelas);
			$hasil = $this->db->get();
			if($hasil->num_rows()){
				return $hasil->row()->idpaket;
			}else{
				return false;
			}
		}
		/* SEPERTINYA THAJARAN DIMASUKKAN KE TABEL PAKET SAJA */
		function insert(){
			$cekpaket = $this->get_idpaket($this->input->post("kodeprodi"), $this->input->post("angkatan"), $this->input->post("thajaran"), $this->input->post("kelas"));
			if(!$cekpaket){
				$data1 = array(
					'kodeprodi' => $this->input->post("kodeprodi"),
					'angkatan'	=> $this->input->post("angkatan"),
					'thajaran'	=> $this->input->post("thajaran"),
					'kelas'		=> $this->input->post("kelas"),
					'tglinput'	=> date('Y-m-d H:i:s')
				);
				/* $this->db->trans_start(); */
				$this->db->insert('paket', $data1);
				/* $this->db->trans_complete(); */
			}
			$idpaket = $this->get_idpaket($this->input->post("kodeprodi"), $this->input->post("angkatan"), $this->input->post("thajaran"), $this->input->post("kelas"));
			$data2 = array(
				'idpaket'	=> $idpaket,
				'kodemk'	=> $this->input->post('kodemk'),
				'namamk'	=> $this->input->post('namamk'),
				'tglinput'	=> date('Y-m-d H:i:s')
			);
			$this->db->insert('detpaket', $data2);
		}
		function _insert_simaktifsemester($nim){
			$th = $this->_thajaran_active();
			$thajaran = $th['thajaran'];
			$data = array(
				'nim' => $nim,
				'thajaran' => $thajaran,
				'status' => 'Non Aktif',
				'tglaktifkan' => date('Y-m-d H:i:s')
			);
			$this->db->insert('simaktifsemester', $data);
		}
	}
?>