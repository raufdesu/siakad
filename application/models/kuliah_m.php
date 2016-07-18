<?php
	Class Kuliah_m extends Model{
		function __construct(){
			parent::model();
		}
		function select_by($nim){
			$data = array();
			$sql="select kdmk,(select namamk from mastermk where krsmhs.kdmk=mastermk.kdmk AND mastermk.kdprodi IN 
(select kdprodi from mastermhs where mastermhs.nimmhs = krsmhs.nimmhs)) as namamk ,(select jumlahsks from mastermk where krsmhs.kdmk=mastermk.kdmk AND mastermk.kdprodi IN 
(select kdprodi from mastermhs where mastermhs.nimmhs = krsmhs.nimmhs)) as jumlahsks, nilaimhs 
from krsmhs where nimmhs='$nim' order by thakad";
			$hasil=$this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function thn_akads($nim){
			$data = array();
			$this->db->select("kul.thakad");
			$this->db->from("akd_kuliah kul");
			$this->db->join("akd_peserta pes", "kul.kdkuliah = pes.kdkuliah");
			$this->db->where("pes.nim",$nim);
			$this->db->group_by("kul.thakad");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function select($limit2,$limit1,$thakad){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_kuliah akul");
			$this->db->join("akd_kurmk akur","akul.kdmk = akur.kdkmk");
			$this->db->join("akd_matakuliah amat","akur.id_mk = amat.id_mk");
			$this->db->join("akd_dosen ados","akul.kdpeg = ados.kdpeg");
			$this->db->join("peg_biodata pbio","ados.kdpeg = pbio.kdpeg");
			//$this->db->join("akd_peserta pes","akul.kdkuliah = pes.kdkuliah");
			$this->db->where("akul.thakad",$thakad);
			//$this->db->where_not_in("akul.kdkuliah", "SELECT kdkuliah FROM akd_peserta", FALSE);
			$this->db->where("akul.kdkuliah NOT IN",
				"(SELECT kdkuliah FROM akd_peserta WHERE nim = '".$this->session->userdata("sesi_user_mhs")."')", FALSE); 
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
				
		function select_cari($limit2,$limit1,$thakad,$sesi_kuliah){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_kuliah akul");
			$this->db->join("akd_kurmk akur","akul.kdmk = akur.kdkmk");
			$this->db->join("akd_matakuliah amat","akur.id_mk = amat.id_mk");
			$this->db->join("akd_dosen ados","akul.kdpeg = ados.kdpeg");
			$this->db->join("peg_biodata pbio","ados.kdpeg = pbio.kdpeg");
			$this->db->where("akul.thakad",$thakad);
			$this->db->like("nama1",$sesi_kuliah);
			$this->db->where("akul.kdkuliah NOT IN",
				"(SELECT kdkuliah FROM akd_peserta WHERE nim = '".$this->session->userdata("sesi_user_mhs")."')", FALSE); 
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($kdkuliah){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_kuliah akul");
			$this->db->join("akd_kurmk akur","akul.kdmk = akur.kdkmk");
			$this->db->join("akd_matakuliah amat","akur.id_mk = amat.id_mk");
			$this->db->join("akd_dosen ados","akul.kdpeg = ados.kdpeg");
			$this->db->join("peg_biodata pbio","ados.kdpeg = pbio.kdpeg");
			$this->db->where("akul.kdkuliah",$kdkuliah);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function update(){
			$data = array(
				"kdmk" => $this->input->post("kdkmk"),
				"kdpeg" => $this->input->post("nomkaprodi"),
				"thakad" => $this->session->userdata("sesi_thn_akad").$this->session->userdata("sesi_semester"),
				"kdruang" => $this->input->post("ruang"),
				"jamawal" => $this->input->post("jamawal"),
				"jamselesai" => $this->input->post("jamselesai"),
				"kdkelas" => $this->input->post("kdkelas"),
				"rcntatapmuka" => $this->input->post("rcntatapmuka"),
				"realtatapmuka" => $this->input->post("realtatapmuka")
			);
			$this->db->where("kdkuliah",$this->input->post("kdkuliah"));
			$this->db->update("akd_kuliah",$data);
		}

		function delete($kode){
			$this->db->where("kdkuliah",$kode);
			$this->db->delete("akd_kuliah");
		}

		function auto_kdakd(){
			$this->db->select_max("kdakd");
			$hasil = $this->db->get('akd_kuliah');
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return the row as an associative array
			}
		}

		function insert(){
			$data = array(
				"kdkuliah" => $this->input->post("kdkuliah"),
				"kdmk" => $this->input->post("kdkmk"),
				"kdpeg" => $this->input->post("nomkaprodi"),
				"thakad" => $this->session->userdata("sesi_thn_akad").$this->session->userdata("sesi_semester"),
				"kdruang" => $this->input->post("ruang"),
				"jamawal" => $this->input->post("jamawal"),
				"jamselesai" => $this->input->post("jamselesai"),
				"kdkelas" => $this->input->post("kdkelas"),
				"rcntatapmuka" => $this->input->post("rcntatapmuka"),
				"realtatapmuka" => $this->input->post("realtatapmuka")
			);
			$this->db->insert("akd_kuliah",$data);
		}
	}
?>