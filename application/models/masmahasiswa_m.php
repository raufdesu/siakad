<?php
	Class Masmahasiswa_m extends Model{
		var $thajaran_aktif;
		function __construct(){
			parent::model();
			$this->thajaran_aktif = '20112';
		}
		function import_pmb($nodaft, $nim){
			$nodaft = $this->input->post('nodaft');
			$nim = $this->input->post('nim');
			
			$conn = mysql_connect('localhost', 'root','');
			mysql_select_db('pmb',$conn);
			
			$sql = "SELECT * FROM siswa WHERE no_daftar = ".$nodaft;
			$que = mysql_query($sql);
			while($d = mysql_fetch_array($que)):
			$kdkelas	= 1;
			if($d['pil_jurusan'] == 'TI'){
				$kodeprodi	= '55201';
			}elseif($d['pil_jurusan'] == 'TI X'){
				$kodeprodi	= '55201';
				$kdkelas	= 2;
			}elseif($d['pil_jurusan'] == 'SI'){
				$kodeprodi	= '57201';
			}elseif($d['pil_jurusan'] == 'MI'){
				$kodeprodi	= '61201';
			}elseif($d['pil_jurusan'] == 'KA'){
				$kodeprodi	= '57402';
			}elseif($d['pil_jurusan'] == 'TK'){
				$kodeprodi	= '56401';
			}
			if($d['jeniskelamin'] == 'L'){
				$jkel = 'L';
			}else{
				$jkel = 'P';
			}
			
			$data = array(
				'nim'		=> $nim,
				'nik'		=> $nik,
				'nama'		=> $d['nama'],
				'kodeprodi'	=> $kodeprodi,
				'kdkelas'	=> $kdkelas,
				'angkatan'	=> date('Y'),
				'statusmasuk'=> $d['status_baru'],
				'alamatasal'=> $d['alamat_rumah'],
				'rt'=> $d['rt'],
				'rw'=> $d['rw'],
				'kodepos'	=> '',
				'alamatjogja'=> '',
				'tlpdiymhs'	=> '',
				'idkabupaten'=> $d['kabupaten'],
				'jeniskelamin'=> $jkel,
				'namaortu'	=> $d['orangtua'],
				'alamatortu'=> $d['pekerjaan_ortu'],
				'kerjaortu'	=> $nim,
				'pddkortu'	=> '',
				'notelportu'=> '',
				'notelpmhs'	=> $d['no_telepon'],
				'email'		=> $d['email'],
				'asalsma'	=> $d['nama_sekolah'],
				'alamatsma'	=> $d['alamat_sekolah'],
				'kodepossma'=> '',
				'jurusansma'=> $d['jurusan'],
				'thlulus'	=> $d['thn_lulus'],
				'tempatlahir'=> $d['tmp_lahir'],
				'tgllahir'	=> $d['tgl_lahir'],
				'tglmasuk'	=> '',
				'agama'		=> $d['agama'],
				'id_agama'	=> $id_agama,
				'asalpt'	=> '',
				'prodiasal'	=> '',
				'statusakademik'=> 'Belum Lulus',
				'statuskrs'	=> 'Close',
				'thlulusmhs'=> $d['thn_lulus'],
				'ipk'		=> 0,
				'skskum'	=> 0,
			);
			endwhile;
			$sql = "UPDATE siswa SET result = 'Diterima' WHERE no_daftar = ".$nodaft;
			mysql_query($sql);
			mysql_close();
			$this->db->insert('masmahasiswa', $data);
		}
		function aktifkan_krs($nim){
			/*$data = array(
				"status_krs" => "open"
			);
			$this->db->where("nimhsmsmhs",$nim);
			$this->db->update("akd_mhs",$data);*/
		}
		
		function nonaktifkan_krs($nim){
			/*$data = array(
				"status_krs" => "close"
			);
			$this->db->where("nimhsmsmhs",$nim);
			$this->db->update("akd_mhs",$data);*/
		}
		
		function cek_aktif_krs($nim){
			/*$this->db->select("status_krs");
			$this->db->from("akd_mhs");
			$this->db->where("nimhsmsmhs",$nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return the row as an associative array
			}*/
		}
		function option_propinsi($idpropinsi = ''){
			$output = '';
			$sql_opt = "SELECT idkabupaten, namakabupaten FROM tkabupaten WHERE idkabupaten LIKE '".$idpropinsi."%'";
			$query = $this->db->query($sql_opt);
			foreach ($query->result() as $category)
			{
				$output .= '<option value="'.$category->no_kab.'">'.$category->nm_kab.'</option>';
			}
			
			return $output;
		}
		function option_kabupaten($idpropinsi = ''){
			$output = '';
			$sql_opt = "SELECT idkabupaten, namakabupaten FROM tkabupaten WHERE idkabupaten LIKE '".$idpropinsi."%'";
			$query = $this->db->query($sql_opt);
			foreach ($query->result() as $category)
			{
				$output .= '<option value="'.$category->no_kab.'">'.$category->nm_kab.'</option>';
			}
			
			return $output;
		}
		function last_angkatan(){
			$sql = 'SELECT DISTINCT(angkatan) AS angkatan FROM masmahasiswa WHERE angkatan <> "" ';
			$sql .= " ORDER BY angkatan DESC LIMIT 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->angkatan;
			}else{
				return false;
			}
		}
		function get_disangkatan(){
			$data = array();
			$sql = "SELECT DISTINCT(angkatan) AS angkatan FROM masmahasiswa WHERE angkatan <> '' ORDER BY angkatan DESC";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function select($limit1, $limit2, $prodi = '', $angkatan = ''){
			$data = array();
			$sql = "SELECT *, kodeprodi kdprod,
						(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi
					FROM masmahasiswa mhs WHERE nim <> '' ";
			if($angkatan){
				$sql .= " AND angkatan = '".$angkatan."'";
			}
			if($this->session->userdata('sesi_shiftmhs')){
				$sql .= " AND kdkelas = '".$this->session->userdata('sesi_shiftmhs')."'";
			}
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."' ";
			}
			if($this->session->userdata('sesi_statusakademik') AND ($this->session->userdata('cari_masmahasiswa'))){
				$sql .= " AND statusakademik = '".$this->session->userdata('sesi_statusakademik')."' ";
				$sql .= " AND nama LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";
				$sql .= " OR nim LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";			
			}elseif($this->session->userdata('cari_masmahasiswa')){
				$sql .= " AND (nama LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";
				$sql .= " OR nim LIKE '%".$this->session->userdata('cari_masmahasiswa')."%') ";
			}elseif($this->session->userdata('sesi_statusakademik')){
				$sql .= " AND statusakademik = '".$this->session->userdata('sesi_statusakademik')."' ";			
			}
			$sql .= " ORDER BY nim DESC ";
			if($limit1 || $limit2){
				$sql .= "LIMIT ".$limit1;
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
		/*function select($limit1, $limit2, $prodi = ''){
			$th = $this->_thajaran_active();
			$thajaran = $th['thajaran'];

			$data = array();
			$sql = "SELECT nim, nama, angkatan, kodeprodi kdprod,
						(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi
					FROM masmahasiswa mhs WHERE nim <> '' ";
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."' ";
			}
			if($this->session->userdata('sesi_statusakademik') AND ($this->session->userdata('cari_masmahasiswa'))){
				$sql .= " AND statusakademik = '".$this->session->userdata('sesi_statusakademik')."' ";
				$sql .= " AND nama LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";
				$sql .= " OR nim LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";			
			}elseif($this->session->userdata('cari_masmahasiswa')){
				$sql .= " AND nama LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";
				$sql .= " OR nim LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";			
			}elseif($this->session->userdata('sesi_statusakademik')){
				$sql .= " AND statusakademik = '".$this->session->userdata('sesi_statusakademik')."' ";			
			}
			if($this->session->userdata('sesi_pendaftar')){
				$sql .= " AND nim IN(SELECT nim FROM simdaftarskripsi WHERE thajaran = '".$thajaran."')";
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
		}*/
		function count_all($prodi = '', $angkatan = ''){
			$data = array();
			$sql = "SELECT nim, nama, angkatan, kodeprodi kdprod,
						(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi
					FROM masmahasiswa mhs WHERE nim <> '' ";
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."'";
			}
			if($angkatan){
				$sql .= " AND angkatan = '".$angkatan."'";
			}
			if($this->session->userdata('sesi_shiftmhs')){
				$sql .= " AND kdkelas = '".$this->session->userdata('sesi_shiftmhs')."'";
			}
			if($this->session->userdata('sesi_statusakademik')){
				$sql .= " AND statusakademik = '".$this->session->userdata('sesi_statusakademik')."'";
			}
			if($this->session->userdata('cari_masmahasiswa')){
				$sql .= " AND (nama LIKE '%".$this->session->userdata('cari_masmahasiswa')."%' ";
				$sql .= " OR nim LIKE '%".$this->session->userdata('cari_masmahasiswa')."%') ";
			}
			return $this->db->query($sql)->num_rows();
		}
		function select_mhs($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_mhs am");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_mhs_sudahambilmk($kodemk, $thajaran, $id_kelas_dosen){
			$data = array();
			$aridkrs = $this->get_idkrssudah_bykodemk($kodemk, $id_kelas_dosen);
			$res="";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res=0;
			$sql = "SELECT (SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim) AS namamhs
					FROM simkrs WHERE thajaran = '".$thajaran."' ";
			$sql .= " AND idkrs IN";
			$sql .= " (".$res.")";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function get_idkrssudah_bykodemk($kodemk, $id_kelas_dosen){
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
		function get_mhs_sudahambilmk($kodemk, $thajaran, $id_kelas_dosen = '', $kelas = ''){
			if($kelas == false){
				$kdkelas = 1;
			}else{
				$kdkelas = $kelas;
			}
			$aridkrs = $this->get_idkrssudah_bykodemk($kodemk, $id_kelas_dosen);
			$res="";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = 0;
				
			/* KALO PADA INPUT NILAI BERMASALAH, NANTI DIPIKIR KEMBALI */
			$sql = "SELECT nim, ";
			/* $sql .= "(SELECT quiz1 FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')quiz1, ";
			$sql .= "(SELECT quiz2 FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')quiz2, ";
			$sql .= "(SELECT quiz3 FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')quiz3, ";
			$sql .= "(SELECT tugas1 FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')tugas1, ";
			$sql .= "(SELECT tugas2 FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')tugas2, ";
			$sql .= "(SELECT tugas3 FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')tugas3, ";
			$sql .= "(SELECT nilaiuts FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaiuts, ";
			$sql .= "(SELECT nilaiuas FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaiuas, "; */
			$sql .= "(SELECT nilaihuruf FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaihuruf, ";
			$sql .= "(SELECT nilaiangka FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaiangka ";
			$sql .= " FROM simkrs WHERE thajaran = '".$thajaran."' ";
			$sql .= " AND idkrs IN";
			$sql .= "(".$res.")";
			/*$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim AND kdkelas = ".$kdkelas.") <> 'NULL' "; */
			$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim) <> 'NULL' ";
			$sql .= " ORDER BY nim ASC ";
			return $this->db->query($sql);
		}
		function get_mhs_nim($kodemk, $thajaran, $id_kelas_dosen = '', $kelas = ''){
			if($kelas == false){
				$kdkelas = 1;
			}else{
				$kdkelas = $kelas;
			}
			$aridkrs = $this->get_idkrssudah_bykodemk($kodemk, $id_kelas_dosen);
			$res="";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = 0;
				
			/* KALO PADA INPUT NILAI BERMASALAH, NANTI DIPIKIR KEMBALI */
			$sql = "SELECT nim";
			$sql .= " FROM simkrs WHERE thajaran = '".$thajaran."' ";
			$sql .= " AND idkrs IN";
			$sql .= "(".$res.")";
			/*$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim AND kdkelas = ".$kdkelas.") <> 'NULL' "; */
			$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim) <> 'NULL' ";
			$sql .= " limit 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		/* MAHASISWA YANG SUDAH MASUK DI PRESENSI (SUDAH DI TENTUKAN KELASNYA) */
		function get_mhs_sudahdipresensi($kodeprodi, $kodemk, $thajaran, $id_kelas_dosen = '', $kelas = ''){
			if($kelas == false){
				$kdkelas = 1;
			}else{
				$kdkelas = $kelas;
			}
			$aridkrs = $this->get_idkrssudah_bykodemk($kodemk, $id_kelas_dosen);
			$res="";
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
			
			$sql .= " AND kodeprodi = ";
			$sql .= "'".$kodeprodi."'";
			
			$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim) <> 'NULL' ";
			$sql .= " ORDER BY nim ASC ";
			return $this->db->query($sql);
		}
		/* function get_mhs_belumdipresensi($kodematkul, $thajaran, $this->session->userdata('sesi_kelas'), $id_kelas_dosen) */
		function get_mhs_belumdipresensi($kodeprodi, $kodemk, $thajaran, $kelas = '', $id_kelas_dosen = ''){
			if($kelas == false){
				$kdkelas = 1;
			}else{
				$kdkelas = $kelas;
			}
			$aridkrs = $this->get_idkrs_bykodemk($kodemk);
			$res="";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res){
				$res = substr($res,0,strlen($res)-1);
			}else{
				$res = 0;
			}
			
			$aridkrs_not = $this->get_idkrs_notbykodemk($id_kelas_dosen);
			$res_not = "";
			foreach($aridkrs_not as $b){
				$res_not .= $b->idkrs.",";
			};
			if($res_not)
				$res_not = substr($res_not,0,strlen($res_not)-1);
			else
				$res_not = 0;

			
			$sql = "SELECT nim,";
			$sql .= " (SELECT id_kelas_dosen FROM simambilmk WHERE idkrs=simkrs.idkrs AND kodemk = '".$kodemk."') AS kelasdosen ";
			$sql .= " FROM simkrs WHERE thajaran = '".$thajaran."' ";
			$sql .= " AND (SELECT nama FROM masmahasiswa WHERE nim = simkrs.nim) <> '' ";
			$sql .= " AND idkrs IN";
			$sql .= "(".$res.")";

			$sql .= " AND idkrs NOT IN";
			$sql .= "(".$res_not.")";
			
			$sql .= " AND kodeprodi = ";
			$sql .= "'".$kodeprodi."'";

			$sql .= " ORDER BY nim ASC ";
			return $this->db->query($sql);
		}
		function get_idkrs_bykodemkx($kodemk){
			// $sql = "SELECT idkrs FROM simambilmk WHERE kodemk = '".$kodemk."' AND id_kelas_dosen = ''";
			$data = array();
			$this->db->select('idkrs');
			$this->db->from('simambilmk');
			$this->db->where('kodemk', $kodemk);
			// $this->db->where('id_kelas_dosen', '');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_mhs_ambilmkx($kodemk, $thajaran, $kelas){
			if($kelas == false){
				$kdkelas = 1;
			}else{
				$kdkelas = $kelas;
			}
			$aridkrs = $this->get_idkrs_bykodemkx($kodemk);
			$res="";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			$res=substr($res,0,strlen($res)-1);
			
			/*$sql = "SELECT nim,(SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim AND kdkelas = ".$kdkelas.") AS namamhs,";*/
			$sql = "SELECT nim,(SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim) AS namamhs,";
			$sql .= "(SELECT nilaihuruf FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaihuruf
					FROM simkrs WHERE thajaran = '".$thajaran."' ";
			$sql .= " AND idkrs IN";
			$sql .= "(".$res.")";
			$sql .= " ORDER BY nim ASC ";
			return $this->db->query($sql);
		}
		function get_idkrs_bykodemk($kodemk){
			$data = array();
			$sql = "SELECT DISTINCT(idkrs) FROM simambilmk WHERE kodemk = '".$kodemk."' ";
			/*$this->db->select('idkrs','id_kelas_dosen');
			$this->db->from('simambilmk');
			$this->db->where('kodemk', $kodemk);*/
			// $this->db->where('id_kelas_dosen', '');
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_mhs_ambilmk($kodemk, $thajaran, $kelas = '', $id_kelas_dosen = ''){
			if($kelas == false){
				$kdkelas = 1;
			}else{
				$kdkelas = $kelas;
			}
			$aridkrs = $this->get_idkrs_bykodemk($kodemk);
			$res="";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res){
				$res = substr($res,0,strlen($res)-1);
			}else{
				$res = 0;
			}
			
			$aridkrs_not = $this->get_idkrs_notbykodemk($id_kelas_dosen);
			$res_not = "";
			foreach($aridkrs_not as $b){
				$res_not .= $b->idkrs.",";
			};
			if($res_not)
				$res_not = substr($res_not,0,strlen($res_not)-1);
			else
				$res_not = 0;

			
			$sql = "SELECT nim,";
			/*$sql .= "(SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim AND kdkelas = ".$kdkelas.") AS namamhs,";*/
			$sql .= "(SELECT nama FROM masmahasiswa WHERE nim=simkrs.nim) AS namamhs,";
			$sql .= "(SELECT id_kelas_dosen FROM simambilmk WHERE idkrs=simkrs.idkrs AND kodemk = '".$kodemk."') AS kelasdosen ";
			/*$sql .= ",(SELECT nilaihuruf FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaihuruf ";*/
			$sql .= " FROM simkrs WHERE thajaran = '".$thajaran."' ";
			/* $sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim = simkrs.nim AND kdkelas = ".$kdkelas.") <> '' "; */
			$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim = simkrs.nim) <> '' ";
			$sql .= " AND idkrs IN";
			$sql .= "(".$res.")";

			$sql .= " AND idkrs NOT IN";
			$sql .= "(".$res_not.")";

			$sql .= " ORDER BY nim ASC ";
			//echo $sql;
			return $this->db->query($sql);
		}
		function get_idkelas($idkelas_dosen){
			$sql = "SELECT kodemk FROM simdosenampu WHERE id_kelas_dosen = ".$idkelas_dosen;
			$hasil = $this->db->query($sql);
			$kodemk = $hasil->row()->kodemk;
			
			$sql2 = "SELECT id_kelas_dosen FROM simdosenampu WHERE kodemk = '".$kodemk."'";
			return $this->db->query($sql2);
		}
		function get_idkrs_notbykodemk($id_kelas_dosen){
			$aridkelas = $this->get_idkelas($id_kelas_dosen);
			$res = "";
			foreach($aridkelas->result() as $k){
				$res  .= $k->id_kelas_dosen.",";
			};
			if($res){
				$res = substr($res,0,strlen($res)-1);
			}else{
				$res = 0;
			}
			//echo $res;
			$data = array();
			$sql = "SELECT DISTINCT(idkrs) FROM simambilmk WHERE id_kelas_dosen IN(".$res.")";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_allmhs_ambilmk($kodemk, $thajaran){
			$aridkrs = $this->get_idkrs_bykodemk($kodemk);
			$res="";
			foreach($aridkrs as $a){
				$res  .= $a->idkrs.",";
			};
			if($res){
				$res = substr($res,0,strlen($res)-1);
			}else{
				$res = 0;
			}
			
			$sql = "SELECT nim,
					(SELECT id_kelas_dosen FROM simambilmk WHERE idkrs=simkrs.idkrs AND kodemk = '".$kodemk."') AS kelasdosen,
					(SELECT nilaihuruf FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaihuruf,
					(SELECT nilaiangka FROM simambilmk WHERE simambilmk.idkrs = simkrs.idkrs AND kodemk = '".$kodemk."')nilaiangka
					FROM simkrs WHERE thajaran = '".$thajaran."' ";
			$sql .= "AND (SELECT nama FROM masmahasiswa WHERE nim = simkrs.nim) <> '' ";
			$sql .= " AND idkrs IN";
			$sql .= "(".$res.")";
			$sql .= " ORDER BY nim ASC ";
			return $this->db->query($sql);
		} 
		
		function select_mhs_transkrip($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_mhs am");
			$this->db->join("akd_peserta pes","am.nimhsmsmhs = pes.nim");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		/* START FOR DPA */
		function select_no_dpa($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_mhs am");
			$this->db->where("am.kdpeg","");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_cari_no_dpa($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_mhs am");
			$this->db->where("am.kdpeg","");
			$this->db->like("am.nmmhsmsmhs",$cari);
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_yes_dpa($limit1, $limit2, $kdpeg){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_mhs am");
			$this->db->where("am.kdpeg",$kdpeg);
			$this->db->limit($limit2,$limit1);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function delete_dpa($nim){
			$data = array(
				"kdpeg" => ""
			);
			$this->db->where("nimhsmsmhs",$nim);
			$this->db->update("akd_mhs",$data);
		}
		/* END MODEL FOR DPA */
		function status_mhs(){
			$data = array();
			$hasil = $this->db->get("tbkod5");
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_cari($limit2,$limit1,$cari,$status_mhs){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_mhs am");
			$this->db->join("akd_prodi ap","ap.kdpst = am.kdpstmsmhs");
			$this->db->like("am.nimhsmsmhs",$cari);
			$this->db->or_like("am.nmmhsmsmhs",$cari);
			if($status_mhs == true){
				$this->db->where("stmhsmsmhs",$status_mhs);
			}
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function cari_mhs($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_mhs am");
			$this->db->join("akd_prodi ap","ap.kdpst = am.kdpstmsmhs");
			$this->db->like("am.nmmhsmsmhs",$cari);
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function count_mhs_yes_per_dpa(){
			$this->db->where("kdpeg",$this->session->userdata("sesi_dosen_dpa"));
			$this->db->from("akd_mhs");
			return $this->db->count_all_results();		
		}
		function count_krs(){
			$this->db->where("kdpeg","");
			$this->db->from("akd_mhs");
			return $this->db->count_all_results();
		}
		function get_one($nim){
			$sql = "SELECT *, kodeprodi kdprod,
					(SELECT LEFT(nim,2) FROM simprodi WHERE kodeprodi=mhs.kodeprodi) pref_prodi,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi
					FROM masmahasiswa mhs ";
			$sql .= " WHERE nim ='".$nim."' ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		function get_kodeprodibynim($nim){
			$sql = "SELECT kodeprodi FROM masmahasiswa ";
			$sql .= " WHERE nim ='".$nim."' ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row()->kodeprodi;
			}else{
				return false;
			}
		}
		function detail($nim){
			$data = array();
			/*$this->db->select("*");
			$this->db->from("masmahasiswa");
			$this->db->join("");
			if($this->session->userdata('cari_masmahasiswa'))
				$this->db->like('nama',$this->session->userdata('cari_masmahasiswa'));
			$this->db->limit($limit1,$limit2);
			*/
			
			$sql = "SELECT *, kodeprodi kdprod,
						(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi,
						(SELECT ijin FROM simprodi WHERE kodeprodi = kdprod) AS ijin_prodi,
						(SELECT status FROM simprodi WHERE kodeprodi = kdprod) AS status_prodi,
						(SELECT judulskripsi FROM simdetailyudisium WHERE nim = '".$nim."')judulskripsi,
						(SELECT totalsks FROM simdetailyudisium WHERE nim = '".$nim."')totalsks,
						(SELECT ipk FROM simdetailyudisium WHERE nim = '".$nim."')ipk,
						(SELECT noijazah FROM simdetailyudisium WHERE nim = '".$nim."')noijazah,
						(SELECT notranskrip FROM simdetailyudisium WHERE nim = '".$nim."')notranskrip,
						(SELECT tglijazah FROM simdetailyudisium WHERE nim = '".$nim."')tglijazah,
						(SELECT tglyudisium FROM simyudisium WHERE idyudisium = (SELECT idyudisium FROM simdetailyudisium WHERE nim = '".$nim."'))tglyudisium
					FROM masmahasiswa mhs ";
			$sql .= " WHERE nim ='".$nim."' ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function detail_mhs_lulus($nim){
			$data = array();
			$this->db->select("*,bio.nama as nama_dpa, t5.nmkodtbkod as nm_keaktifan,t6.nmkodtbkod as nm_pindah,
				tp.nmprotbpro as nama_prop");
			$this->db->from("akd_mhs am");
			$this->db->join("akd_prodi ap","ap.kdpst = am.kdpstmsmhs");
			$this->db->join("tbkod5 t5","t5.kdkodtbkod = am.stmhsmsmhs");
			$this->db->join("tbkod6 t6","t6.kdkodtbkod = am.stpidmsmhs");
			$this->db->join("tbpro tp","tp.kdprotbpro = am.assmamsmhs");
			$this->db->join("peg_biodata bio","am.kdpeg = bio.kdpeg");
			$this->db->join("akd_trlulus lus","am.nimhsmsmhs = lus.nim");
			$this->db->join("akd_trskripsi skr","am.nimhsmsmhs = skr.nim");
			$this->db->where("am.nimhsmsmhs",$nim);
			$this->db->group_by("am.nimhsmsmhs");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function detail_awal($nim){
			$data = array();
			$this->db->select('*');
			$this->db->from('masmahasiswa mhs');
			$this->db->where("mhs.nim",$nim);
			/* $this->db->group_by("mhs.nimmhs"); */
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function auto_nim($kdprodi){
			$this->db->select_max("nimhsmsmhs","jumnim");
			$this->db->from("akd_mhs mhs");
			$this->db->where("mhs.kdpstmsmhs",$kdprodi);
			$this->db->join("akd_prodi prod","mhs.kdpstmsmhs=prod.kdpst");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return the row as an associative array
			}
		}
		
		function update_dpa($nim){
			$data = array(
				"kdpeg" => $this->session->userdata("sesi_dosen_dpa")
			);
			$this->db->where("nimhsmsmhs",$nim);
			$this->db->update("akd_mhs",$data);
		}
		
		function update(){
			if($this->input->post("stpidmsmhs") == "P"){
				$sksdimsmhs = $this->input->post("sksdimsmhs");
				$asnimmsmhs = $this->input->post("asnimmsmhs");
				$aspstmsmhs = $this->input->post("aspstmsmhs");
				$kdpti		= $this->input->post("kdpti");
			}elseif($this->input->post("stpidmsmhs") == "B"){
				$sksdimsmhs = '';
				$asnimmsmhs = '';
				$aspstmsmhs = '';
				$kdpti		= '';			
			}
			$data = array(
				"kdpstmsmhs" => $this->input->post("kdpstmsmhs"),
				"nimhsmsmhs" => $this->input->post("nimhsmsmhs"),
				"nmmhsmsmhs" => $this->input->post("nmmhsmsmhs"),
				"shiftmsmhs" => $this->input->post("shiftmsmhs"),
				"tplhrmsmhs" => $this->input->post("tplhrmsmhs"),
				"tglhrmsmhs" => tgl_ingg($this->input->post("tglhrmsmhs")),
				"kdjekmsmhs" => $this->input->post("kdjekmsmhs"),
				"tahunmsmhs" => $this->input->post("tahunmsmhs"),
				"smawlmsmhs" => $this->input->post("smawlmsmhs"),
				"btstumsmhs" => $this->input->post("btstumsmhs"),
				"assmamsmhs" => $this->input->post("assmamsmhs"),
				"tgmskmsmhs" => tgl_ingg($this->input->post("tgmskmsmhs")),
				"tgllsmsmhs" => tgl_ingg($this->input->post("tgllsmsmhs")),
				"stmhsmsmhs" => $this->input->post("stmhsmsmhs"),
				"stpidmsmhs" => $this->input->post("stpidmsmhs"),
				"sksdimsmhs" => $sksdimsmhs,
				"asnimmsmhs" => $asnimmsmhs,
				"asptimsmhs" => $kdpti,
				"aspstmsmhs" => $aspstmsmhs
			);
			$this->db->where("nimhsmsmhs",$this->input->post("nimhsmsmhs"));
			$this->db->update("akd_mhs",$data);
		}

		function delete($nim){
			$this->db->where("nim",$nim);
			$this->db->delete("masmahasiswa");
		}
		function insert(){
			$nm_kk = implode(",", $_POST['id_kk']);
			$sql10 = "SELECT id_kk from kebutuhan_khusus WHERE nm_kk = '".$nm_kk."'";
			$hasil = mysql_query($sql10);
			$idkkmhs = mysql_fetch_row($hasil);
			$nm_kk_ayah = implode(",", $_POST['id_kebutuhan_khusus_ayah']);
			$sql11 = "SELECT id_kk from kebutuhan_khusus WHERE nm_kk = '".$nm_kk_ayah."'";
			$hasil2 = mysql_query($sql11);
			$idkkayah = mysql_fetch_row($hasil2);
			$nm_kk_ibu = implode(",", $_POST['id_kebutuhan_khusus_ibu']);
			$sql12 = "SELECT id_kk from kebutuhan_khusus WHERE nm_kk = '".$nm_kk_ibu."'";
			$hasil3 = mysql_query($sql12);
			$idkkibu = mysql_fetch_row($hasil3);
			$agama = explode (",", $_POST['agama']);
			$statusmasuk = explode (",", $_POST['statusmasuk']);
			$jeniskelamin = explode (",", $_POST['jeniskelamin']);
			$angkatan = $_POST['angkatan'];
			$mulai_smt = str_pad($angkatan, 5, '1', STR_PAD_RIGHT);
			$tgl_lahir_ayah = tgl_ingg($_POST['tgl_lahir_ayah']);
			if($tgl_lahir_ayah == '--')
			{
				$tgl_lahir_ayah = '';
			}
			$tgl_lahir_ibu = tgl_ingg($_POST['tgl_lahir_ibu']);
			if($tgl_lahir_ibu == '--')
			{
				$tgl_lahir_ibu = '';
			}
			$tgl_lahir_wali = tgl_ingg($_POST['tgl_lahir_wali']);
			if($tgl_lahir_wali == '--')
			{
				$tgl_lahir_wali = '';
			}
			$data = array(
				"nim" => $this->input->post("nim"),
				"nik" => $this->input->post("nik"),
				"nama" => $this->input->post("nama"),
				"kodeprodi" => $this->input->post("kodeprodi"),
				"kdkelas" => $this->input->post("kdkelas"),
				"angkatan" => $this->input->post("angkatan"),
				"statusmasuk" => $statusmasuk[0],
				"alamatasal" => $this->input->post("alamatasal"),
				"nm_dsn" => $this->input->post("nm_dsn"),
				"ds_kel" => $this->input->post("ds_kel"),
				"rt" => $this->input->post("rt"),
				"rw" => $this->input->post("rw"),
				"nisn" => $this->input->post("nisn"),
				"alamatsekarang" => $this->input->post("alamatsekarang"),
				"idkabupaten" => $this->input->post("kabupaten"),
				"jeniskelamin" => $jeniskelamin[0],
				"nm_ayah" => $this->input->post("nm_ayah"),
				"tempatlahir_ayah" => $this->input->post("tempatlahir_ayah"),
				"tgl_lahir_ayah" => tgl_ingg($this->input->post("tgl_lahir_ayah")),
				"nik_ayah" => $this->input->post("nik_ayah"),
				"id_jenjang_pendidikan_ayah" => $this->input->post("id_jenjang_pendidikan_ayah"),
				"id_pekerjaan_ayah" => $this->input->post("id_pekerjaan_ayah"),
				"id_penghasilan_ayah" => $this->input->post("id_penghasilan_ayah"),
				"nm_ibu_kandung" => $this->input->post("nm_ibu_kandung"),
				"tempatlahir_ibu" => $this->input->post("tempatlahir_ibu"),
				"tgl_lahir_ibu" => tgl_ingg($this->input->post("tgl_lahir_ibu")),
				"nik_ibu" => $this->input->post("nik_ibu"),
				"id_jenjang_pendidikan_ibu" => $this->input->post("id_jenjang_pendidikan_ibu"),
				"id_pekerjaan_ibu" => $this->input->post("id_pekerjaan_ibu"),
				"id_penghasilan_ibu" => $this->input->post("id_penghasilan_ibu"),
				"nm_wali" => $this->input->post("nm_wali"),
				"tempatlahir_wali" => $this->input->post("tempatlahir_wali"),
				"tgl_lahir_wali" => tgl_ingg($this->input->post("tgl_lahir_wali")),
				"id_jenjang_pendidikan_wali" => $this->input->post("id_jenjang_pendidikan_wali"),
				"id_pekerjaan_wali" => $this->input->post("id_pekerjaan_wali"),
				"id_penghasilan_wali" => $this->input->post("id_penghasilan_wali"),
				"alamatortu" => $this->input->post("alamatortu"),
				"notelportu" => $this->input->post("notelportu"),
				"notelpmhs" => $this->input->post("notelpmhs"),
				"email" => $this->input->post("email"),
				"a_terima_kps" => $this->input->post("a_terima_kps"),
				"no_kps" => $this->input->post("no_kps"),
				"npwp" => $this->input->post("npwp"),
				//"id_wil" => $this->input->post("id_wil"),
				"id_jns_tinggal" => $this->input->post("jenis_tinggal"),
				"id_alat_transport" => $this->input->post("alat_transport"),
				"kewarganegaraan" => $this->input->post("wilayah"),
				"asalsma" => $this->input->post("asalsma"),
				"jurusansma" => $this->input->post("jurusansma"),
				"tempatlahir" => $this->input->post("tempatlahir"),
				"tgllahir" => tgl_ingg($this->input->post("tgllahir")),
				"tglmasuk" => tgl_ingg($this->input->post("tglmasuk")),
				"agama" => $agama[0],
				"id_agama" => $agama[1],
				"asalpt" => $this->input->post("asalpt"),
				"prodiasal" => $this->input->post("prodiasal"),
				"statusakademik" => $this->input->post("statusakademik"),
				"statuskrs" => $this->input->post("statuskrs"),
				"kodepos" => $this->input->post("kodepos"),
				"thlulus" => $this->input->post("thlulus"),
				"alamatsma" => $this->input->post("alamatsma"),
				"kodepossma" => $this->input->post("kodepossma"),
				"statuspaket" => $this->input->post("statuspaket"),
				"id_kk" => $nm_kk,
				"id_kk_ayah" => $nm_kk_ayah,
				"id_kk_ibu" => $nm_kk_ibu
			);
			$data2 = array(
				"nm_pd" => $this->input->post("nama"),
				"jk" => $jeniskelamin[1],
				"nisn" => $this->input->post("nisn"),
				"npwp" => $this->input->post("npwp"),
				"nik" => $this->input->post("nik"),
				"tmpt_lahir" => $this->input->post("tempatlahir"),
				"tgl_lahir" => tgl_ingg($this->input->post("tgllahir")),
				"id_agama" => $agama[1],
				"id_kk" => $idkkmhs[0],
				"jln" => $this->input->post("alamatsekarang"),
				"rt" => $this->input->post("rt"),
				"rw" => $this->input->post("rw"),
				"nm_dsn" => $this->input->post("nm_dsn"),
				"ds_kel" => $this->input->post("ds_kel"),
				"id_wil" => $this->input->post("kecamatan"),
				"kode_pos" => $this->input->post("kodepos"),
				"id_jns_tinggal" => $this->input->post("jenis_tinggal"),
				"id_alat_transport" => $this->input->post("alat_transport"),
				"no_tel_rmh" => $this->input->post("notelportu"),
				"no_hp" => $this->input->post("notelpmhs"),
				"email" => $this->input->post("email"),
				"a_terima_kps" => $this->input->post("a_terima_kps"),
				"no_kps" => $this->input->post("no_kps"),
				"stat_pd" => 'A',
				"nik_ayah" => $this->input->post("nik_ayah"),
				"nm_ayah" => $this->input->post("nm_ayah"),
				"tgl_lahir_ayah" => $tgl_lahir_ayah,
				"id_jenjang_pendidikan_ayah" => $this->input->post("id_jenjang_pendidikan_ayah"),
				"id_pekerjaan_ayah" => $this->input->post("id_pekerjaan_ayah"),
				"id_penghasilan_ayah" => $this->input->post("id_penghasilan_ayah"),
				"id_kebutuhan_khusus_ayah" => $idkkayah[0],
				"nik_ibu" => $this->input->post("nik_ibu"),
				"nm_ibu_kandung" => $this->input->post("nm_ibu_kandung"),
				"tgl_lahir_ibu" => $tgl_lahir_ibu,
				"id_jenjang_pendidikan_ibu" => $this->input->post("id_jenjang_pendidikan_ibu"),
				"id_pekerjaan_ibu" => $this->input->post("id_pekerjaan_ibu"),
				"id_penghasilan_ibu" => $this->input->post("id_penghasilan_ibu"),
				"id_kebutuhan_khusus_ibu" => $idkkibu[0],
				"nm_wali" => $this->input->post("nm_wali"),
				"tgl_lahir_wali" => $tgl_lahir_wali,
				"id_jenjang_pendidikan_wali" => $this->input->post("id_jenjang_pendidikan_wali"),
				"id_pekerjaan_wali" => $this->input->post("id_pekerjaan_wali"),
				"id_penghasilan_wali" => $this->input->post("id_penghasilan_wali"),
				"kewarganegaraan" => $this->input->post("wilayah")
			);
			$data3 = array(
				"kode_jurusan" => $this->input->post("kodeprodi"),
				"id_jns_daftar" => $statusmasuk[1],
				"nipd" => $this->input->post("nim"),
				"tgl_masuk_sp" => tgl_ingg($this->input->post("tglmasuk")),
				"mulai_smt" => $mulai_smt
			);
			if($this->input->post('nim2')){
				$this->db->where('nim', $this->input->post('nim2'));
				$this->db->update("masmahasiswa", $data);
				//$this->pmb = $this->load->database('pmb', TRUE);
				//$this->pmb->update('mhs', $data2);
			}else{
				$this->db->trans_start();
					$this->db->insert("masmahasiswa", $data);
					$this->_insert_login($this->input->post('nim'), $this->input->post('nama'));
					$this->_insert_simaktifsemester($this->input->post('nim'));
				$this->db->trans_complete();
				$this->pmb = $this->load->database('pmb', TRUE);
					$this->pmb->insert('mhs', $data2);
					$last_id = $this->pmb->insert_id();
					$last = array('id_mhs' => $last_id);
					$data3 = array_merge($data3,$last);
					$this->pmb->insert('mhs_pt', $data3);
					
			}
			$data["sem"] = $mulai_smt;
			$data["jurusan"] = $_POST['kodeprodi'];
			$this->load->view("admin/push_mhs",$data);
		}
		function get_angkatan(){
			$data = array();
			$this->db->select('angkatan');
			$this->db->from('masmahasiswa');
			$this->db->order_by('angkatan', 'DESC');
			$this->db->group_by('angkatan');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
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
		function _insert_login($nim='', $namanya=''){
			$nama = str_replace("'","",$nim);
			$data = array(
				/* "password" => str_shuffle($this->input->post("nim")."ABC"), */
				"nim"	=> $nim,
				"password" => strtok($nama,' '),
				"status"	=> 2
			);
			$this->db->insert("loginmhs", $data);
		}
		function _thajaran_active(){
			$data = array();
			$this->db->from('simsetting');
			$this->db->where('aktif', 'Aktif');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_namabynim($nim){
			$this->db->select('nama');
			$this->db->from('masmahasiswa');
			$this->db->where('nim', $nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row()->nama;
			}else{
				return false;
			}
		}
	}
?>