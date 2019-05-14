<?php
	Class Simaktifsemester_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_bystatus($limit1, $limit2, $prodi = '', $thajaran = '', $status = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$data = array();
			$sql = "SELECT mhs.nim, nama, kodeprodi kdprod,
						(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi,
						(SELECT status FROM simaktifsemester WHERE nim = mhs.nim AND thajaran = '".$thajaran."') AS status
					FROM masmahasiswa mhs LEFT JOIN simaktifsemester aksem ON mhs.nim=aksem.nim WHERE
					aksem.thajaran = '".$thajaran."' AND 
					mhs.nim IN (SELECT nim FROM simaktifsemester WHERE thajaran = '".$thajaran."') ";
			if($prodi){
				$sql .= " AND kodeprodi = ".$prodi." ";
			}
			if($status){
				$sql .= " AND aksem.status = '".$status."' ";
			}
			if($this->session->userdata('cari_simaktifsemester')){
				/*$sql .= " AND nama LIKE '%".$this->session->userdata('cari_simaktifsemester')."%' "; */
				$sql .= " AND mhs.nim LIKE '%".$this->session->userdata('cari_simaktifsemester')."%' ";			
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
		function count_bystatus($prodi = '', $thajaran = '', $status = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$data = array();
			$sql = "SELECT mhs.nim
					FROM masmahasiswa mhs LEFT JOIN simaktifsemester aksem ON mhs.nim=aksem.nim WHERE
					aksem.thajaran = '".$thajaran."' AND 
					mhs.nim IN (SELECT nim FROM simaktifsemester WHERE thajaran = '".$thajaran."') ";
			if($prodi){
				$sql .= " AND kodeprodi = ".$prodi." ";
			}
			if($status){
				$sql .= " AND aksem.status = '".$status."' ";
			}
			if($this->session->userdata('cari_simaktifsemester')){
				/*$sql .= " AND nama LIKE '%".$this->session->userdata('cari_simaktifsemester')."%' "; */
				$sql .= " AND mhs.nim LIKE '%".$this->session->userdata('cari_simaktifsemester')."%' ";			
			}
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
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
		function nim_aktifsemester($thajaran, $status){
			$data = array();
			$sql = "SELECT nim FROM simaktifsemester WHERE thajaran = '".$thajaran."' AND status = '".$status."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_jumstatus($prodi, $thajaran, $status){
			$res = '';
			$arnim = $this->nim_aktifsemester($thajaran, $status);
			foreach($arnim as $a){
				$res  .= "'".$a->nim."',";
			};
			if($res){
				$res=substr($res,0,strlen($res)-1);
			}else{
				$res = "''";
			}
			$sql = "SELECT COUNT(nim)jumstatus FROM masmahasiswa WHERE kodeprodi = '".$prodi."'";
			$sql .= " AND nim IN(".$res.")";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->jumstatus;
			}else{
				return false;
			}
		}
		function get_totjumstatus($thajaran, $status){
			$res = '';
			$arnim = $this->nim_aktifsemester($thajaran, $status);
			foreach($arnim as $a){
				$res  .= "'".$a->nim."',";
			};
			if($res){
				$res=substr($res,0,strlen($res)-1);
			}else{
				$res = "''";
			}
			$sql = "SELECT COUNT(nim)jumstatus FROM masmahasiswa WHERE nim IN(".$res.")";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->jumstatus;
			}else{
				return false;
			}
		}
		function cek_aktifsemester($nim, $thajaran = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$this->db->select('*');
			$this->db->from('simaktifsemester');
			$this->db->where('nim', $nim);
			$this->db->where('status', 'Aktif');
			$this->db->where('thajaran', $thajaran);
			return $this->db->count_all_results();
		}
		/*function export_toaktifsemester(){
			$output = '';
			//$sql_mhs = "SELECT masmahasiswa.nim, simaktifsemester.status, masmahasiswa.statusakademik FROM masmahasiswa, simaktifsemester  WHERE statusakademik ='Belum Lulus' and masmahasiswa.nim = simaktifsemester.nim group by masmahasiswa.nim";
			$sql_mhs = "SELECT nim, statusakademik FROM masmahasiswa WHERE statusakademik ='Belum Lulus'";
			$query = $this->db->query($sql_mhs);
			foreach ($query->result() as $rec)
			{
				$this->insert($rec->nim, $rec->status);
			}
			
			return $output;
		}*/
		function export_toaktifsemester(){
			$output = '';
			$sql_mhs = "SELECT nim, statusakademik FROM masmahasiswa WHERE statusakademik ='Belum Lulus'";
			$query = $this->db->query($sql_mhs);
			foreach ($query->result() as $rec)
			{
				$this->insert($rec->nim);
			}
			
			return $output;
		}
		function insert_one(){
			$thajaran_active = $this->thajaran_active();
			$thajaran = $thajaran_active['thajaran'];
			$data = array(
				"nim" => $this->input->post('nim'),
				"thajaran" => $thajaran,
				"status" => $this->input->post('status'),
				"tglaktifkan" => date('Y-m-d H:i:s')
			);
			$this->db->insert("simaktifsemester",$data);
		}
		/*function insert($nim, $status){
			if ($status == 'Aktif'){
			$thajaran_active = $this->thajaran_active();
			$thajaran = $thajaran_active['thajaran'];
			$data = array(
				"nim" => $nim,
				"thajaran" => $thajaran,
				"status" => '-',
			);
			$this->db->insert("simaktifsemester",$data);
			}
			else{
			$thajaran_active = $this->thajaran_active();
			$thajaran = $thajaran_active['thajaran'];
			$data = array(
				"nim" => $nim,
				"thajaran" => $thajaran,
				"status" => $status,
			);
			$this->db->insert("simaktifsemester",$data);
			}
		}*/
		function insert($nim){
			$thajaran_active = $this->thajaran_active();
			$thajaran = $thajaran_active['thajaran'];
			$data = array(
				"nim" => $nim,
				"thajaran" => $thajaran,
				"status" => 'Non Aktif',
			);
			$this->db->insert("simaktifsemester",$data);
		}
		function cek_to_move(){
			$thajaran_active = $this->thajaran_active();
			$thajaran = $thajaran_active['thajaran'];
			$this->db->select('nim');
			$this->db->from('simaktifsemester');
			$this->db->where('thajaran', $thajaran);
			return $this->db->count_all_results();
		}
		function select_mhs($limit1, $limit2, $prodi = '', $thajaran = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$data = array();
			$sql = "SELECT mhs.nim, nama, kodeprodi kdprod, angkatan, status, thajaran, ";
			$sql .= " (SELECT jenjang FROM simprodi WHERE kodeprodi = kdprod) AS jenjang,
						(SELECT namaprodi FROM simprodi WHERE kodeprodi = kdprod) AS nama_prodi ";
			$sql .= " FROM masmahasiswa mhs INNER JOIN simaktifsemester aksem ON mhs.nim=aksem.nim WHERE
					aksem.thajaran = '".$thajaran."' ";
			/* $sql .= " AND mhs.nim IN (SELECT nim FROM simaktifsemester WHERE thajaran = '".$thajaran."') "; */
			if($prodi){
				$sql .= " AND kodeprodi = ".$prodi." ";
			}
			if($this->session->userdata('sesi_statussem')){
				$sql .= " AND aksem.status = '".$this->session->userdata('sesi_statussem')."' ";
			}
			if($this->session->userdata('cari_simaktifsemester')){
				$sql .= " AND (nama LIKE '%".$this->session->userdata('cari_simaktifsemester')."%' ";
				$sql .= " OR mhs.nim LIKE '%".$this->session->userdata('cari_simaktifsemester')."%') ";
			}
			$sql .= " ORDER BY nim";
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
		function count_all_mhs($prodi = '', $thajaran = ''){
			if(!$thajaran){
				$act = $this->thajaran_active();
				$thajaran = $act['thajaran'];
			}
			$data = array();
			$sql = "SELECT mhs.nim, nama, kodeprodi kdprod
					FROM masmahasiswa mhs LEFT JOIN simaktifsemester aksem ON mhs.nim=aksem.nim WHERE
					aksem.thajaran = '".$thajaran."'
					AND mhs.nim IN(SELECT nim FROM simaktifsemester WHERE thajaran = '".$thajaran."')";
			if($prodi){
				$sql .= " AND kodeprodi = ".$prodi." ";
			}
			if($this->session->userdata('sesi_statussem')){
				$sql .= " AND aksem.status = '".$this->session->userdata('sesi_statussem')."' ";
			}
			if($this->session->userdata('cari_simaktifsemester')){
				$sql .= " AND (mhs.nim LIKE '%".$this->session->userdata('cari_simaktifsemester')."%' ";
				$sql .= " OR nama LIKE '%".$this->session->userdata('cari_simaktifsemester')."%') ";
			}
			return $this->db->query($sql)->num_rows();
		}
		function statuskan($nim, $status, $thajaran = ''){
			if($status != 'Aktif'){
				$paket = $this->masmahasiswa_m->get_one($nim);
				if($paket['statuspaket'] == 'paket'){
					$this->simkrs_m->delete_all($nim, $thajaran);
				}
			}
			$data = array(
				'status' => $status,
				'tglaktifkan' => date('Y-m-d H:i:s')
			);
			$this->db->where('thajaran', $thajaran);
			$this->db->where("nim", $nim);
			$this->db->update("simaktifsemester", $data);
		}
		/*
		function select_mk(){
			$data = array();
			$sql = "SELECT *,(SELECT namamk FROM simnamamk nm WHERE nm.kodenama = kur.kodenama) AS nama_mk FROM simkurikulum kur WHERE 
					kur.kodemk NOT IN
					(SELECT tawar.kodemk FROM simaktifsemester tawar)";
			if($this->session->userdata('sesi_prodi')){
				$sql .= " AND kur.kodeprodi = '".$this->session->userdata('sesi_prodi')."'";
			}
			if($this->session->userdata('sesi_semester')){
				$sql .= " AND kur.semester = '".$this->session->userdata('sesi_semester')."'";
			}
			if($this->session->userdata('sesicari_matakuliah')){
				$sql .= " AND kur.kodemk LIKE '%".$this->session->userdata('sesicari_matakuliah')."%'";
				// $sql .= " OR nama_mk LIKE '%".$this->session->userdata('sesicari_matakuliah')."%'";
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function cek_kodemk($kodemk){
			$data = array();
			$this->db->select("kodemk");
			$this->db->from("simaktifsemester");
			$this->db->where("kodemk",$kodemk);
			return $this->db->count_all_results();
		}

		function select_cari($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab");
			$this->db->from("simaktifsemester ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			$this->db->join("tbkod2 t2","ad.jabakad = t2.kdkodtbkod");
			$this->db->like("nama",$cari);
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($kodemk){
			$data = array();
			$this->db->select("*");
			$this->db->from("simaktifsemester");
			$this->db->join("simnamamk","simaktifsemester.kodenama = simnamamk.kodenama");
			$this->db->join("simprodi","simaktifsemester.kodeprodi = simprodi.kodeprodi");
			$this->db->where("kodemk",$kodemk);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function update(){
			$data = array(
				"kodemk" => $this->input->post("kodemk"),
				"kodenama" => $this->input->post("kodenama"),
				"kodeprodi" => $this->input->post("kodeprodi"),
				"sks" => $this->input->post("sks"),
				"teori_praktek" => $this->input->post("teori_praktek"),
				"wajib_pilihan" => $this->input->post("wajib_pilihan"),
				"semester" => $this->input->post("semester"),
				"inti" => $this->input->post("inti"),
				"sifat" => $this->input->post("sifat"),
				"prasyarat" => $this->input->post("prasyarat"),
				"thnkur" => $this->input->post("thnkur")
			);
			$this->db->where("kodemk",$this->input->post("kodemk2"));
			$this->db->update("simaktifsemester",$data);
		}
		*/

		function delete($nim, $thajaran){
			$this->db->where('nim', $nim);
			$this->db->where('thajaran', $thajaran);
			$this->db->delete('simaktifsemester');
		}
	}
?>