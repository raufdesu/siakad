<?php
Class Epsbed_m extends Model{
	function __construct(){
		parent::model();
	}
	function get_kurikulum($thajaran){
		$sql = "SELECT idkrs, kodemk, nilaihuruf,
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS thajaran,
				(SELECT nim FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS nim,
				(SELECT tanggal FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS tglkrs,
				(SELECT namamk FROM simkurikulum WHERE kodemk = ambil.kodemk) AS namamk,
				(SELECT sks FROM simkurikulum WHERE kodemk = ambil.kodemk) AS sks
				FROM simambilmk ambil WHERE 
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) = '".$thajaran."'";
		return $this->db->query($sql);
	}
	function get_nilai($thajaran){
		$sql = "SELECT idkrs, kodemk, nilaihuruf,
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS thajaran,
				(SELECT nim FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS nim,
				(SELECT tanggal FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS tglkrs
				FROM simambilmk ambil WHERE 
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) = '".$thajaran."'";
		return $this->db->query($sql);
	}
	function get_kuliahmhs($thajaran){
		$sql = "SELECT *, (SELECT DISTINCT(thajaran) FROM simaktifsemester WHERE thajaran = '".$thajaran."')thajaran FROM masmahasiswa mhs WHERE nim IN(SELECT nim FROM simaktifsemester WHERE thajaran = '".$thajaran."')";
echo $sql;
		$hasil = $this->db->query($sql);
		if($hasil->num_rows() > 0){
			$data = $hasil->result();
		}
		$hasil->free_result();
		return $data;			
	}
	function get_mhs_all($thajaran){
		$sql = "SELECT *,
				(SELECT (YEAR(mhs.tglmasuk) - YEAR(mhs.tgllahir)) FROM masmahasiswa mhs WHERE mhs.nim = mah.nim) AS usiamhs,
				(SELECT status FROM simaktifsemester WHERE nim = mah.nim AND thajaran = '".$thajaran."')AS status
				FROM masmahasiswa mah WHERE nim IN (SELECT nim FROM simaktifsemester WHERE thajaran = '".$thajaran."')";
		echo $sql;
		$hasil = $this->db->query($sql);
		if($hasil->num_rows() > 0){
			$data = $hasil->result();
		}
		$hasil->free_result();
		return $data;			
	}
	function get_nimkrs($thajaran){
		$sql = "SELECT nim FROM simkrs WHERE thajaran = ".$thajaran;
		$hasil = $this->db->query($sql);
		if($hasil->num_rows() > 0){
			$data = $hasil->result();
		}
		$hasil->free_result();
		return $data;			
	}
	function get_status_all($thajaran){
		$sql = "SELECT idkrs, kodemk, nilaihuruf,
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS thajaran,
				(SELECT nim FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS nim,
				(SELECT tanggal FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS tglkrs
				FROM simambilmk ambil WHERE 
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) = '".$thajaran."'";
		return $this->db->query($sql);
	}
	function get_krs_all($thajaran){
		$sql = "SELECT idkrs, kodemk, nilaihuruf,
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS thajaran,
				(SELECT nim FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS nim,
				(SELECT tanggal FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) AS tglkrs
				FROM simambilmk ambil WHERE 
				(SELECT thajaran FROM simkrs WHERE thajaran = '".$thajaran."' AND idkrs = ambil.idkrs) = '".$thajaran."'";
		return $this->db->query($sql);
	}
}
?>