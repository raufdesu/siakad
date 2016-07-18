<?php
Class Simupload extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model(array('simupload_m'));
		$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
		$this->load->helper(array('globals'));
	}
	function index(){
		$this->browse();
	}
	function upload_file(){
		$msg = "";
		$err = "";
		$target_path = "./asset/upload/";
		$target_path = $target_path . basename($_FILES['myfile']['name']); 
		if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)){
			$nmfile = $_FILES["myfile"]["name"];
			echo $this->simplival->alert('KONFIRMASI\nUpload File Sukses');
			$msg .= '<a href="'.base_url().'asset/upload/'.$nmfile.'">'.$nmfile.'</a>';
			$msg .= " <input type='hidden' value='".$nmfile."' name='file' />";
		}else{
			$err = "<p class='warning'><font color=#FF0000>Pengunggahan file logo gagal dilakukan</font></p><br />";
		}
		echo "{";
		echo	   "error: '" . $err . "',\n";
		echo	   "msg: '" . $msg . "'\n";
		echo "}"; 
	}
	function browse($idkelas=''){
		$data['title'] = 'Daftar File Upload';
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= $this->simupload_m->count_all();
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simupload/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_upload'] = $this->simupload_m->get_all($perpage, $data['no']);
		$this->load->view('admin/simupload/tsimupload_v', $data);
	}
	function input(){
		$data['title'] = 'Form Upload File';
		$this->load->view('admin/simupload/isimupload_v', $data);
	}
	function edit($idbap = ''){
		if(!$idbap){
			$idbap = $this->uri->segment(4);
		}
		$idkelas = $this->simupload_m->get_idkelasbyidbap($idbap);
		$this->session->set_userdata('sesi_dosenampu', $idkelas);
		$data['idkelas'] = $idkelas;
		$sesi_dosenampu = $this->session->userdata('sesi_dosenampu');

		$data['ampu'] = $this->simdosenampu_m->get_one($sesi_dosenampu);
		$data['bap'] = $this->simupload_m->get_one($idbap);
		
		
			$data['no'] = $this->uri->segment(4, 0);
			$data['total_page']	= 3; //$this->simupload_m->count_byidkelas($this->session->userdata('sesi_dosenampu'));
			$perpage	= 10;
			$data3		= $this->simpliparse->getAjaxPagination($data['total_page'],
				$perpage,'admin/simupload/browse/',4,'#center-column');
			$data['paging'] = $data3['paging'];
		$data['browse_bap'] = $this->simupload_m->get_byidkelas($data['idkelas']);
		$this->load->view('admin/simupload/esimupload_v', $data);
	}
	function save(){
		$config = array(
				array(
					  'field'   => 'file',
					  'label'   => 'File',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'namaupload',
					  'label'   => 'Judul/Nama file',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'untuk',
					  'label'   => 'Untuk',
					  'rules'   => 'required'
				   ),
				array(
					  'field'   => 'tglupload',
					  'label'   => 'Tanggal upload',
					  'rules'   => 'required'
				   )
				 );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<br /><span class="error"> * ', '</span>');
		if($this->form_validation->run() == FALSE){
			$this->input();
		}else{
			$this->simupload_m->insert();
			redirect('admin/simupload/browse');
		}
	}
	function delete(){
		$this->simupload_m->delete($this->uri->segment(4));
		redirect('admin/simupload/browse/');
	}
}
?>