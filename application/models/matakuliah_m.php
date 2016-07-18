<?php
	Class Matakuliah_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_matakuliah");
			$this->db->where("id_mk NOT IN", "(SELECT id_mk FROM akd_kurmk)", FALSE); 
			$this->db->group_by("nama1");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($nim){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_matakuliah");
			$this->db->where("id_mk",$nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_matakuliah($sesi_matkul = ''){
			$this->db->like("nama1", $sesi_matkul);
			$this->db->from("akd_matakuliah");
			//$this->db->group_by("nama1");
			return $this->db->count_all_results();		
		}
		function update(){
			$data = array(
				"nama1"=>$this->input->post("nama1"),
				"nama2"=>$this->input->post("nama2"),
			);
			$this->db->where("id_mk",$this->input->post("id_mk"));
			$this->db->update("akd_matakuliah",$data);
		}

		function insert(){
			$data = array(
				"nama1"=>$this->input->post("nama1"),
				"nama2"=>$this->input->post("nama2"),
			);
			$this->db->insert("akd_matakuliah",$data);
		}
		
		function delete($id_mk){
			$this->db->where("id_mk",$id_mk);
			$this->db->delete("akd_matakuliah");
		}

		function select_cari($limit1, $limit2, $cari){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_matakuliah");
			$this->db->like("nama1",$cari);
			$this->db->where("id_mk NOT IN", "(SELECT id_mk FROM akd_kurmk)", FALSE); 
			$this->db->group_by("nama1");
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