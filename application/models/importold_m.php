<?php
	Class Importold_m extends Model{
		function __construct(){
			parent::model();
		}
		function insert_simkrs($nim, $thajaran, $kodeprodi){
			$data = array(
				'nim'	=> $nim,
				'thajaran'	=> $thajaran,
				'kodeprodi'	=> $kodeprodi
			);
			$this->db->insert('simkrs', $data);
		}
		function import(){
			$data = '';
			$sql_mhs = "SELECT DISTINCT nim,thajaran,kodeprodi FROM nilai";
			$query = $this->db->query($sql_mhs);
			foreach ($query->result() as $rec){
				$this->insert_simkrs($rec->nim,$rec->thajaran,$rec->kodeprodi);
			}
			//return $data;
		}
		function import2(){
			$data = '';
			$sql_krs = "SELECT nim,kodemk,nilaihuruf,
				(SELECT idkrs FROM simkrs WHERE nim = nilai3.nim AND thajaran = nilai3.thajaran LIMIT 1)AS id_krs
				FROM nilai3 LIMIT 240000, 40000";
			$query_krs = $this->db->query($sql_krs);
			foreach($query_krs->result() as $rec){
				$this->insert_simambilmk($rec->id_krs, $rec->kodemk, $rec->nilaihuruf);
			}
			return $data;
		}
		function insert_simambilmk($idkrs, $kodemk, $nilaihuruf){
			$data = array(
				'idkrs'		=> $idkrs,
				'kodemk'	=> $kodemk,
				'nilaihuruf'	=> $nilaihuruf
			);
			$this->db->insert('simambilmk', $data);
			//$this->db->truncate('krsmhs');
		}
		function import_krs(){
			$data = '';
			$sql_krs = "SELECT * FROM nilai";
			$que_krs = $this->db->query($sql_krs);
			foreach($que_krs->result() as $rec){
				$this->db->insert();
			}
			$this->db->truncate('nilai');
		}
		function import_matakuliah(){
			$data = '';
			$sql_matkul = "SELECT * FROM mastermk";
			$que_matkul = $this->db->query($sql_matkul);
			foreach($que_matkul->result() as $rec){
				$data = array(
					'kodemk'	=> $rec->kdmk,
					'namamk'	=> $rec->namamk,
					'namamkinggris'	=> $rec->namaenglish,
					'kodeprodi'	=> $rec->kdprodi,
					'sks'	=> $rec->jumlahsks,
					'teori_praktek'	=> '',
					'wajib_pilihan'	=> '',
					'semester'	=> $rec->semester,
					'inti'	=> '',
					'sifat'	=> '',
					'prasyarat'	=> '',
					'thnkur'	=> '',
				);
				$this->db->insert('simkurikulum', $data);
			}
			//$this->db->truncate('mastermk');
		}
	}
?>