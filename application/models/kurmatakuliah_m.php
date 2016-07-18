<?php
	Class Kurmatakuliah_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit2,$limit1,$thakad=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_kurmk kurmk");
			$this->db->join("akd_matakuliah mk","mk.id_mk = kurmk.id_mk");
			if($thakad == true){
				$this->db->join("akd_kuliah kul", "kurmk.kdkmk = kul.kdmk");
				$this->db->join("peg_biodata peg", "kul.kdpeg = peg.kdpeg");
				$this->db->where("kul.thakad",$thakad);
			}
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($kdkmk){
			$data = array();
			$this->db->select("*, t10.nmkodtbkod as nama_kel, t11.nmkodtbkod as nama_kur,
				t28.nmkodtbkod as nama_wpl");
			$this->db->from("akd_kurmk kurmk");
			$this->db->join("akd_matakuliah mk","kurmk.id_mk = mk.id_mk");
			$this->db->join("tbkod10 t10","t10.kdkodtbkod = kurmk.kdkel");
			$this->db->join("tbkod11 t11","t11.kdkodtbkod = kurmk.kdkur");
			$this->db->join("tbkod28 t28","t28.kdkodtbkod = kurmk.kdwpl");
			$this->db->join("akd_prodi ap","ap.kdpst = kurmk.kdpst");
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
			$this->db->update("akd_kurmk",$data);
		}
		
		function cek_kode(){
			$this->db->select("kdkmk");
			$this->db->where("kdkmk",$this->input->post("kdkmk"));
			$hasil = $this->db->get("akd_kurmk");
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		
		function insert(){
			$data = array(
				"kdkmk"=>$this->input->post("kdkmk"),
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
			$this->db->insert("akd_kurmk",$data);
		}
		
		function delete($kdkmk){
			$this->db->where("kdkmk",$kdkmk);
			$this->db->delete("akd_kurmk");
		}

		function select_cari($limit1, $limit2, $cari, $thakad = ''){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_kurmk kurmk");
			$this->db->join("akd_matakuliah mk", "mk.id_mk = kurmk.id_mk");
			if($thakad == true){
				$this->db->join("akd_kuliah kul", "kurmk.kdkmk = kul.kdmk");
				$this->db->where("kul.thakad",$thakad);
			}
			$this->db->like("mk.nama1",$cari);
			$this->db->limit($limit2, $limit1);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
	}
?>