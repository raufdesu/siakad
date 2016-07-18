<?php
	Class Simmktawar extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("simmktawar_m","simprodi_m","simsetting_m","masmahasiswa_m","simdosenampu_m","simambilmk_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		/* START BUAT PRESENSI */
		function ganti_kelas(){
			if($this->uri->segment(4,0) == true){
				$this->session->set_userdata('sesi_kelas', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_kelas', '');
			}
			$this->pengambilmk();
			redirect('prodi/simmktawar/pengambilmk');
		}
		function export_pengambilmk(){
			$thajaran = $this->session->userdata('sesi_thajaran');
			$kelas = $this->session->userdata('sesi_kelas');
			$data['browse_mhs_sudah'] = $this->masmahasiswa_m->get_mhs_ambilmkx($this->session->userdata('sesi_kodematkul'), $thajaran, $kelas);
			$this->load->view('prodi/simambilmk/expengambilmk_v', $data);
		}
		function pengambilmk(){
			$thajaran = $this->session->userdata('sesi_thajaran');
			if($this->uri->segment(5)){
				// $data['namamatkul'] = $this->uri->segment(5);
				$this->session->set_userdata('sesi_kodematkul', $this->uri->segment(4));
				$this->session->set_userdata('sesi_namamatkul', good_karakter($this->uri->segment(5)));
				// $asr = array(
					// 'sesi_kodematkul', $this->uri->segment(4),
					// 'sesi_namamatkul', $this->uri->segment(5)
				// );
				// $this->session->set_userdata($asr);
			}
			// if($this->uri->segment(3,0)){
				$data['kodematkul'] = $this->session->userdata('sesi_kodematkul');
				$data['title'] = 'Daftar Mahasiswa';
				$kelas = $this->session->userdata('sesi_kelas');
				$data['browse_mhs_sudah'] = $this->masmahasiswa_m->get_mhs_ambilmkx($this->session->userdata('sesi_kodematkul'), $thajaran, $kelas);
				// echo $this->db->last_query();
				$this->load->view('prodi/simambilmk/tpengambilmk_v', $data);
			// }
		}
		function presensi(){
			if($this->input->post('txtCari') && $this->input->post('cbKategori')){
				$this->session->set_userdata('sesicari_matakuliahtawar', $this->input->post('txtCari'));
				$this->session->set_userdata('sesicari_katmatakuliahtawar', $this->input->post('cbKategori'));
			}else{
				$this->session->set_userdata('sesicari_matakuliahtawar', '');
			}
			$this->listpresensi();
		}
		function pilih_kelas(){
			$thajaran	= $this->session->userdata('sesi_thajaran');
			if($this->uri->segment(4) == 'batalpilih'){
					$nim = $this->uri->segment(6);
					$kodemk = $this->uri->segment(7);
					$krs = $this->simambilmk_m->get_idkrs_bynim($nim, $thajaran);
					$idkrsnya = $krs['idkrsnya'];
					$this->simambilmk_m->update_pilihkelas($idkrsnya, $kodemk, '');
				$id_kelas_dosen = $this->uri->segment(5);
				redirect('prodi/simmktawar/mhsambilmk/'.$id_kelas_dosen);
			}else{
				$kodemk		= $this->input->post('kodemk');
				$id_kelas_dosen = $this->input->post('id_kelas_dosen');
				if($thajaran == false){
					redirect(base_url().'prodi/login/','REFRESH');
				}else{
					$n = $this->input->post('n');
					for($i=0; $i<=$n; $i++){
						$nim = $this->input->post('nim'.$i);
						if($nim){
							$krs = $this->simambilmk_m->get_idkrs_bynim($nim, $thajaran);
							$idkrsnya = $krs['idkrsnya'];
							$this->simambilmk_m->update_pilihkelas($idkrsnya, $kodemk, $id_kelas_dosen);
						}
					}
					redirect('prodi/simmktawar/mhsambilmk/'.$id_kelas_dosen);
				}
			}
		}
		function batalpilih_kelas(){
			$id_kelas_dosen = $this->input->post('id_kelas_dosen');
			redirect('prodi/simmktawar/mhsambilmk/'.$id_kelas_dosen);
		}
		function listpresensi(){
			$cari = $this->session->userdata('sesicari_matakuliahtawar');
			$prodi = $this->session->userdata('sesi_prodi');
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			// $data['browse_mk'] = $this->simmktawar_m->select_mk();
			$data['total_page'] = $this->simdosenampu_m->count_matkul($this->session->userdata('sesi_thajaran'), $cari, $prodi);
			// $data['total_page']	= $this->simmktawar_m->count_all();
			$data['no']	= $this->uri->segment(4,0);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simmktawar/listpresensi/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data['browse_mkdosenampu'] = $this->simdosenampu_m->get_matkul($perpage,$data['no'],$this->session->userdata('sesi_thajaran'), $cari, $prodi);
			$data["title"]	= "Daftar Matakuliah";
			$this->load->view("prodi/simmktawar/tpresensi_v",$data);
		}
		function gantikelas(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_kelas', $this->uri->segment(4,0));
				redirect('prodi/simmktawar/mhsambilmk');
			}
		}
		function mhsambilmk(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_kelas_dosen', $this->uri->segment(4));
			}
			if($this->uri->segment(5) == 'awal'){
				$this->session->set_userdata('sesi_kelas', '');
			}
			$thajaran = $this->session->userdata('sesi_thajaran');
			$data['title'] = 'Daftar Mahasiswa';
			$id_kelas_dosen = $this->session->userdata('sesi_kelas_dosen');
			$det = $this->simdosenampu_m->get_onepengampu($id_kelas_dosen);
			$data['kodemk'] = $det['kodemk'];
			$data['id_kelas_dosen'] = $det['id_kelas_dosen'];
			$data['namamatkul'] = $det['namamatkul'];
			$data['namadosen'] = $det['namadosen'];
			$kodematkul = $det['kodemk'];
			$ars = array(
				'sesi_kodematkul' => $kodematkul,
				'sesi_namamatkul' => $data['namamatkul'],
				'sesi_namadosen' => $data['namadosen'],
				'sesi_id_kelas_dosen' => $id_kelas_dosen
			);
			$this->session->set_userdata($ars);
			$data['browse_mhs_sudah'] = $this->masmahasiswa_m->get_mhs_sudahdipresensi($kodematkul, $thajaran, $id_kelas_dosen, $this->session->userdata('sesi_kelas'));
			$data['browse_mhs'] = $this->masmahasiswa_m->get_mhs_belumdipresensi($kodematkul, $thajaran, $this->session->userdata('sesi_kelas'), $id_kelas_dosen);
			$data['ampu'] = $this->simdosenampu_m->get_one($id_kelas_dosen);
			$this->load->view("prodi/tpresensi_mhsambilmk_v", $data);
		}
		function cetak_coverpresensi(){
			$kodematkul = $this->session->userdata('sesi_kodematkul');
			if($kodematkul){
				$data['kodematkul'] = $kodematkul;
				$thajaran	= $this->session->userdata('sesi_thajaran');
				$id_kelas_dosen = $this->session->userdata('sesi_id_kelas_dosen');
				$head = $this->simdosenampu_m->get_kelasdosen($kodematkul,$thajaran,$id_kelas_dosen);
				$data['ampu'] = $this->simdosenampu_m->get_one($id_kelas_dosen);
				$data['sks'] = $head['sks'];
				$data['namaprodi'] = $head['namaprodi'];
				$data['kelas'] = $head['kelas'];
				$data['semester'] = $head['semester'];
				if($this->session->userdata('sesi_kelas')){
					$kelas = $this->session->userdata('sesi_kelas');
				}else{
					$kelas = 1;
				}
				// $mhs=$this->masmahasiswa_m->get_mhs_sudahambilmk($kodematkul,$thajaran,$id_kelas_dosen, $kelas);
				// $data['totalmhs']= $this->uri->segment(4,0);
				// $data['totalmhs']=$this->masmahasiswa_m->count_mhs_sudahambilmk($kodematkul,$thajaran,$id_kelas_dosen, $kelas);
				
				$this->load->view('prodi/ccover_presensimhs_v', $data);
			}else{
				echo '<div class="confirm">Anda belum memilih salah satu daftar Matakuliah</div>';
			}
		}
		function cetakpresensi(){
			$kodematkul = $this->session->userdata('sesi_kodematkul');
			$thajaran	= $this->session->userdata('sesi_thajaran');
			$id_kelas_dosen = $this->session->userdata('sesi_id_kelas_dosen');
			$head = $this->simdosenampu_m->get_kelasdosen($kodematkul,$thajaran,$id_kelas_dosen);
			$data['sks'] = $head['sks'];
			$data['namaprodi'] = $head['namaprodi'];
			$data['kodeprodi'] = $this->simprodi_m->get_prodibymatkul($kodematkul);
			$data['kelas'] = $head['kelas'];
			if($this->session->userdata('sesi_kelas')){
				$kelas = $this->session->userdata('sesi_kelas');
			}else{
				$kelas = 1;
			}
			$data['browse_mhs']=$this->masmahasiswa_m->get_mhs_sudahdipresensi($kodematkul,$thajaran,$id_kelas_dosen, $kelas);
			$data['title'] = '';
			$this->load->view('prodi/cpresensimhs_v', $data);
		}
		// EKSPORT PENGAMBIL MK
		function export(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_kelas_dosen', $this->uri->segment(4));
			}
			if($this->uri->segment(5) == 'awal'){
				$this->session->set_userdata('sesi_kelas', '');
			}
			$thajaran = $this->session->userdata('sesi_thajaran');
			$data['title'] = 'Daftar Mahasiswa';
			$id_kelas_dosen = $this->session->userdata('sesi_kelas_dosen');
			$det = $this->simdosenampu_m->get_onepengampu($id_kelas_dosen);
			$data['kodemk'] = $det['kodemk'];
			$data['id_kelas_dosen'] = $det['id_kelas_dosen'];
			$data['namamatkul'] = $det['namamatkul'];
			$data['namadosen'] = $det['namadosen'];
			$kodematkul = $det['kodemk'];
			$ars = array(
				'sesi_kodematkul' => $kodematkul,
				'sesi_namamatkul' => $data['namamatkul'],
				'sesi_namadosen' => $data['namadosen'],
				'sesi_id_kelas_dosen' => $id_kelas_dosen
			);
			$this->session->set_userdata($ars);
			$data['browse_mhs_sudah'] = $this->masmahasiswa_m->get_mhs_sudahambilmk($kodematkul, $thajaran, $id_kelas_dosen, $this->session->userdata('sesi_kelas'));
			$data['ampu'] = $this->simdosenampu_m->get_one($id_kelas_dosen);
			$this->load->view('prodi/simambilmk/expengambilmk_v', $data);
		}
		/* SELESAI BUAT PRESENSI */
		function thn_mktawar(){
			if($this->uri->segment(4,0)){
				$this->session->set_userdata('sesi_thnmktawar', $this->uri->segment(4,0));
			}else{
				$this->session->set_userdata('sesi_thnmktawar', '');			
			}
			redirect('prodi/simmktawar/listview');
		}
		function update_quota(){
			$this->simmktawar_m->update_quota($this->input->post('kode'));
			redirect('prodi/simmktawar/listview/'.$this->input->post('segment'));
		}
		function index(){
			$this->_empty_sesi();
			redirect('prodi/simmktawar/listview');
		}
		function listview(){
			$prodi = $this->session->userdata('sesi_prodi');
			$data['browse_prodi'] = $this->simprodi_m->select();
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$cari = $this->session->userdata('sesicari_matakuliahtawar');
			$thajaran = $this->session->userdata('sesi_thajaran');
			// $data['browse_mk'] = $this->simmktawar_m->select_mk();
			$data['total_page'] = $this->simmktawar_m->count_tawar($thajaran, $cari, $prodi);
			// $data['total_page']	= $this->simmktawar_m->count_all();
			$data['no']	= $this->uri->segment(4,0);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simmktawar/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data['browse_mktawar'] = $this->simmktawar_m->get_tawar($perpage,$data['no'],$thajaran,$cari, $prodi);
			$data["title"]	= "Daftar Matakuliah Yang Ditawarkan";
			$this->load->view("prodi/simmktawar/tsimmktawar_v",$data);
		}
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
			redirect('prodi/simmktawar/listview');
			/* $this->listview(); */
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
		/* FUNCTION MENGKOSONGKAN SESI */
		function _empty_sesi(){
			$arsesi = array(
				'sesicari_matakuliahtawar'=>''
			);
			$this->session->set_userdata($arsesi);
		}
		function add(){
			$prodi = $this->session->userdata('sesi_prodi');
			$data['browse_prodi']	= $this->simprodi_m->select('','',$prodi);
			$data['browse_thn_ajaran'] = $this->simsetting_m->select();
			$data['browse_mk'] = $this->simmktawar_m->select_mk();
			$data['total_page']	= $this->simmktawar_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/simmktawar/add/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data['thajaran'] = substr($this->session->userdata('sesi_thajaran'),0,4);
			$data['semester'] = semester($this->session->userdata('sesi_thajaran'));
			$data['browse_mktawar'] = $this->simmktawar_m->select();
			$data["title"]	= "Form Tambah Penawaran Matakuliah";
			$this->load->view("prodi/simmktawar/isimmktawar_v",$data);
		}
		function edit(){
			$data['browse_prodi']	= $this->simprodi_m->select('','');
			$data["detail_simmktawar"] = $this->simmktawar_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/esimmktawar_v",$data);
		}
		function save(){
			if(($this->session->userdata('sesi_thajaran') == false) or ($this->session->userdata('sesi_prodi')==false)){
				$this->simplival->alert('PERINGATAN\n Combo Tahun Ajaran\n Atau Combo PRODI Belum Dipilih');
				$this->add();
			}else{
				$n = $this->input->post('total_mk');
				for($i=1; $i<$n; $i++){
					if(($this->input->post('matkul'.$i) == true) and ($this->input->post('kuota'.$i))){
						$this->simmktawar_m->insert($this->input->post('matkul'.$i), $this->input->post('kuota'.$i));
					}
				}
				redirect('prodi/simmktawar/listview');
			}
		}
		/*function update(){
			$this->simmktawar_m->update();
			redirect("admin/simmktawar");
		}
		function detail(){
			$data["detail_simmktawar"] = $this->simmktawar_m->detail($this->uri->segment(4,0));
			$this->load->view("admin/tdsimmktawar_v",$data);
		}*/
		function delete(){
			$this->simmktawar_m->delete($this->uri->segment(4,0), $this->uri->segment(5,0));
			redirect('prodi/simmktawar/add');
		}
		function delete2(){
			$this->simmktawar_m->delete($this->uri->segment(4,0), $this->uri->segment(5,0));
			redirect('prodi/simmktawar');
		}
	}
?>