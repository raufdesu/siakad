<?php
	Class Maspegawai_m extends Model{
		function __construct(){
			parent::model();
		}
		function getOne($id){
			$data = array();
			$this->db->select("*");
			$this->db->where("npp", $id);
			$this->db->from("maspegawai");
			return $this->db->get();
		}
		function getDosenOnly($limit2='',$limit1=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("maspegawai");
			$this->db->like("statuspegawai", 'Dosen');
			/*if($this->session->userdata('cari_maspegawai'))
				$this->db->like('nama',$this->session->userdata('cari_maspegawai'));
			$this->db->limit($limit1,$limit2);*/
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			// echo $this->db->last_query();
			return $data;
		}
		function countDosenOnly(){
			$data = array();
			$this->db->select("*");
			$this->db->from("maspegawai");
			$this->db->like("statuspegawai",'Dosen');
			if($this->session->userdata('cari_maspegawai'))
				$this->db->like('nama',$this->session->userdata('cari_maspegawai'));
			return $this->db->count_all_results();		
		}
		function select($limit2='',$limit1=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("maspegawai");
			if($this->session->userdata('cari_maspegawai'))
				$this->db->like('nama',$this->session->userdata('cari_maspegawai'));
			$this->db->limit($limit1,$limit2);
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
			$this->db->from("maspegawai");
			if($this->session->userdata('cari_maspegawai'))
				$this->db->like('nama',$this->session->userdata('cari_maspegawai'));
			return $this->db->count_all_results();
		}

		function select_maspegawai_dpa(){
			$data = array();
			$this->db->select("*");
			$this->db->from("maspegawai ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			$this->db->join("tbkod3 t3","ad.statuskerja = t3.kdkodtbkod");
			$this->db->join("tbkod15 t15","ad.statusaktif = t15.kdkodtbkod");
			$this->db->where("t3.kdkodtbkod","A");
			$this->db->where("t15.kdkodtbkod","A");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_cari($limit2,$limit1,$cari){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab");
			$this->db->from("maspegawai ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			$this->db->join("tbkod2 t2","ad.jabakad = t2.kdkodtbkod");
			$this->db->like("nama",$cari);
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($npp){
			$data = array();
			$this->db->select("*");
			$this->db->from("maspegawai");
			$this->db->where("npp",$npp);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_namabynpp($npp){
			$data = array();
			$this->db->select('nama');
			$this->db->from("maspegawai");
			$this->db->where("npp",$npp);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row()->nama;
			}else{
				return false;
			}
		}
		function delete($npp){
			if($npp){
				$this->db->where("npp",$npp);
				$this->db->delete("maspegawai");
			}
		}
		function insert(){
			$data = array(
				"npp" => $this->input->post("npp"),
				"nip" => $this->input->post("nip"),
				"nama" => $this->input->post("nama"),
				"jnskelamin" => $this->input->post("jnskelamin"),
				"statuspegawai" => 'Dosen',
				"nama" => $this->input->post("nama"),
				"alamat" => $this->input->post("alamat"),
				"notelp" => $this->input->post("notelp"),
				"email" => $this->input->post("email"),
				"statusnikah" => $this->input->post("statusnikah"),
				"pendidikanterakhir" => $this->input->post("pendidikanterakhir"),
				"kodeprodi" => $this->input->post("kodeprodi"),
				"nidn" => $this->input->post("nidn"),
				"bagian" => $this->input->post("bagian"),
				"jabatanakademik" => $this->input->post("jabatanakademik"),
				"tglmasuk" => tgl_ingg($this->input->post("tglmasuk"))
			);
			if($this->input->post('npp2')){
				$this->db->where("npp",$this->input->post("npp2"));
				$this->db->update("maspegawai",$data);
			}else{
				$this->db->insert("maspegawai",$data);
			}
		}
		function get_one($npp){
			$data = array();
			$this->db->select('*');
			$this->db->from('maspegawai');
			$this->db->where('npp', $npp);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		/* HANYA UNTUK UPDATE DARI DOSEN */
		function update(){
			$data = array(
				"npp" => $this->input->post("npp"),
				"nip" => $this->input->post("nip"),
				"nama" => $this->input->post("nama"),
				"statuspegawai" => 'Dosen',
				"alamat" => $this->input->post("alamat"),
				"notelp" => $this->input->post("notelp"),
				"email" => $this->input->post("email"),
				"statusnikah" => $this->input->post("statusnikah"),
				"tglmasuk" => tgl_ingg($this->input->post("tglmasuk"))
			);
			if($this->input->post('npp2')){
				$this->db->where("npp",$this->input->post("npp2"));
				$this->db->update("maspegawai", $data);
			}else{
				$this->db->insert("maspegawai", $data);
			}
		}
	}
?>