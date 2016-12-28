<?php
	Class Simkrs_m extends Model{
		function __construct(){
			parent::model();
		}
		function getIdkrs($nim, $thajaran = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$this->db->select('idkrs');
			$this->db->from('simkrs');
			$this->db->where('nim', $nim);
			$this->db->where('thajaran', $thajaran);
			$hasil = $this->db->get();
			if($hasil->num_rows()){
				return $hasil->row()->idkrs;
			}else{
				return false;
			}
		}
		function insert_paket($nim, $kodeprodi, $angkatan, $kelas, $thajaran){
			/* $kodeprodi = $this->auth->get_kodeprodibynim($nim); */
			$belumkrsan = $this->cek_sudah_krs($nim, $thajaran);
			if(!$belumkrsan){
				$data1 = array(
					'nim'		=> $nim,
					'thajaran'	=> $thajaran,
					'tanggal'	=> date('Y-m-d H:i:s'),
					'kodeprodi'	=> $kodeprodi,
				);
				$this->db->insert('simkrs', $data1);
				$browse_paket = $this->paket_m->get_all('', '', '', $kodeprodi, $angkatan, $kelas, $thajaran);
				$idkrs = $this->getIdkrs($nim);
				foreach($browse_paket as $bp){
					$data2 = array(
						'idkrs'		=> $idkrs,
						'kodemk'	=> $bp->kodemk,
						'nilaihuruf'=> '',
						'id_kelas_dosen' => '',
						'status'	=> 'baru'
					);
					$this->db->insert('simambilmk', $data2);
				}
				$dpa = $this->simdosenwali_m->get_last_nppdpa($nim);
				$cek_dosenwali = $this->simdosenwali_m->cek_dosenwali($nim, $thajaran);
				if(!$cek_dosenwali){
					$this->simdosenwali_m->insert_dpa($nim, $thajaran, $dpa);
				}
			}else{
				echo $this->simplival->alert('PERINGATAN\nData tidak disimpan kedalam database.\nMahasiswa yang bersangkutan sudah melakukan penginputan KRS');
			}
		}
		function get_thbynim($nim){
			$data = array();
			$sql = "SELECT thajaran FROM simkrs WHERE nim = '".$nim."' ORDER BY thajaran DESC";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
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
		function ceksama_tabel($kodemk,$nim,$thakad){
			$res = '';
			$arkode = $this->get_one_krs($nim,$thakad);
			foreach($arkode->result() as $a){
				$res  .= $a->kodemk.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = '';

			if(preg_match("/\b".$kodemk."\b/i", $res)){
				return true;
			}else{
				return false;
			}
		}
		function cek_waktukrs(){
			$sql = "SELECT aktif FROM simsetting WHERE aktif = 'Aktif' AND CURDATE()
					BETWEEN (SELECT DISTINCT(tglkrsawal) FROM simsetting WHERE aktif = 'Aktif')
					AND (SELECT DISTINCT(tglkrsakhir) FROM simsetting WHERE aktif = 'Aktif')";
			$que = $this->db->query($sql);
			$sql2 = "SELECT aktif FROM simsetting WHERE aktif = 'Aktif' AND CURDATE()
					BETWEEN (SELECT DISTINCT(tglperubahankrsawal) FROM simsetting WHERE aktif = 'Aktif')
					AND (SELECT DISTINCT(tglperubahankrsakhir) FROM simsetting WHERE aktif = 'Aktif')";
			$que2 = $this->db->query($sql2);
			if($que->num_rows() or $que2->num_rows()){
				return 1;
			}else{
				return 0;
			}
		}
		function cek_waktuksp(){
			$sql3 = "SELECT aktif FROM simsetting WHERE aktif = 'Aktif' AND CURDATE()
					BETWEEN (SELECT DISTINCT(tglkspawal) FROM simsetting WHERE aktif = 'Aktif')
					AND (SELECT DISTINCT(tglkspakhir) FROM simsetting WHERE aktif = 'Aktif')";
			$que3 = $this->db->query($sql3);
			if($que3->num_rows()){
				return 1;
			}else{
				return 0;
			}
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
		function count_mhskrs($thajaran, $cari = '', $prodi = ''){
			$res = "";
			$arnimkrs = $this->get_nimkrs($thajaran);
			foreach($arnimkrs as $a){
				$res  .= "'".$a->nim."',";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res=0;

			$sql = "SELECT nim, nama, angkatan FROM masmahasiswa mhs ";
			$sql .= " WHERE nim IN(".$res.")";
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."'";
			}
			if($cari){
				$sql .= " AND nim LIKE '%".$cari."%'";
				$sql .= " OR nama LIKE '%".$cari."%'";
			}
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function get_mhskrs($limit1, $limit2, $thajaran, $cari = '', $prodi = ''){
			$res="";
			$arnimkrs = $this->get_nimkrs($thajaran);
			foreach($arnimkrs as $a){
				$res  .= "'".$a->nim."',";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res=0;

			$sql = "SELECT nim, nama, angkatan FROM masmahasiswa mhs ";
			$sql .= " WHERE nim IN(".$res.")";
			if($prodi){
				$sql .= " AND kodeprodi = '".$prodi."'";
			}
			if($cari){
				$sql .= " AND nim LIKE '%".$cari."%'";
				$sql .= " OR nama LIKE '%".$cari."%'";
			}
			$sql .= " LIMIT ".$limit1;
			if($limit2){
				$sql .= ", ".$limit2;
			}
			// echo $sql;
			return $this->db->query($sql);
		}
		function max_id_krs(){
			$sql = "SELECT MAX(idkrs) max_idkrs FROM simkrs";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function id_pkrs(){
			$sql = "SELECT idkrs FROM simkrs WHERE nim = '".$this->session->userdata('sesi_krs_nim')."'";
			$sql .= " AND thajaran = '".$this->session->userdata('sesi_krs_thajaran_aktif')."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function cek_update(){
			$this->db->from('simkrs');
			$this->db->where('nim', $this->session->userdata('sesi_krs_nim'));
			$this->db->where('thajaran', $this->session->userdata('sesi_krs_thajaran_aktif'));
			return $this->db->count_all_results();
		}
		/* MASIH BERMASALAH */
		function _getIdKrs($nim, $thajaran){
			$data = array();
			$sql = "SELECT idkrs FROM simkrs WHERE nim = '".$nim."' AND thajaran = '".$thajaran."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		/* Update Nilai By Dosen*/
				/* Solusi bug dari pak yuli itu cek kosongnya bukan nilai uts saja oke mas gatot? */
		function update_nilai($nim, $thajaran, $kodemk, $nilai = '', $nilai_angka = ''){
			$id_krs = $this->_getIdKrs($nim, $thajaran);
			$idkrs = $id_krs['idkrs'];
			$data = array(
				'nilaihuruf' => $nilai,
				'nilaiangka' => $nilai_angka
			);
			$this->db->where('kodemk',$kodemk);
			$this->db->where('idkrs',$idkrs);
			$this->db->update('simambilmk', $data);
		}
		function update_nilai_admin($nim, $thajaran, $kodemk, $nilai = '', $nilai_angka = ''){
			$id_krs = $this->_getIdKrs($nim, $thajaran);
			// echo $this->db->query();
			$idkrs = $id_krs['idkrs'];
			
			$data = array(
				'nilaiangka' => $nilai_angka,
				'nilaihuruf' => $nilai
			);
			$this->db->where('kodemk',$kodemk);
			$this->db->where('idkrs',$idkrs);
			$this->db->update('simambilmk', $data);
			
			/* echo $this->db->last_query();*/
		}
		function update_nilai_feeder($nim, $thajaran, $kodemk, $nilai = '', $nilai_angka = ''){
			$nilaiindex = '';
			if ($nilai == 'A')
			{
				$nilaiindex = 4;
			}
			else if ($nilai == 'B')
			{
				$nilaiindex = 3;
			}
			else if ($nilai == 'C')
			{
				$nilaiindex = 2;
			}
			else if ($nilai == 'D')
			{
				$nilaiindex = 1;
			}
			else if ($nilai == 'E')
			{
				$nilaiindex = 0;
			}
			$data2 = array(
				'nilai_angka' => $nilai_angka,
				'nilai_indek' => $nilaiindex,
				'nilai_huruf' => $nilai
			);
			$this->pmb = $this->load->database('pmb', TRUE);
			$this->pmb->where('kode_mk',$kodemk);
			$this->pmb->where('nim',$nim);
			$this->pmb->update('nilai', $data2);
			//$this->pmb->insert('nilai', $data2);
			
			
			
			
			/* echo $this->db->last_query();*/
		}
		/*SELESAI */
		function adm_insert_simkrs(){
			$update = $this->cek_update();
			if($update){
				$id_pkrs = $this->id_pkrs();
				$maxidkrs = $id_pkrs['idkrs'];
			}else{
				$maxkrs = $this->max_id_krs();
				$maxidkrs = $maxkrs['max_idkrs']+1;

				$data = array(
					'idkrs' => $maxidkrs,
					'nim'	=> $this->session->userdata('sesi_krs_nim'),
					'thajaran' => $this->session->userdata('sesi_krs_thajaran_aktif'),
					'tanggal' => date('Y-m-d H:i:s')
				);
				$this->db->insert('simkrs', $data);
			
			}
			foreach($this->cart->contents() as $items):
				$data = array(
					'idkrs' => $maxidkrs,
					'kodemk' => $items['id'],
					'status' => $items['options']['status'],
					'nilaihuruf' => '',
					'id_kelas_dosen' => '',
				);
				$this->db->insert('simambilmk', $data);
			endforeach;
			foreach($this->cart->contents() as $items):
				$data2 = array(
					'nim' => $this->session->userdata('sesi_krs_nim'),
					'nama' => $this->session->userdata('sesi_krs_nama'),
					'kode_mk' => $items['id'],
					'nama_mk' => $items['name'],
					'nama_kelas' => 'A',
					'semester' => $this->session->userdata('sesi_krs_thajaran_aktif'),
					'kode_jurusan' => $this->session->userdata('sesi_krs_kodeprodi'),
					'status_error' => '0',
				);
				$this->pmb = $this->load->database('pmb', TRUE);
				$this->pmb->insert('krs', $data2);
				$this->pmb->insert('nilai', $data2);
				//insert into the second database
				//$this->pmb = $this->load->database('pmb', TRUE);
				//$this->pmb->insert('simambilmk', $data);
			endforeach;
		}
		// CEK QUOTA
		function jumsedia($kodemk, $thajaran){
			$data = array();
			$this->db->select('kuota');
			$this->db->from('simmktawar');
			$this->db->where('kodemk', $kodemk);
			$this->db->where('thajaran', $thajaran);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		function jumpengambil($kodemk, $thajaran){
			$sql = "SELECT COUNT(kodemk)jumambil FROM simambilmk WHERE kodemk = '".$kodemk."'
					AND idkrs IN(SELECT idkrs FROM simkrs WHERE thajaran = '".$thajaran."')";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array			
			}
		}		
		function _cekquota($kodemk = '', $thajaran = ''){
			$jp = $this->jumpengambil($kodemk, $thajaran);
			$jumQ_pengambil = $jp['jumambil'];
			
			$js = $this->jumsedia($kodemk, $thajaran);
			$jumQ_disediakan = $js['kuota'];
			if($jumQ_pengambil >= $jumQ_disediakan){
				return $quo = 1; // Tidak Disimpan, Quota Habis
			}else{
				return $quo = 0; // Disimpan, Quota Masih
			}
		}
		function cekquota_all(){
			$n = 0;
			$thajaran = $this->session->userdata('sesi_thajaran');
			foreach($this->cart->contents() as $items):
				$kodemk = $items['id'];
				$n = $this->_cekquota($kodemk, $thajaran);
				if($n > 0){
					return $kodemk;
				}
			endforeach;
			// return $jum;
		}
		function get_quota(){
			foreach($this->cart->contents() as $items):
				echo $items['id'];
			endforeach; //return false;
		}
		function insert_simkrs(){
			$maxkrs = $this->max_id_krs();
			$maxidkrs = $maxkrs['max_idkrs']+1;

			$data = array(
				'idkrs' => $maxidkrs,
				'nim'	=> $this->session->userdata('sesi_user_mhs'),
				'thajaran' => $this->session->userdata('sesi_thajaran'),
				'tanggal' => date('Y-m-d H:i:s')
			);
			$this->db->insert('simkrs', $data);
			foreach($this->cart->contents() as $items):
				$data = array(
					'idkrs' => $maxidkrs,
					'kodemk' => $items['id'],
					'status' => $items['options']['status'],
					'nilaihuruf' => '',
					'id_kelas_dosen' => '',
				);
				$this->db->insert('simambilmk', $data);
			endforeach;
		}
		function validate_add_cart_item(){			
			$id = $this->input->post('product_id'); // Assign posted product_id to $id
			$cty = $this->input->post('quantity'); // Assign posted quantity to $cty
			
			$this->db->where('id', $id); // Select where id matches the posted id
			$query = $this->db->get('products', 1); // Select the products where a match is found and limit the query by 1
			
			// Check if a row has been found
			if($query->num_rows > 0){
			
				foreach ($query->result() as $row)
				{
					$data = array(
						'id'      => $id,
						'qty'     => $cty,
						'price'   => $row->price,
						'name'    => $row->name
					);

					$this->cart->insert($data); 
					
					return TRUE;
				}
			
			// Nothing found! Return FALSE!	
			}else{
				return FALSE;
			}
		}
		function detail_mahasiswa($nim){
			$sql = "SELECT nim,nama,kdkelas,kodeprodi,(SELECT namaprodi FROM simprodi WHERE kodeprodi=mhs.kodeprodi) nama_prodi, ";
					/* (SELECT LEFT(nim,2) FROM simprodi WHERE kodeprodi=mhs.kodeprodi) pref_prodi, */
				$sql .= "(SELECT jenjang FROM simprodi WHERE kodeprodi=mhs.kodeprodi) jenjang
					FROM masmahasiswa mhs WHERE mhs.nim = '".$nim."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}else{
				return false;
			}
		}
		function detail_mhs($nim, $thakad){
			$id_krs = $this->get_idkrs($nim, $thakad);
			$idkrs = $id_krs['idkrs'];

			$sql = "SELECT nim, nama, kdkelas, kodeprodi, (SELECT namaprodi FROM simprodi WHERE kodeprodi=mhs.kodeprodi) nama_prodi,
					(SELECT jenjang FROM simprodi WHERE kodeprodi = mhs.kodeprodi) jenjang,
					(SELECT tanggal FROM simkrs WHERE simkrs.idkrs = ".$idkrs.")tglkrs
					FROM masmahasiswa mhs WHERE mhs.nim = '".$nim."'";
			return $this->db->query($sql);
		}
		function get_one($nim, $thakad){
			$id_krs = $this->get_idkrs($nim, $thakad);
			$idkrs = $id_krs['idkrs'];
			$sql = "SELECT nim, nama, kdkelas, kodeprodi, (SELECT namaprodi FROM simprodi WHERE kodeprodi=mhs.kodeprodi) nama_prodi,
					(SELECT jenjang FROM simprodi WHERE kodeprodi = mhs.kodeprodi) jenjang,
					(SELECT tanggal FROM simkrs WHERE simkrs.idkrs = ".$idkrs.")tglkrs
					FROM masmahasiswa mhs WHERE mhs.nim = '".$nim."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_namamatkul($kodemk = ''){
			$sql = "SELECT sks, kodemk, namamk FROM simkurikulum kur WHERE
					kodemk = '".$kodemk."'
					AND kodeprodi LIKE '".$this->session->userdata('sesi_krs_prefprodi')."%'";
			$sql .= " LIMIT 1 ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_namamatkulnilai($kodemk = ''){
			$sql = "SELECT sks, kodemk, namamk FROM simkurikulum kur WHERE
					kodemk = '".$kodemk."'";
					/*AND kodeprodi LIKE '".$this->session->userdata('sesi_krs_prefprodi')."%'";
			$sql .= " LIMIT 1 ";*/
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_namamatkul_one($kodemk = '', $thajaran = '', $nim = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$kodeprodi = $this->auth->get_kodeprodibynim($nim);
			$sql = "SELECT sks, kodemk, namamk FROM simkurikulum kur WHERE
					kodemk IN(SELECT twr.kodemk FROM simmktawar twr WHERE twr.thajaran = '".$thajaran."'
					AND twr.kodemk LIKE '%".$kodemk."%')";
			if($kodeprodi){
				$sql .= " AND kodeprodi = '".$kodeprodi."'";
			}
			$sql .= " LIMIT 1 ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_idkrs($nim, $thakad){
			$sql = "SELECT DISTINCT(idkrs) idkrs FROM simkrs WHERE nim='".$nim."' AND thajaran='".$thakad."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function cek_sudah_krs($nim, $thakad){
			$id_krs = $this->get_idkrs($nim, $thakad);
			$idkrs = $id_krs['idkrs'];
			// $idkrs = '8440';
			$sql = "SELECT kodemk, (SELECT DISTINCT(sim.namamk) FROM simkurikulum sim WHERE kodemk = siam.kodemk GROUP BY sim.kodemk) nama_mk,
					(SELECT DISTINCT(s.sks) FROM simkurikulum s WHERE kodemk = siam.kodemk GROUP BY s.kodemk) sks
					FROM simambilmk siam WHERE siam.idkrs = '".$idkrs."'";
			$hasil = $this->db->query($sql);
			return $num = $hasil->num_rows();
			// return $this->db->count_all_results();
		}
		function get_one_krs($nim,$thakad){
			$id_krs = $this->get_idkrs($nim, $thakad);
			$idkrs = $id_krs['idkrs'];
			$sql = "SELECT idkrs,kodemk,status, (SELECT DISTINCT(sim.namamk) FROM simkurikulum sim WHERE kodemk = siam.kodemk GROUP BY sim.kodemk) nama_mk,
					(SELECT DISTINCT(s.sks) FROM simkurikulum s WHERE kodemk = siam.kodemk GROUP BY s.kodemk) sks
					FROM simambilmk siam WHERE siam.idkrs = '".$idkrs."'";
			return $this->db->query($sql);
		}
		function khs_permahasiswa($nim,$thakad){
			$data = array();
			$sql="select kdmk,(select namamk from mastermk where krsmhs.kdmk=mastermk.kdmk 
					AND mastermk.kdprodi IN (select kdprodi from mastermhs where mastermhs.nimmhs = krsmhs.nimmhs))
						as namamk ,
					(select jumlahsks from mastermk where krsmhs.kdmk=mastermk.kdmk AND mastermk.kdprodi IN 
						(select kdprodi from mastermhs where mastermhs.nimmhs = krsmhs.nimmhs)
					) as jumlahsks, nilaimhs 
					from krsmhs where nimmhs='".$nim."' AND thakad='$thakad' order by thakad";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		/* NTAR HABIS SHOLAT DILANJUTKAN 
			MASIH SANGAT KACAU
		*/
		function thajaran_sebelumnya($nim){
			$thajaran_now = $this->session->userdata('sesi_thajaran');
			$sql = "SELECT thajaran FROM simkrs WHERE nim = '".$nim."' AND thajaran <> '".$thajaran_now."' ORDER BY thajaran DESC LIMIT 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function res_sks($nim){
			$prev = $this->thajaran_sebelumnya($nim);
			$thajaran = $prev['thajaran'];
			if($thajaran == false){
				return $sks = 24;
			}else{
				$sql = "SELECT CASE nilaihuruf 
					WHEN 'A' THEN 4 
					WHEN 'B' THEN 3 
					WHEN 'C' THEN 2
					WHEN 'D' THEN 1
					WHEN '' THEN 0 
					END AS nilai,
					(SELECT DISTINCT(sks) FROM simkurikulum WHERE kodemk = simambilmk.kodemk LIMIT 1) sks FROM simambilmk WHERE idkrs IN
						(SELECT idkrs FROM simkrs WHERE nim = '".$nim."' AND thajaran = '".$thajaran."')";
				$hasil = $this->db->query($sql);
				$js = 0; $jn = 0;
				$ip = 0;
				foreach ($hasil->result() as $rec){
					$ns = $rec->nilai * $rec->sks;
					$jn = $jn+$ns;
					$js = $js + $rec->sks;
				}
				if($js == 0){
					$ip = 0;
				}else{
					$ip = substr($jn/$js,0,4);
				}
				if($this->session->userdata('sesi_status') == 'admin'){
					return 24;
				}else{
					if($ip >= 3)
						$sks = 24;
					elseif(($ip >= 2.5) AND ($ip <= 2.99))
						$sks = 21;
					elseif(($ip >= 2) AND ($ip <= 2.49))
						$sks = 18;
					elseif(($ip >= 1.5) AND ($ip <= 1.99))
						$sks = 15;
					else
						$sks = 12;
					return $sks;
				}
				// if($hasil->num_rows() > 0){
					// return $hasil->row_array();
				// }
			}
		}
		function jumsks_one_last($nim){
			$abc = $this->res_sks($nim);
			
			$query = $this->db->query($sql_mhs);
			foreach ($query->result() as $rec)
			{
				$this->insert_simambilmk($rec->nim);
				$this->insert_simkrs('','','');
			}
			return $data;
		}
		function count_sks($nim, $thakad){
			$data = array();
			$this->db->select("SUM(kur.sks) jumsks");
			$this->db->from("akd_kurmk kur");
			$this->db->join("akd_kuliah kul","kur.kdkmk=kul.kdmk");
			$this->db->join("akd_peserta pes","kul.kdkuliah=pes.kdkuliah");
			$this->db->where("kul.thakad",$thakad);
			$this->db->where("pes.nim",$nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		/* FUNCTIN UNTUK TOTAL MUTU, TOTAL SKS*/
		function get_total($nim, $thajaran=''){
			$sql = "SELECT
					SUM(CASE nilaihuruf
					WHEN 'A' THEN 4 * (SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk LIMIT 1)
					WHEN 'B' THEN 3 * (SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk LIMIT 1)
					WHEN 'C' THEN 2 * (SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk LIMIT 1)
					WHEN 'D' THEN 1 * (SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk LIMIT 1)
					WHEN 'E' THEN 0
					END) AS mutu,
					SUM((SELECT sks FROM simkurikulum WHERE kodemk = simambilmk.kodemk LIMIT 1)) jumsks FROM simambilmk WHERE idkrs IN
					(SELECT idkrs FROM simkrs WHERE nim = '".$nim."' ";
			if($thajaran){
				$sql .= " AND thajaran = '".$thajaran."' ";
			}
			$sql .= ")";
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}
		function get_ipk($nim){
			$sql = "SELECT CASE nilaihuruf 
					WHEN 'A' THEN 4 
					WHEN 'B' THEN 3 
					WHEN 'C' THEN 2
					WHEN 'D' THEN 1
					WHEN 'E' THEN 0 
					END AS nilai,
					(SELECT DISTINCT(sks) FROM simkurikulum WHERE kodemk = simambilmk.kodemk LIMIT 1) sks FROM simambilmk WHERE idkrs IN
						(SELECT idkrs FROM simkrs WHERE nim = '".$nim."')";
			$hasil = $this->db->query($sql);
			$js = 0; $jn = 0;
			$ip = 0;
			foreach ($hasil->result() as $rec){
				$ns = $rec->nilai * $rec->sks;
				$jn = $jn+$ns;
				$js = $js + $rec->sks;
			}
			if($jn)
				return substr($jn/$js,0,4);
			else
				return 0;
		}
		function delete_all($nim, $thajaran){
			$idkrs = $this->getIdkrs($nim, $thajaran);
			$this->db->where('idkrs', $idkrs);
			$this->db->delete('simambilmk');

			$this->db->where('nim', $nim);
			$this->db->where('thajaran', $thajaran);
			$this->db->delete('simkrs');
		}
	}
?>