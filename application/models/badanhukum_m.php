<?php
	Class badanhukum_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select(){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbadanhukum");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($id_badanhukum){
			$data = array();
			$this->db->select("*");
			$this->db->from("tbadanhukum");
			$this->db->where("kdyayasan",$id_badanhukum);
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
				"nmyayasan"=>$this->input->post("nmyayasan"),
				"alamat1"=>$this->input->post("alamat1"),
				"alamat2"=>$this->input->post("alamat2"),
				"kota"=>$this->input->post("kota"),
				"kodepos"=>$this->input->post("kodepos"),
				"telp"=>$this->input->post("telp"),
				"faks"=>$this->input->post("faks"),
				"tglakta"=>tgl_ingg($this->input->post("tglakta")),
				"nomsk"=>$this->input->post("nomsk"),
				"tglpengesahan"=>tgl_ingg($this->input->post("tglpengesahan")),
				"nompengesahan"=>$this->input->post("nompengesahan"),
				"email"=>$this->input->post("email"),
				"homepage"=>$this->input->post("homepage"),
				"tglberdiri"=>tgl_ingg($this->input->post("tglberdiri"))
			);
			$this->db->update("tbadanhukum",$data);
			$this->db->where("kdyayasan",$this->input->post("kdyayasan2"));
		}
	}
?>