<?php
	Class Simmktawar_m extends Model{
		function __construct(){
			parent::model();
		}
		/*function selectThKurikulum(){
			$data = array();
			$this->db->select('thnkur');
			$this->db->from("simmktawar");
			$this->db->group_by('thnkur');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
			
		}*/
		function get_cari_all($limit1 = '', $field = '', $value = ''){
			$data = array();
			$sql = "SELECT kodemk, (SELECT namamk FROM simkurikulum WHERE kodemk = simmktawar.kodemk)namamk,
					(SELECT sks FROM simkurikulum WHERE kodemk = simmktawar.kodemk)sks,
					(SELECT semester FROM simkurikulum WHERE kodemk = simmktawar.kodemk)semester
					FROM simmktawar ";
			if($field == 'nama'){
				$sql .= " WHERE kodemk IN(SELECT kodemk FROM simkurikulum WHERE namamk LIKE '%".$value."%')";
			}elseif($field == 'kode'){
				$sql .= " WHERE kodemk LIKE '%".$value."%' ";
			}
			$sql .= " LIMIT ".$limit1;
			return $this->db->query($sql);
		}
		function get_namamatkul_one($kodemk = '', $kodeprodi = ''){
			$sql = "SELECT sks, kodemk, namamk, kodeprodi FROM matkul kur WHERE
					kodemk IN(SELECT twr.kodemk FROM matkul_kurikulum twr WHERE twr.kodemk LIKE '%".$kodemk."%')
					and kodeprodi = '".$kodeprodi."'";
			$sql .= " LIMIT 1 ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
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
		function cekquota($kodemk='', $thajaran=''){
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
		function update_quota($kodemk){
			if($this->session->userdata('sesi_thajaran')){
				$data = array(
					'kuota' => $this->input->post('quota')
				);
				$this->db->where('thajaran',$this->session->userdata('sesi_thajaran'));
				$this->db->where('kodemk',$kodemk);
				$this->db->update('simmktawar', $data);
			}
		}
		function cekangkatan($nim){
			$sql = "select id_smt from kurikulum_sp INNER JOIN masmahasiswa on kurikulum_sp.kodeprodi = masmahasiswa.kodeprodi 
					INNER JOIN matkul_kurikulum on matkul_kurikulum.id_kurikulum_sp = kurikulum_sp.id_kurikulum
					where angkatan >= SUBSTR(id_smt,1,4) and nim = '".$nim."' ORDER BY id_smt desc limit 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_byprodi($kodeprodi='',$semester='',$nim=''){
			$data = array();
			$cek_angkatan = $this->cekangkatan($nim);
			$angkatan = $cek_angkatan['id_smt'];
			if($semester % 2 == 0){
			$sql = "SELECT matkul.kodemk,matkul.kodeprodi,matkul.namamk,matkul.sks,
					matkul_kurikulum.smt AS semester,
					kurikulum_sp.id_smt AS thnkur,
					kurikulum_sp.nm_kurikulum_sp AS nmkurikulum 
					FROM matkul inner join matkul_kurikulum on matkul_kurikulum.id_mk = matkul.id_mk inner join kurikulum_sp on 
					kurikulum_sp.id_kurikulum = matkul_kurikulum.id_kurikulum_sp";
			$sql .= " WHERE matkul.kodemk <> '' and kurikulum_sp.kodeprodi =  '".$kodeprodi."' and (matkul_kurikulum.smt%2)=0 
					and kurikulum_sp.id_smt = '".$angkatan."' order by kurikulum_sp.id_smt DESC, matkul_kurikulum.smt";
			return $this->db->query($sql);
			}else
			{
			$sql = "SELECT matkul.kodemk,kurikulum_sp.kodeprodi,matkul.namamk,matkul.sks,
					matkul_kurikulum.smt AS semester,
					kurikulum_sp.id_smt AS thnkur,
					kurikulum_sp.nm_kurikulum_sp AS nmkurikulum 
					FROM matkul_kurikulum inner join matkul on matkul.id_mk = matkul_kurikulum.id_mk inner join kurikulum_sp on 
					kurikulum_sp.id_kurikulum = matkul_kurikulum.id_kurikulum_sp";
			$sql .= " WHERE matkul.kodemk <> '' AND kurikulum_sp.kodeprodi = '".$kodeprodi."' and (matkul_kurikulum.smt%2)>0 order by kurikulum_sp.id_smt DESC, matkul_kurikulum.smt";
			return $this->db->query($sql);
			}
		}
		function get_idkrs($thajaran){
			$sql = "SELECT idkrs FROM simkrs WHERE thajaran = '".$thajaran."'";
			return $this->db->query($sql);
		}
		function count_pengambil($kodemk, $thajaran = ''){
			if(!$thajaran){
				$thajaran = $this->auth->get_thactive()->thajaran;
			}
			$sql ='SELECT COUNT(kodemk)jumpengambil FROM simambilmk
					INNER JOIN simkrs ON simambilmk.idkrs = simkrs.idkrs WHERE kodemk = "'.$kodemk.'" AND thajaran = "'.$thajaran.'"';
			$hasil = $this->db->query($sql);
			return $hasil->row()->jumpengambil;
		}
		function get_kuota($kodemk, $thajaran = ''){
			if(!$thajaran){
				$thajaran = $this->auth->get_thactive()->thajaran;
			}
			$sql = "SELECT kuota FROM simmktawar WHERE kodemk='".$kodemk."' AND thajaran = '".$thajaran."' LIMIT 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->kuota;
			}else{
				return false;
			}
		}
		function get_kodemk($thajaran){
			$sql = "SELECT kodemk FROM simmktawar WHERE thajaran = '".$thajaran."'";
			return $this->db->query($sql);
		}
		
		function get_tawar($limit2=0, $limit1=10, $thajaran, $cari='', $kodeprodi = ''){
			$data = array();
			$res = "";
			$aridkrs = $this->get_kodemk($thajaran);
			foreach($aridkrs->result() as $a){
				$res  .= "'".$a->kodemk."',";
			}
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = "''";


			$sql = "SELECT kodemk,namamk,kodeprodi
					FROM simkurikulum WHERE kodemk IN
					(".$res.")";
			if($kodeprodi){
				$sql .= " AND kodeprodi = '".$kodeprodi."'";
			}
			if($cari){
				$sql .= " AND kodemk LIKE '%".$cari."%'";
			}
				$sql .= " GROUP BY kodemk ORDER BY namamk ASC LIMIT ".$limit1;
			if($limit2){
				$sql .= ", ".$limit2;
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		/*function get_tawar($limit2=0, $limit1=10, $thajaran, $cari='', $kodeprodi = ''){
			$data = array();
			$sql = 'SELECT simmktawar.kodemk, namamk, simmktawar.kodeprodi FROM simkurikulum INNER JOIN simmktawar WHERE simmktawar.thajaran = "'.$thajaran.'"';
			if($kodeprodi){
				$sql .= " AND simmktawar.kodeprodi = '".$kodeprodi."'";
			}
			if($cari){
				$sql .= " AND simmktawar.kodemk LIKE '%".$cari."%'";
			}
				$sql .= " GROUP BY simmktawar.kodemk ORDER BY namamk ASC LIMIT ".$limit1;
			if($limit2){
				$sql .= ", ".$limit2;
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		} */
		function count_tawar($thajaran='', $cari='', $kodeprodi = ''){
			$res = '';
			if(!$thajaran){
				$thajaran = $this->auth->get_thactive()->thajaran;
			}
			$arkode = $this->get_kodemk($thajaran);
			foreach($arkode->result() as $a){
				$res  .= '"'.$a->kodemk.'",';
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = '';

			$data = array();
			$sql = "SELECT kodemk,namamk,kodeprodi
					FROM simkurikulum WHERE kodemk IN
					(".$res.")";
			if($kodeprodi){
				$sql .= " AND kodeprodi = '".$kodeprodi."'";
			}
			if($cari){
				$sql .= " AND kodemk LIKE '%".$cari."%'";
			}
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function select($limit2=0,$limit1=10){
			$data = array();
			$sql = "SELECT kodemk,thajaran,kuota,kodeprodi,
					(SELECT namamk FROM simkurikulum WHERE kodemk=simmktawar.kodemk AND kodeprodi=simmktawar.kodeprodi LIMIT 1)
					AS namamk FROM simmktawar";
			$sql .= " WHERE kodemk <> '' ";
			if($this->session->userdata('sesi_prodi')){
				$sql .= " AND kodeprodi = '".$this->session->userdata('sesi_prodi')."'";
			}
			if($this->session->userdata('sesi_thajaran')){
				$sql .= " AND thajaran = ".$this->session->userdata('sesi_thajaran');
			}
			if($this->session->userdata('sesicari_matakuliahtawar')){
				$sql .= " AND kodemk LIKE '%".$this->session->userdata('sesicari_matakuliahtawar')."%'";
				/* $sql .= " OR namamk LIKE '%".$this->session->userdata('sesicari_matakuliahtawar')."%'";*/
			}
				$sql .= " ORDER BY id_tawar DESC LIMIT ".$limit1;
			if($limit2){
				$sql .= ", ".$limit2;
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function select_mk(){
			$data = array();
			/*
			$sql = "SELECT *,namamk as nama_mk FROM simkurikulum kur
					WHERE namamk <> ''
					AND kur.kodemk NOT IN (SELECT kodemk FROM simmktawar WHERE kodeprodi = '".$this->session->userdata('sesi_prodi')."') ";
			*/
			$sesi_thajaran = $this->session->userdata('sesi_thajaran');
			$sql = "SELECT *,namamk as nama_mk FROM simkurikulum kur
					WHERE namamk <> ''
					AND kur.kodemk NOT IN
						(SELECT kodemk FROM simmktawar WHERE thajaran = '".$sesi_thajaran."' AND kodeprodi = '".$this->session->userdata('sesi_prodi')."') ";
			if($this->session->userdata('sesi_prodi')){
				$sql .= " AND kur.kodeprodi = '".$this->session->userdata('sesi_prodi')."'";
			}
			if($this->session->userdata('sesi_semester') % 2 <> 0){
				$sql .= " AND kur.semester % 2 <> 0 ";
			}elseif($this->session->userdata('sesi_semester') % 2 == 0){
				$sql .= " AND kur.semester % 2 = 0 ";
			}
			if($this->session->userdata('sesicari_matakuliah')){
				$sql .= " AND kur.kodemk LIKE '%".$this->session->userdata('sesicari_matakuliah')."%'";
				// $sql .= " OR nama_mk LIKE '%".$this->session->userdata('sesicari_matakuliah')."%'";
			}
			$sql .= " LIMIT 10 ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all(){
			$data = array();
			$this->db->select("*");
			$this->db->from("simmktawar");
			$this->db->join("simkurikulum", "simmktawar.kodemk = simkurikulum.kodemk");
			if($this->session->userdata('sesi_thajaran')){
				$this->db->where('thajaran', $this->session->userdata('sesi_thajaran'));
			}
			if($this->session->userdata('sesi_prodi')){
				$this->db->where('simkurikulum.kodeprodi', $this->session->userdata('sesi_prodi'));
			}
			return $this->db->count_all_results();
		}
		function cek_kodemk($kodemk){
			$data = array();
			$this->db->select("kodemk");
			$this->db->from("simmktawar");
			$this->db->where("kodemk",$kodemk);
			return $this->db->count_all_results();
		}

		function select_cari($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab");
			$this->db->from("simmktawar ad");
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
			$this->db->from("simmktawar");
			$this->db->join("simnamamk","simmktawar.kodenama = simnamamk.kodenama");
			$this->db->join("simprodi","simmktawar.kodeprodi = simprodi.kodeprodi");
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
			$this->db->update("simmktawar",$data);
		}
		function delete($kodemk, $kodeprodi){
			$this->db->where("kodemk",$kodemk);
			$this->db->where("kodeprodi",$kodeprodi);
			$this->db->delete("simmktawar");
		}
		function insert($kodemk = '', $kuota = ''){
			$data = array(
				"kodemk" => $kodemk,
				"thajaran" => $this->session->userdata("sesi_thajaran"),
				"kuota" => $kuota,
				"kodeprodi" => $this->session->userdata("sesi_prodi")
			);
			$this->db->insert("simmktawar",$data);
		}
	}
?>