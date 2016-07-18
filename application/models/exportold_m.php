<?php
	Class Exportold_m extends Model{
		function __construct(){
			parent::model();
		}
		
		function export_old(){
			$data = '';
			$sql_mhs = "SELECT * FROM krsmhs";
			$query = $this->db->query($sql_mhs);
			foreach ($query->result() as $rec)
			{
				$this->insert_simambilmk($rec->nim);
				$this->insert_simkrs('','','');
			}
			return $data;
		}
		function insert_simambilmk(){
			$data = array();
		}
		function insert_simkrs($idkrs, $nim, $thajaran){
			$data = array(
				'idkrs'	=> $idkrs,
				'nim'	=> $nim,
				'thajaran'	=> $thajaran,
				'thajaran'	=> '0000-00-00'
			);
			$this->db->insert($data);
		}
	}
?>