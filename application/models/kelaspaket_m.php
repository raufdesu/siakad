<?php
	Class Kelaspaket_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_all($limit1 = '', $limit2 = '', $cari = '', $prodi = '', $angkatan = '', $kelas){
			$data = array();
			$this->db->select("*");
			$this->db->from("kelaspaket");
			$this->db->join("simprodi", "kelaspaket.kodeprodi = simprodi.kodeprodi");
			if($cari){
				$this->db->like('namaprodi', $cari);
			}
			if($prodi){
				$this->db->where('kelaspaket.kodeprodi', $prodi);
			}
			if($angkatan){
				$this->db->where('kelaspaket.angkatan', $angkatan);
			}
			if($kelas){
				$this->db->where('kelaspaket.kelas', $kelas);
			}
			if($limit1 || $limit2)
				$this->db->limit($limit2,$limit1);
			
			$this->db->order_by('tglinput','DESC');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_prodi(){
			$data = array();
			$this->db->select("kelaspaket.kodeprodi, simprodi.namaprodi");
			$this->db->from("kelaspaket");
			$this->db->join("simprodi", "kelaspaket.kodeprodi = simprodi.kodeprodi");
			$this->db->group_by("kelaspaket.kodeprodi");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_angkatan(){
			$data = array();
			$this->db->select("angkatan");
			$this->db->from("kelaspaket");
			$this->db->group_by("angkatan");
			$this->db->order_by("angkatan", "DESC");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_one($idkelaspaket){
			$sql = "SELECT * FROM kelaspaket WHERE idkelaspaket = '".$idkelaspaket."'";
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}
		function count_all($cari='', $prodi='', $angkatan='', $kelas=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("kelaspaket");
			if($prodi){
				$this->db->where('kelaspaket.kodeprodi', $prodi);
			}
			if($angkatan){
				$this->db->where('kelaspaket.angkatan', $angkatan);
			}
			if($kelas){
				$this->db->where('kelaspaket.kelas', $kelas);
			}
			return $this->db->count_all_results();
		}
		function update_paketmahasiswa($kodeprodi, $kelas, $angkatan, $statuspaket){
			$this->db->where('kodeprodi', $kodeprodi);
			$this->db->where('kdkelas', $kelas);
			$this->db->where('angkatan', $angkatan);
			$this->db->update('masmahasiswa', array('statuspaket' => $statuspaket));
		}
		function insert(){
			$data = array(
				"kodeprodi" => $this->input->post("kodeprodi"),
				"kelas"		=> $this->input->post("kelas"),
				"angkatan"	=> $this->input->post("angkatan"),
				"tglinput"	=> date('Y-m-d H:i:s')
			);
			if($this->input->post('idkelaspaket')){
				$this->db->where('idkelaspaket', $this->input->post('idkelaspaket'));
				$this->db->update("kelaspaket", $data);	
			}else{
				$this->db->insert("kelaspaket", $data);
			}
			$this->update_paketmahasiswa($this->input->post('kodeprodi'), $this->input->post('kelas'), $this->input->post('angkatan'), 'paket');
		}
		function delete($idkelaspaket){
			$paket = $this->get_one($idkelaspaket);
			$this->update_paketmahasiswa($paket->kodeprodi, $paket->kelas, $paket->angkatan, 'non paket');
			$this->db->where("idkelaspaket", $idkelaspaket);
			$this->db->delete("kelaspaket");
		}
	}
?>