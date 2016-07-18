<?php
	Class Simkrs extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simkrs_m','simprodi_m','simsetting_m','simdosenwali_m','maspegawai_m','simmktawar_m'));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->library('cart');
			$this->load->helper(array('globals','html'));
		}
		function index(){
			$this->_empty_sesi();
			redirect('mhs/simkrs/input');
		}
		function cari_matakuliah(){
			$this->session->set_userdata('sesi_kodemk', $this->uri->segment(4,0));
			$nim = $this->session->userdata('sesi_krs_nim');
			if($this->session->userdata('sesi_kodemk')){
				$nm = $this->simkrs_m->get_namamatkul_one($this->session->userdata('sesi_kodemk'), '', $nim);
				$nama_matkul = $nm['namamk'];
				$kode_matkul = $nm['kodemk'];
				$sks = $nm['sks'];
			}else{
				$nama_matkul = '';
				$kode_matkul = '';
				$sks = '';
			}
			echo "<input type='hidden' readonly name='txt_kode_mk' value='".$kode_matkul."' size='8' style='float:left'>";
			echo "<input type='text' readonly name='txt_nama_mk' value='".$nama_matkul."' size='45' style='float:left'>";
			echo "<input type='hidden' name='txt_sks' value='".$sks."'>";
		}
		function awal_input(){
			$this->_empty_sesi();
			$this->cart->destroy();
			$data['nama_matkul'] = '';
			$data['sks'] = '';
			$this->input($data);
		}
		function input($data=''){
			$data['cekwaktu'] = $this->simkrs_m->cek_waktukrs();
			$this->detail_mahasiswa($this->session->userdata('sesi_user_mhs'));
			$thajar = $this->simsetting_m->select_active();
			$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
			/*$dpa = $this->simdosenwali_m->get_namadpa($this->session->userdata('sesi_user_mhs'),$this->session->userdata('sesi_krs_thajaran_aktif'));*/
			$dpa = $this->simdosenwali_m->get_namadpa($this->session->userdata('sesi_user_mhs'));
			$data['nama_dpa'] = $dpa['nama'];
			$data['id_dpa'] = $dpa['npp'];
			$data['sudah_krs'] = $this->simkrs_m->cek_sudah_krs($this->session->userdata('sesi_user_mhs'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			$data['browse_krs'] = $this->simkrs_m->get_one_krs($this->session->userdata('sesi_user_mhs'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			$data['nama'] = '';
			$data['ds'] = $this->simsetting_m->get_allactive();
			$this->load->view('mhs/isimkrs_v', $data);
		}
		function browse_dpa(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->maspegawai_m->countDosenOnly();
			/* $perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'mhs/simkrs/browse_dpa/',4,'#center-column');
			$data['paging'] = $data3['paging'];*/
			$data["browse_maspegawai"] = $this->maspegawai_m->getDosenOnly();
			$this->load->view("mhs/tmaspegawai_v",$data);
		}
		function _empty_sesi(){
			$arsesi = array(
				'sesi_krs_nim' => '',
				'sesi_krs_nama' => '',
				'sesi_krs_prodi' => '',
				'sesi_krs_kelas' => ''
			);
			$this->session->set_userdata($arsesi);
		}
		function detail_mahasiswa($nim){
			$dm = $this->simkrs_m->detail_mahasiswa($nim);
			// echo $this->db->last_query();
			$this->session->set_userdata('sesi_jumgab', $this->simkrs_m->res_sks($nim));
			$arsesi = array(
				'sesi_krs_nim' => $dm['nim'],
				'sesi_krs_nama' => $dm['nama'],
				'sesi_krs_prodi' => $dm['nama_prodi'],
				/* 'sesi_krs_prefprodi' => $dm['pref_prodi'], */
				'sesi_krs_kelas' => $dm['kdkelas']
			);
			$this->session->set_userdata($arsesi);
			$data['nama_matkul'] = '';
		}
		function simpan(){
			$ceksama = $this->simkrs_m->ceksama_tabel($this->input->post('txt_kode_mk'),$this->session->userdata('sesi_user_mhs'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			$cekquota = $this->simmktawar_m->cekquota($this->input->post('txt_kode_mk'),$this->session->userdata('sesi_thajaran'));
			if($cekquota == false){
				if($ceksama == false){
					$data = array(
						'id'      => $this->input->post('txt_kode_mk'),
						'qty'     => $this->input->post('txt_sks'),
						'price'   => 3,
						'name'    => $this->input->post('txt_nama_mk'),
						'options' => array('status'=>$this->input->post('status'))
						// array('Size' => 'L', 'Color' => 'Red')
					);
					$this->cart->insert($data);
				}else{
					if($this->input->post('txt_nama_mk')){
						echo '<div class="error-top">Matakuliah '.$this->input->post('txt_nama_mk').' Sudah Dimasukkan</div>';
					}
				}
					$data['nama_matkul'] = '';
					$this->session->set_userdata('sesi_kodemk','');
					$data['sks'] = '';
					$this->input($data);
			}else{
				$data['nama_matkul'] = '';
				$this->session->set_userdata('sesi_kodemk','');
				$data['sks'] = '';
				$this->input($data);
				echo '<div class="error-top">Quota Untuk matakuliah '.
						$this->input->post('txt_nama_mk').'('.$this->input->post('txt_kode_mk').')
						Sudah Habis
					</div>';
			}
		}
		function simpan_tabel(){
			if(($this->input->post('jum_sks_input')) > ($this->session->userdata('sesi_jumgab'))){
				$data['err'] = 'sks_lebih';
				$this->load->view('mhs/peringatan_v', $data);
				$this->input();
				return false;
			}
			if($this->input->post('nama_dpa') == false){
				$this->input();
				$data['err'] = 'dpa_kosong';
				$this->load->view('mhs/peringatan_v', $data);
				return false;
			}
			if($this->simkrs_m->cekquota_all()){
				$data['err'] = 'quota_habis';
				$data['kodehabis'] = $this->simkrs_m->cekquota_all();
				$this->load->view('mhs/peringatan_v', $data);
				$this->input();
				return false;
			}
			if($this->input->post('id_dpa')){
				$this->simdosenwali_m->insert_dosenwali($this->session->userdata('sesi_user_mhs'),$this->session->userdata('sesi_thajaran'));
			}
			$this->simkrs_m->adm_insert_simkrs();
			$this->cart->destroy();
			$this->cetak_krs();
			// if($this->input->post('id_dpa')){
				// $this->simdosenwali_m->insert();
			// }
			// $this->simkrs_m->insert_simkrs();
			// $this->cart->destroy();
		}
		function cetak_krs(){
			$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($this->session->userdata('sesi_user_mhs'), $this->session->userdata('sesi_thajaran'));
			$data['detail_krs_peserta'] = $this->simkrs_m->get_one_krs($this->session->userdata('sesi_user_mhs'), $this->session->userdata('sesi_thajaran'));
			$data['dpa'] = $this->simdosenwali_m->get_namadpa($this->session->userdata('sesi_user_mhs'),$this->session->userdata('sesi_thajaran'));
			$this->load->view('mhs/laporan/ckrs_v', $data);
		}
		function delete2(){
			$this->db->where('idkrs',$this->uri->segment(4,0));
			$this->db->where('kodemk',$this->uri->segment(5,0));
			$this->db->delete('simambilmk');
			$data['nama_matkul'] = '';
			$this->input($data);
		}
		function delete(){
			$data = array(
				'rowid' => $this->uri->segment(4),
				'qty'	=> '0',
				'price'	=> '0',
				'name'	=> '',
				'options' => ''
			);
			$this->cart->update($data);
			$data['nama_matkul'] = '';
			$this->input($data);
		}
	}
?>