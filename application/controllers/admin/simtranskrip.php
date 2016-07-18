<?php
	Class Simtranskrip extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("simtranskrip_m","simprodi_m","simkrs_m","simsetting_m","masmahasiswa_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation','cart'));
			$this->load->helper(array('globals','html'));
		}
		function index_browse(){
			$this->session->set_userdata('sesi_nimmhs', '');
			if($this->input->post('txtNimMhs')){
				$this->session->set_userdata('sesi_nimmhs', $this->input->post('txtNimMhs'));
			}elseif($this->uri->segment(4)){
				$this->session->set_userdata('sesi_nimmhs', $this->uri->segment(4));
			}
			if($this->input->post('bythajaran')){
				$this->browse_bythajaran();
			}else{
				$this->browse();
			}
		}
		function browse_bythajaran(){
			$data['nim'] = $this->session->userdata('sesi_nimmhs');
			$data['browse_thajaran'] = $this->simtranskrip_m->get_thajaranbynim($data['nim']);
			$data['browse_matrikulasi'] = $this->simtranskrip_m->get_onetranskrip($data['nim']);
			$this->load->view('admin/simtranskrip/ttranskrip_bythajaran_v', $data);
		}
		function browse(){
			if($this->uri->segment(4) == 'xls'){
				$namafile = 'transkrip-'.$this->session->userdata('sesi_nimmhs').'.xls';
				header("Content-type: application/excel");
				header("Content-disposition: attachment; filename=".$namafile);
			}
			$nim = $this->session->userdata('sesi_nimmhs');
			$mhs = $this->masmahasiswa_m->get_one($nim);
			$data['nim'] = $mhs['nim'];
			$data['nama'] = $mhs['nama'];
			$data['prodi'] = $mhs['nama_prodi'];
			if($mhs['kdkelas'] == '2')
				$data['kelas'] = 'Malam';
			else
				$data['kelas'] = 'Reguler';
			
			$data['detail_transkrip'] = $this->simtranskrip_m->get_one($nim);
			$this->load->view('admin/simtranskrip/ttranskrip_v', $data);
		}
		function header(){
			$data['title'] = '';
			$this->session->set_userdata('sesi_nimmhs', '');
			$this->load->view('admin/thead_transkrip_v', $data);
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('sesicari_mhsmatrik', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('sesicari_mhsmatrik', '');
			}
			$this->listview();
		}
		function cari_mhs(){
			if($this->input->post('txtNimMhs')){
				$this->session->set_userdata('sesi_nimmhs', $this->input->post('txtNimMhs'));
			}else{
				$this->session->set_userdata('sesi_nimmhs', '');
			}
			redirect('admin/simtranskrip/yudisium_list');
		}
		function awal_yudisium(){
			$this->session->set_userdata('sesi_nimmhs', '');
			$this->session->set_userdata('sesi_akad', '');
			$this->yudisium_semester();
		}
		function yudisium_semester(){
			$data['sesi_thajaran'] = $this->session->userdata('sesi_thajaran');
			$this->session->set_userdata('sesi_thajar', substr($data['sesi_thajaran'],0,4));
			$this->session->set_userdata('sesi_semester', substr($data['sesi_thajaran'],4,1));

			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['sesi_semester'] = $this->session->userdata('sesi_semester');
			$data['sesi_thajar'] = $this->session->userdata('sesi_thajar');
			$data['title'] = '';
			$data['records'] = $this->simtranskrip_m->get_nimprodi($this->session->userdata('sesi_transprodi'));
			$this->load->view('admin/thead_masmahasiswa_v', $data);
		}
		function change_semester(){
			$this->session->set_userdata('sesi_akad',$this->uri->segment(4));
			if(!$this->session->userdata('sesi_nimmhs')){
				$this->load->view('admin/tkonfirmasi_nonim_v');
			}else{
				redirect('admin/simtranskrip/yudisium_list');
			}
		}
		function change_prodi(){
			$this->session->set_userdata('sesi_transprodi', $this->uri->segment(4));
			if(!$this->session->userdata('sesi_transprodi')){
				$this->load->view('admin/tkonfirmasi_nonim_v');
			}else{
				redirect('admin/simtranskrip/awal_yudisium');
			}
		}
		function change_thajaran(){
			$this->session->set_userdata('sesi_akad', $this->uri->segment(4));
			if(!$this->session->userdata('sesi_nimmhs')){
				$this->load->view('admin/tkonfirmasi_nonim_v');
			}else{
				redirect('admin/simtranskrip/yudisium_list');
			}
		}
		function yudisium_list(){
			$mhs = $this->masmahasiswa_m->get_one($this->session->userdata('sesi_nimmhs'));
			if($this->session->userdata('sesi_akad')){
				$data['sesi_akad'] = $this->session->userdata('sesi_akad');
			}else{
				$data['sesi_akad'] = $this->session->userdata('sesi_thajaran');
			}
			$data['nim'] = $mhs['nim'];
			$data['nama'] = $mhs['nama'];
			$data['prodi'] = $mhs['nama_prodi'];
			if($mhs['kdkelas'] == '2')
				$data['kelas'] = 'Malam';
			else
				$data['kelas'] = 'Reguler';
				
			$arkodemk = '';
			$arkode = $this->simtranskrip_m->get_arraykodemk($data['nim'], $data['sesi_akad']);;
			foreach($arkode as $a){
				$arkodemk  .= $a->kodemk.",";
			};
			if($arkodemk)
				$data['arkodemk'] = substr($arkodemk,0,strlen($arkodemk)-1);
			else
				$data['arkodemk'] = 0;

			$data['browse_ambilmk'] = $this->simtranskrip_m->get_one_ambilmk($data['nim'],$data['sesi_akad']);
			/*echo $this->db->last_query();*/
			$data['browse_transkrip'] = $this->simtranskrip_m->get_all(0, 10, $data['nim']);
			$this->load->view('admin/iyudisiumsemester_v', $data);
		}
		function save(){
			if($this->session->userdata('sesi_akad')){
				$thajaran = $this->session->userdata('sesi_akad');
			}else{
				$thajaran = $this->session->userdata('sesi_thajaran');
			}
			$nim = $this->session->userdata('sesi_nimmhs');
			if($this->session->userdata('sesi_thajaran')==false or ($this->session->userdata('sesi_akad') == false)){
				//$this->simplival->alert('PERINGATAN\n Combo Tahun Ajaran\n Atau Combo PRODI Belum Dipilih');
				//$this->add();
			}else{
				$n = $this->input->post('total_mk');
				for($i=1; $i<$n; $i++){
					if($this->input->post('matkul'.$i)){
						/*echo 'simpan '.$this->input->post('matkul'.$i).'<br />';*/
						$kodemk = $this->input->post('matkul'.$i);
						$nilai = $this->input->post('nilai'.$i);
						
						$nilaisama = $this->simtranskrip_m->cek_kodesama($nim, $kodemk);
						if($nilaisama){
							if($nilaisama > $nilai){
								$this->simtranskrip_m->delete($nim, $kodemk);
								/*$this->simtranskrip_m->update($nim, $thajaran, $status = 'reguler', $kodemk, $nilai); */
							}
						}
						$this->simtranskrip_m->insert($nim, $thajaran, $status = 'reguler', $kodemk, $nilai);
					}
				}
				//redirect('admin/simmktawar/add');
			}
			redirect('admin/simtranskrip/yudisium_list');
		}
		function delete(){
			$nim = $this->session->userdata('sesi_nimmhs');
			$this->simtranskrip_m->delete($nim, $this->uri->segment(4));
			redirect('admin/simtranskrip/yudisium_list');
		}
		function cetak(){
			$data['title'] = '';
			$nim = $this->session->userdata('sesi_nimmhs');
			if($nim == false){
				$this->simplival->alert('PERINGATAN\nAnda Belum Memilih Nim Mahasiswa');
				return false;
			}
			$data['detail_mahasiswa'] = $this->masmahasiswa_m->detail($nim);
			$data['jum_ipk'] = $this->simtranskrip_m->get_ipk($nim);
			$hasilbagi = $this->simtranskrip_m->count_one_paralel($nim) / 2;
			$res = ceil($hasilbagi);
			$data['detail_simtranskrip'] = $this->simtranskrip_m->get_one_paralel($nim, 0, $res);
			$data['detail_simtranskrip2'] = $this->simtranskrip_m->get_one_paralel($nim, $res, $res);
			if($this->input->post('tglcetak')){
				$data['tglcetak'] = tgl_ingg($this->input->post('tglcetak'));
			}else{
				$data['tglcetak'] = date('Y-m-d');
			}
			$this->load->view('admin/laporan/ctranskrip_v', $data);
		}
			// $nim = $this->session->userdata('sesi_nimmhs');
			// $mhs = $this->masmahasiswa_m->get_one($this->session->userdata('sesi_nimmhs'));
			// if($nim){
				// $this->session->set_userdata('sesi_nimtranskrip', $nim);
				// $nim = $mhs['nim'];
				// $data['nama'] = $mhs['nama'];
				// $data['kelas'] = $mhs['kdkelas'];
				// $data['prodi'] = $mhs['nama_prodi'];
				// // $this->load->view('admin/tdhead_masmahasiswa_v', $data);
			// }else{
				// echo "<center>Mahasiswa Tidak Ditemukan</center>";
			// }
			// $thakad = $this->session->userdata('sesi_thajaran');
			// $data['title'] = 'Form Yudisium Semester';
			// $data['total_page']	= 20; //$this->simtranskrip_m->count_all($this->session->userdata('sesicari_mhsmatrik'));
			// $data['no']	= $this->uri->segment(4,0);
			// $perpage	= 10;
			// $data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				// $perpage,'admin/simtranskrip/listview/',4,'#center-column');
			// $data['paging'] = $data3['paging'];
			// $data['browse_ambilmk'] = $this->simtranskrip_m->get_matkul_notranskrip($data['no'], $perpage = '', $nim, $thakad);
			// // $data['browse_transmk'] = $this->simtranskrip_m->get_matkul_intranskrip();
			// $this->load->view('admin/iyudisiumsemester_v', $data);
		// }
		/*function listview(){
			$data['no'] = $this->uri->segment(4, 0);
			// $data['total_page']	= $this->db->count_all('simtranskrip');
			$data['total_page']	= $this->simtranskrip_m->count_all($this->session->userdata('sesicari_mhsmatrik'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simtranskrip/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_mhsmatrikulasi"] = $this->simtranskrip_m->get_all($data['no'],$perpage,$this->session->userdata('sesicari_mhsmatrik'));
			$this->load->view("admin/tsimtranskrip_v",$data);
		}*/
		/*function input_awal(){
			$atrs = array(
				'sesi_krs_nim' => '',
				'sesi_krs_nama' => '',
				'sesi_krs_kelas' => '',
				'sesi_krs_prodi' => ''
			);
			$this->session->set_userdata($atrs);
			$this->input();
		}*/
		/*function input(){
			$thajar = $this->simsetting_m->select_active();
			$this->session->set_userdata('sesi_krs_thajaran_aktif', $thajar['thajaran']);
			$nim = $this->session->userdata('sesi_krs_nim');
			$data['nama'] = '';
			$data[''] = '';
			$data['detail_matrikulasi'] = $this->simtranskrip_m->get_one($nim);
			$this->load->view("admin/isimtranskrip_v",$data);
		}*/
		/* function detail_mahasiswa(){
			$this->session->set_userdata('sesi_jumgab','');
			$dm = $this->simkrs_m->detail_mahasiswa($this->input->post('nim'));
			// $data['jum_gab'] = $this->simkrs_m->res_sks($this->input->post('nim'));
			$this->session->set_userdata('sesi_jumgab', $this->simkrs_m->res_sks($this->input->post('nim')));
			// $krs = $this->simkrs_m->jumsks_one_last($this->input->post('nim'));
			// $nilai	= $krs['nilai'];
			// $sks	= $krs['sks'];
			// $data['tot_sks_last'] = $this->session->set_userdata('sesi_last_sks', $sks_last['']);
			$arsesi = array(
				'sesi_krs_nim' => $dm['nim'],
				'sesi_krs_nama' => $dm['nama'],
				'sesi_krs_prodi' => $dm['nama_prodi'],
				'sesi_krs_prefprodi' => $dm['pref_prodi'],
				'sesi_krs_kelas' => $dm['kdkelas']
			);
			$this->session->set_userdata($arsesi);
			$data['nama_matkul'] = '';
			$this->input($data);
		} */

		/*function edit(){
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data["detail_simkurikulum"] = $this->simkurikulum_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/esimkurikulum_v",$data);
		}*/
		/*function save(){
			$cek_kodemk = $this->simtranskrip_m->cek_ada($this->session->userdata('sesi_krs_nim'), $this->input->post('txt_kode_mk'));
			$config = array(
					array(
						  'field'   => 'txt_kodemk',
						  'label'   => 'Kode Matakuliah',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'nilai',
						  'label'   => 'Nilai Matakuliah',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'txt_sks',
						  'label'   => 'SKS',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error"> * ', '</span><br />');
			if ($this->form_validation->run() == FALSE){
				$this->input();
				// $this->load->view('admin/isimkurikulum_v');
			}else{
				if($cek_kodemk == true){
					// $this->simplival->alert('PERINGATAN\nKode Matakuliah Sudah Ada Sebelumnya');
					$this->input();
				}else{
					$this->simtranskrip_m->insert();
					redirect("admin/simtranskrip/input");
				}
			}
		}*/
	}
?>