<?php
	Class Mastermk_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit1, $limit2){
			$data = array();
			$this->db->select("*");
			$this->db->from("mastermk");
			$this->db->limit($limit2,$limit1);
			if($this->session->userdata('sesi_carimastermk')) $this->db->like('namamk', $this->session->userdata('sesi_carimastermk'));
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
			$this->db->from("mastermk");
			if($this->session->userdata('sesi_carimastermk')) $this->db->like('namamk', $this->session->userdata('sesi_carimastermk'));
			return $this->db->count_all_results();
		}
		function detail($kdkmk){
			$data = array();
			$this->db->select("*, t10.nmkodtbkod as nama_kel, t11.nmkodtbkod as nama_kur,
				t28.nmkodtbkod as nama_wpl");
			$this->db->from("mastermk");
			$this->db->join("akd_matakuliah mk","mastermk.id_mk = mk.id_mk");
			$this->db->join("tbkod10 t10","t10.kdkodtbkod = mastermk.kdkel");
			$this->db->join("tbkod11 t11","t11.kdkodtbkod = mastermk.kdkur");
			$this->db->join("tbkod28 t28","t28.kdkodtbkod = mastermk.kdwpl");
			$this->db->join("akd_prodi ap","ap.kdpst = mastermk.kdpst");
			$this->db->where("kdkmk",$kdkmk);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function update(){
			$data = array(
				"kdkmk"=>$this->input->post("kdkmkx"),
				"id_mk"=>$this->input->post("id_mk"),
				"sks"=>$this->input->post("sks"),
				"skstm"=>$this->input->post("skstm"),
				"skspraktikum"=>$this->input->post("skspraktikum"),
				"skspraktlap"=>$this->input->post("skspraktlap"),
				"semester"=>$this->input->post("semester"),
				"kdkel"=>$this->input->post("kdkel"),
				"kdkur"=>$this->input->post("kdkur"),
				"kdwpl"=>$this->input->post("kdwpl"),
				"kdpst"=>$this->input->post("kdpst"),
				"statusmk"=>$this->input->post("statusmk"),
				"silabus"=>$this->input->post("silabus"),
				"sapp"=>$this->input->post("sapp"),
				"bhnajar"=>$this->input->post("bhnajar"),
				"diktat"=>$this->input->post("diktat")
			);
			$this->db->where("kdkmk",$this->input->post("kdkmk"));
			$this->db->update("akd_mastermk",$data);
		}
		
		function cek_kode(){
			$this->db->select("kdmk");
			$this->db->from("mastermk");
			$this->db->where("kdmk",$this->input->post("kdmk"));
			return $this->db->count_all_results();
		}
		
		function insert(){
			$data = array(
				"kdmk"=>$this->input->post("kdmk"),
				"namamk"=>$this->input->post("namamk"),
				"jumlahsks"=>$this->input->post("jumlahsks"),
				"kdprodi"=>$this->input->post("kdprodi"),
				"semester"=>$this->input->post("semester"),
				"namaenglish"=>$this->input->post("namaenglish")
			);
			$this->db->insert("mastermk",$data);
		}
		
		function delete($kdmk){
			$this->db->where("kdmk",$kdmk);
			$this->db->delete("mastermk");
		}
	}
?>