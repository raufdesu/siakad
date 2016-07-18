<?php
	Class Keubayar_m extends Model{
		function __construct(){
			parent::model();
		}
		function cek_bayar($nim, $thajaran){
			$sql = "SELECT * FROM keubayar WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$que = $this->db->query($sql);
			if($que->num_rows()){
				return $que->num_rows();
			}else{
				return 0;
			}			
		}
		function get_nimangkatan($angkatan){
			$data = array();
			$sql = "SELECT nim FROM masmahasiswa WHERE angkatan = '".$angkatan."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
		}
		function get_nimprodi($prodi){
			$data = array();
			$sql = "SELECT nim FROM masmahasiswa WHERE kodeprodi = '".$prodi."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
		}
		function get_allbayar($limit1 = '', $limit2 = '', $prodi = '', $angkatan = '', $thajaran = ''){
			$data = array();
			$res = "";
			$arnimangkatan = $this->get_nimangkatan($angkatan);
			foreach($arnimangkatan as $a){
				$res  .= $a->nim.",";
			}
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res= 0;

			$res2 = "";
			$arnimprodi = $this->get_nimprodi($prodi);
			foreach($arnimprodi as $b){
				$res2 .= $b->nim.",";
			}
			if($res2)
				$res2 = substr($res2,0,strlen($res2)-1);
			else
				$res2 = 0;

			$sql = "SELECT *, (SELECT kodeprodi FROM masmahasiswa WHERE nim = keubayar.nim) AS kodeprodi,
					(SELECT totalbiaya FROM keujenisbayar WHERE angkatan = (SELECT angkatan FROM masmahasiswa WHERE nim = keubayar.nim) AND jenisbayar = keubayar.jenisbayar) AS biaya,
					(SELECT nama FROM masmahasiswa WHERE nim = keubayar.nim) AS nama,
					(SELECT angkatan FROM masmahasiswa WHERE nim = keubayar.nim) AS angkatan
					FROM keubayar WHERE thajaran = '".$thajaran."' ";
			if($angkatan){
				$sql .= " AND nim IN(".$res.") ";
			}
			if($prodi){
				$sql .= " AND nim IN(".$res2.") ";
			}
			$sql .= " ORDER BY idbayar DESC";
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
		function get_all($limit1 = '', $limit2 = '', $prodi = '', $angkatan = '', $thajaran = ''){
			$data = array();
			$res = "";
			$arnimangkatan = $this->get_nimangkatan($angkatan);
			foreach($arnimangkatan as $a){
				$res  .= $a->nim.",";
			}
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res= 0;

			$res2 = "";
			$arnimprodi = $this->get_nimprodi($prodi);
			foreach($arnimprodi as $b){
				$res2 .= $b->nim.",";
			}
			if($res2)
				$res2 = substr($res2,0,strlen($res2)-1);
			else
				$res2 = 0;

			$sql = "SELECT *, (SELECT kodeprodi FROM masmahasiswa WHERE nim = keubayar.nim) AS kodeprodi,
					(SELECT totalbiaya FROM keujenisbayar WHERE angkatan = (SELECT angkatan FROM masmahasiswa WHERE nim = keubayar.nim) AND jenisbayar = keubayar.jenisbayar) AS biaya,
					(SELECT nama FROM masmahasiswa WHERE nim = keubayar.nim) AS nama,
					(SELECT angkatan FROM masmahasiswa WHERE nim = keubayar.nim) AS angkatan
					FROM keubayar WHERE thajaran = '".$thajaran."' ";
			if($angkatan){
				$sql .= " AND nim IN(".$res.") ";
			}
			if($prodi){
				$sql .= " AND nim IN(".$res2.") ";
			}
			$sql .= " GROUP BY nim ORDER BY idbayar DESC";
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
		function count_all($prodi = '', $angkatan = '', $thajaran = ''){
			/* $sql = "SELECT nim FROM masmahasiswa WHERE nim <> '' ";
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."' ";
			}
			if($angkatan){
				$sql .= " AND angkatan = ".$angkatan;
			}
			$sql .= " AND nim IN(SELECT nim FROM keubayar WHERE thajaran = '".$thajaran."')";*/
			$data = array();
			$res = "";
			$arnimangkatan = $this->get_nimangkatan($angkatan);
			foreach($arnimangkatan as $a){
				$res  .= $a->nim.",";
			}
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res= 0;

			$res2 = "";
			$arnimprodi = $this->get_nimprodi($prodi);
			foreach($arnimprodi as $b){
				$res2 .= $b->nim.",";
			}
			if($res2)
				$res2 = substr($res2,0,strlen($res2)-1);
			else
				$res2 = 0;

			$sql = "SELECT idbayar FROM keubayar WHERE thajaran = '".$thajaran."' ";
			if($angkatan){
				$sql .= " AND nim IN(".$res.") ";
			}
			if($prodi){
				$sql .= " AND nim IN(".$res2.") ";
			}
			$sql .= " GROUP BY nim ORDER BY idbayar DESC";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->num_rows();
			}else{
				return 0;
			}
		}
		function get_onemhs($nim, $jenisbayar, $thajaran = '', $kodeprodi = '', $gelombang = ''){
			$sql = "SELECT *, kodeprodi kdprod,
					(SELECT LEFT(nim,2) FROM simprodi WHERE kodeprodi=mhs.kodeprodi) pref_prodi,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi,
					(SELECT totalbiaya FROM keujenisbayar WHERE jenisbayar = '".$jenisbayar."' ";
				if($kodeprodi){
					$sql .= " AND kodeprodi=".$kodeprodi;
				}
				if($gelombang){
					$sql .= " AND gelombang=".$gelombang;
				}
					$sql .= " AND angkatan = mhs.angkatan LIMIT 1) totalbiaya,
					(SELECT jumbayar FROM keudetbayar WHERE idbayar =
					(SELECT idbayar FROM keubayar WHERE nim = '".$nim."' AND jenisbayar = '".$jenisbayar."' AND thajaran = '".$thajaran."') ORDER BY idbayar DESC LIMIT 1) jumbayar,
					(SELECT status FROM keubayar WHERE nim = '".$nim."' AND jenisbayar = '".$jenisbayar."' AND thajaran = '".$thajaran."') status ";
			$sql .= " FROM masmahasiswa mhs ";
			$sql .= " WHERE nim ='".$nim."' ";
			/*if($prodi){
				$sql .= " AND kodeprodi = ".$kodeprodi;
			}
			if($gelombang){
			
			}*/
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		function get_onemhsnew($nim, $jenisbayar, $thajaran = '', $kodeprodi = '', $gelombang = ''){
			$data = array();
			$sql = "SELECT *, kodeprodi kdprod,
					(SELECT LEFT(nim,2) FROM simprodi WHERE kodeprodi=mhs.kodeprodi) pref_prodi,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi,
					(SELECT totalbiaya FROM keujenisbayar WHERE jenisbayar = '".$jenisbayar."' ";
				if($kodeprodi){
					$sql .= " AND kodeprodi=".$kodeprodi;
				}
				if($gelombang){
					$sql .= " AND gelombang=".$gelombang;
				}
					$sql .= " AND angkatan = mhs.angkatan LIMIT 1) totalbiaya,
					(SELECT jumbayar FROM keudetbayar WHERE idbayar =
					(SELECT idbayar FROM keubayar WHERE nim = '".$nim."' AND jenisbayar = '".$jenisbayar."' AND thajaran = '".$thajaran."') ORDER BY idbayar DESC LIMIT 1) jumbayar,
					(SELECT status FROM keubayar WHERE nim = '".$nim."' AND jenisbayar = '".$jenisbayar."' AND thajaran = '".$thajaran."') status ";
			$sql .= " FROM masmahasiswa mhs ";
			$sql .= " WHERE nim ='".$nim."' ";

			$hasil = $this->db->query($sql);
			return $hasil;
			// if($hasil->num_rows() > 0){
				// $data = $hasil->result();
			// }
			// $hasil->free_result();
			// return $data;
		}
		function cek_bayar2($thajaran, $nim, $jenisbayar){
			$sql = "SELECT * FROM keubayar WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$sql .= " AND jenisbayar = '".$jenisbayar."'";
			$que = $this->db->query($sql);
			if($que->num_rows()){
				return $que->num_rows();
			}else{
				return 0;
			}
		}
		function cek_lunas($thajaran, $nim, $jenisbayar){
			$sql = "SELECT idbayar FROM keubayar WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$sql .= " AND jenisbayar = '".$jenisbayar."' AND status = 'Lunas'";
			$que = $this->db->query($sql);
			return $que->num_rows();
		}
		function get_idbayarby($thajaran, $nim, $jenisbayar){
			$sql = "SELECT idbayar FROM keubayar WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$sql .= " AND jenisbayar = '".$jenisbayar."'";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row()->idbayar;
			}else{
				return false;
			}
		}
		function get_angkatanbynim($nim){
			$sql = "SELECT angkatan FROM masmahasiswa WHERE nim = '".$nim."'";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row()->angkatan;
			}else{
				return false;
			}
		}
		function get_bynim($nim, $thajaran, $prodi = '', $gelombang = ''){
			$angkatan = $this->get_angkatanbynim($nim);
			$data = array();
			$sql = "SELECT *,(SELECT totalbiaya FROM keujenisbayar WHERE jenisbayar = keubayar.jenisbayar ";
			if($prodi){
				$sql .= " AND kodeprodi = ".$prodi;
			}
			if($gelombang){
				$sql .= " AND gelombang = ".$gelombang;
			}
			$sql .= " AND angkatan = '".$angkatan."')totalbiaya ";
			$sql .= " FROM keubayar WHERE nim = '".$nim."' AND thajaran = '".$thajaran."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_lastidbayar(){
			$sql = "SELECT idbayar FROM keubayar ORDER BY idbayar DESC LIMIT 1";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row()->idbayar;
			}else{
				return false;
			}
		}
		function last_bayar(){
			$sql = "SELECT ";
		}
		function insert(){
			$thajaran = $this->input->post('thajaran');
			$nim = $this->input->post('nim');
			$jenisbayar = $this->input->post('jenisbayar');
			
			if($this->input->post('jumbayar') >= $this->input->post('kekurangan')){
				$status = 'Lunas';				
			}else{
				$status = 'Belum Lunas';
			}
			$data = array(
				'thajaran'	=> $thajaran,
				'nim'		=> $nim,
				'jenisbayar'=> $jenisbayar,
				'status'	=> $status
			);
			$cek_bayar2 = $this->cek_bayar2($thajaran, $nim, $jenisbayar);
			if($cek_bayar2 == false){
				$this->db->insert('keubayar', $data);
				$idbayar = $this->get_lastidbayar();
				$rec = array(
					'status' => $status
				);
				$this->db->where('idbayar', $idbayar);
				$this->db->update('keubayar', $rec);
			}else{
				$idbayar = $this->get_idbayarby($thajaran, $nim, $jenisbayar);
				$rec = array(
					'status' => $status
				);
				$this->db->where('idbayar', $idbayar);
				$this->db->update('keubayar', $rec);
			}
			$data2 = array(
				'idbayar'	=> $idbayar,
				'jumbayar'	=> $this->input->post('jumbayar'),
				'petugas'	=> $this->input->post('petugas'),
				'tglbayar'	=> date('Y-m-d H:i:s'),
				'keterangan'=> $this->input->post('keterangan')
			);
			$this->db->insert('keudetbayar', $data2);
		}
		/* INPUT DATA PEMBAYARAN SPP DARI MENU CALON MAHASISWA BARU */
		function insert_new($thajaran, $nim, $jenisbayar){
			if(trim($this->input->post('tagihan')) == trim($this->input->post('jumbayar'))){
				$status = 'Lunas';
			}else{
				$status = 'Belum Lunas';
			}
			$data = array(
				'thajaran'	=> $thajaran,
				'nim'		=> $nim,
				'jenisbayar'=> $jenisbayar,
				'status'	=> $status
			);
			$this->db->insert('keubayar', $data);
			
			$petugas = $this->input->post('petugas');
			if(!$this->input->post('petugas')){
				$petugas = 'admin';
			}
			$idbayar = $this->get_idbayarby($thajaran, $nim, $jenisbayar);
			$data2 = array(
				'idbayar'	=> $idbayar,
				'jumbayar'	=> $this->input->post('jumbayar'),
				'petugas'	=> $petugas,
				'tglbayar'	=> date('Y-m-d H:i:s'),
				'keterangan'=> $this->input->post('keterangan')
			);
			$this->db->insert('keudetbayar', $data2);
		}
		function get_one($id){
			$sql = "SELECT *,(SELECT nama FROM masmahasiswa WHERE nim = keubayar.nim)nama FROM keudetbayar INNER JOIN keubayar ON keudetbayar.idbayar = keubayar.idbayar WHERE iddetbayar = '".$id."'";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row();
			}else{
				return false;
			}
		}
		function _cekdetbayar($id2){
			$this->db->where('idbayar', $id2);
			$this->db->from('keudetbayar');
			return $this->db->count_all_results();
		}
		function delete($id, $id2 = ''){
			$this->db->where('iddetbayar', $id);
			$this->db->delete('keudetbayar');
			
			$cek_detbayar = $this->_cekdetbayar($id2);
			if($cek_detbayar){
				$data = array(
					'status' => 'Belum Lunas'
				);
				$this->db->where('idbayar', $id2);
				$this->db->update('keubayar', $data);
			}else{
				$this->db->where('idbayar', $id2);
				$this->db->delete('keubayar');
			}
		}
		/*function get_namakeubayar($id){
			$data = array();
			$sql = "SELECT namaprodi FROM keubayar WHERE prefkodeprodi = '".$id."'";
			$que = $this->db->query($sql);
			if($que->num_rows > 0){
				return $que->row()->namaprodi;
			}else{
				return 'Keseluruhan';
			}
		}
		function detail($kodeprodi){
			$data = array();
			$this->db->select("*");
			$this->db->from("keubayar");
			$this->db->where("kodeprodi",$kodeprodi);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all(){
			$data = array();
			$this->db->select("*");
			$this->db->from("keubayar");
			return $this->db->count_all_results();
		}*/
	}
?>