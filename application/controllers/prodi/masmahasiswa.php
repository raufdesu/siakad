<?php
	Class Masmahasiswa extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array('masmahasiswa_m', 'simprodi_m', 'simdaftarskripsi_m'));
			$this->load->library(array('simpliparse', 'pquery', 'form_validation'));
			$this->load->library('fungsi');
			$this->load->helper(array('globals', 'html'));
		}
		function pendaftaran(){
			$data['title'] = 'Pendaftaran TA/KP/Skripsi';
			$nim = $this->uri->segment(4);
			$data['cek_daftar'] = $this->simdaftarskripsi_m->count_all($nim);
			$data['detail_simdaftarskripsi'] = $this->simdaftarskripsi_m->get_one($nim);
			$this->load->view('prodi/simdaftarskripsi/tdsimdaftarskripsi_v', $data);
		}
		function status(){
			if($this->uri->segment(4)){
				$this->session->set_userdata('sesi_statusakademik', $this->uri->segment(4));
			}else{
				$this->session->set_userdata('sesi_statusakademik', '');			
			}
			redirect('prodi/masmahasiswa/listview');
		}
		function index(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('cari_masmahasiswa', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('cari_masmahasiswa', '');			
			}
			$this->listview();
		}
		function angkatan(){
			$this->session->set_userdata('sesi_angkatanmhs', $this->uri->segment(4));
			redirect('prodi/masmahasiswa/listview');
		}
		function shift(){
			$this->session->set_userdata('sesi_shiftmhs', $this->uri->segment(4));
			redirect('prodi/masmahasiswa/listview');
		}
		function pendaftar_skripsi(){
			$this->session->set_userdata('sesi_pendaftar', $this->uri->segment(4));
			redirect('prodi/masmahasiswa/listview');
		}
		function cetak(){
			$prodi = $this->session->userdata('sesi_prodi');
			$angkatan = $this->session->userdata('sesi_angkatanmhs');
			$data['title'] = url_title('Data Mahasiswa '.$this->auth->get_namaprodi($prodi));
			$data['total_page']	= $this->masmahasiswa_m->count_all($prodi, $angkatan);
			$data['browse_masmahasiswa'] = $this->masmahasiswa_m->select('', '', $prodi, $angkatan);
			$this->load->view('prodi/masmahasiswa/cmasmahasiswa_v', $data);
		}
		function listview(){
			$prodi = $this->session->userdata('sesi_prodi');
			$angkatan = $this->session->userdata('sesi_angkatanmhs');
			$this->load->library(array('form_validation'));
			$data['no'] = $this->uri->segment(4, 0);
			$data['browse_angkatan'] = $this->masmahasiswa_m->get_disangkatan();
			$data['total_page']	= $this->masmahasiswa_m->count_all($prodi, $angkatan);
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'prodi/masmahasiswa/listview/',4,'#center-column');
			$data['paging'] = $data3['paging'];
			$data["browse_masmahasiswa"] = $this->masmahasiswa_m->select($data['no'], $perpage, $prodi, $angkatan);
			$this->load->view("prodi/masmahasiswa/tmasmahasiswa_v",$data);
		}
		function tampilkan_kabupaten(){
			$kategori = $this->uri->segment(4,0);
			$kat = substr($kategori, 0, 2);
			$sql = "SELECT * FROM tkabupaten WHERE idkabupaten LIKE '$kat%'";
			$kabupaten = $this->db->query($sql);
			echo $this->fungsi->create_combobox('kabupaten',$kabupaten,'idkabupaten','namakabupaten');
		}
		function add(){
			$data['propinsi'] = $this->db->get('tpropinsi');
			$data['propinsi'] = $this->db->get('tpropinsi');
			$data['browse_prodi'] = $this->simprodi_m->select('','');
			$data["title"]	= "Form Tambah Data Mahasiswa";
			$this->load->view("prodi/imasmahasiswa_v",$data);
		}
		function edit($id = ''){
			if($this->uri->segment(4) == false){
				$id = $id;
			}else{
				$id = $this->uri->segment(4);
			}
			$data["title"]	= "Form Update Data Mahasiswa";
			$data['browse_prodi'] = $this->simprodi_m->select('','');
			$data["detail_masmahasiswa"] = $this->masmahasiswa_m->detail($id);
			$this->load->view("prodi/emasmahasiswa_v",$data);
		}
		function save(){
			$config = array(
					array(
						  'field'   => 'nim',
						  'label'   => 'NIM',
						  'rules'   => 'required'
					   )
					/*array(
						  'field'   => 'nama',
						  'label'   => 'Nama mahasiswa',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'kodeprodi',
						  'label'   => 'PRODI',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'angkatan',
						  'label'   => 'Angkatan',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'kdkelas',
						  'label'   => 'Kelas',
						  'rules'   => 'required'
					   )*/
					/*array(
						  'field'   => 'alamatasal',
						  'label'   => 'Alamat Asal',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'alamatjogja',
						  'label'   => 'Alamat Jogja',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'idpropinsi',
						  'label'   => 'Propinsi',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'idkabupaten',
						  'label'   => 'Kabupaten',
						  'rules'   => 'required'
					   ),*/
					/*array(
						  'field'   => 'jeniskelamin',
						  'label'   => 'Jenis Kelamin',
						  'rules'   => 'required'
					   ),*/
					/*array(
						  'field'   => 'namaortu',
						  'label'   => 'Nama Orang Tua',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'alamatortu',
						  'label'   => 'Alamat Orang Tua',
						  'rules'   => 'required'
					   ),*/
					/*array(
						  'field'   => 'notelportu',
						  'label'   => 'No. Telepon Orang Tua',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'notelpmhs',
						  'label'   => 'No. Telepon Mahasiswa',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'email',
						  'label'   => 'Email Mahasiswa',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'asalsma',
						  'label'   => 'SMA Asal',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'jurusansma',
						  'label'   => 'Jurusan SMA',
						  'rules'   => 'required'
					   ),*/
					/*array(
						  'field'   => 'tempatlahir',
						  'label'   => 'Tempat Lahir',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tgllahir',
						  'label'   => 'Tanggal Lahir',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'tglmasuk',
						  'label'   => 'Tanggal Masuk',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'statusmasuk',
						  'label'   => 'Status Masuk',
						  'rules'   => 'required'
					   ),*/
					/*array(
						  'field'   => 'asalpt',
						  'label'   => 'Asal Perguruan Tinggi',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'prodiasal',
						  'label'   => 'PRODI Asal',
						  'rules'   => 'required'
					   ),*/
					/*array(
						  'field'   => 'statusakademik',
						  'label'   => 'Status Akademik',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'statuskrs',
						  'label'   => 'Status KRS',
						  'rules'   => 'required'
					   ) */
					/*array(
						  'field'   => 'alamatsma',
						  'label'   => 'Alamat SMA',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'kodepossma',
						  'label'   => 'Kode POS SMA',
						  'rules'   => 'required'
					   ),*/
					/*array(
						  'field'   => 'kodepos',
						  'label'   => 'Kode POS',
						  'rules'   => 'required'
					   ),
					array(
						  'field'   => 'thlulus',
						  'label'   => 'Tahun Lulus',
						  'rules'   => 'required'
					   ) */
					 );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if ($this->form_validation->run() == FALSE){
				if($this->input->post('nim2')){
					$id = $this->input->post('nim2');
					$this->edit($id);
				}else{
					$this->add();
				}
			}else{
				$this->masmahasiswa_m->insert();
				redirect("prodi/masmahasiswa");		
			}
		}
		function update(){
			$this->masmahasiswa_m->update();
			redirect("prodi/masmahasiswa");
		}

		function detail(){
			$data["detail_masmahasiswa"] = $this->masmahasiswa_m->detail($this->uri->segment(4,0));
			$this->load->view("prodi/masmahasiswa/tdmasmahasiswa_v",$data);
		}

		function delete(){
			$this->masmahasiswa_m->delete($this->uri->segment(4,0));
			redirect('prodi/masmahasiswa');
		}
	}
?>