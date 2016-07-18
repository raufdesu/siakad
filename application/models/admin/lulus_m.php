<?php
	Class Lulus_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function count_lulus($limit2,$limit1,$thn_lulus='',$cari=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_trlulus lulus");
			$this->db->join("akd_mhs mhs","lulus.nim = mhs.nimhsmsmhs");
			if($cari == true){
				$this->db->like("mhs.nimhsmsmhs",$cari);
				$this->db->or_like("mhs.nmmhsmsmhs",$cari);
			}
			return $this->db->count_all_results();
		}

		function select($limit2,$limit1,$thn_lulus='',$cari=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_trlulus lulus");
			$this->db->join("akd_mhs mhs","lulus.nim = mhs.nimhsmsmhs");
			if($cari == true){
				$this->db->like("mhs.nimhsmsmhs",$cari);
				$this->db->or_like("mhs.nmmhsmsmhs",$cari);
			}
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){             // QUERY MASIH SALAH :D 
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail($nim){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_trlulus lulus");
			$this->db->join("akd_mhs mhs","lulus.nim = mhs.nimhsmsmhs");
			$this->db->where("lulus.nim",$nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function insert(){
			$data = array(
				"nim" => $this->input->post("nimhsmsmhs"),
				"tgllulus" => tgl_ingg($this->input->post("tgllulus")),
				"totsks" => $this->input->post("totsks"),
				"ipkakhir" => $this->input->post("ipkakhir"),
				"nomskyudisium" => $this->input->post("nomskyudisium"),
				"tglskyudisium" => tgl_ingg($this->input->post("tglskyudisium")),
				"nomijasah" => $this->input->post("nomijasah"),
				"nomtranskrip" => $this->input->post("nomtranskrip")
			);
			$this->db->insert("akd_trlulus",$data);
		}
		
		function update(){
			$data = array(
				"nim" => $this->input->post("nimhsmsmhs"),
				"tgllulus" => tgl_ingg($this->input->post("tgllulus")),
				"totsks" => $this->input->post("totsks"),
				"ipkakhir" => $this->input->post("ipkakhir"),
				"nomskyudisium" => $this->input->post("nomskyudisium"),
				"tglskyudisium" => tgl_ingg($this->input->post("tglskyudisium")),
				"nomijasah" => $this->input->post("nomijasah"),
				"nomtranskrip" => $this->input->post("nomtranskrip")
			);
			$this->db->where("nim",$this->input->post("nimhsmsmhs"));
			$this->db->update("akd_trlulus",$data);
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
		function delete($nim){
			$this->db->where("nim",$nim);
			$this->db->delete("akd_trlulus");
		}
	}
?>