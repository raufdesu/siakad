<?php
	Class Simdosenwali extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('simdosenwali_m', 'maspegawai_m', 'simsetting_m', 'masmahasiswa_m'));
			$this->load->library(array('simpliparse'));
			if($this->session->userdata('sesi_thajaran') == false){
				redirect(base_url().'index.php/admin/login','refresh');
			}
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_dosenpa', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_dosenpa', '');			
			}
			$this->listview();
		}
		function listview(){
			$data['no'] = $this->uri->segment(4, 0);
			$cari = $this->session->userdata('cari_dosenpa');
			$prodi = $this->session->userdata('sesi_prodi');
			$data['total_page']	= $this->simdosenwali_m->count_dosen($prodi, $cari);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simdosenwali/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_maspegawai"] = $this->simdosenwali_m->get_dosen($data['no'], $perpage, $prodi, $cari);
			$this->load->view("admin/simdosenwali/tsimdosenwali_v",$data);
		}
		function pilih_pa($npp){
			$this->session->set_userdata('sesi_dosenwali', $this->uri->segment(4));
			$angkatan = $this->masmahasiswa_m->last_angkatan();
			$this->session->set_userdata('sesi_angkatanpa', $angkatan);
			redirect('admin/simdosenwali/detail');
		}
		function change_angkatan(){
			$angkatan = $this->session->set_userdata('sesi_angkatanpa', $this->uri->segment(4));
			redirect('admin/simdosenwali/detail');
		}
		function cari_mhspa(){
			$this->session->set_userdata('sesi_carimhspa', $this->input->post('txtCari'));
			redirect('admin/simdosenwali/detail');
		}
		function detail(){
			$data['no'] = $this->uri->segment(4, 0);
			$cari	= $this->session->userdata('sesi_carimhspa');
			$npp		= $this->session->userdata('sesi_dosenwali');
			$data['angkatan'] = $this->session->userdata('sesi_angkatanpa');
			$data['browse_angkatan'] = $this->masmahasiswa_m->get_angkatan();
			$data['total_page']	= $this->simdosenwali_m->count_bydosen($npp, $data['angkatan'], $cari);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simdosenwali/detail/', 4, '#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_mahasiswa"] = $this->simdosenwali_m->get_bydosen($data['no'], $perpage, $npp, $data['angkatan'], $cari);
			$data['dosen'] = $this->maspegawai_m->get_one($npp);
			$this->load->view("admin/simdosenwali/tdsimdosenwali_v", $data);
		}
		function cari_inputmhspa(){
			$this->session->set_userdata('cari_inputmhspa', $this->uri->segment(4));
			$this->add();
		}
		function add($npp = ''){
			$data['npp'] = $this->session->userdata('sesi_dosenwali');
			$cari = $this->session->userdata('cari_inputmhspa');
			$pro = $this->maspegawai_m->get_one($data['npp']);
			$prodi = $pro['kodeprodi'];
			$angkatan = $this->session->userdata('sesi_angkatanpa');
			$count = 1000; //$this->simdosenwali_m->count;
			$data["mahasiswa_nodpa"] = $this->simdosenwali_m->get_mhsnodpa(0, $count, $prodi, $angkatan, $cari);
			$this->load->view('admin/simdosenwali/isimdosenwali_v', $data);
		}
		function edit(){
			$data["title"]	= "Form Update Data Pegawai Dan Dosen";
			$data["detail_maspegawai"] = $this->maspegawai_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/emaspegawai_v",$data);
		}
		function save(){
			$n = $this->input->post('n');
			$npp = $this->input->post('npp');
			for($i=1;$i<$n;$i++){
				$nim = $this->input->post('nim'.$i);
				if($nim){
					$this->simdosenwali_m->insert_fromprodi($nim);
				}
			}
			redirect('admin/simdosenwali/detail');
		}
		function delete(){
			$this->simdosenwali_m->delete($this->uri->segment(4), $this->uri->segment(5));
			redirect('admin/simdosenwali/detail');
		}
	}
?>