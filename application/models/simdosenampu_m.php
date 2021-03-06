<?php
	Class Simdosenampu_m extends Model{
		function __construct(){
			parent::model();
		}
		function get_bydosen($npp){
			$thajaran = $this->auth->get_thactive()->thajaran;
			$sql = "SELECT id_kelas_dosen, kodemk,
				(SELECT namamk FROM simkurikulum WHERE kodemk = simdosenampu.kodemk)namamk,
				(SELECT sks FROM simkurikulum WHERE kodemk = simdosenampu.kodemk)sks,
				(SELECT kodeprodi FROM simkurikulum WHERE kodemk = simdosenampu.kodemk) kodeprodi,kelas
				FROM simdosenampu WHERE npp = '".$npp."' AND thajaran = '".$thajaran."' ";
			return $this->db->query($sql);
		}
		function count_bydosen($npp){
			$thajaran = $this->auth->get_thactive()->thajaran;
			$sql = "SELECT id_kelas_dosen, kodemk,
				(SELECT namamk FROM simkurikulum WHERE kodemk = simdosenampu.kodemk)namamk,
				(SELECT sks FROM simkurikulum WHERE kodemk = simdosenampu.kodemk)sks,
				(SELECT kodeprodi FROM simkurikulum WHERE kodemk = simdosenampu.kodemk) kodeprodi,kelas
				FROM simdosenampu WHERE npp = '".$npp."' AND thajaran = '".$thajaran."' ";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function cek_idkelasdipakai($id_kelas_dosen){
			$sql = "SELECT idkrs FROM simambilmk ";
			$sql .= " WHERE id_kelas_dosen = '".$id_kelas_dosen."' ";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function _getprefkodeprodi($kodematkul){
			$sql = "SELECT kodeprodi FROM simkurikulum WHERE kodemk = '".$kodematkul."' LIMIT 1";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
			return $hasil;
		}
		function get_bykelas_dosen($id_kelas_dosen){
			$sql = "SELECT * FROM simdosenampu WHERE id_kelas_dosen = ".$id_kelas_dosen;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		function get_dosenbyidkelas($id_kelas_dosen){
			$sql = "SELECT npp, nama FROM maspegawai WHERE npp = (SELECT npp FROM simdosenampu WHERE id_kelas_dosen = ".$id_kelas_dosen.")";
			$hasil = $this->db->query($sql);
			return $hasil->row();
		}
		function get_kelasdosen($kodematkul = '',$thajaran, $id_kelas_dosen){
			$kdprodi = $this->_getprefkodeprodi($kodematkul);
			$kodeprodi = $kdprodi['kodeprodi'];
			$sql = "SELECT *,
					(SELECT nama FROM simruang WHERE id_ruang = simdosenampu.id_ruang) ruang,
					(SELECT semester FROM simkurikulum WHERE kodemk=simdosenampu.kodemk) semester,
					(SELECT sks FROM simkurikulum WHERE kodemk=simdosenampu.kodemk) sks,
					(SELECT namamk FROM simkurikulum WHERE kodemk=simdosenampu.kodemk) namamk,
					(SELECT namaprodi FROM simprodi WHERE kodeprodi=".$kodeprodi.") namaprodi,
					kelas FROM simdosenampu ";
			$sql .= " WHERE thajaran = '".$thajaran."'
					AND id_kelas_dosen = '".$id_kelas_dosen."'";
			if($kodematkul){
				$sql .= " AND kodemk = '".$kodematkul."'";
			}
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
			return $hasil;
		}		
		function select($limit2,$limit1){
			$data = array();
			$this->db->select("*");
			$this->db->from("simdosenampu");
			$this->db->order_by("id_simdosenampu","DESC");
			$this->db->limit($limit1,$limit2);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_one($id){
			$sql = "SELECT id_kelas_dosen,kodemk,npp,thajaran,jamawal,jamselesai,hari,id_ruang,
					(SELECT namamk FROM simkurikulum WHERE kodemk=simdosenampu.kodemk)namamatkul,kelas,
					(SELECT nama FROM maspegawai WHERE npp = simdosenampu.npp)namadosen
					FROM simdosenampu WHERE id_kelas_dosen = ".$id." ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row();
			}else{
				return false;
			}
		}
		function get_onepengampu($id_kelas_dosen){
			$sql = "SELECT id_kelas_dosen,kodemk,npp,(SELECT namamk FROM simkurikulum WHERE kodemk=simdosenampu.kodemk)namamatkul,
					(SELECT nama FROM maspegawai WHERE npp=simdosenampu.npp)namadosen
					FROM simdosenampu WHERE id_kelas_dosen = ".$id_kelas_dosen." ";
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}
		}
		function get_matkul($limit1='', $limit2='', $thajaran='', $cari = '', $kodeprodi = ''){
			$sql = "SELECT kodemk,id_kelas_dosen,(SELECT namamk FROM simkurikulum WHERE kodemk=simdosenampu.kodemk)namamk,kelas,
					(SELECT nama FROM maspegawai WHERE npp=simdosenampu.npp)namadosen
					FROM simdosenampu WHERE thajaran = '".$thajaran."' ";
			if($this->session->userdata('sesicari_katmatakuliahtawar') == 'namadosen'){
				$kategori = "(SELECT nama FROM maspegawai WHERE npp=simdosenampu.npp)";
			}elseif($this->session->userdata('sesicari_katmatakuliahtawar') == 'namamk'){
				$kategori = "(SELECT namamk FROM simkurikulum WHERE kodemk=simdosenampu.kodemk)";
			}else{
				$kategori = $this->session->userdata('sesicari_katmatakuliahtawar');
			}
			if($kodeprodi){
				$res = '';
				$arkode = $this->matkulprodi($kodeprodi);
				foreach($arkode->result() as $a){
					$res  .= "'".$a->kodemk."',";
				};
				if($res)
					$res=substr($res,0,strlen($res)-1);
				else
					$res = '';

				$sql .= " AND kodemk IN(".$res.")";
			}
			if($cari && $kategori){
				$sql .= " AND ".$kategori." LIKE '%".$cari."%'";
			}
			$sql .= " LIMIT ".$limit2;
			if($limit1){
				$sql .= " ,".$limit1." ";
			}
			return $this->db->query($sql);
		}
		function matkulprodi($kodeprodi){
			$sql = 'SELECT kodemk FROM simkurikulum WHERE kodeprodi = "'.$kodeprodi.'"';
			$hasil = $this->db->query($sql);
			return $hasil;
		}
		function count_matkul($thajaran='', $cari = '', $kodeprodi = ''){
			$sql = "SELECT kodemk FROM simdosenampu WHERE thajaran = '".$thajaran."' ";
			if($this->session->userdata('sesicari_katmatakuliahtawar') == 'namadosen'){
				$kategori = "(SELECT nama FROM maspegawai WHERE npp=simdosenampu.npp)";
			}elseif($this->session->userdata('sesicari_katmatakuliahtawar') == 'namamk'){
				$kategori = "(SELECT namamk FROM simkurikulum WHERE kodemk=simdosenampu.kodemk)";
			}else{
				$kategori = $this->session->userdata('sesicari_katmatakuliahtawar');
			}
			if($kodeprodi){
				$res = '';
				$arkode = $this->matkulprodi($kodeprodi);
				foreach($arkode->result() as $a){
					$res  .= "'".$a->kodemk."',";
				};
				if($res)
					$res=substr($res,0,strlen($res)-1);
				else
					$res = '';

				$sql .= " AND kodemk IN(".$res.")";
			}
			if($cari && $kategori){
				$sql .= " AND ".$kategori." LIKE '%".$cari."%'";
			}
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		function getOne($npp = '', $kodeprodi = ''){
			if(!$npp){
				$npp = $this->session->userdata('sesi_dosenampu');
			}
			$data = array();
			/*$sql = "SELECT *,(SELECT namamk FROM simkurikulum WHERE simkurikulum.kodemk=simdosenampu.kodemk)namamk,
					(SELECT sks FROM simkurikulum WHERE simkurikulum.kodemk=simdosenampu.kodemk) sks,
					(SELECT nama FROM simruang WHERE simruang.id_ruang=simdosenampu.id_ruang) ruang FROM
					simdosenampu WHERE thajaran = '".$this->session->userdata('sesi_thajaran')."' "; */
			$sql = 'SELECT *,(SELECT nama FROM simruang WHERE simruang.id_ruang = simdosenampu.id_ruang)ruang
					FROM simdosenampu INNER JOIN simkurikulum ON simdosenampu.kodemk = simkurikulum.kodemk
					WHERE thajaran = "'.$this->session->userdata('sesi_thajaran').'"';
			$sql .= " AND npp = '".$npp."'";
			if($kodeprodi){
				$sql .= " AND kodeprodi = '".$kodeprodi."'";
			}
			return $this->db->query($sql);
		}
		function cek_inputsama($npp, $kodemk, $kelas, $thajaran = ''){
			$thajaran = $thajaran = $this->auth->get_thactive()->thajaran;
			$this->db->select('npp');
			$this->db->from('simdosenampu');
			$this->db->where('npp', $npp);
			$this->db->where('kodemk', $kodemk);
			$this->db->where('kelas', $kelas);
			$this->db->where('thajaran', $thajaran);
			return $this->db->count_all_results();
		}
		function insert(){
			$data = array(
				"npp" => $this->session->userdata('sesi_dosenampu'),
				"thajaran" => $this->session->userdata('sesi_thajaran'),
				"kodemk" => $this->input->post("txt_kode_mk"),
				"id_ruang" => $this->input->post("id_ruang"),
				"kelas" => $this->input->post("kelas"),
				"hari" => $this->input->post("hari"),
				"jamawal" => $this->input->post("jamawal"),
				"jamselesai" => $this->input->post("jamselesai")
			);
			$this->db->insert("simdosenampu",$data);
		}
		function update(){
			$data = array(
				"thajaran" => $this->input->post('thajaran'),
				"npp" => $this->input->post('npp'),
				"kodemk" => $this->input->post("kodemk"),
				"id_ruang" => $this->input->post("id_ruang"),
				"kelas" => $this->input->post("kelas"),
				"hari" => $this->input->post("hari"),
				"jamawal" => $this->input->post("jamawal"),
				"jamselesai" => $this->input->post("jamselesai")
			);
			$this->db->where('id_kelas_dosen', $this->input->post('id_kelas_dosen'));
			$this->db->update("simdosenampu",$data);
		}
		function delete($id_kelas_dosen){
			$this->db->where('id_kelas_dosen', $id_kelas_dosen);
			$this->db->delete('simdosenampu');
		}
	}
?>