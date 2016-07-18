<?php
	Class Simmatrikulasi_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_nolimit($nim){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$data = array();
			$sql = "SELECT *,
					nilai AS nilaihuruf,
					(SELECT namamk FROM simkurikulum WHERE kodemk = simmatrikulasi.kodemk AND kodeprodi = '".$kodeprodi."')namamk,
					(SELECT sks FROM simkurikulum WHERE kodemk = simmatrikulasi.kodemk AND kodeprodi = '".$kodeprodi."')jumlahsks
					FROM simmatrikulasi WHERE nim = '".$nim."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function cek_ada($nim, $kodemk){
			$data = array();
			$this->db->where('nim', $nim);
			$this->db->where('kodemk', $kodemk);
			$this->db->from('simmatrikulasi');
			return $this->db->count_all_results();
		}
		// function count_all($nim=''){
			// $data = array();
			// if($nim){
				// $this->db->where('nim', $nim);
			// }
			// $this->db->from('simmatrikulasi');
			// $this->db->group_by('nim','DESC');
			// return $this->db->count_all_results();
		// }
		function get_namamatkul_one($kodemk = '', $thajaran = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$nim = $this->session->userdata('sesi_krs_nim');
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$sql = "SELECT sks, kodemk, namamk FROM simkurikulum kur WHERE
					kodemk LIKE '%".$kodemk."%'
					AND kodeprodi = '".$kodeprodi."'";
			$sql .= " LIMIT 1 ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function thajaran_active(){
			$this->db->select('thajaran');
			$this->db->from('simsetting');
			$this->db->where('aktif', 'Aktif');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function count_all($nim=''){
			$sql = "SELECT * FROM simmatrikulasi ";
			if($nim){
				$sql .= " WHERE nim LIKE '%".$nim."%'";
			}
			$sql .= " GROUP BY nim";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function get_all($limit1, $limit2, $cari){
			$data = array();
			$sql = "SELECT nim,
					(SELECT nama FROM masmahasiswa WHERE nim = simmatrikulasi.nim) AS nama,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi = (SELECT kodeprodi FROM masmahasiswa WHERE nim = simmatrikulasi.nim)) AS prodi,
					(SELECT angkatan FROM masmahasiswa WHERE nim = simmatrikulasi.nim) AS angkatan FROM simmatrikulasi ";
			if($cari){
				$sql .= " WHERE nim LIKE '%".$cari."%' ";
			}
			$sql .= " GROUP BY nim ";
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
		function count_allbyprodi($kodeprodi, $cari = ''){
			$sql = "SELECT nim FROM masmahasiswa WHERE kodeprodi = '".$kodeprodi."' AND nim IN(SELECT nim FROM simmatrikulasi)";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function get_allbyprodi($limit1, $limit2, $prodi = '', $cari = '', $thajaran = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$data = array();
			$sql = "SELECT simmatrikulasi.nim,
					(SELECT nama FROM masmahasiswa WHERE nim = simmatrikulasi.nim) AS nama,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi = (SELECT kodeprodi FROM masmahasiswa WHERE nim = simmatrikulasi.nim)) AS prodi,
					(SELECT angkatan FROM masmahasiswa WHERE nim = simmatrikulasi.nim) AS angkatan FROM simmatrikulasi ";
			$sql .= " LEFT JOIN masmahasiswa ON simmatrikulasi.nim=masmahasiswa.nim WHERE masmahasiswa.kodeprodi = '".$prodi."' ";
			$sql .= " AND simmatrikulasi.thajaran = '".$thajaran."'";
			/*if($cari){
				$sql .= " AND simmatrikulasinim LIKE '%".$cari."%' ";
			}*/
			$sql .= " GROUP BY simmatrikulasi.nim ";
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
		function get_one($nim){
			$data = array();
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$sql = "SELECT kdsimmatrikulasi, nim, kodemk, nilai,
					(SELECT namamk FROM simkurikulum WHERE kodemk=simmatrikulasi.kodemk AND kodeprodi = '".$kodeprodi."') AS namamk,
					(SELECT sks FROM simkurikulum WHERE kodemk=simmatrikulasi.kodemk AND kodeprodi = '".$kodeprodi."') AS sks
					FROM simmatrikulasi ";
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
				'nim' => $this->session->userdata('sesi_krs_nim'),
				'thajaran' => $this->session->userdata('sesi_krs_thajaran_aktif'),
				'kodemk' => $this->input->post('txt_kode_mk'),
				'nilai' => $this->input->post('nilai')
			);
			$this->db->insert('simmatrikulasi', $data);
			$data2 = array(
				'nim' => $this->session->userdata('sesi_krs_nim'),
				'thajaran' => $this->session->userdata('sesi_krs_thajaran_aktif'),
				'status' => 'matrikulasi',
				'kodemk' => $this->input->post('txt_kode_mk'),
				'nilai' => $this->input->post('nilai')
			);
			$this->db->insert('simtranskrip', $data2);
		}
	}
?>