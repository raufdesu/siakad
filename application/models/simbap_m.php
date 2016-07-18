<?php
	Class Simbap_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_bydosen($npp){
			$thajaran = $this->auth->get_thactive()->thajaran;
			$sql = "SELECT id_kelas_dosen, kodemk,
				(SELECT namamk FROM simkurikulum WHERE kodemk = simdosenampu.kodemk)namamk,
				(SELECT sks FROM simkurikulum WHERE kodemk = simdosenampu.kodemk)sks,
				(SELECT kodeprodi FROM simkurikulum WHERE kodemk = simdosenampu.kodemk) kodeprodi,kelas,";
			$sql .= " (SELECT COUNT(DISTINCT(idbap)) FROM presensimhs WHERE idbap ";
			$sql .= " IN(SELECT idbap FROM simbap WHERE id_kelas_dosen = simdosenampu.id_kelas_dosen)) AS jumhadir";
			$sql .= " FROM simdosenampu WHERE npp = '".$npp."' AND thajaran = '".$thajaran."' ";
			return $this->db->query($sql);
		}
		function get_idkelasbyidbap($idbap){
			$sql = "SELECT id_kelas_dosen FROM simbap WHERE idbap = ".$idbap;
			$hasil = $this->db->query($sql);
			return $hasil->row()->id_kelas_dosen;
		}
		function get_idkrsbykelas($id_kelas_dosen){
			$sql = "SELECT idkrs FROM simambilmk WHERE id_kelas_dosen = ".$id_kelas_dosen;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
		}
		function count_bap($id_kelas_dosen){
			$this->db->from('simbap');
			$this->db->where('id_kelas_dosen', $id_kelas_dosen);
			return $this->db->count_all_results();
		}
		function getmhs_byidkelas($id_kelas_dosen){
			$data = array();
			$res = "";
			$aridkrs = $this->get_idkrsbykelas($id_kelas_dosen);
			//echo $this->db->last_query();
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = "''";

			$sql = "SELECT idkrs,nim,thajaran,(SELECT nama FROM masmahasiswa WHERE nim = simkrs.nim)namamhs, ";
			$sql .= " (SELECT COUNT(status) FROM presensimhs WHERE status = 'H' AND nim = simkrs.nim AND idbap ";
			$sql .= " IN(SELECT idbap FROM simbap WHERE id_kelas_dosen = ".$id_kelas_dosen.")) AS jumhadir";
			$sql .= " FROM simkrs WHERE idkrs IN (".$res.")";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function getmatkul_byidkelas($id_kelas_dosen){
			$sql = "SELECT * FROM simdosenampu WHERE id_kelas_dosen = ". $id_kelas_dosen;
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}
		/* Kalo terjadi masalah disini, kemungkinan besar salahnya karena idkelas tak hapus. */
		function get_mhsambilmk($kodemk, $thajaran, $id_kelas_dosen = ''){
			$aridkrs = $this->get_idkrsbykodemk($kodemk, $id_kelas_dosen);
			$res = "";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = 0;
				
			$sql = "SELECT nim ";
			$sql .= " FROM simkrs WHERE thajaran = '".$thajaran."' ";
			$sql .= " AND idkrs IN";
			$sql .= "(".$res.")";
			$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim) <> 'NULL' ";
			$sql .= " ORDER BY nim ASC ";
			return $this->db->query($sql);
		}
		function get_idkrsbykodemk($kodemk, $id_kelas_dosen){
			// $sql = "SELECT idkrs FROM simambilmk WHERE kodemk = '".$kodemk."' AND id_kelas_dosen = ''";
			$data = array();
			$this->db->select('idkrs');
			$this->db->from('simambilmk');
			$this->db->where('kodemk', $kodemk);
			$this->db->where('id_kelas_dosen', $id_kelas_dosen);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_all(){
			$sql = "";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_byidkelas($idkelasdosen){
			$sql = "SELECT *,
				(SELECT COUNT(idpresensimhs) FROM presensimhs WHERE status = 'H' AND idbap = simbap.idbap)jumhadir,
				(SELECT COUNT(idpresensimhs) FROM presensimhs WHERE status = 'A' AND idbap = simbap.idbap)jumalpha,
				(SELECT COUNT(idpresensimhs) FROM presensimhs WHERE status = 'I' AND idbap = simbap.idbap)jumijin,
				(SELECT COUNT(idpresensimhs) FROM presensimhs WHERE status = 'S' AND idbap = simbap.idbap)jumsakit
				FROM simbap WHERE id_kelas_dosen = ".$idkelasdosen;
			$sql .= " ORDER BY tglkuliah ASC";
			return $this->db->query($sql);
		}
		function get_mhsbybap($idbap){
			$sql = "SELECT *, (SELECT nama FROM masmahasiswa WHERE nim = presensimhs.nim) namamhs, ";
			$sql .= " status FROM presensimhs WHERE idbap = ".$idbap;
			return $this->db->query($sql);
		}
		function get_one($idbap){
			$sql = "SELECT * FROM simbap WHERE idbap = ".$idbap;
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}
		function insert(){
			$data = array(
				"materi"		=> $this->input->post("materi"),
				"tglkuliah"		=> tgl_ingg($this->input->post("tglkuliah")),
				"id_kelas_dosen" => $this->input->post("id_kelas_dosen")
			);
			$this->db->insert("simbap",$data);
		}
		/* function insert_presensimhs($kodemk, $thajaran, $id_kelas_dosen = '', $kelas = ''){ */
		function insert_presensimhs($kodemk, $thajaran, $id_kelas_dosen = ''){
			$ambilmk = $this->get_mhsambilmk($kodemk, $thajaran, $id_kelas_dosen);
			$lb = $this->last_bap();
			$last_bap = $lb['idbap'];
			foreach($ambilmk->result() as $am){
				$data = array(
					'nim' => $am->nim,
					'status' => 'H',
					'idbap' => $last_bap
				);
				$this->db->insert('presensimhs', $data);
			}
		}
		function last_bap(){
			$sql = "SELECT * FROM simbap ORDER BY idbap DESC LIMIT 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function delete($id){
			$this->db->where('idbap', $id);
			$this->db->delete('simbap');
			
			$this->db->where('idbap', $id);
			$this->db->delete('presensimhs');
		}
	}
?>