<?php
	Class Perguruantinggi_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tperti");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($id_perguruantinggi){
			$data = array();
			$this->db->select("*");
			$this->db->from("tperti");
			$this->db->where("kdpti",$id_perguruantinggi);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function update(){
			$data = array(
				"kdyayasan"=>$this->input->post("kdyayasan"),
				"kdpti"=>$this->input->post("kdpti"),
				"namapt"=>$this->input->post("namapt"),
				"alamat1"=>$this->input->post("alamat1"),
				"alamat2"=>$this->input->post("alamat2"),
				"kota"=>$this->input->post("kota"),
				"kodepos"=>$this->input->post("kodepos"),
				"telp"=>$this->input->post("telp"),
				"faks"=>$this->input->post("faks"),
				"tglsk"=>tgl_ingg($this->input->post("tglsk")),
				"nomsk"=>$this->input->post("nomsk"),
				"email"=>$this->input->post("email"),
				"homepage"=>$this->input->post("homepage"),
				"tglberdiri"=>tgl_ingg($this->input->post("tglberdiri"))
			);
			$this->db->update("tperti",$data);
			$this->db->where("kdpti",$this->input->post("kdpti2"));
		}
	}
?>