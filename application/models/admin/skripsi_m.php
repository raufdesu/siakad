<?php
	Class Skripsi_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit2,$limit1,$thakad,$cari=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_trskripsi skr");
			$this->db->join("akd_mhs mhs","skr.nim = mhs.nimhsmsmhs");
			$this->db->where("skr.thakad",$thakad);
			if($cari){
				$this->db->like("judul",$cari);
			}
			$this->db->order_by("skr.tglawal","DESC");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){             // QUERY MASIH SALAH :D 
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($nim,$tglselesai){
			$data = array();
			$this->db->select("*,skr.tglawal as tgl_awal");
			$this->db->from("akd_trskripsi skr");
			$this->db->join("akd_mhs mhs","skr.nim = mhs.nimhsmsmhs");
			$this->db->join("akd_prodi pro","mhs.kdpstmsmhs= pro.kdpst");
			$this->db->where("skr.nim",$nim);
			$this->db->where("skr.tglselesai",$tglselesai);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function insert($tgl_next){
			//$this->non_aktif();
			$data = array(
				"nim" => $this->input->post("nimhsmsmhs"),
				"jenis" => $this->input->post("jenis"),
				"tglawal" => tgl_ingg($this->input->post("tglawal")),
				"tglselesai" => tgl_ingg($tgl_next),
				"nidnpembimbing1" => $this->input->post("nomkaprodi"),
				"nidnpembimbing2" => $this->input->post("nidnpembimbing2"),
				"thakad" => $this->input->post("thn_akad"),
				"judul" => $this->input->post("judul")
			);
			$this->db->insert("akd_trskripsi",$data);
		}
		
		function update(){
			$data = array(
				"nim" => $this->input->post("nimhsmsmhs"),
				"jenis" => $this->input->post("jenis"),
				"nidnpembimbing1" => $this->input->post("nomkaprodi"),
				"nidnpembimbing2" => $this->input->post("nidnpembimbing2"),
				"thakad" => $this->input->post("thn_akad"),
				"judul" => $this->input->post("judul")
			);
			$this->db->where("nim",$this->input->post("nim2"));
			$this->db->where("tglselesai",$this->input->post("tglselesai"));
			$this->db->update("akd_trskripsi",$data);
		}
		
		function non_aktif(){
			$data = array(
				"aktif" => ""
			);
			$this->db->update("trskripsi",$data);
		}

		function aktifkan($id){
			$this->trskripsi_m->non_aktif();
			$data = array(
				"aktif" => 1
			);
			$this->db->where("id_trskripsi",$id);
			$this->db->update("trskripsi",$data);
		}
		function delete($nim, $tglselesai){
			$this->db->where("tglselesai",$tglselesai);
			$this->db->where("nim",$nim);
			$this->db->delete("akd_trskripsi");
		}
	}
?>