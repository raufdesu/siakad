<?php
	Class Biayadaftar_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_one($id){
			$this->db->select("*");
			$this->db->where("idbiayadaftar", $id);
			$this->db->from("biayadaftar");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row();
			}
		}
		function get_byangkatan($angkatan = '', $prodi = ''){
			// $data = array();
			// $sql = "SELECT * FROM biayadaftar WHERE idbiayadaftar <> '' ";
			// if($angkatan){
				// $sql .= " AND angkatan = ".$angkatan;
			// }
			// if($prodi){
				// $sql .= " AND kodeprodi = ".$prodi;
			// }
			// $hasil = $this->db->query($sql);
			
			$data = array();
			$this->db->select("*");
			$this->db->from("biayadaftar");
			$this->db->where("angkatan", $angkatan);
			if($prodi){
				$this->db->where('kodeprodi', $prodi);
			}
			$this->db->group_by("idbiayadaftar", "DESC");
			$hasil = $this->db->get();
			
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_bygelangkatan($angkatan = '', $gelombang, $prodi){
			$data = array();
			$this->db->select("*");
			$this->db->from("biayadaftar");
			$this->db->where("angkatan", $angkatan);
			$this->db->where("gelombang", $gelombang);
			$this->db->where("kodeprodi", $prodi);
			//$this->db->group_by("jenisbayar");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_byangkatan($angkatan = '', $prodi = ''){
			$this->db->from("biayadaftar");
			$this->db->where("angkatan", $angkatan);
			if($prodi){
				$this->db->where('kodeprodi', $prodi);
			}
			return $this->db->count_all_results();
		}
		function cek_inputsama($namabiaya, $angkatan, $gelombang, $prodi){
			$this->db->from("biayadaftar");
			$this->db->where("angkatan", $angkatan);
			$this->db->where("gelombang", $gelombang);
			$this->db->where("namabiaya", $namabiaya);
			$this->db->where("kodeprodi", $prodi);
			return $this->db->count_all_results();
		}
		// function get_distinctall(){
			// $data = array();
			// $this->db->select("*");
			// $this->db->from("biayadaftar");
			// $this->db->group_by("jenisbayar");
			// $hasil = $this->db->get();
			// if($hasil->num_rows() > 0){
				// $data = $hasil->result();
			// }
			// $hasil->free_result();
			// return $data;
		// }
		// function get_all($limit2 = '', $limit1 = ''){
			// $data = array();
			// $this->db->select("*");
			// $this->db->from("biayadaftar");
			// $this->db->order_by('idbiayadaftar', 'DESC');
			// if($limit1 || $limit2){
				// $this->db->limit($limit1,$limit2);
			// }
			// $hasil = $this->db->get();
			// if($hasil->num_rows() > 0){
				// $data = $hasil->result();
			// }
			// $hasil->free_result();
			// return $data;
		// }
		// function count_all(){
			// $data = array();
			// $this->db->select("*");
			// $this->db->from("biayadaftar");
			// return $this->db->count_all_results();
		// }
		function insert(){
			$data = array(
				'namabiaya' => $this->input->post('namabiaya'),
				'biaya' => $this->input->post('biaya'),
				'angkatan' => $this->input->post('angkatan'),
				'kodeprodi' => $this->input->post('kodeprodi'),
				'gelombang' => $this->input->post('gelombang')
			);
			if($this->input->post('idbiayadaftar')){
				$this->db->where('idbiayadaftar', $this->input->post('idbiayadaftar'));
				$this->db->update('biayadaftar', $data);	
			}else{
				$namabiaya = $this->input->post('namabiaya');
				$angkatan = $this->input->post('angkatan');
				$kodeprodi = $this->input->post('kodeprodi');
				$gelombang = $this->input->post('gelombang');
				$prodi = $this->input->post('kodeprodi');
				$cek = $this->cek_inputsama($namabiaya, $angkatan, $gelombang, $prodi);
				if(!$cek){
					$this->db->insert('biayadaftar', $data);	
				}
			}
		}
	}
?>