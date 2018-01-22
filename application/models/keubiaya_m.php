<?php
	Class Keubiaya_m extends Model{
		function __construct(){
			parent::model();
		}
		function import($kodeprodi = '', $angkatan = '', $gelombang = '', $namabiaya = '', $thajaran = '', $jumbiaya = '', $minaktif = '', $jenis, $kategori=''){
			$sql = 'SELECT nim FROM masmahasiswa WHERE statusakademik = "Belum Lulus" ';
			if($kodeprodi){
				$sql .= ' AND kodeprodi = "'.$kodeprodi.'" ';
			}
			if($angkatan){
				$sql .= ' AND angkatan = "'.$angkatan.'" ';
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				foreach($hasil->result() as $mhs){
					$data = array(
						'namabiaya'	=> $namabiaya,
						'jenis'		=> $jenis,
						'kategori'	=> $kategori,
						'thajaran'	=> $thajaran,
						'nim'		=> $mhs->nim,
						'jumbiaya'	=> $jumbiaya,
						'jumbiaya_awal'	=> $jumbiaya,
						'minaktif'	=> $minaktif,
						'dispensasi'=> 'Tidak',
						'status'	=> 'Belum Lunas',
						
					);
					$this->db->insert('keubiaya', $data);
				}
			}
		}
		function update_status($idbiaya, $status){
			$data = array(
				'status' => $status
			);
			$this->db->where('idbiaya', $idbiaya);
			$this->db->update('keubiaya', $data);
		}
		function update_biayasks(){
			$data = array(
				'jumbiaya_awal' => $this->input->post('jumbiaya_awal'),
				'jumsks' => $this->input->post('jumsks'),
				'jumbiaya' => $this->input->post('jumbiaya_awal') * $this->input->post('jumsks')
			);
			$this->db->where('idbiaya', $this->input->post('idbiaya'));
			$this->db->update('keubiaya', $data);
		}
		function cek_biaya($nim, $thajaran){
			$sql = "SELECT * FROM keubiaya WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$que = $this->db->query($sql);
			if($que->num_rows()){
				return $que->num_rows();
			}else{
				return 0;
			}			
		}
		/* function get_namabiayabynim($nim, $thajaran){ */
		function get_namabiayabynim($nim, $jenis=''){
			$data = array();
			$sql = "SELECT namabiaya FROM keubiaya WHERE nim = '".$nim."' ";
			if($jenis){
				$sql .= " AND jenis = '".$jenis."'";
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
		}
		function get_setoran($idbiaya, $limit=''){
			$data = array();
			$sql = 'SELECT * FROM keusetoran WHERE idbiaya = "'.$idbiaya.'" ';
			if($limit == '1'){
				$sql .= ' LIMIT 1';
			}elseif($limit == '2'){
				$sql .= ' LIMIT 1,1';
			}elseif($limit == '3'){
				$sql .= ' LIMIT 2,1';
			}elseif($limit == '4'){
				$sql .= ' LIMIT 3,1';
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_jenisbynim($nim){
			$data = array();
			$sql = "SELECT DISTINCT(jenis) FROM keubiaya WHERE nim = '".$nim."' ";
			$sql .= " ORDER BY FIELD(jenis, 'Awal Masuk', 'Sumbangan Pembangunan', 'SPP/UJIAN', 'Kewajiban Lain')";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
		}
		function get_bynimjenis($nim, $jenis=''){
			$data = array();
			$sql = 'SELECT * FROM keubiaya WHERE nim = "'.$nim.'"';
			if($jenis){
				$sql .= ' AND jenis = "'.$jenis.'"';
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;			
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
		function get_allbiaya($limit1 = '', $limit2 = '', $prodi = '', $angkatan = '', $thajaran = ''){
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

			$sql = "SELECT *, (SELECT kodeprodi FROM masmahasiswa WHERE nim = keubiaya.nim) AS kodeprodi,
					(SELECT totalbiaya FROM keujenisbiaya WHERE angkatan = (SELECT angkatan FROM masmahasiswa WHERE nim = keubiaya.nim) AND jenisbiaya = keubiaya.jenisbiaya) AS biaya,
					(SELECT nama FROM masmahasiswa WHERE nim = keubiaya.nim) AS nama,
					(SELECT angkatan FROM masmahasiswa WHERE nim = keubiaya.nim) AS angkatan
					FROM keubiaya WHERE thajaran = '".$thajaran."' ";
			if($angkatan){
				$sql .= " AND nim IN(".$res.") ";
			}
			if($prodi){
				$sql .= " AND nim IN(".$res2.") ";
			}
			$sql .= " ORDER BY idbiaya DESC";
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
		function get_allpembayaran($limit1 = '', $limit2 = '', $thajaran='', $cari='', $prodi='', $angkatan='', $status=''){
			/* if(!$thajaran){
				$thajaran = $this->simsetting_m->get_active();
			} */
			$sql = 'SELECT * FROM keubiaya INNER JOIN masmahasiswa ON keubiaya.nim = masmahasiswa.nim ';
			$sql .= ' WHERE 1 ';
			if($thajaran){
				$sql .= ' AND thajaran = "'.$thajaran.'" ';
			}
			if($prodi){
				$sql .= ' AND kodeprodi = "'.$prodi.'"';
			}
			if($status){
				$sql .= ' AND status = "'.$status.'"';
			}
			if($angkatan){
				$sql .= ' AND angkatan = '.$angkatan;
			}
			if($cari){
				$sql .= ' AND (nama LIKE "%'.$cari.'%" OR keubiaya.nim LIKE "%'.$cari.'%") ';
			}
			/* $sql .= ' GROUP BY keubiaya.nim '; */
			if($limit1 || $limit2){
				$sql .= " LIMIT ".$limit1;
				if($limit2 == true){
					$sql .= " ,".$limit2;
				}
			}
			return $this->db->query($sql);
		}
		function count_allpembayaran($thajaran='', $cari='', $prodi='', $angkatan='', $status=''){
			/* if(!$thajaran){
				$thajaran = $this->simsetting_m->get_active();
			} */
			$sql = 'SELECT idbiaya FROM keubiaya INNER JOIN masmahasiswa ON keubiaya.nim = masmahasiswa.nim ';
			$sql .= ' WHERE 1 ';
			if($thajaran){
				$sql .= ' AND thajaran = "'.$thajaran.'" ';
			}
			if($prodi){
				$sql .= ' AND kodeprodi = "'.$prodi.'"';
			}
			if($status){
				$sql .= ' AND status = "'.$status.'"';
			}
			if($angkatan){
				$sql .= ' AND angkatan = '.$angkatan;
			}
			if($cari){
				$sql .= ' AND (nama LIKE "%'.$cari.'%") OR (keubiaya.nim LIKE "%'.$cari.'%") ';
			}
			/* $sql .= ' GROUP BY keubiaya.nim '; */
			$que = $this->db->query($sql);
			return $que->num_rows();
		}
		function count_all($prodi = '', $angkatan = '', $thajaran = ''){
			/* $sql = "SELECT nim FROM masmahasiswa WHERE nim <> '' ";
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."' ";
			}
			if($angkatan){
				$sql .= " AND angkatan = ".$angkatan;
			}
			$sql .= " AND nim IN(SELECT nim FROM keubiaya WHERE thajaran = '".$thajaran."')";*/
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

			$sql = "SELECT idbiaya FROM keubiaya WHERE thajaran = '".$thajaran."' ";
			if($angkatan){
				$sql .= " AND nim IN(".$res.") ";
			}
			if($prodi){
				$sql .= " AND nim IN(".$res2.") ";
			}
			$sql .= " GROUP BY nim ORDER BY idbiaya DESC";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->num_rows();
			}else{
				return 0;
			}
		}
		/* function get_onebiaya($nim, $namabiaya, $thajaran){ */
		function get_onebiaya($nim, $namabiaya, $jenisbiaya){
			$sql = 'SELECT *,
						(SELECT SUM(jumsetoran) FROM keusetoran WHERE keusetoran.idbiaya = keubiaya.idbiaya) totalsetoran
						FROM keubiaya ';
			$sql .= ' WHERE nim ="'.$nim.'" AND namabiaya = "'.$namabiaya.'"  AND jenis = "'.$jenisbiaya.'"';
			/* $sql .= ' WHERE nim ="'.$nim.'" AND namabiaya = "'.$namabiaya.'" AND thajaran = "'.$thajaran.'"'; */
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_onemhs($nim, $namabiaya, $thajaran = '', $kodeprodi = '', $gelombang = ''){
			$sql = "SELECT kodeprodi ";
			$sql .= " FROM masmahasiswa mhs ";
			$sql .= " WHERE nim ='".$nim."' ";
			/*if($kodeprodi){
				$sql .= " AND kodeprodi = ".$kodeprodi;
			}
			if($gelombang){
			
			}*/
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		function get_onemhsnew($nim, $jenisbiaya, $thajaran = '', $kodeprodi = '', $gelombang = ''){
			$data = array();
			$sql = "SELECT *, kodeprodi kdprod,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi,
					(SELECT totalbiaya FROM keujenisbiaya WHERE jenisbiaya = '".$jenisbiaya."' ";
				if($kodeprodi){
					$sql .= " AND kodeprodi=".$kodeprodi;
				}
				if($gelombang){
					$sql .= " AND gelombang=".$gelombang;
				}
					$sql .= " AND angkatan = mhs.angkatan LIMIT 1) totalbiaya,
					(SELECT jumbiaya FROM keudetbiaya WHERE idbiaya =
					(SELECT idbiaya FROM keubiaya WHERE nim = '".$nim."' AND jenisbiaya = '".$jenisbiaya."' AND thajaran = '".$thajaran."') ORDER BY idbiaya DESC LIMIT 1) jumbiaya,
					(SELECT status FROM keubiaya WHERE nim = '".$nim."' AND jenisbiaya = '".$jenisbiaya."' AND thajaran = '".$thajaran."') status ";
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
		function cek_biaya2($thajaran, $nim, $jenisbiaya){
			$sql = "SELECT * FROM keubiaya WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$sql .= " AND jenisbiaya = '".$jenisbiaya."'";
			$que = $this->db->query($sql);
			if($que->num_rows()){
				return $que->num_rows();
			}else{
				return 0;
			}
		}
		function cek_lunas($thajaran, $nim, $jenisbiaya){
			$sql = "SELECT idbiaya FROM keubiaya WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$sql .= " AND jenisbiaya = '".$jenisbiaya."' AND status = 'Lunas'";
			$que = $this->db->query($sql);
			return $que->num_rows();
		}
		function get_idbiayaby($thajaran, $nim, $jenisbiaya){
			$sql = "SELECT idbiaya FROM keubiaya WHERE thajaran = '".$thajaran."' AND nim = '".$nim."' ";
			$sql .= " AND jenisbiaya = '".$jenisbiaya."'";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row()->idbiaya;
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
		function get_bynim($nim){
			$data = array();
			$sql = 'SELECT * FROM keubiaya WHERE nim = "'.$nim.'"';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_lastidbiaya(){
			$sql = "SELECT idbiaya FROM keubiaya ORDER BY idbiaya DESC LIMIT 1";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row()->idbiaya;
			}else{
				return false;
			}
		}
		function last_biaya(){
		}
		function insert(){
			if($this->input->post('thajaran')){
				$thajaran = $this->input->post('thajaran');
			}else{
				$thajaran = $this->session->userdata('sesi_thajaran');
			}
			$data = array(
				'namabiaya'	=> $this->input->post('namabiaya'),
				'jenis'	=> $this->input->post('jenis'),
				'thajaran'	=> $thajaran,
				'nim'	=> $this->input->post('nim'),
				'jumbiaya'	=> $this->input->post('jumbiaya'),
				'dispensasi'=> $this->input->post('dispensasi'),
				'keterangan'=> $this->input->post('keterangan'),
				'status'=> $this->input->post('status')
			);
			if($this->input->post('idbiaya')){
				$this->db->where('idbiaya', $this->input->post('idbiaya'));
				$this->db->update('keubiaya', $data);
			}else{
				$this->db->insert('keubiaya', $data);
			}
		}
		function get_one($id){
			$sql = "SELECT * FROM keubiaya WHERE idbiaya = '".$id."'";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row();
			}else{
				return false;
			}
		}
		function _cekdetbiaya($id2){
			$this->db->where('idbiaya', $id2);
			$this->db->from('keudetbiaya');
			return $this->db->count_all_results();
		}
		function delete_drop($id){
			$this->db->where('idbiaya', $id);
			$this->db->delete('keubiaya');
			
			$this->db->where('idbiaya', $id);
			$this->db->delete('keusetoran');
		}
		function delete($id, $id2 = ''){
			$this->db->where('iddetbiaya', $id);
			$this->db->delete('keudetbiaya');
			
			$cek_detbiaya = $this->_cekdetbiaya($id2);
			if($cek_detbiaya){
				$data = array(
					'status' => 'Belum Lunas'
				);
				$this->db->where('idbiaya', $id2);
				$this->db->update('keubiaya', $data);
			}else{
				$this->db->where('idbiaya', $id2);
				$this->db->delete('keubiaya');
			}
		}
		/*function get_namakeubiaya($id){
			$data = array();
			$sql = "SELECT namaprodi FROM keubiaya WHERE prefkodeprodi = '".$id."'";
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
			$this->db->from("keubiaya");
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
			$this->db->from("keubiaya");
			return $this->db->count_all_results();
		}*/
	}
?>