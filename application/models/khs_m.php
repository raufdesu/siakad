<?php
	Class Khs_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function khs_permahasiswa($nim,$thakad){
			/*$data = array();
			$this->db->dis('mk.kdmk');
			$this->db->from("krsmhs krs");
			$this->db->join("mastermhs mhs", "krs.nimmhs = mhs.nimmhs");
			$this->db->join("mastermk mk", "mk.kdmk = krs.kdmk");
			$this->db->where("krs.nimmhs", $nim);
			$this->db->group_by("mk.kdmk");
			$this->db->limit(50,0);
			if($thakad == true){
				$this->db->where("krs.thakad", $thakad);
			}*/
			$data = array();
			$sql="select kdmk,(select namamk from mastermk where krsmhs.kdmk=mastermk.kdmk AND mastermk.kdprodi IN 
(select kdprodi from mastermhs where mastermhs.nimmhs = krsmhs.nimmhs)) as namamk ,(select jumlahsks from mastermk where krsmhs.kdmk=mastermk.kdmk AND mastermk.kdprodi IN 
(select kdprodi from mastermhs where mastermhs.nimmhs = krsmhs.nimmhs)) as jumlahsks, nilaimhs 
from krsmhs where nimmhs='$nim' AND thakad='$thakad' order by thakad";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}

		function count_sks($nim, $thakad){
			$data = array();
			$this->db->select("SUM(kur.sks) jumsks");
			$this->db->from("akd_kurmk kur");
			$this->db->join("akd_kuliah kul","kur.kdkmk=kul.kdmk");
			$this->db->join("akd_peserta pes","kul.kdkuliah=pes.kdkuliah");
			$this->db->where("kul.thakad",$thakad);
			$this->db->where("pes.nim",$nim);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}		
	}
?>