<?php
	Class Nilai extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simdosenampu_m','simambilmk_m','simkrs_m','simprodi_m','simsetting_m','simmktawar_m','simdosenwali_m','maspegawai_m','masmahasiswa_m','simkurikulum_m','simmatrikulasi_m'));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index_inputbydosen(){
			$this->session->set_userdata('sesi_dosenampu', $this->uri->segment(4,0));
			redirect('prodi/nilai/input_bydosen');
		}
		function input_bydosen(){
			$sesi_dosenampu = $this->session->userdata('sesi_dosenampu');
			$ampu = $this->simdosenampu_m->get_one($sesi_dosenampu);
			$data['kodemk'] = $ampu->kodemk;
			$data['namamatkul'] = $ampu->namamatkul;
			$data['kelas'] = $ampu->kelas;
			$data['thajaran'] = $ampu->thajaran;
			$data['id_kelas_dosen'] = $ampu->id_kelas_dosen;
			$this->session->set_userdata('sesi_kodemk', $data['kodemk']);
			/* kelas siang atau malam masih statis */
			$kelas = $this->session->userdata('sesi_kelas');
			if($sesi_dosenampu){
				$data['browse_mahasiswaambilmk'] = $this->masmahasiswa_m->get_mhs_sudahambilmk($data['kodemk'], $data['thajaran'], $data['id_kelas_dosen'], $kelas);
				$this->load->view('prodi/nilai/inilaibydosen_v',$data);
			}
		}
		function ubah_thajaran(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_cbthajarannilai', $this->uri->segment(4));
			}
			redirect('prodi/nilai/input');
		}
		function index(){
			$this->_empty_sesi();
			$set = $this->simsetting_m->select_active();
			$thakad = $set['thajaran'];
			$this->session->set_userdata('sesi_cbthajarannilai', $thakad);
			redirect('prodi/nilai/input');
		}
		function change_thajarankhs(){
			if($this->uri->segment(4) == true){
				$this->session->set_userdata('sesi_khsthajaran', $this->uri->segment(4));
				if($this->session->userdata('sesi_nimmhs') == false){
					echo "<center>Tentukan NIM untuk melihat KHS mahasiswa</center>";
				}else{
					$this->browse_khs();
				}
			}
		}
		function transkrip(){
			$data['title'] = 'Daftar Nilai Keseluruhan Mahasiswa';
			$this->load->view('prodi/nilai/thead_transkrip_v', $data);
		}
		function cari_nimtranskrip(){
			if($this->session->userdata('sesi_prodi')){
				$cek_nimprodi = $this->simprodi_m->cek_nimprodi($this->session->userdata('sesi_prodi'), $this->input->post('txtNimMhs'));
				if($cek_nimprodi){
					$this->session->set_userdata('sesi_nimtranskrip', $this->input->post('txtNimMhs'));
					$this->browse_transkrip();
				}else{
					$namaprodi = $this->auth->get_namaprodi($this->session->userdata('sesi_prodi'));
					echo $this->simplival->alert('KONFIRMASI\nHarap memasukkan NIM mahasiswa PRODI '.$namaprodi);
				}
			}else{
				redirect(base_url());
			}
		}
		function browse_transkrip(){
			$nim = $this->session->userdata('sesi_nimtranskrip');
			$data['browse_transkrip'] = $this->simambilmk_m->get_transkrip($nim);
			$data['browse_matrikulasi'] = $this->simmatrikulasi_m->get_nolimit($nim);
			$this->load->view('prodi/nilai/ttranskrip_v', $data);
		}
		function transkrip_excel(){
			$cek_nimprodi = $this->simprodi_m->cek_nimprodi($this->session->userdata('sesi_prodi'), $this->session->userdata('sesi_nimtranskrip'));
			if($cek_nimprodi){
				$data['nim'] = $this->session->userdata('sesi_nimtranskrip');
				$data['browse_transkrip'] = $this->simambilmk_m->get_transkrip($data['nim']);
				$data['browse_matrikulasi'] = $this->simmatrikulasi_m->get_nolimit($data['nim']);
				$this->load->view('prodi/nilai/ttranskrip_excel_v', $data);
			}else{
				redirect(base_url());
			}
		}
		function cetak_transkrip(){
			$nim = $this->session->userdata('sesi_nimtranskrip');
			$data['cetak_transkrip'] = $this->simambilmk_m->get_transkrip($nim);
			$data['cetak_matrikulasi'] = $this->simmatrikulasi_m->get_nolimit($nim);
			if($this->session->userdata('sesi_khsthajaran') == false){
				$set = $this->simsetting_m->select_active();
				$data['thakad'] = $set['thajaran'];
			}else{
				$data['thakad'] = $this->session->userdata('sesi_khsthajaran');
			}
			$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $data['thakad']);
			$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
			$dpa = $this->simdosenwali_m->get_namadpa($nim, $data['thakad']);
			$data['nama_dpa'] = $dpa['nama'];
			$this->load->view('prodi/laporan/ctranskrip_s', $data);
		}
		function khs(){
			$data['title'] = 'Kartu Hasil Studi';
			$data['browse_thajar'] = $this->simsetting_m->select();
			$this->session->set_userdata('sesi_nimmhs', '');
			$this->session->set_userdata('sesi_khsthajaran', '');
			$this->load->view('prodi/nilai/thead_khs_v', $data);
		}
		function cari_browse_khs(){
			$prodimhs = $this->masmahasiswa_m->get_kodeprodibynim($this->input->post('txtNimMhs'));
			if($prodimhs == $this->session->userdata('sesi_prodi')){
				if($this->input->post('txtNimMhs')){
					$this->session->set_userdata('sesi_nimmhs', $this->input->post('txtNimMhs'));
				}
				$this->browse_khs();
			}else{
				echo "<div style='border:1px solid brown;padding:8px;width:97%;background-color:yellow;margin:10px auto;'>
					<b>PERINGATAN</b><br />Harap memasukkan NIM mahasiswa yang berada pada prodi Anda dengan benar</div>
					<script> stoploading() </script>";
			}
		}
		function browse_khs(){
			if($this->session->userdata('sesi_khsthajaran') == false){
				$set = $this->simsetting_m->select_active();
				$data['thakad'] = $set['thajaran'];
			}else{
				$data['thakad'] = $this->session->userdata('sesi_khsthajaran');
			}
			$data['nim'] = $this->session->userdata('sesi_nimmhs');
			$data['browse_khs'] = $this->simambilmk_m->get_khs($data['nim'], $data['thakad']);
			$this->load->view('prodi/nilai/tkhs_v', $data);
		}
		function cetak_khs(){
			$nim = $this->session->userdata('sesi_nimmhs');
			if($this->session->userdata('sesi_khsthajaran') == false){
				$set = $this->simsetting_m->select_active();
				$data['thakad'] = $set['thajaran'];
			}else{
				$data['thakad'] = $this->session->userdata('sesi_khsthajaran');
			}
			$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $data['thakad']);
			$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
			$dpa = $this->simdosenwali_m->get_namadpa($nim, $data['thakad']);
			$data['nama_dpa'] = $dpa['nama'];
			$this->load->view('prodi/laporan/ckhs_v', $data);
		}
		function cari_matkul(){
			/*$this->session->set_userdata('sesi_namamk', $this->input->post('txt_namamk'));
			$this->session->set_userdata('sesi_fieldtawar', $this->input->post('matkul'));*/
			$field = $this->input->post('matkul');
			$value = $this->input->post('txt_namamk');
			$data['browse_matkul'] = $this->simmktawar_m->get_cari_all(10, $field, $value);
			$this->load->view('prodi/tmatkul_v', $data);
		}
		function pilih_matakuliah(){
			$this->session->set_userdata('sesi_kodemk', $this->uri->segment(4,0));
			if($this->session->userdata('sesi_kodemk')){
				$nm = $this->simkrs_m->get_namamatkulnilai($this->session->userdata('sesi_kodemk'));
				/*echo $this->db->last_query();*/
				$data['nama_matkul'] = $nm['namamk'];
				$data['kode_matkul'] = $nm['kodemk'];
				$this->session->set_userdata('sesi_kodematkul', $data['kode_matkul']);
				$this->session->set_userdata('sesi_namamatkul', $data['nama_matkul']);
				$data['sks'] = $nm['sks'];
				if($this->session->userdata('sesi_cbthajarannilai')){
					$sesi_thajaran = $this->session->userdata('sesi_cbthajarannilai');
				}else{
					$sesi_thajaran = $this->session->userdata('sesi_cbthajarannilai');
				}
				$data['browse_mahasiswaambilmk'] = $this->masmahasiswa_m->get_allmhs_ambilmk($this->session->userdata('sesi_kodematkul'), $sesi_thajaran);
				//echo $this->db->last_query();
				/* echo 'Kode Matakuliah : '.$data['kode_matkul'].'<br />';
				echo 'Nama Matakuliah: '.$data['nama_matkul'].'<br />'; */
				$this->load->view('prodi/tmahasiswaambilmk_v',$data);
			}else{
				$data['nama_matkul'] = '';
				$data['kode_matkul'] = '';
				$data['sks'] = '';
			}
		}
		function input(){
			$data = '';
			if($this->session->userdata('sesi_cbthajarannilai')){
				$data['sesi_thajaran'] = $this->session->userdata('sesi_cbthajarannilai');
			}else{
				$data['sesi_thajaran'] = $this->session->userdata('sesi_thajaran');
			}
			/*$data = array(
				'kode_matkul' => '',
				'nama_matkul' => ''
			);*/
			$thajar = $this->simsetting_m->select_active();
			$this->session->set_userdata('sesi_thajaran', $thajar['thajaran']);
			$this->load->view('prodi/inilai_v', $data);
		}
		function save(){
			$n = $this->input->post('n');
			if($this->session->userdata('sesi_cbthajarannilai')){
				$thajaran = $this->session->userdata('sesi_cbthajarannilai');
				//$thajaran = '20102';
				$kodemk = $this->session->userdata('sesi_kodemk');
				for($i=0;$i<=$n;$i++){
					// echo $this->input->post('nim_'.$i).'='.$this->input->post('nilai_'.$i).'<br />';
					$this->simkrs_m->update_nilai($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i));
					// echo $this->db->last_query().'<br />';
				}
				$this->load->view('prodi/nilai/tsukses_simpan_v.php');
			}
			/* redirect('prodi/nilai/pilih_matakuliah/'.$this->session->userdata('sesi_kodemk')); */
		}
		function _empty_sesi(){
			$arsesi = array(
				'sesi_krs_nim' => '',
				'sesi_krs_nama' => '',
				'sesi_krs_prodi' => '',
				'sesi_krs_kelas' => '',
				'sesi_jumgab' => ''
			);
			$this->session->set_userdata($arsesi);
		}
	}
?>