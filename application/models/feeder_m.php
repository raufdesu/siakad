<?php
	Class Feeder_m extends Model{
		var $thajaran_aktif;
		function __construct(){
			parent::model();
			$this->thajaran_aktif = '20112';
		}
		function select(){
			$data = array();
			$sql = "SELECT * from config_user";
			$this->pmb = $this->load->database('pmb', TRUE);
			$hasil = $this->pmb->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function insert(){
			$data = array(
				"username" => $this->input->post("username"),
				"password" => $this->input->post("password"),
				"url" => $this->input->post("url"),
				"port" => $this->input->post("port"),
				"id_sp" => $this->input->post("id_sp"),
				"live" => $this->input->post("live")
			);
				$this->pmb = $this->load->database('pmb', TRUE);
				$this->pmb->where('id', $this->input->post('id'));
				$this->pmb->update("config_user", $data);
		}
		
	}
?>