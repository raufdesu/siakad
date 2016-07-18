<?php
	Class Simcalonmhs_m extends Model{
		function __construct(){
			parent::model();
			$host = "localhost"; $user = "root"; $pass= ""; $dbase = "pmbonline";
			$conn = mysql_connect($host, $user, $pass);
			mysql_select_db($dbase, $conn);
		}
		function cek_nimada($nim){
			$sql = "SELECT nim FROM siswa WHERE nim = '".$nim."' AND NIM <> ''";
			$que = mysql_query($sql);
			$d = mysql_fetch_array($que);
			return $d['nim'];
		}
		function update_nim($nodaft, $nim){
			$sama = $this->cek_nimada($nim);
			date_default_timezone_set("Asia/Jakarta");
			$now = date('Y-m-d H:i:s');
			$sql = "UPDATE siswa SET nim = '".$nim."' ";
			if($nim && $sama == false){
				$sql .= ",waktu_update_nim = '".$now."' ";
			}
			$sql .= " WHERE no_daftar = ".$nodaft;
			mysql_query($sql);
		}
		function get_one($nodaftar){
			$sql = "SELECT * FROM siswa WHERE no_daftar = ".$nodaftar;
			return $sql;
		}
		function nim_bynodaft($nodaft){
			$sql = "SELECT nim FROM siswa WHERE no_daftar = ".$nodaft;
			$que = mysql_query($sql);
			$d = mysql_fetch_array($que);
			return $d['nim'];
		}
		function gelombang_bynodaft($nodaft){
			$sql = "SELECT gelombang FROM siswa WHERE no_daftar =".$nodaft;
			$que = mysql_query($sql);
			$hasil = mysql_fetch_array($que);
			return $hasil['gelombang'];
		}
		function prodi_bynodaft($nodaft){
			$sql = "SELECT pil_jurusan FROM siswa WHERE no_daftar =".$nodaft;
			$que = mysql_query($sql);
			$hasil = mysql_fetch_array($que);
			if($hasil['pil_jurusan'] == 22){
				return 87203;
			}elseif($hasil['pil_jurusan'] == 33){
				return 87205;
			}elseif($hasil['pil_jurusan'] == 44){
				return 88201;
			}elseif($hasil['pil_jurusan'] == 55){
				return 88203;
			}elseif($hasil['pil_jurusan'] == 66){
				return 84202;
			}
		}
		function get_all($limit1, $limit2 = '', $prodi = '', $cari = ''){
			$data = array();
			$sql = "SELECT * FROM siswa WHERE angkatan = '2012' AND result = 'Diterima' ";
			if($prodi){
				$sql .= " AND pil_jurusan = '".$prodi."'";
			}
			if($cari){
				$sql .= " AND nama LIKE '%".$cari."%'";
			}
			/* $sql .= " ORDER BY no_registrasi ASC"; */
			$sql .= " ORDER BY waktu_update_nim DESC";
			$sql .= " LIMIT ".$limit1;
			if($limit2){
				$sql .= ",".$limit2;
			}
			return $sql;
		}
		function count_all($prodi = '', $cari = ''){
			$angkatan = date('Y');
			$sql = "SELECT COUNT(*)AS jum FROM siswa WHERE angkatan = '".$angkatan."' AND result = 'Diterima' ";
			if($prodi){
				$sql .= " AND pil_jurusan = '".$prodi."'";
			}
			if($cari){
				$sql .= " AND nama LIKE '%".$cari."%'";
			}
			$que = mysql_query($sql);
			$d = mysql_fetch_array($que);
			if($d[0]){
				return $d['jum'];
			}else{
				return 0;
			}
			mysql_close();
		}
		function delete($id){
			$sql = "DELETE FROM siswa WHERE no_daftar = ".$id;
			mysql_query($sql);
		}
	}
?>
