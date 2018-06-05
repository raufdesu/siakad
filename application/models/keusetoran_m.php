<?php
	Class Keusetoran_m extends Model{
		function __construct(){
			parent::model();
			$this->load->model(array('simaktifsemester_m', 'simprodi_m', 'masmahasiswa_m', 'simkrs_m'));
			$this->load->model(array('paket_m', 'simsetting_m', 'simdaftarskripsi_m', 'simdosenwali_m'));

		}
		function insert(){
			$idbiaya = $this->input->post('idbiaya');
			$data = array(
				'idbiaya'	=> $idbiaya,
				'jumsetoran'	=> angka_utuh($this->input->post('jumsetoran')),
				'petugas'	=> $this->input->post('petugas'),
				'tglsetor'	=> tgl_ingg($this->input->post('tglsetor')).' '.date('H:i:s'),
				'keterangan'=> $this->input->post('keterangan')
			);
			$this->db->insert('keusetoran', $data);
		}
		function status_semester($nim, $thajaran, $status=''){
			$data = array(
				'status' => $status,
				'tglaktifkan' => date('Y-m-d H:i:s')
			);
			$this->db->where('nim', $nim);
			$this->db->where('thajaran', $thajaran);
			$this->db->update('simaktifsemester', $data);
		}
		function tentukan_status($idbiaya, $nim='', $thajaran=''){
			$tagihan = $this->get_tagihan($idbiaya);
			$totalsetoran = $this->get_totalsetoran($idbiaya);
			if($tagihan == $totalsetoran){
				$data = array(
					'status' => 'Lunas'
				);
				$this->db->where('idbiaya', $idbiaya);
				$this->db->update('keubiaya', $data);
			}
		}
		function aktif_setengah($idbiaya, $nim='', $thajaran=''){
			$tagihan2 = $this->get_setengah($idbiaya);
			$totalsetoran = $this->get_totalsetoran($idbiaya);
			$mhspaket	= $this->masmahasiswa_m->get_one($nim);
			if($totalsetoran >= $tagihan2){
				$namabiaya = strtoupper($this->namabiaya_byidbiaya($idbiaya));
				if(preg_match("/\bSPP SEMESTER\b/i", $namabiaya)){
					
					if($mhspaket['statuspaket'] == 'paket'){
					$cek_sudahaturpaket = $this->paket_m->count_all('', $mhspaket['kodeprodi'], $mhspaket['angkatan'], $mhspaket['kdkelas'], $thajaran);
					if($cek_sudahaturpaket){
						$cek_punyadpa = $this->simdosenwali_m->cek_dosenwali($nim);
						if($cek_punyadpa){
							$this->simkrs_m->insert_paket($nim, $mhspaket['kodeprodi'], $mhspaket['angkatan'], $mhspaket['kdkelas'], $thajaran);
							$this->status_semester($nim, $thajaran, 'Aktif');
							echo $this->simplival->alert('KONFIRMASI\nPengaktifan status dan penginputan KRS Paket\ndengan NIM '.$nim.' berhasil');
						}else{
							echo $this->simplival->alert('PERINGATAN\nGagal mengaktifkan status mahasiswa, karena DPA mahasiswa terpilih belum ditentukan.\nHarap administrator menentukan DPA mahasiswa dengan NIM '.$nim.' terlebih dahulu');
							$this->listview(1);
						}
					}else{
						echo $this->simplival->alert('PERINGATAN !\nGagal diaktifkan. Matakuliah Paket belum diatur');
						$this->listview(1);
					}
				}else{
					$this->status_semester($nim, $thajaran, 'Aktif');
				}
				}
			}
		}
		function namabiaya_byidbiaya($idbiaya){
			$sql	= 'SELECT namabiaya FROM keubiaya WHERE idbiaya = '.$idbiaya;
			$hasil	= $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->namabiaya;
			}else{
				return false;
			}
		}
		function get_tagihan($idbiaya){
			$sql	= 'SELECT jumbiaya FROM keubiaya WHERE idbiaya = '.$idbiaya;
			$hasil	= $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->jumbiaya;
			}else{
				return false;
			}
		}
		function get_setengah($idbiaya){
			$sql	= 'SELECT minaktif FROM keubiaya WHERE idbiaya = '.$idbiaya;
			$hasil	= $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->minaktif;
			}else{
				return false;
			}
		}
		function get_totalsetoran($idbiaya){
			$sql	= 'SELECT SUM(jumsetoran) totalsetoran FROM keusetoran WHERE idbiaya = '.$idbiaya;
			$hasil	= $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->totalsetoran;
			}else{
				return false;
			}
		}
		function delete($id){
			$this->db->where('idsetoran', $id);
			$this->db->delete('keusetoran');
		}
		function get_lastidsetoran($idbiaya=''){
			$sql = 'SELECT * FROM keusetoran ';
			if($idbiaya){
				$sql .= ' WHERE idbiaya = '.$idbiaya;
			}
			$sql .= ' ORDER BY idsetoran DESC LIMIT 1';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows()){
				return $hasil->row()->idsetoran;
			}else{
				return false;
			}
		}
		function delete_last($idbiaya, $nim='', $thajaran=''){
			$last_idsetoran = $this->get_lastidsetoran($idbiaya);
			$sql = 'DELETE FROM keusetoran WHERE idsetoran = '.$last_idsetoran;
			$this->db->query($sql);

			$data = array(
				'status' => 'Belum Lunas'
			);
			$this->db->where('idbiaya', $idbiaya);
			$this->db->update('keubiaya', $data);

			$namabiaya = strtoupper($this->namabiaya_byidbiaya($idbiaya));
			if(preg_match("/\bSPP SEMESTER\b/i", $namabiaya)){
				$this->status_semester($nim, $thajaran, 'Non Aktif');
			}
		}
	}
?>