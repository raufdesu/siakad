<?php
	Class Simdaftarskripsi_m extends Model{
		function __construct(){
			parent::model();
		}
		// function nomor_sk(){
			// return 
		// }
		function get_statusdaftar($nim){
			$sql = "SELECT jenisdaftar FROM simdaftarskripsi WHERE nim = '".$nim."' ";
			$hasil = $this->db->query($sql);
			$res = '';
			foreach($hasil->result() as $a){
				$res  .= $a->jenisdaftar.",";
			};
			return $res;
		}
		function get_arrbysk($nosk){
			$res = '';
			$sql = "SELECT * FROM simdaftarskripsi WHERE nosk = '".$nosk."'";
			$hasil = $this->db->query($sql);
			foreach($hasil->result() as $a){
				$res .= $a->nim.",";
			};
			return substr($res,0,strlen($res)-1);
		}
		function get_onesk($nosk){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nosk = '".$nosk."' LIMIT 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row();
			}
		}
		function cekstatus($nim){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nim = '".$nim."' AND tglakhir > CURDATE()";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function get_bypembimbing($npp1, $jenisdaftar = ''){
			$sql = "SELECT *,(SELECT nama FROM masmahasiswa WHERE nim = simdaftarskripsi.nim)namamhs FROM simdaftarskripsi WHERE pembimbing1 = '".$npp1."' ";
			if($jenisdaftar){
				$sql .= " AND jenisdaftar = '".$jenisdaftar."' ";
			}
			return $this->db->query($sql);
		}
		function cekdaftar(){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nim = '".$this->input->post('nim')."' AND jenisdaftar = '".$this->input->post('jenisdaftar')."'";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function count_sk($cari){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nosk <> '' 
				AND kodeprodi='".$this->session->userdata('sesi_prodi')."' GROUP BY nosk";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function get_sk($limit1='', $limit2='', $jenis_sk=''){
			if($this->session->userdata('sesi_prodi')){
				$data = array();
				$sql = "SELECT * FROM simdaftarskripsi WHERE nosk <> '' 
					AND kodeprodi='".$this->session->userdata('sesi_prodi')."' GROUP BY nosk";
				$sql .= " LIMIT ".$limit1;
				if($limit2 == true){
					$sql .= " ,".$limit2;
				}
				// echo $sql;
				$hasil = $this->db->query($sql);
				if($hasil->num_rows() > 0){
					$data = $hasil->result();
				}
				$hasil->free_result();
				return $data;
			}
		}
		function count_all($cari = ''){
			$data = array();
			if($cari){
				$this->db->where('nim', $cari);
			}
			if($this->session->userdata('sesi_jenisdaftar')){
				$this->db->where('jenisdaftar', $this->session->userdata('sesi_jenisdaftar'));
			}
			$this->db->from('simdaftarskripsi');
			return $this->db->count_all_results();
		}
		function get_all($limit1, $limit2, $cari = '', $kategori='nim'){
			$data = array();
			$sql = "SELECT *,
					(SELECT nama FROM masmahasiswa WHERE nim=daf.nim)nama
					FROM simdaftarskripsi daf WHERE iddaftarskripsi <> '' ";
			if($cari){
				$sql .= " AND ".$kategori." LIKE '%".$cari."%' ";
			}
			if($this->session->userdata('sesi_jenisdaftar')){
				$sql .= " AND jenisdaftar = '".$this->session->userdata('sesi_jenisdaftar')."'";
			}
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
		function count_forbrowse($jenisdaftar=''){
			return 100;
		}
		function get_forbrowse($jenisdaftar = '', $nosk='', $kategori='', $cari='',$thajaran=''){
			$data = array();
			$kodeprodi = $this->session->userdata('sesi_prodi');
			if(!$thajaran){
				$thajaran = $this->auth->get_thactive()->thajaran;
			}
			$sql = "SELECT *,
						(SELECT nama FROM masmahasiswa WHERE nim=daf.nim)nama
						FROM simdaftarskripsi daf WHERE jenisdaftar = '".$jenisdaftar."' AND kodeprodi = '".$kodeprodi."'
						AND nosk = '".$nosk."' AND thajaran = '".$thajaran."' ";
						if($cari){
							$sql .= " AND ".$kategori." LIKE '%".$cari."%' ";
						}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_forbrowse_no($jenisdaftar = '', $kategori='', $cari='', $thajaran=''){
			$data = array();
			$kodeprodi = $this->session->userdata('sesi_prodi');
			if(!$thajaran){
				$thajaran = $this->auth->get_thactive()->thajaran;
			}
			$sql = "SELECT *,
						(SELECT nama FROM masmahasiswa WHERE nim=daf.nim)nama
						FROM simdaftarskripsi daf WHERE jenisdaftar = '".$jenisdaftar."' AND kodeprodi = '".$kodeprodi."'
						AND nosk = '' AND persetujuan = 'Disetujui' AND thajaran = '".$thajaran."' ";
						if($cari){
							$sql .= " AND ".$kategori." LIKE '%".$cari."%' ";
						}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_one2($id){
			$data = array();
			$sql = "SELECT persetujuan,iddaftarskripsi, nim, jenisdaftar, tgldaftar, statusdaftar,
					judulskripsi,thajaran,nosk,tglsk,tglakhir, pembimbing1, pembimbing2,
					(SELECT nama FROM masmahasiswa WHERE nim = daf.nim)namamhs,
					(SELECT nama FROM maspegawai WHERE npp = daf.pembimbing1)nmpembimbing1,
					(SELECT nama FROM maspegawai WHERE npp = daf.pembimbing2)nmpembimbing2
					FROM simdaftarskripsi daf";
			$sql .= " WHERE iddaftarskripsi = '".$id."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_bynosk($nosk){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nosk = '".$nosk."'";
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}
		function get_allbynosk($nosk){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nosk = '".$nosk."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_byid($id){
			$sql = "SELECT *,
					(SELECT nama FROM masmahasiswa WHERE nim = simdaftarskripsi.nim)namamhs,
					(SELECT nama FROM maspegawai WHERE npp = simdaftarskripsi.pembimbing1)namadosen1,
					(SELECT jabatanakademik FROM maspegawai WHERE npp = simdaftarskripsi.pembimbing1)jabatanakademik
					FROM simdaftarskripsi WHERE iddaftarskripsi = ".$id;
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}
		function get_one($nim){
			$data = array();
			$sql = "SELECT iddaftarskripsi, nim, jenisdaftar, tgldaftar, statusdaftar, persetujuan,
					judulskripsi,thajaran,nosk,tglsk,tglakhir,
					(SELECT nama FROM masmahasiswa WHERE nim = daf.nim)namamhs,
					(SELECT nama FROM maspegawai WHERE npp = daf.pembimbing1)nmpembimbing1,
					(SELECT nama FROM maspegawai WHERE npp = daf.pembimbing2)nmpembimbing2
					FROM simdaftarskripsi daf";
			$sql .= " WHERE nim = '".$nim."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function berlakusampai($jenisdaftar){
			if($jenisdaftar == 'KP'){
				$interval = '+6 month';
			}else{
				$interval = '+1 year';
			}
			$date = date('Y-m-d');
			$gendate = strtotime($interval, strtotime($date));
			$newdate = date ( 'Y-m-d' , $gendate );
			return tgl_indo($newdate);
			/* return $newdate;
			$date = date_create(date('Y-m-d'));
			date_add($date, date_interval_create_from_date_string($interval));
			return date_format($date, 'd-m-Y'); */
		}
		function statusdaftar($nim, $jenisdaftar){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nim = '".$nim."' AND jenisdaftar = '".$jenisdaftar."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return 'Melanjutkan';
			}else{
				return 'Baru';
			}
		}
		/* SISTEM INI HANYA SUPPORT SK BERADA PADA SEMESTER DIAKTIFKAN SAJA (secepatnya SK-nya)*/
		function _cekbarudaftar($nim, $jenisdaftar){
			$sql = "SELECT * FROM simdaftarskripsi WHERE nim = '".$nim."' AND jenisdaftar = '".$jenisdaftar."'
					AND persetujuan = 'Belum Disetujui'";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function insert($nim = '', $jenisdaftar = ''){
			if(!$nim){
				$nim = $this->session->userdata('sesi_krs_nim');
			}
			$statusdaftar = $this->statusdaftar($nim, $jenisdaftar);
			$thajaran = $this->auth->get_thactive()->thajaran;
			$tglakhir = $this->berlakusampai($jenisdaftar);
			$kodeprodi = $this->auth->get_prodibynim($nim)->kodeprodi;
			/* $tglakhir = '00-00-0000'; */
			$data = array(
				'nim'			=> $nim,
				'jenisdaftar'	=> $jenisdaftar,
				'tgldaftar'		=> date('Y-m-d'),
				'statusdaftar'	=> $statusdaftar,
				'thajaran'		=> $thajaran,
				'tglakhir'		=> tgl_ingg($tglakhir),
				'kodeprodi'		=> $kodeprodi
			);
			if($this->_cekbarudaftar($nim, $jenisdaftar)){
				$this->db->where('nim', $nim);
				$this->db->where('jenisdaftar', $jenisdaftar);
				$this->db->where('persetujuan', 'Belum Disetujui');
				$this->db->delete('simdaftarskripsi');
			}else{
				$this->db->insert('simdaftarskripsi', $data);
			}
		}
		function insert_mahasiswa(){
			$data = array(
				'pembimbing1' => $this->input->post('npp1'),
				'pembimbing2' => $this->input->post('npp2'),
				'judulskripsi' => $this->input->post('judulskripsi')
			);
			$this->db->where('iddaftarskripsi', $this->input->post('iddaftarskripsi'));
			$this->db->update('simdaftarskripsi', $data);
		}
		function insert_byprodi(){
			$data = array(
				'nim'		=> $this->session->userdata('sesi_krs_nim'),
				'jenisdaftar'	=> $this->input->post('jenisdaftar'),
				'tgldaftar'		=> $this->input->post('tgldaftar'),
				'statusdaftar'	=> $this->input->post('statusdaftar'),
				'pembimbing1'	=> $this->input->post('npp1'),
				'pembimbing2'	=> $this->input->post('npp2'),
				'judulskripsi'	=> $this->input->post('judulskripsi'),
				'thajaran'		=> $this->input->post('thajaran'),
				'persetujuan'	=> $this->input->post('persetujuan')
			);
			if($this->input->post('iddaftarskripsi')){
				$this->db->where('iddaftarskripsi', $this->input->post('iddaftarskripsi'));
				$this->db->update('simdaftarskripsi', $data);
			}
		}
		function _limit_expired($jenisdaftar, $tgl){
			if($jenisdaftar == 'KP'){
				$interval = '6 months';
			}else{
				$interval = '1 years';
			}
			$todayDate = tgl_ingg($tgl);
			$penambahan = strtotime(date("Y-m-d", strtotime($todayDate)) . "+".$interval);
			return date('Y-m-d', $penambahan);

			/* $date = date_create($tgl);
			date_add($date, date_interval_create_from_date_string($interval));
			return date_format($date, 'd-m-Y'); */
		}

		function update_sk($nim){
			$thajaran = $this->auth->get_thactive()->thajaran;
			$tglakhir = $this->_limit_expired($this->input->post('jenisdaftar'), $this->input->post('tglsk'));
			$data = array(
				'nosk'		=> $this->input->post('nosk'),
				'tglsk'		=> tgl_ingg($this->input->post('tglsk')),
				'persetujuan' => 'Disetujui',
				'tglakhir'	=> $tglakhir
			);
			$this->db->where('jenisdaftar', $this->input->post('jenisdaftar'));
			$this->db->where('nim', $nim);
			$this->db->where('thajaran', $thajaran);
			$this->db->update('simdaftarskripsi', $data);
		}
		function update(){
			if($this->input->post('iddaftarskripsi')){
				$this->db->where('iddaftarskripsi', $this->input->post('iddaftarskripsi'));
				$this->db->update('simdaftarskripsi', $data);
			}
		}
		function get_nim($id){
			$sql = "SELECT nim FROM simdaftarskripsi WHERE iddaftarskripsi = ".$id;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function delete($id){
			$this->db->where('iddaftarskripsi', $id);
			$this->db->delete('simdaftarskripsi');
		}
		function reset_sk($nosk){
			$data = array(
				'nosk' => '',
				'tglsk' => '0000-00-00'
			);
			$this->db->where('nosk', $nosk);
			$this->db->update('simdaftarskripsi', $data);
		}
	}
?>