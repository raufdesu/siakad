<?php
	Class Peserta_m extends Model{
		function __construct(){
			parent::model();
		}

		function sks_max($thakad){
			$sem_awal = substr($thakad, 4, 1);
			$thn_awal = substr($thakad, 0, 4);
			if($sem_awal % 2 == 0){
				$sem_cek = 2;
			}else{
				$sem_cek = 1;
			}

			if($sem_cek == 2){
				$thn_prev = $thn_awal;
				$sem_prev = 1;
			}else{
				$thn_prev = $thn_awal - 1;			
				$sem_prev = 2;
			}
			$hasil_awal = $thn_prev.$sem_prev;
			return $hasil_awal;
		}

		function transkrip_generate($nim, $limit1 = '', $limit2 = ''){
			$data = array();
			$this->db->select("nim, nilai, ascii('E') - ascii(nilai) as nilainya, sks, (ascii('E') - ascii(nilai)) * sks as point,
				kur.kdkmk kode_mk, nama1");
			$this->db->from("akd_peserta pes");
			$this->db->join("akd_kuliah kul", "pes.kdkuliah = kul.kdkuliah");
			$this->db->join("akd_kurmk kur", "kul.kdmk = kur.kdkmk");
			$this->db->join("akd_matakuliah mat", "kur.id_mk = mat.id_mk");
			$this->db->group_by("kode_mk");
			$this->db->where("pes.nim", $nim);
			if(($limit1 == true) or ($limit2 == true)){
				$this->db->limit($limit2, $limit1);
			}
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function hit_ipk($nim){
			$data = array();
			$this->db->select("nim, ascii('E') - ascii(nilai) as nilainya, sks, (ascii('E') - ascii(nilai)) * sks as point,kur.kdkmk kode_mk, nama1");
			$this->db->from("akd_peserta pes");
			$this->db->join("akd_kuliah kul", "pes.kdkuliah = kul.kdkuliah");
			$this->db->join("akd_kurmk kur", "kul.kdmk = kur.kdkmk");
			$this->db->join("akd_matakuliah mat", "kur.id_mk = mat.id_mk");
			$this->db->group_by("kode_mk");
			$this->db->where("pes.nim", $nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function count_sks($limit2,$limit1){
			$data = array();
			$this->db->select_count("akul.sks");
			$this->db->from("akd_peserta ap");
			$this->db->join("akd_kuliah akul","ap.kdkuliah = akul.kdkuliah");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}

		function mhs_kuliah($limit1='', $limit2='', $kd_matkul, $cari_nilai='',$thakad){
			$data = array();
			$this->db->select("*,mhs.nmmhsmsmhs nama_mhs, pes.kdkuliah kode_kuliah");
			$this->db->from("akd_mhs mhs");
			$this->db->join("akd_peserta pes", "mhs.nimhsmsmhs = pes.nim");
			$this->db->join("akd_kuliah kul", "pes.kdkuliah = kul.kdkuliah");
			$this->db->join("akd_kurmk akur", "kul.kdmk = akur.kdkmk");
			$this->db->join("akd_matakuliah amat", "akur.id_mk = amat.id_mk");
			$this->db->where("kul.kdmk",$kd_matkul);
			$this->db->where("kul.thakad",$thakad);
			if($cari_nilai == true){
				$this->db->like("mhs.nmmhsmsmhs",$cari_nilai);
				$this->db->or_like("pes.nim",$cari_nilai);
			}
			$this->db->group_by("mhs.nimhsmsmhs");
			$this->db->limit($limit2,$limit1);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function detail_krs_peserta($nim,$thakad){
			$data = array();
			$this->db->select("*");
			$this->db->from("akd_peserta ap");
			$this->db->join("akd_kuliah akul","ap.kdkuliah = akul.kdkuliah");
			$this->db->join("akd_kurmk akur","akul.kdmk = akur.kdkmk");
			$this->db->join("akd_matakuliah amat","akur.id_mk = amat.id_mk");
			$this->db->where("ap.nim",$nim);
			$this->db->where("akul.thakad",$thakad);
			$this->db->group_by("ap.kdkuliah");
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function insert(){
			$data = array(
				"kdkuliah" => $this->input->post("kdkuliah"),
				"nim" => $this->session->userdata("sesi_user_mhs"),
				"nilai" => $this->input->post("nilai")
			);
			$this->db->insert("akd_peserta",$data);
		}

		function update_nilai($kd_kul, $nim, $nilai){
			$data = array(
				"nilai" => $nilai
			);
			$this->db->where("nim",$nim);
			$this->db->where("kdkuliah",$kd_kul);
			$this->db->update("akd_peserta",$data);		
		}

		function delete($kdkuliah,$nim){
			$this->db->where("kdkuliah",$kdkuliah);
			$this->db->where("nim",$nim);
			$this->db->delete("akd_peserta");
		}
	}
?>