<?php
	Class Dosen_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function select($limit2,$limit1){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab");
			$this->db->from("akd_dosen ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			$this->db->join("tbkod2 t2","ad.jabakad = t2.kdkodtbkod");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function select_dosen_dpa(){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_dosen ad");
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
			$this->db->from("akd_dosen ad");
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

		function detail($kd_peg){
			$data = array();
			$this->db->select("*,t2.nmkodtbkod as nama_jab,tbkod1.kdkodtbkod as kd_pend,tbkod1.nmkodtbkod as nm_pend,
				tbkod15.nmkodtbkod as nama_aktif, t3.nmkodtbkod as nama_setker");
			$this->db->from("akd_dosen ad");
			$this->db->join("peg_biodata pb","ad.kdpeg = pb.kdpeg");
			//$this->db->join("tbkod1 t1","ad.pendidikan = t1.kdkodtbkod");
			//$this->db->join("tbkod15 t15","ad.jabakad = t15.kdkodtbkod");
			$this->db->join("tbkod3 t3","ad.statuskerja = t3.kdkodtbkod");
			$this->db->join("tbkod2 t2","ad.jabakad = t2.kdkodtbkod");
			$this->db->join("tbkod1","tbkod1.kdkodtbkod = ad.pendidikan");
			$this->db->join("tbkod15","tbkod15.kdkodtbkod = ad.statusaktif");
			$this->db->where("ad.kdpeg",$kd_peg);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
		function update(){
			$data = array(
				"kdpeg" => $this->input->post("kdpeg"),
				"nidn" => $this->input->post("nidn"),
				"jabakad" => $this->input->post("jabakad"),
				"pendidikan" => $this->input->post("pendidikan"),
				"tmtakad" => tgl_ingg($this->input->post("tmtakad")),
				"statuskerja" => $this->input->post("statuskerja"),
				"statusaktif" => $this->input->post("statusaktif"),
				"semkeluar" => $this->input->post("semkeluar"),
				"sertajar" => $this->input->post("sertajar"),
				"suratijinajar" => $this->input->post("suratijinajar"),
				"nip" => $this->input->post("nip"),
				"kdptiinduk" => $this->input->post("kdptiinduk"),
				"namaptinondiknas" => $this->input->post("namaptinondiknas")
			);
			$this->db->where("kdpeg",$this->input->post("kdpeg"));
			$this->db->update("akd_dosen",$data);
		}

		function delete($kode){
			$this->db->where("kdpeg",$kode);
			$this->db->delete("akd_dosen");
		}
		function insert(){
			$data = array(
				"kdpeg" => $this->input->post("kdpeg"),
				"nidn" => $this->input->post("nidn"),
				"jabakad" => $this->input->post("jabakad"),
				"pendidikan" => $this->input->post("pendidikan"),
				"tmtakad" => tgl_ingg($this->input->post("tmtakad")),
				"statuskerja" => $this->input->post("statuskerja"),
				"statusaktif" => $this->input->post("statusaktif"),
				"semkeluar" => $this->input->post("semkeluar"),
				"sertajar" => $this->input->post("sertajar"),
				"suratijinajar" => $this->input->post("suratijinajar"),
				"nip" => $this->input->post("nip"),
				"kdptiinduk" => $this->input->post("kdptiinduk"),
				"namaptinondiknas" => $this->input->post("namaptinondiknas")
			);
			$this->db->insert("akd_dosen",$data);
		}
	}
?>