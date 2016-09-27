<?php
	Class Simaktifksp extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simaktifksp_m', 'simprodi_m', 'masmahasiswa_m', 'simkrs_m'));
			$this->load->model(array('paket_m', 'simsetting_m', 'simdaftarskripsi_m', 'simdosenwali_m'));
			$this->load->library(array('simpliparse', 'simplival', 'pquery', 'form_validation'));
			$this->load->helper(array('globals', 'html'));
		}
		function index(){
			$this->_empty_sesi();
			if($this->simaktifksp_m->cek_to_move()){
				redirect('admin/simaktifksp/listview');
			}else{
				redirect('admin/simaktifksp/input_move');
			}
		}
		function akumulasi(){
			$data['thajaran'] = $this->session->userdata('sesi_thajaran');
			$data['title'] = 'Rekap TA '.$data['thajaran'];
			/* $data['count_ti'] = $this->simaktifksp_m->get_jumstatus(12, $data['thajaran']);
			$data['count_si'] = $this->simaktifksp_m->get_jumstatus(11, $data['thajaran']);
			$data['count_mi'] = $this->simaktifksp_m->get_jumstatus(23, $data['thajaran']);
			$data['count_tk'] = $this->simaktifksp_m->get_jumstatus(24, $data['thajaran']);
			$data['count_ka'] = $this->simaktifksp_m->get_jumstatus(25, $data['thajaran']); */
			$data['browse_prodi'] = $this->simprodi_m->select();
			$this->load->view('admin/takumulasi_v', $data);
		}
		function index_statussemester(){
			$this->session->set_userdata('sesi_prodiaktifsemester', $this->uri->segment(4));
			$this->session->set_userdata('sesi_statusaktifsemester', $this->uri->segment(5));
			redirect('admin/simaktifksp/statussemester');
		}
		function statussemester(){
			$prodi = $this->session->userdata('sesi_prodiaktifsemester');
			$status = $this->session->userdata('sesi_statusaktifsemester');
			$data['no'] = $this->uri->segment(4, 0);
			$data['thajaran'] = $this->simsetting_m->get_allactive()->thajaran;

			$data['total_page']	= $this->simaktifksp_m->count_bystatus($prodi, $data['thajaran'], $status);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simaktifksp/statussemester/',4,'#center-column');
			$data['paging'] = $data3['paging'];

			$data['browse_statusmhs'] = $this->simaktifksp_m->get_bystatus($data['no'],$perpage, $prodi, $data['thajaran'], $status);
			$this->load->view('admin/simaktifksp/tstatussemester_v', $data);
		}
		function input(){
			$this->load->view('admin/simaktifksp/isimaktifkspone_v');
		}
		function input_move(){
			$this->load->view('admin/isimaktifksp_v');
		}
		function save_move(){
			$this->simaktifksp_m->export_toaktifsemester();
			redirect('admin/simaktifksp/listview');
		}
		function _empty_sesi(){
			$arsesi = array(
				'cari_simaktifksp'=>'',
				'sesi_statussem'=>''
			);
			$this->session->set_userdata($arsesi);
		}
		function cari(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_simaktifksp', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_simaktifksp', '');
			}
			redirect('admin/simaktifksp/listview');
		}
		function change_status(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_statussem', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_statussem', '');
			}
			redirect('admin/simaktifksp/listview');
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'nim',
						  'label'   => 'NIM',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'status',
						  'label'   => 'Status',
						  'rules'   => 'required'
					   )
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				$this->input();
			}else{
				$nim		= $this->input->post('nim');
				$thajaran	= $this->input->post('thajaran');
				$mhspaket	= $this->masmahasiswa_m->get_one($nim);
				if($this->input->post('status') == 'Aktif' && $mhspaket['statuspaket'] == 'paket'){
					$cek_sudahaturpaket = $this->paket_m->count_all('', $mhspaket['kodeprodi'], $mhspaket['angkatan'], $mhspaket['kdkelas'], $thajaran);
					if($cek_sudahaturpaket){
						$cek_punyadpa = $this->simdosenwali_m->cek_dosenwali($nim);
						if($cek_punyadpa){
							$this->simkrs_m->insert_paket($nim, $mhspaket['kodeprodi'], $mhspaket['angkatan'], $mhspaket['kdkelas'], $thajaran);
							$this->simaktifksp_m->insert_one();
							echo $this->simplival->alert('KONFIRMASI\nPengaktifan status dan penginputan KRS Paket\ndengan NIM '.$nim.' berhasil');
							$this->listview(1);
						}else{
							echo $this->simplival->alert('PERINGATAN\nGagal mengaktifkan status mahasiswa, karena DPA mahasiswa terpilih belum ditentukan.\nHarap administrator menentukan DPA mahasiswa dengan NIM '.$nim.' terlebih dahulu');
							$this->listview(1);
						}
					}else{
						echo $this->simplival->alert('PERINGATAN !\nGagal diaktifkan. Matakuliah Paket belum diatur');
						$this->listview(1);
					}
				}else{
					$this->simaktifksp_m->insert_one();
					redirect('admin/simaktifksp');
				}
			}
		}
		function status(){
			$thaj	= $this->simaktifksp_m->thajaran_active();
			$thajaran = $thaj['thajaran'];
			$nim	= $this->uri->segment(4);
			$status	= $this->uri->segment(5);

			$mhspaket = $this->masmahasiswa_m->get_one($nim);
			if($this->uri->segment(5) == 'Aktif' && $mhspaket['statuspaket'] == 'paket'){
				$cek_sudahaturpaket = $this->paket_m->count_all('', $mhspaket['kodeprodi'], $mhspaket['angkatan'], $mhspaket['kdkelas'], $thajaran);
				if($cek_sudahaturpaket){
					$cek_punyadpa = $this->simdosenwali_m->cek_dosenwali($nim);
					if($cek_punyadpa){
						$this->simkrs_m->insert_paket($nim, $mhspaket['kodeprodi'], $mhspaket['angkatan'], $mhspaket['kdkelas'], $thajaran);
						$this->simaktifksp_m->statuskan($nim, $status, $thajaran);
						echo $this->simplival->alert('KONFIRMASI\nPengaktifan status dan penginputan KRS Paket\ndengan NIM '.$nim.' berhasil');
						$this->listview(1);
					}else{
						echo $this->simplival->alert('PERINGATAN\nGagal mengaktifkan status mahasiswa, karena DPA mahasiswa terpilih belum ditentukan.\nHarap administrator menentukan DPA mahasiswa dengan NIM '.$nim.' terlebih dahulu');
						$this->listview(1);
					}
				}else{
					echo $this->simplival->alert('PERINGATAN !\nGagal diaktifkan. Matakuliah Paket belum diatur');
					$this->listview(1);
				}
			}else{
				$this->simaktifksp_m->statuskan($nim, $status, $thajaran);
				redirect('admin/simaktifksp/listview');
			}
		}
		function listview($reset=''){
			/* if(!$reset){ */
			$data['no'] = $this->uri->segment(4, 0);
			/*
			}else{
				$data['no'] = 0;
			} */
			$data["title"]	= "Daftar Mahasiswa Aktif Semester";
			$thajaran = $this->simsetting_m->select_active();
			$data['thajaran'] = $thajaran['thajaran'];
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$data['total_page']	= $this->simaktifksp_m->count_all_mhs();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simaktifksp/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_masmahasiswa"] = $this->simaktifksp_m->select_mhs($data['no'], $perpage);
			$this->load->view("admin/tsimaktifksp_v",$data);
		}
		function jenisdaftar(){
			if($this->uri->segment(4) && $this->uri->segment(5)){
				$this->simdaftarskripsi_m->insert($this->uri->segment(4), $this->uri->segment(5));
			}
			redirect('admin/simaktifksp/listview');
		}
		/*
		function change_prodi(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_prodi', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_prodi', '');			
			}
			$this->add();
		}
		function change_thajaran(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_thajaran', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_thajaran', '');
			}
			$this->add();
		}
		function change_thajaran2(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_thajaran', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_thajaran', '');
			}
			$this->listview();
		}
		function change_semester(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_semester', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_semester', '');
			}
			$this->add();
		}
		function cari_matakuliah(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesicari_matakuliah', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesicari_matakuliah', '');
			}
			$this->add();
		}
		function cari_matakuliahtawar(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('sesicari_matakuliahtawar', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('sesicari_matakuliahtawar', '');
			}
			$this->listview();
		}
		function add(){
			$this->_empty_sesi();
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$data['browse_mk'] = $this->simaktifksp_m->select_mk();
			
			$data['total_page']	= $this->simaktifksp_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simaktifksp/add/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data['browse_aktifsemester'] = $this->simaktifksp_m->select();
			$data["title"]	= "Form Tambah Penawaran Matakuliah";
			$this->load->view("admin/isimaktifksp_v",$data);
		}
		function edit(){
			$data['browse_namamk']	= $this->simnamamk_m->select();
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data["detail_simaktifksp"] = $this->simaktifksp_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/esimaktifksp_v",$data);
		}
		function update(){
			$this->simaktifksp_m->update();
			redirect("admin/simaktifksp");
		}
		function detail(){
			$data["detail_simaktifksp"] = $this->simaktifksp_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdsimaktifksp_v",$data);
		}
		*/
		function hapus(){
			$this->simaktifksp_m->delete($this->uri->segment(4), $this->uri->segment(5));
			redirect('admin/simaktifksp/listview');
		}
	}
?>