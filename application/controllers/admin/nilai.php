<?php
	Class Nilai extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simambilmk_m','simdosenampu_m','simkrs_m','simprodi_m','simsetting_m','simmktawar_m','simdosenwali_m','maspegawai_m','masmahasiswa_m','simkurikulum_m','simmatrikulasi_m'));
			$this->load->library(array('auth','simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function ubah_thajaran(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_cbthajarannilai', $this->uri->segment(4));
			}
			redirect('admin/nilai/input');
		}
		function change_kelas(){
			$this->session->set_userdata('sesi_kelas', $this->uri->segment(4));
			redirect('admin/nilai/input_bydosen');
		}
		function index_inputbydosen(){
			$this->session->set_userdata('sesi_dosenampu', $this->uri->segment(4,0));
			redirect('admin/nilai/input_bydosen');
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
				$this->load->view('admin/nilai/inilaibydosen_v',$data);
			}
		}
		function save_bydosen(){
			$n = $this->input->post('n');
			if($this->session->userdata('sesi_thajaran')){
				$thajaran = $this->session->userdata('sesi_thajaran');
				$kodemk = $this->session->userdata('sesi_kodemk');
				for($i=1;$i<=$n;$i++){
					$this->simkrs_m->update_nilai($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilaiuts_'.$i));
					/*echo $this->db->last_query();*/
				}
			}
			$data['title'] = 'Konfirmasi Simpan';
			$this->load->view('dosen/tsukses_simpan_v', $data);
			//redirect('dosen/nilai/input/'.$this->session->userdata('sesi_kodemk'));
		}
		function index(){
			$this->_empty_sesi();
			$set = $this->simsetting_m->select_active();
			$thakad = $set['thajaran'];
			$this->session->set_userdata('sesi_cbthajarannilai', $thakad);
			redirect('admin/nilai/input');
		}
		function change_thajarankhs(){
			if($this->uri->segment(4) == true){
				$this->session->set_userdata('sesi_khsthajaran', $this->uri->segment(4));
				if($this->session->userdata('sesi_nimmhs') == false){
					echo "<center>Tentukan NIM untuk melihat KHS mahasiswa</center>";
				}else{
					$this->cari_browse_khs();
				}
			}
		}
		function transkrip(){
			$data['title'] = 'Daftar Nilai Keseluruhan Mahasiswa';
			$this->load->view('admin/nilai/thead_transkrip_v', $data);
		}
		function cari_nimtranskrip(){
			if($this->input->post('txtNimMhs')){
				$this->session->set_userdata('sesi_nimtranskrip', $this->input->post('txtNimMhs'));
			}
			$this->browse_transkrip();
		}
		function browse_transkrip(){
			$nim = $this->session->userdata('sesi_nimtranskrip');
			$data['browse_transkrip'] = $this->simambilmk_m->get_transkrip($nim);
			$data['browse_matrikulasi'] = $this->simmatrikulasi_m->get_nolimit($nim);
			$this->load->view('admin/nilai/ttranskrip_v', $data);
		}
		function transkrip_excel(){
			$data['nim'] = $this->session->userdata('sesi_nimtranskrip');
			$data['browse_transkrip'] = $this->simambilmk_m->get_transkrip($data['nim']);
			$data['browse_matrikulasi'] = $this->simmatrikulasi_m->get_nolimit($data['nim']);
			$this->load->view('admin/nilai/ttranskrip_excel_v', $data);
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
			$this->load->view('admin/laporan/ctranskrip_s', $data);
		}
		function khs(){
			$data['title'] = 'Kartu Hasil Studi';
			$data['browse_thajar'] = $this->simsetting_m->select();
			$this->session->set_userdata('sesi_nimmhs', '');
			$this->load->view('admin/thead_khs_v', $data);
		}
		function cari_browse_khs(){
			if($this->input->post('txtNimMhs')){
				$this->session->set_userdata('sesi_nimmhs', $this->input->post('txtNimMhs'));
			}
			$this->browse_khs();
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
			$this->load->view('admin/nilai/tkhs_v', $data);
		}
		function cetak_khs(){
			if($this->uri->segment(4) == 'xls'){
				$namafile = 'KHS-'.$this->session->userdata('sesi_nimmhs').'.xls';
				header("Content-type: application/excel");
				header("Content-disposition: attachment; filename=".$namafile);
			}
			$nim = $this->session->userdata('sesi_nimmhs');
			if($this->session->userdata('sesi_khsthajaran') == false){
				$set = $this->simsetting_m->select_active();
				$data['thakad'] = $set['thajaran'];
			}else{
				$data['thakad'] = $this->session->userdata('sesi_khsthajaran');
			}
			/*
			$data['max_pengambilan_sks'] = $this->simkrs_m->res_sks($nim, $data['thakad']);
		
			$data['ipkabeh'] = $this->simkrs_m->get_ipk($nim);
			$data['sksini'] = $this->simkrs_m->get_total($nim, $data['thakad'])->jumsks;
			$data['skskabeh'] = $this->simkrs_m->get_total($nim)->jumsks;
			$data['mutuini'] = $this->simkrs_m->get_total($nim, $data['thakad'])->mutu;
			$data['mutukabeh'] = $this->simkrs_m->get_total($nim)->mutu;
			*/
			
			
			$data['dm'] = $this->simkrs_m->get_one($nim, $data['thakad']);
			$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
			$dpa = $this->simdosenwali_m->get_namadpa($nim, $data['thakad']);
			$data['nama_dpa'] = $dpa['nama'];
			$this->load->view('admin/laporan/ckhs_v', $data);
		}
		function cari_matkul(){
			/*$this->session->set_userdata('sesi_namamk', $this->input->post('txt_namamk'));
			$this->session->set_userdata('sesi_fieldtawar', $this->input->post('matkul'));*/
			$field = $this->input->post('matkul');
			$value = $this->input->post('txt_namamk');
			$data['browse_matkul'] = $this->simmktawar_m->get_cari_all(15, $field, $value);
			$this->load->view('admin/tmatkul_v', $data);
		}
		function pilih_matakuliah($kodemk = ''){
			if($kodemk){
				$this->session->set_userdata('sesi_kodemk', $kodemk);
			}else{
				$this->session->set_userdata('sesi_kodemk', $this->uri->segment(4,0));
			}
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
				$this->load->view('admin/tmahasiswaambilmk_v',$data);
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
			$data['thajaran'] = $this->simsetting_m->select();
			$thajar = $this->simsetting_m->select_active();
			$this->session->set_userdata('sesi_thajaran', $thajar['thajaran']);
			$this->load->view('admin/inilai_v', $data);
		}
		function save(){
			$n = $this->input->post('n');
			$kodemk = $this->session->userdata('sesi_kodemk');
			if($this->session->userdata('sesi_cbthajarannilai')){
				$thajaran = $this->session->userdata('sesi_cbthajarannilai');
				//$thajaran = '20102';
				for($i=0;$i<=$n;$i++){
					// echo $this->input->post('nim_'.$i).'='.$this->input->post('nilai_'.$i).'<br />';
					$this->simkrs_m->update_nilai_admin($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilai_angka_'.$i));
					//$this->simkrs_m->update_nilai_feeder($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilai_angka_'.$i));
					// echo $this->db->last_query().'<br />';
				}
				for($i=0;$i<=$n;$i++){
					// echo $this->input->post('nim_'.$i).'='.$this->input->post('nilai_'.$i).'<br />';
					//$this->simkrs_m->update_nilai_admin($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilai_angka_'.$i));
					$this->simkrs_m->update_nilai_feeder($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilai_angka_'.$i));
					$nim = $this->input->post('nim_'.$i);
					$data["kodemk"] = $kodemk;
					$data["nim"] = $nim;
					$this->load->view("admin/push_nilai",$data);
					// echo $this->db->last_query().'<br />';
				}
				$this->load->view('admin/nilai/tsukses_simpan_v.php');
				
			}
			/* $this->pilih_matakuliah($kodemk); */
			//redirect('admin/nilai/pilih_matakuliah/'.$this->session->userdata('sesi_kodemk'));
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