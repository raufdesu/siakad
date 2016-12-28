<?php
	Class Simambilmk_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_kdprodibynim($nim){
			$sql = "SELECT kodeprodi FROM masmahasiswa WHERE nim = '".$nim."'";
			$hasil = $this->db->query($sql);
			return $hasil->row()->kodeprodi;
		}
		function getidkrsthajaran($nim, $thajaran){
			$data = array();
			$sql = "SELECT idkrs FROM simkrs WHERE nim = '".$nim."' AND thajaran = '".$thajaran."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
		}
		function _getidkelas($nim, $thajaran){
			$data = array();
			$res = "";
			$aridkrs = $this->getidkrsthajaran($nim, $thajaran);
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			}
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = "''";

			$sql = "SELECT id_kelas_dosen FROM simambilmk WHERE id_kelas_dosen <> '' AND idkrs IN(".$res.")";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_kelasdosen($nim, $thajaran, $hari){
			/*$kdprodibynim = $this->get_kdprodibynim($nim);*/
			$res = "";
			$aridkelas = $this->_getidkelas($nim, $thajaran);
			foreach($aridkelas as $b){
				$res  .= $b->id_kelas_dosen.",";
			}
			if($res)
				$res = substr($res,0,strlen($res)-1);
			else
				$res = "''";
			
			/* echo $this->db->last_query(); exit; */
			$data = array();
			$sql = "SELECT *,
					(SELECT nama FROM simruang WHERE id_ruang = simdosenampu.id_ruang)ruang,
					(SELECT nama FROM maspegawai WHERE npp = simdosenampu.npp)namadosen,
					(SELECT namamk FROM simkurikulum WHERE kodemk = simdosenampu.kodemk)namamk
					FROM simdosenampu WHERE id_kelas_dosen IN(".$res.") AND hari = '".$hari."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function _getidkrs($nim){
			$data = array();
			$thajaran = $this->auth->get_thactive()->thajaran;
			$sql = "SELECT idkrs FROM simkrs WHERE nim = '".$nim."' AND thajaran <> '".$thajaran."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function _getidkrs_untilthajaran($nim, $thajaran_until){
			$data = array();
			$sql = "SELECT idkrs FROM simkrs WHERE nim = '".$nim."' AND thajaran 
					IN(select thajaran from simsetting where thajaran between
						(select thajaran from simsetting order by thajaran limit 1)
					and '".$thajaran_until."' order by thajaran)";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
		}
		function get_transkrip_bythajaran($nim, $thajaran_until){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$data = array();
			$res = "";
			$aridkrs = $this->_getidkrs_untilthajaran($nim, $thajaran_until);
			// if($aridkrs):
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = "''";
			$sql = "SELECT *,
					(SELECT namamk FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."')namamk,
					(SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."')jumlahsks
					FROM simambilmk WHERE nilaihuruf <> '' AND idkrs IN(".$res.")";
			$sql .= " GROUP BY simambilmk.kodemk ORDER BY (SELECT namamk FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."') ASC";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			return $data;
		}
		function get_transkrip($nim){
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$data = array();
			$res = "";
			$aridkrs = $this->_getidkrs($nim);
			// if($aridkrs):
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = "''";
			$sql = "SELECT idkrs,kodemk,id_kelas_dosen,status,nilaihuruf,
					(SELECT namamk FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."')namamk,
					(SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."')jumlahsks
					FROM simambilmk WHERE nilaihuruf <> '' AND idkrs IN(".$res.")";
			$sql .= " ORDER BY (SELECT namamk FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."') ASC";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			return $data;
		}
		function get_idkrs_bynim($nim, $thajaran){
			$sql = "SELECT get_idkrs_bynim('".$nim."','".$thajaran."') AS idkrsnya";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_khs($nim, $thajaran){
			$data = array();
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			$gi = $this->get_idkrs_bynim($nim, $thajaran);
			$idkrs = $gi['idkrsnya'];
			if($idkrs){
				$sql = "SELECT *,
					(SELECT namamk FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."') AS namamk,
					(SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk AND kodeprodi = '".$kodeprodi."') AS jumlahsks
					FROM simambilmk WHERE idkrs = ".$idkrs;
				$hasil = $this->db->query($sql);
				if($hasil->num_rows() > 0){
					$data = $hasil->result();
				}
				$hasil->free_result();
				return $data;
			}else{
				return $data;
			}
		}
		function update_pilihkelas($idkrsnya, $kodemk, $id_kelas_dosen){
			$data = array(
				"id_kelas_dosen"	=> $id_kelas_dosen
			);
			$this->db->where('idkrs', $idkrsnya);
			$this->db->where('kodemk', $kodemk);
			$this->db->update('simambilmk', $data);
		}
		function update_pilihkelas_feeder($nim, $kodemk, $kelas){
			$data2 = array(
				"nama_kelas"	=> $kelas
			);
			$this->pmb = $this->load->database('pmb', TRUE);
			$this->pmb->where('nim', $nim);
			$this->pmb->where('kode_mk', $kodemk);
			$this->pmb->update('krs', $data2);
		}
	}
?>