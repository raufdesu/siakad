<?php
	Class Prodi_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select_kaprodi(){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_prodi prod");
			$this->db->join("peg_biodata bio","prod.nomkaprodi=bio.kdpeg");
			//$this->db->where("
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select(){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_prodi");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($id_mk){
			$data = array();
			$this->db->select("*,tb4.nmkodtbkod as namajen, tb14.nmkodtbkod as namaset, 
				tb7.nmkodtbkod as namaakre, tb29.nmkodtbkod as namafrek,tb30.nmkodtbkod as namapelak");
			$this->db->from("akd_prodi ap");
			$this->db->join("tbpti tp","ap.kdpti = tp.kdptitbpti");
			$this->db->join("tbpst tps","ap.kdpst = tps.kdpsttbpst");
			$this->db->join("tbkod4 tb4","ap.kdjen = tb4.kdkodtbkod");
			$this->db->join("tbkod14 tb14","ap.status = tb14.kdkodtbkod");
			$this->db->join("tbkod7 tb7","ap.kdstatusakred = tb7.kdkodtbkod");
			$this->db->join("tbkod29 tb29","ap.kdfrem = tb29.kdkodtbkod");
			$this->db->join("tbkod30 tb30","ap.kdpelaksanan = tb30.kdkodtbkod");
			$this->db->where("ap.kdpst",$id_mk);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function update(){
			$data = array(
				"kdpti" => $this->input->post("kdpti"),
				"kdfak" => $this->input->post("kdfak"),
				"kdjen" => $this->input->post("kdjen"),
				//"kdpst" => $this->input->post("kdpst"),
				"nmpst" => $this->input->post("nmpst"),
				"tglawal" => tgl_ingg($this->input->post("tglawal")),
				"semawal" => $this->input->post("semawal"),
				"status" => $this->input->post("status"),
				"mulaisem" => $this->input->post("mulaisem"),
				"skslulus" => $this->input->post("skslulus"),
				"email" => $this->input->post("email"),
				"nomskdikti" => $this->input->post("nomskdikti"),
				"tglmulaiskdikti" => tgl_ingg($this->input->post("tglmulaiskdikti")),
				"tglakhirskdikti" => tgl_ingg($this->input->post("tglakhirskdikti")),
				"nomskban" => $this->input->post("nomskban"),
				"tglmulaiskban" => tgl_ingg($this->input->post("tglmulaiskban")),
				"tglakhirskban" => tgl_ingg($this->input->post("tglakhirskban")),
				"kdstatusakred" => $this->input->post("kdstatusakred"),
				"kdfrem" => $this->input->post("kdfrem"),
				"kdpelaksanan" => $this->input->post("kdpelaksanan"),
				"nomkaprodi" => $this->input->post("nomkaprodi"),
				"nomhp" => $this->input->post("nomhp"),
				"telp" => $this->input->post("telp"),
				"faks" => $this->input->post("faks")
				//"kd_nimprodi" => $this->input->post("kd_nimprodi")
			);
			$this->db->where("kdpst",$this->input->post("kdpst"));
			$this->db->update("akd_prodi",$data);
		}

		function delete($kode){
			$this->db->where("kdpsttbpst",$kode);
			$this->db->delete("tbpst");
		}

		function insert(){
			$data = array(
				"kdpti" => $this->input->post("kdpti"),
				"kdfak" => $this->input->post("kdfak"),
				"kdjen" => $this->input->post("kdjen"),
				"kdpst" => $this->input->post("kdpst"),
				"nmpst" => $this->input->post("nmpst"),
				"tglawal" => tgl_ingg($this->input->post("tglawal")),
				"semawal" => $this->input->post("semawal"),
				"status" => $this->input->post("status"),
				"mulaisem" => $this->input->post("mulaisem"),
				"skslulus" => $this->input->post("skslulus"),
				"email" => $this->input->post("email"),
				"nomskdikti" => $this->input->post("nomskdikti"),
				"tglmulaiskdikti" => tgl_ingg($this->input->post("tglmulaiskdikti")),
				"tglakhirskdikti" => tgl_ingg($this->input->post("tglakhirskdikti")),
				"nomskban" => $this->input->post("nomskban"),
				"tglmulaiskban" => tgl_ingg($this->input->post("tglmulaiskban")),
				"tglakhirskban" => tgl_ingg($this->input->post("tglakhirskban")),
				"kdstatusakred" => $this->input->post("kdstatusakred"),
				"kdfrem" => $this->input->post("kdfrem"),
				"kdpelaksanan" => $this->input->post("kdpelaksanan"),
				"nomkaprodi" => $this->input->post("nomkaprodi"),
				"nomhp" => $this->input->post("nomhp"),
				"telp" => $this->input->post("telp"),
				"faks" => $this->input->post("faks")
				//"kd_nimprodi" => $this->input->post("kd_nimprodi")
			);
			$this->db->insert("akd_prodi",$data);
		}
	}
?>