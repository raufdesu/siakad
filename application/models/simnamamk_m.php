<?php
	Class Simnamamk_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select(){
			$data = array();
			$this->db->select("*");
			$this->db->from("simnamamk");
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
			$this->db->from("simnamamk");
			return $this->db->count_all_results();
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
			$this->db->update("simnamamk",$data);
		}

		function delete($npp){
			$this->db->where("kodeprodi",$npp);
			$this->db->delete("simnamamk");
		}
		function insert(){
			$data = array(
				"namamk" => $this->input->post("namamk"),
				"namamkinggris" => $this->input->post("namamkinggris"),			
			);
			$this->db->insert("simnamamk",$data);
		}
	}
?>