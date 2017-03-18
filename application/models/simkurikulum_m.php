<?php
	Class Simkurikulum_m extends Model{
		function __construct(){
			parent::model();
		}
		function cek_likemkprodi($likekode){
			$sql = 'SELECT kodemk FROM simkurikulum WHERE kodemk LIKE "'.$likekode.'%"';
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		/* SEMOGA TIDAK KEPAKAI DI CONTROLLER YANG LAIN HEHEHEHE */
		function get_cari_all($namamk='',$limit1=''){
			$data = array();
			$sql = "SELECT *,namamk,
				(SELECT namaprodi FROM simprodi WHERE kodeprodi = simkurikulum.kodeprodi)namaprodi FROM simkurikulum ";
			// $sql .= " WHERE namamk LIKE '%".$namamk."%' ";
			$sql .= " WHERE kodemk LIKE '%".$namamk."%' ";
			// $sql .= " AND kodemk IN (SELECT kodemk FROM simmktawar)";
			$sql .= " LIMIT ".$limit1;
			return $this->db->query($sql);
		}
		function select($limit2=0, $limit1=10, $kodeprodi = ''){
			$data = array();
			$this->db->select("*");
			$this->db->from("simkurikulum");
			$this->db->join("simprodi", "simkurikulum.kodeprodi = simprodi.kodeprodi");
			if($this->session->userdata('cari_simkurikulum')){
				$this->db->like('kodemk',$this->session->userdata('cari_simkurikulum'));
				$this->db->or_like('namamk',$this->session->userdata('cari_simkurikulum'));
			}
			if($this->session->userdata('sesi_thnkurikulum')){
				$this->db->where('thnkur',$this->session->userdata('sesi_thnkurikulum'));
			}
			if($kodeprodi){
				$this->db->where('simprodi.kodeprodi', $kodeprodi);
			}
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		/* GET_ALL DIBUAT PAS BUAT FITUR PAKET... JADI BISA DI HAJAR... */
		function get_all($limit1=10, $limit2=0, $cari = '', $kodeprodi = '', $angkatan = '', $kelas = '', $thajaran = ''){
			$data = array();
			$sql = 'SELECT matkul.kodemk as kodemk, matkul.namamk as namamk, matkul_kurikulum.sks as sks, kurikulum_sp.nm_kurikulum_sp 
			from matkul inner join matkul_kurikulum on matkul.id_mk = matkul_kurikulum.id_mk 
			inner join kurikulum_sp on matkul_kurikulum.id_kurikulum_sp = kurikulum_sp.id_kurikulum INNER JOIN simprodi ON matkul.kodeprodi = simprodi.kodeprodi WHERE 1 ';
			if($cari){
				$sql .= ' AND (matkul.kodemk LIKE "%'.$cari.'%" OR namamk LIKE "%'.$cari.'%") ';
			}
			if($kodeprodi){
				$sql .= ' AND simprodi.kodeprodi = "'.$kodeprodi.'" ';
			}
			$sql .= ' AND matkul.kodemk NOT IN(
					SELECT kodemk FROM paket INNER JOIN detpaket ON paket.idpaket = detpaket.idpaket
					WHERE 1 AND kodeprodi = "'.$kodeprodi.'" AND angkatan = "'.$angkatan.'" AND kelas = "'.$kelas.'" AND thajaran = "'.$thajaran.'"	)';
			$sql .= ' LIMIT '.$limit2.', '.$limit1;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all($kodeprodi = ''){
			$data = array();
			$this->db->select("*");
			$this->db->from("simkurikulum");
			$this->db->join("simprodi", "simkurikulum.kodeprodi = simprodi.kodeprodi");
			if($this->session->userdata('cari_simkurikulum'))
				$this->db->like('kodemk',$this->session->userdata('cari_simkurikulum'));
			if($this->session->userdata('sesi_thnkurikulum')){
				$this->db->where('thnkur',$this->session->userdata('sesi_thnkurikulum'));
			}
			if($kodeprodi){
				$this->db->where('simprodi.kodeprodi', $kodeprodi);
			}
			return $this->db->count_all_results();
		}
		function cek_kodemk($kodemk){
			$data = array();
			$this->db->select("kodemk");
			$this->db->from("simkurikulum");
			$this->db->where("kodemk",$kodemk);
			return $this->db->count_all_results();
		}
		function select_cari($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab");
			$this->db->from("simkurikulum ad");
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
			$this->db->from("simkurikulum");
			$this->db->join("simprodi","simkurikulum.kodeprodi = simprodi.kodeprodi");
			$this->db->where("kodemk",$kodemk);
			$this->db->limit(1);
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
				"namamk" => $this->input->post("namamk"),
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
			$this->db->update("simkurikulum",$data);
		}

		function delete($kodemk){
			$this->db->where("kodemk",$kodemk);
			$this->db->delete("simkurikulum");
		}
		function insert(){
			$data = array(
				"kodemk" => $this->input->post("kodemk"),
				"namamk" => $this->input->post("namamk"),
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
			$this->db->insert("simkurikulum",$data);
		}
	}
?>