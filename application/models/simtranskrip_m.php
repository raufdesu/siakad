<?php
	Class Simtranskrip_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_thajaranbynim($nim){
			$data = array();
			$sql = "SELECT thajaran FROM simkrs WHERE nim = '".$nim."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_nimprodi($prodi = ''){
			$res = "";
			$sql = "SELECT nim FROM masmahasiswa ";
			if($prodi){
				$sql .= " WHERE kodeprodi = '".$prodi."' ";
			}
			$arnim = $this->db->query($sql);
			foreach($arnim->result() as $a){
				$res  .= '"'.$a->nim.'"'.',';
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res=0;
			return $res;
		}

		function delete($nim, $kodemk){
			$this->db->where('nim', $nim);
			$this->db->where('kodemk', $kodemk);
			$this->db->delete('simtranskrip');
		}
		function insert($nim, $thajaran, $status = 'reguler', $kodemk, $nilai){
			$data = array(
				'nim'		=> $this->session->userdata('sesi_nimmhs'),
				'thajaran'	=> $thajaran,
				'status'	=> $status,
				'kodemk'	=> $kodemk,
				'nilai'		=> $nilai
			);
			$this->db->insert('simtranskrip', $data);
		}
		function update($nim, $thajaran, $status = 'reguler', $kodemk, $nilai){
			$data = array(
				'nim'		=> $nim,
				'thajaran'	=> $thajaran,
				'status'	=> $status,
				'kodemk'	=> $kodemk,
				'nilai'		=> $nilai
			);
			$this->db->where("nim", $nim);
			$this->db->where("thajaran", $thajaran);
			$this->db->where("kodemk", $kodemk);
			$this->db->update("simtranskrip",$data);
		}
		function get_arraykodemk($nim, $thajaran){
			$data = array();
			$sql = "SELECT kodemk FROM simtranskrip WHERE nim = '".$nim."' AND thajaran = ".$thajaran;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function cek_kodesama($nim, $kodemk){
			$sql = "SELECT nilai FROM simtranskrip WHERE nim = '".$nim."' AND kodemk = '".$kodemk."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row()->nilai;
			}else{
				return false;
			}
		}
		function get_one($nim){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$sql = "SELECT kodemk,(SELECT namamk FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."') nama,
					(SELECT sks FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."')sks,nilai FROM simtranskrip WHERE nim = '".$nim."' ORDER BY thajaran";
			return $this->db->query($sql);
		}
		function get_onebythajaran($nim, $thajaran){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$sql = "SELECT kodemk,(SELECT namamk FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."') nama,status,
					(SELECT sks FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."')sks,nilai
					FROM simtranskrip WHERE nim = '".$nim."' AND thajaran = '".$thajaran."' AND status <> 'matrikulasi' ORDER BY nama";
			return $this->db->query($sql);
		}
		function get_onetranskrip($nim){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$sql = "SELECT kodemk,(SELECT namamk FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."') nama,status,
					(SELECT sks FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."')sks,nilai
					FROM simtranskrip WHERE nim = '".$nim."' AND status = 'matrikulasi' ORDER BY nama";
			return $this->db->query($sql);
		}
		function count_one_paralel($nim){
			$this->db->select('kodemk');
			$this->db->from('simtranskrip');
			$this->db->where('nim', $nim);
			return $this->db->count_all_results();
		}
		function get_ipk($nim){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$res = "";
			$sql = "SELECT CASE nilai
					WHEN 'A' THEN 4
					WHEN 'B' THEN 3 
					WHEN 'C' THEN 2
					WHEN 'D' THEN 1
					WHEN '' THEN 0 
					END AS nilai,
					(SELECT sks FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi='".$kodeprodi."') AS sks
					FROM simtranskrip WHERE nim = '".$nim."'";
			$que = $this->db->query($sql);
			$js = 0; $ns = 0;
			if($que->num_rows() > 0){
				foreach($que->result() as $row){
					$rs  = $row->nilai*$row->sks.",";
					$js = $js+$rs;
					$ns = $ns+$row->sks;
				};
				$hasil = $js/$ns;
				return $hasil;
			}else{
				return 0;
			}
		}
		function get_jumsks($nim){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$res = "";
			$sql = "SELECT 
					SUM((SELECT sks FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi='".$kodeprodi."')) AS jumsks
					FROM simtranskrip WHERE nim = '".$nim."'";
			$que = $this->db->query($sql);
			foreach($que->result() as $row){
				$jumsks = $row->jumsks;
			};
			return $jumsks;
		}
		function get_one_paralel($nim, $limit1, $limit2){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$sql = "SELECT kodemk,(SELECT namamk FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."') nama,
					(SELECT sks FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."')sks,nilai FROM simtranskrip WHERE nim = '".$nim."' ORDER BY thajaran";
			$sql .= " LIMIT ".$limit1.", ". $limit2;
			return $this->db->query($sql);
		}
		function get_one_ambilmk($nim,$thakad){
			$id_krs = $this->get_idkrs($nim, $thakad);
			$idkrs = $id_krs['idkrs'];
			$sql = "SELECT idkrs,kodemk,status,
					(SELECT DISTINCT(sim.namamk) FROM simkurikulum sim WHERE kodemk = siam.kodemk GROUP BY sim.kodemk) nama_mk,
					(SELECT DISTINCT(s.sks) FROM simkurikulum s WHERE kodemk = siam.kodemk GROUP BY s.kodemk) sks,
					nilaihuruf,status
					FROM simambilmk siam WHERE siam.idkrs = '".$idkrs."' ORDER BY kodemk";
			return $this->db->query($sql);
		}
		function get_all($limit1, $limit2, $nim){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$data = array();
			$sql = "SELECT nim, thajaran, status, kodemk, nilai,
					(SELECT namamk FROM simkurikulum WHERE kodemk = simtranskrip.kodemk AND kodeprodi = '".$kodeprodi."') namamk ";
			$sql .= "FROM simtranskrip WHERE nim = '".$nim."' GROUP BY kodemk ";
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
		function get_idkrs($nim, $thakad){
			$sql = "SELECT DISTINCT(idkrs) idkrs FROM simkrs WHERE nim='".$nim."' AND thajaran='".$thakad."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_matkul_notranskrip($limit1, $limit2 = '', $nim, $thakad){
			$data = array();
			$id_krs = $this->get_idkrs($nim, $thakad);
			$idkrs = $id_krs['idkrs'];
			$sql = "SELECT * FROM simambilmk WHERE idkrs = ".$idkrs." AND kodemk NOT IN(SELECT kodemk FROM simtranskrip WHERE nim = '".$nim."')";
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
/*		function count_all_mhs(){
			$data = array();
			$sql = "SELECT mhs.nim, nama, kodeprodi kdprod,
						(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi
					FROM masmahasiswa mhs LEFT JOIN simtranskrip aksem ON mhs.nim=aksem.nim WHERE mhs.nim IN(SELECT nim FROM simtranskrip)";
			if($this->session->userdata('sesi_statussem')){
				$sql .= " AND aksem.status = '".$this->session->userdata('sesi_statussem')."' ";
			}
			if($this->session->userdata('cari_simtranskrip')){
				$sql .= " AND nama LIKE '%".$this->session->userdata('cari_simtranskrip')."%' ";
				$sql .= " OR mhs.nim LIKE '%".$this->session->userdata('cari_simtranskrip')."%' ";
			}
			return $this->db->query($sql)->num_rows();
		} */
		/*
		function select_mk(){
			$data = array();
			$sql = "SELECT *,(SELECT namamk FROM simnamamk nm WHERE nm.kodenama = kur.kodenama) AS nama_mk FROM simkurikulum kur WHERE 
					kur.kodemk NOT IN
					(SELECT tawar.kodemk FROM simtranskrip tawar)";
			if($this->session->userdata('sesi_prodi')){
				$sql .= " AND kur.kodeprodi = '".$this->session->userdata('sesi_prodi')."'";
			}
			if($this->session->userdata('sesi_semester')){
				$sql .= " AND kur.semester = '".$this->session->userdata('sesi_semester')."'";
			}
			if($this->session->userdata('sesicari_matakuliah')){
				$sql .= " AND kur.kodemk LIKE '%".$this->session->userdata('sesicari_matakuliah')."%'";
				// $sql .= " OR nama_mk LIKE '%".$this->session->userdata('sesicari_matakuliah')."%'";
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function cek_kodemk($kodemk){
			$data = array();
			$this->db->select("kodemk");
			$this->db->from("simtranskrip");
			$this->db->where("kodemk",$kodemk);
			return $this->db->count_all_results();
		}

		function select_cari($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab");
			$this->db->from("simtranskrip ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			$this->db->join("tbkod2 t2","ad.jabakad = t2.kdkodtbkod");
			$this->db->like("nama",$cari);
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($kodemk){
			$data = array();
			$this->db->select("*");
			$this->db->from("simtranskrip");
			$this->db->join("simnamamk","simtranskrip.kodenama = simnamamk.kodenama");
			$this->db->join("simprodi","simtranskrip.kodeprodi = simprodi.kodeprodi");
			$this->db->where("kodemk",$kodemk);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		*/
	}
?>