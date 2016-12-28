<?php
	Class Nilai extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simkrs_m','simprodi_m','simsetting_m','simdosenwali_m','simdosenampu_m','masmahasiswa_m','simkurikulum_m'));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function index(){
			/* $this->_empty_sesi(); */
			$this->daftarmatkul_bydosen();
		}
		function daftarmatkul_bydosen(){
			$data['title'] = 'Daftar Matakuliah Yang Diampu';
			$data['browse_matakuliah'] = $this->simdosenampu_m->get_bydosen($this->session->userdata('sesi_user'));
			if($this->simdosenampu_m->count_bydosen($this->session->userdata('sesi_user'))){
				$this->load->view('dosen/tmatkul_nilai', $data);
			}else{
				$konfirmasi = '<h3>KONFIRMASI</h3>Pada tahun ajaran sekarang, anda <b>belum</b> mempunyai matakuliah ampuan. Besar kemungkinan,
				bagian akademik belum melakukan pendistribusian pengajar matakuliah';
				echo '<div class="konfirmasi">'.$konfirmasi.'</div>';
			}
		}
		function change_kelas(){
			$this->session->set_userdata('sesi_kelas', $this->uri->segment(4));
			redirect('dosen/nilai/input');
		}
		function index_input(){
			$this->session->set_userdata('sesi_dosenampu', $this->uri->segment(4,0));
			redirect('dosen/nilai/input');
		}
		function input(){
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
				$this->load->view('dosen/inilai_v',$data);
			}
		}
		function export(){
			//$ekstensi = $this->uri->segment(4);
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
				$namamatkul = str_replace(' ', '_', $data['namamatkul']).'-'.$data['kodemk'];
				$filename ="Daftar-Nilai_".$namamatkul.".xls";
				header('Content-type: application/ms-excel');
				header('Content-Disposition: attachment; filename='.$filename);
				
				$data['browse_mahasiswaambilmk'] = $this->masmahasiswa_m->get_mhs_sudahambilmk($data['kodemk'], $data['thajaran'], $data['id_kelas_dosen'], $kelas);
				$this->load->view('dosen/nilaiexcel_v',$data);
			}
		}
		/*function input(){
			$this->session->set_userdata('sesi_kodemk', $this->uri->segment(4,0));
			$kelas = $this->uri->segment(5,0);
			if($this->session->userdata('sesi_kodemk')){
				$nm = $this->simkrs_m->get_namamatkulnilai($this->session->userdata('sesi_kodemk'));
				$data['nama_matkul'] = $nm['namamk'];
				$data['kode_matkul'] = $nm['kodemk'];
				$this->session->set_userdata('sesi_kodematkul', $data['kode_matkul']);
				$this->session->set_userdata('sesi_namamatkul', $data['nama_matkul']);
				$data['sks'] = $nm['sks'];
				if($this->session->userdata('sesi_cbthajaran')){
					$sesi_thajaran = $this->session->userdata('sesi_cbthajaran');
				}else{
					$sesi_thajaran = $this->session->userdata('sesi_thajaran');
				}
				$data['browse_mahasiswaambilmk'] = $this->masmahasiswa_m->get_allmhs_ambilmk($this->session->userdata('sesi_kodematkul'), $sesi_thajaran);
				$this->load->view('dosen/inilai_v',$data);
			}else{
				$data['nama_matkul'] = '';
				$data['kode_matkul'] = '';
				$data['sks'] = '';
			}
		}*/
		function save(){
			$n = $this->input->post('n');
			if($this->session->userdata('sesi_thajaran')){
				$thajaran = $this->session->userdata('sesi_thajaran');
				$kodemk = $this->session->userdata('sesi_kodemk');
				for($i=1;$i<=$n;$i++){
					$this->simkrs_m->update_nilai($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilai_angka_'.$i),$this->input->post('nilaiuts_'.$i),$this->input->post('nilaiuas_'.$i),$this->input->post('q1_'.$i),$this->input->post('q2_'.$i),$this->input->post('q3_'.$i),$this->input->post('t1_'.$i),$this->input->post('t2_'.$i),$this->input->post('t3_'.$i));
					/*echo $this->db->last_query();*/
				}
				for($i=0;$i<=$n;$i++){
					// echo $this->input->post('nim_'.$i).'='.$this->input->post('nilai_'.$i).'<br />';
					//$this->simkrs_m->update_nilai_admin($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilai_angka_'.$i));
					$this->simkrs_m->update_nilai_feeder($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i),$this->input->post('nilai_angka_'.$i));
					// echo $this->db->last_query().'<br />';
				}
			}
			$data['title'] = 'Konfirmasi Simpan';
			$this->load->view('dosen/tsukses_simpan_v', $data);
			//redirect('dosen/nilai/input/'.$this->session->userdata('sesi_kodemk'));
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
			$nim = $this->session->userdata('sesi_nimmhs');
			$data['browse_khs'] = $this->simambilmk_m->get_khs($nim, $data['thakad']);
			$this->load->view('admin/nilai/tkhs_v', $data);
		}
		/*function cari_matkul(){
			$this->session->set_userdata('sesi_namamk', $this->uri->segment(4,0));
			$data['browse_matkul'] = $this->simkurikulum_m->get_cari_all($this->session->userdata('sesi_namamk'),30);
			$this->load->view('dosen/tmatkul_v', $data);
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
		} */
	}
?>