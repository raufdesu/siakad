<?php
Class Masalumni_m extends Model{
	function __construct(){
		parent::model();
	}
	function _getone($nim){
		$sql = "SELECT *,
				(SELECT password FROM loginmhs WHERE nim = '".$nim."')AS password
				FROM masmahasiswa WHERE nim = '".$nim."'";
		$hasil = $this->db->query($sql);
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		}
	}
	function _connect(){
		$host = 'localhost';
		$user = 'root';
		$pass = '';
		$dbase = 'alumni';
		$conn = mysql_connect($host, $user, $pass);
		mysql_select_db($dbase, $conn);
	}
	function auto_insert($nim = ''){
		$d = $this->_getone($nim);
		$data = array(
			'nim'			=> $d['nim'],
			'alamatasal'	=> $d['alamatasal'],
			'email'			=> $d['email'],
			'notelp'		=> $d['notelpmhs']
		);
		$this->db->insert('masalumni', $data);
		
		$this->_connect();
		$sql = "INSERT INTO login(username, password, status, idalumni)
				VALUES('".$d['nim']."','".$d['password']."',2,'".$d['nim']."')";
		mysql_query($sql);
		$tglinput = date('Y-m-d');
		$sql2  = "INSERT INTO alumni(idalumni, nama, nimdulu, angkatan, alamat, tglinput)
					VALUES('".$d['nim']."','".$d['nama']."','".$d['nim']."','".$d['angkatan']."','".$d['alamatasal']."','".$tglinput."')";
		mysql_query($sql2);
		mysql_close();
	}
	function get_all($limit1, $limit2 = '', $cari = ''){
		$data = array();
		$sql = "SELECT *,
				(SELECT nama FROM masmahasiswa WHERE nim = masalumni.nim)AS nama,
				(SELECT angkatan FROM masmahasiswa WHERE nim = masalumni.nim)AS angkatan
				FROM masalumni ";
		if($cari){
			$sql .= " WHERE nim LIKE '%".$cari."%' ";
		}
		$sql .= "LIMIT ".$limit1;
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
	function count_all($cari = ''){
		$data = array();
		$sql = "SELECT nim FROM masalumni WHERE nim <> '' ";
		if($cari){
			$sql .= " AND nim LIKE '%".$cari."%'";
		}
		return $this->db->query($sql)->num_rows();
	}
	// function get_one($nim){
		// $sql = "SELECT *, kodeprodi kdprod,
				// (SELECT LEFT(nim,2) FROM simprodi WHERE kodeprodi=mhs.kodeprodi) pref_prodi,
				// (SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi
				// FROM masmahasiswa mhs ";
		// $sql .= " WHERE nim ='".$nim."' ";
		// $hasil = $this->db->query($sql);
		// if($hasil->num_rows() > 0){
			// return $hasil->row_array(); //return row sebagai associative array
		// }
	// }
}
?>