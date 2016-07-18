<?php
	Class Simprodi_m extends Model{
		function __construct(){
			parent::model();
		}
		function cek_nimprodi($kodeprodi, $nim){
			$sql = 'SELECT kodeprodi FROM masmahasiswa WHERE nim = "'.$nim.'"';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				if(trim($hasil->row()->kodeprodi) == trim($kodeprodi)){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		function get_namaprodibynim($nim){
			$sql = "SELECT namaprodi FROM simprodi LEFT JOIN masmahasiswa ON simprodi.kodeprodi = masmahasiswa.kodeprodi WHERE masmahasiswa.nim = '".$nim."'";
			$que = $this->db->query($sql);
			if($que->num_rows > 0){
				return $que->row()->namaprodi;
			}else{
				return 'Keseluruhan';
			}
		}
		function get_namaprodi(){
			$data = array();
			$sql = "SELECT * FROM simprodi GROUP BY namaprodi";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				$data = $que->result();
			}
			$que->free_result();
			return $data;
		}
		function select($limit1='', $limit2=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("simprodi");
			if($limit1 || $limit2)
				$this->db->limit($limit2,$limit1);
			
			$this->db->order_by('kodeprodi','DESC');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function detail($kodeprodi){
			$data = array();
			$this->db->select("*,(SELECT nama FROM maspegawai WHERE simprodi.npp=maspegawai.npp) as kaprodi");
			$this->db->from("simprodi");
			$this->db->where("kodeprodi",$kodeprodi);
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
			$this->db->from("simprodi");
			return $this->db->count_all_results();
		}

		function update(){
			$data = array(
				"kodeprodi" => $this->input->post("kodeprodi"),
				"prefkodeprodi" => $this->input->post("prefkodeprodi"),
				"namaprodi" => $this->input->post("namaprodi"),
				"jenjang" => $this->input->post("jenjang"),
				"ijin" => $this->input->post("ijin"),
				"status" => $this->input->post("status"),
				"npp" => $this->input->post("npp"),
				"kodefakultas" => $this->input->post("kodefakultas")
			);
			$this->db->where("kodeprodi",$this->input->post("kodeprodi2"));
			$this->db->update("simprodi",$data);
		}
		function insert(){
			$data = array(
				"kodeprodi" => $this->input->post("kodeprodi"),
				"prefkodeprodi" => $this->input->post("prefkodeprodi"),
				"namaprodi" => $this->input->post("namaprodi"),
				"jenjang" => $this->input->post("jenjang"),
				"ijin" => $this->input->post("ijin"),
				"status" => $this->input->post("status"),
				"npp" => $this->input->post("npp"),
				"kodefakultas" => $this->input->post("kodefakultas")
			);
			$this->db->insert("simprodi",$data);
		}
		/*function get_one($kodeprodi){
			$sql = "SELECT *,(SELECT nama FROM maspegawai WHERE npp = simprodi.npp)kaprodi FROM simprodi WHERE kodeprodi = '".$kodeprodi."'";
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}*/
		function delete($kodeprodi){
			$this->db->where("kodeprodi",$kodeprodi);
			$this->db->delete("simprodi");
		}
	}
?>