<?php
	Class Pembayaran_m extends Model{
		function __construct(){
			parent::model();
		}
		
	function get_idbiaya_bynim($nim, $thajaran){
			$data = array();
			$sql = "SELECT idbiaya from keubiaya where nim = '".$nim."' and thajaran = '".$thajaran."'";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;		
		}
	
	function get_thbynim($nim){
			$data = array();
			$sql = "SELECT thajaran FROM keubiaya WHERE nim = '".$nim."' GROUP BY thajaran ORDER BY thajaran DESC";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		
	function get_biaya($nim, $thajaran){
			$data = array();
			$res = "";
			$idbiaya = $this->get_idbiaya_bynim($nim, $thajaran);
			foreach($idbiaya as $a){
				$res  .= $a->idbiaya.",";
			};
			if($res)
				$res=substr($res,0,strlen($res)-1);
			else
				$res = "''";
				$sql = "SELECT *,SUM(jumsetoran) as totalsetoran from keusetoran INNER JOIN keubiaya 
				on keusetoran.idbiaya = keubiaya.idbiaya WHERE keubiaya.idbiaya IN(".$res.") GROUP BY keusetoran.idbiaya";
				$hasil = $this->db->query($sql);
				if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			return $data;
			}
		}

?>