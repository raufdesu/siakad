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
			redirect('prodi/simkrs/input');
		}
		function index_listview(){
			if($this->input->post('cari_mhs')){
				$this->session->set_userdata('sesi_carimhs', $this->input->post('cari_mhs'));
			}else{
				$this->session->set_userdata('sesi_carimhs', '');
			}
			$this->listview();
		}
		function pilih_prodi(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_prodi', $this->uri->segment(4));
			}else{
				$this->session->set_userdata('sesi_prodi', '');
			}
			redirect('prodi/simkrs/listview');
		}
		function detail_krs(){
			$this->session->set_userdata('sesi_jumgab','');
			$dm = $this->simkrs_m->detail_mahasiswa($this->uri->segment(4));
			$this->session->set_userdata('sesi_jumgab', $this->simkrs_m->res_sks($this->uri->segment(4)));
			$arsesi = array(
				'sesi_krs_nim' => $dm['nim'],
				'sesi_krs_nama' => $dm['nama'],
				'sesi_krs_prodi' => $dm['nama_prodi'],
				/*'sesi_krs_prefprodi' => $dm['pref_prodi'], */
				'sesi_krs_kelas' => $dm['kdkelas']
			);
			$this->session->set_userdata($arsesi);
			$data['nama_matkul'] = '';
			$thajar = $this->simsetting_m->select_active();
			// $data['thajaran_aktif'] = $thajar['thajaran'];
			$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
			$dpa = $this->simdosenwali_m->get_namadpa($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			// $this->db->last_query();
			$data['nama_dpa'] = $dpa['nama'];
			$this->session->userdata('sesi_krs_nim');
			if($this->session->userdata('sesi_krs_nim')){
				$data['browse_krs'] = $this->simkrs_m->get_one_krs($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
				$data['sudah_krs'] = $this->simkrs_m->cek_sudah_krs($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			}else{
				$data['sudah_krs'] = '';
			}
			// echo $this->db->last_query();
			// sesi_krs_thajaran']
			// $data['browse_thajaran'] = $this->simsetting_m->select();
			$data['nama'] = '';
			$data[''] = '';
			$this->load->view('prodi/tdsimkrs_v', $data);
		}
		function listview(){
			$thajaran = $this->simsetting_m->select_active();
			$data['thajaran'] = $thajaran['thajaran'];
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$data['no'] = $this->uri->segment(4,0);
			$data['total_page']	= $this->simkrs_m->count_mhskrs($data['thajaran'], $this->session->userdata('sesi_carimhs'), $this->session->userdata('sesi_prodi'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simkrs/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data['browse_mhskrs'] = $this->simkrs_m->get_mhskrs($data['no'], $perpage, $data['thajaran'], $this->session->userdata('sesi_carimhs'), $this->session->userdata('sesi_prodi'));
			$this->load->view("prodi/simkrs/tsimkrs_v",$data);
		}
		function browse_dpa(){
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->maspegawai_m->countDosenOnly();
			$data["browse_maspegawai"] = $this->maspegawai_m->getDosenOnly();
			$this->load->view("prodi/maspegawai/tbrowsemaspegawai_v",$data);
		}

		function cari_matakuliah(){
			$this->session->set_userdata('sesi_kodemk', $this->uri->segment(4,0));
			if($this->session->userdata('sesi_kodemk')){
				$nm = $this->simkrs_m->get_namamatkul_one($this->session->userdata('sesi_kodemk'));
				// echo $this->db->last_query();
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
		function awal_input_ujian(){
			$this->_empty_sesi();
			$this->cart->destroy();
			$data['nama_matkul'] = '';
			$data['sks'] = '';
			$this->input_ujian($data);
		}
		function input($data=''){
			$thajar = $this->simsetting_m->select_active();
			// $data['thajaran_aktif'] = $thajar['thajaran'];
			$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
			$dpa = $this->simdosenwali_m->get_namadpa($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			// $this->db->last_query();
			$data['nama_dpa'] = $dpa['nama'];
			$this->session->userdata('sesi_krs_nim');
			if($this->session->userdata('sesi_krs_nim')){
				$data['browse_krs'] = $this->simkrs_m->get_one_krs($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
				$data['sudah_krs'] = $this->simkrs_m->cek_sudah_krs($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			}else{
				$data['sudah_krs'] = '';
			}
			// echo $this->db->last_query();
			// sesi_krs_thajaran']
			// $data['browse_thajaran'] = $this->simsetting_m->select();
			$data['nama'] = '';
			$data[''] = '';
			$this->load->view('prodi/simkrs/isimkrs_v', $data);
		}
		function input_ujian($data=''){
			$thajar = $this->simsetting_m->select_active();
			// $data['thajaran_aktif'] = $thajar['thajaran'];
			$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
			$dpa = $this->simdosenwali_m->get_namadpa($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			// $this->db->last_query();
			$data['nama_dpa'] = $dpa['nama'];
			$this->session->userdata('sesi_krs_nim');
			if($this->session->userdata('sesi_krs_nim')){
				$data['browse_krs'] = $this->simkrs_m->get_one_krs($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
				$data['sudah_krs'] = $this->simkrs_m->cek_sudah_krs($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			}else{
				$data['sudah_krs'] = '';
			}
			// echo $this->db->last_query();
			// sesi_krs_thajaran']
			// $data['browse_thajaran'] = $this->simsetting_m->select();
			$data['nama'] = '';
			$data[''] = '';
			$this->load->view('prodi/simkrs/ikartuujian_v', $data);
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
		function detail_mahasiswa(){
			$kodeprodi = $this->session->userdata('sesi_prodi');
			$cek_nimprodi = $this->simprodi_m->cek_nimprodi($kodeprodi, $this->input->post('nim'));
			if($cek_nimprodi){
				$this->session->set_userdata('sesi_jumgab','');
				$dm = $this->simkrs_m->detail_mahasiswa($this->input->post('nim'));
				$this->session->set_userdata('sesi_jumgab', $this->simkrs_m->res_sks($this->input->post('nim')));
				$arsesi = array(
					'sesi_krs_nim' => $dm['nim'],
					'sesi_krs_nama' => $dm['nama'],
					'sesi_krs_prodi' => $dm['nama_prodi'],
					'sesi_krs_kelas' => $dm['kdkelas']
				);
				$this->session->set_userdata($arsesi);
				$data['nama_matkul'] = '';
				$this->input($data);
			}else{
				echo $this->simplival->alert('KONFIRMASI\nNIM tidak ditemukan!');
				$data['nama_matkul'] = '';
				$this->input($data);
			}
		}
		function detail_mahasiswa_ujian(){
			$kodeprodi = $this->session->userdata('sesi_prodi');
			$cek_nimprodi = $this->simprodi_m->cek_nimprodi($kodeprodi, $this->input->post('nim'));
			if($cek_nimprodi){
				$this->session->set_userdata('sesi_jumgab','');
				$dm = $this->simkrs_m->detail_mahasiswa($this->input->post('nim'));
				$this->session->set_userdata('sesi_jumgab', $this->simkrs_m->res_sks($this->input->post('nim')));
				$arsesi = array(
					'sesi_krs_nim' => $dm['nim'],
					'sesi_krs_nama' => $dm['nama'],
					'sesi_krs_prodi' => $dm['nama_prodi'],
					'sesi_krs_kelas' => $dm['kdkelas']
				);
				$this->session->set_userdata($arsesi);
				$data['nama_matkul'] = '';
				$this->input_ujian($data);
			}else{
				echo $this->simplival->alert('KONFIRMASI\nNIM tidak ditemukan!');
				$data['nama_matkul'] = '';
				$this->input($data);
			}
		}
		function simpan(){
			$cekquota = $this->simmktawar_m->cekquota($this->input->post('txt_kode_mk'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			//echo $cekquota; 
			if($cekquota == false){
				$data = array(
					'id'      => $this->input->post('txt_kode_mk'),
					'qty'     => $this->input->post('txt_sks'),
					'price'   => 39.95,
					'name'    => $this->input->post('txt_nama_mk'),
					'options' => array('status' => $this->input->post('status'))
				);
				$this->cart->insert($data); 
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
				$this->input();
				$data['err'] = 'sks_lebih';
				$this->load->view('prodi/peringatan_v', $data);
				return false;
			}
			if($this->input->post('nama_dpa') == false){
				$this->input();
				$data['err'] = 'dpa_kosong';
				$this->load->view('prodi/peringatan_v', $data);
				return false;
			}
			if($this->input->post('id_dpa')){
				$this->simdosenwali_m->insert_dosenwali($this->session->userdata('sesi_krs_nim'),$this->session->userdata('sesi_krs_thajaran_aktif'));
			}
			$this->simkrs_m->adm_insert_simkrs();
			$this->cart->destroy();
			// $this->simplival->alert('Konfirmasi\n Penyimpanan Sukses');
			$this->cetak_krs();
		}
		function cetak_krs(){
			$nim = $this->session->userdata('sesi_krs_nim');
			$thajaran = $this->session->userdata('sesi_krs_thajaran_aktif');
			$cekada = $this->simkrs_m->get_idkrs($nim, $thajaran);
			if($cekada){
				$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $thajaran);
				$data['detail_krs_peserta'] = $this->simkrs_m->get_one_krs($nim, $thajaran);
				$data['dpa'] = $this->simdosenwali_m->get_namadpa($nim, $thajaran);
				$this->load->view('prodi/laporan/ckrs_v', $data);
			}else{
				echo $this->simplival->alert('KONFIRMASI\nMahasiswa dengan NIM '.$nim.' belum melakukan KRS');
				$this->awal_input();
			}
		}
		function cetak_kartu_ujian(){
			$nim = $this->session->userdata('sesi_krs_nim');
			$thajaran = $this->session->userdata('sesi_krs_thajaran_aktif');
			$cekada = $this->simkrs_m->get_idkrs($nim, $thajaran);
			if($cekada){
				$data['detail_mahasiswa'] = $this->simkrs_m->detail_mhs($nim, $thajaran);
				$data['detail_krs_peserta'] = $this->simkrs_m->get_one_krs($nim, $thajaran);
				$data['dpa'] = $this->simdosenwali_m->get_namadpa($nim, $thajaran);
				$this->load->view('prodi/laporan/cujian_v', $data);
			}else{
				echo $this->simplival->alert('KONFIRMASI\nMahasiswa dengan NIM '.$nim.' belum melakukan KRS');
				$this->awal_input();
			}
		}
		function change_thajarankrs(){
			$this->session->set_userdata('sesi_thajaranpembayaran', $this->uri->segment(4));
			redirect('prodi/simkrs/rekapitulasi/');
		}
		function rekapitulasi(){
			$thajar = $this->simsetting_m->select_active();
			$data['browse_thajaran'] = $this->simsetting_m->select();
			$data['thajaran'] = $this->session->userdata('sesi_thajaranpembayaran');
			$this->load->view('prodi/laporan/rkrs_v', $data);
		}
		function cetak_rekap_krs(){
			$data['thajaran'] = $this->session->userdata('sesi_thajaranpembayaran');
			$kodeprodi = $this->session->userdata('sesi_prodi');
			$data['browse_rekap_krs'] = $this->simkrs_m->get_rekap_krs($data['thajaran'], $kodeprodi);
			if($this->uri->segment(5) == 'xls'){
				$namafile = 'Rekap KRS '.$data['thajaran'];
				$file = url_title($namafile).".xls";
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment;filename=".$file );
				header('Pragma: no-cache');
				header('Expires: 0');
			}
			$this->load->view('prodi/laporan/export_rekap_v', $data);
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
		function delete2(){
			$this->db->where('idkrs',$this->uri->segment(4,0));
			$this->db->where('kodemk',$this->uri->segment(5,0));
			$this->db->delete('simambilmk');
			$data['nama_matkul'] = '';
			$this->input($data);
		}
		/*
		function save_move(){
			$this->simkrs_m->export_toaktifsemester();
			redirect('prodi/simkrs/listview');
		}
		function cari(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_simkrs', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_simkrs', '');
			}
			redirect('prodi/simkrs/listview');
		}
		function change_status(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_statussem', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_statussem', '');
			}
			redirect('prodi/simkrs/listview');
		}
		function status(){
			$data = array(
				'status' => $this->uri->segment(5,0),
				'tglaktifkan' => date('Y-m-d H:i:s')
			);
			$this->db->where("nim",$this->uri->segment(4,0));
			$this->db->update("simkrs",$data);
			redirect('prodi/simkrs/listview');
		}
		function listview(){
			$data["title"]	= "Daftar Mahasiswa Aktif Semester";
			$thajaran = $this->simsetting_m->select_active();
			$data['thajaran'] = $thajaran['thajaran'];
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simkrs_m->count_all_mhs();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simkrs/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_masmahasiswa"] = $this->simkrs_m->select_mhs($data['no'],$perpage);
			$this->load->view("prodi/tsimkrs_v",$data);
		}*/
	}
?>