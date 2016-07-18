<?php
	Class biodata_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("peg_biodata pb");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_cari($limit2,$limit1,$txtCari){
			$data = array();
			$this->db->select("*");
			$this->db->from("peg_biodata pb");
			$this->db->like("nama",$txtCari);
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($id_bio){
			$data = array();
			$this->db->select("*");
			$this->db->from("peg_biodata pb");
			$this->db->where("kdpeg",$id_bio);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function update(){
			$data = array(
				"kdpeg" => $this->input->post("kdpeg"),
				"nomktp" => $this->input->post("nomktp"),
				"nama" => $this->input->post("nama"),
				"gelar" => $this->input->post("gelar"),
				"tempatlahir" => $this->input->post("tempatlahir"),
				"tgllahir" => tgl_ingg($this->input->post("tgllahir")),
				"jklmn" => $this->input->post("jklmn"),
				"alamat" => $this->input->post("alamat"),
				"status" => $this->input->post("status"),
				"agama" => $this->input->post("agama"),
				"telp" => $this->input->post("telp"),
				"hp" => $this->input->post("hp"),
				"tglmasuk" => tgl_ingg($this->input->post("tglmasuk")),
				"statuskerja" => $this->input->post("statuskerja"),
				"pendidikan" => $this->input->post("pendidikan"),
				"passwd" => $this->input->post("passwd"),
			);
			$this->db->where("kdpeg",$this->input->post("kdpegx"));
			$this->db->update("peg_biodata",$data);
		}

		function delete($kode){
			$this->db->where("kdpeg",$kode);
			$this->db->delete("peg_biodata");
		}

		function auto_kdpeg(){
			$this->db->select_max("kdpeg");
			$hasil = $this->db->get('peg_biodata');
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return the row as an associative array
			}
		}

		function insert(){
			$data = array(
				"kdpeg" => $this->input->post("kdpeg"),
				"nomktp" => $this->input->post("nomktp"),
				"nama" => $this->input->post("nama"),
				"gelar" => $this->input->post("gelar"),
				"tempatlahir" => $this->input->post("tempatlahir"),
				"tgllahir" => tgl_ingg($this->input->post("tgllahir")),
				"jklmn" => $this->input->post("jklmn"),
				"alamat" => $this->input->post("alamat"),
				"status" => $this->input->post("status"),
				"agama" => $this->input->post("agama"),
				"telp" => $this->input->post("telp"),
				"hp" => $this->input->post("hp"),
				"tglmasuk" => tgl_ingg($this->input->post("tglmasuk")),
				"statuskerja" => $this->input->post("statuskerja"),
				"pendidikan" => $this->input->post("pendidikan"),
				"passwd" => $this->input->post("passwd"),
			);
			$this->db->insert("peg_biodata",$data);
		}
	}
?>