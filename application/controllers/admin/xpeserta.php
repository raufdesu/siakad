<?php
	Class Peserta extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->library("pagination");
			$this->load->model("kurmatakuliah_m");
			$this->load->model("peserta_m");
			//$this->load->helper("file");
			$this->load->helper("html");
			//$this->load->library('form_validation');
			$sesmain_mn = array(
				"mn_mhs" => "",
				"mn_skripsi" => "",
				"mn_password" => "",
				"mn_khs" => "",
				"mn_dpa" => "",
				"mn_kuliah" => "",
				"mn_nilai" => "active",
				"mn_set" => "",
			);
			$this->session->set_userdata($sesmain_mn);
		}

		function input_nilai(){
			$thn_akad = $this->session->userdata("sesi_thn_akad").$this->session->userdata("sesi_semester");
			if($this->uri->segment(6) == "awal"){
				$this->session->set_userdata("sesi_cari_nilai","");				
			}
			if($this->input->post("txtCari")){
				$this->session->set_userdata("sesi_cari_nilai",$this->input->post("txtCari"));
			}
			$cari_nilai = $this->session->userdata("sesi_cari_nilai");
			if($this->uri->segment(6) == "awal"){
				$arseni = array(
					"matkul_sesi" => $this->uri->segment(4),
					"nama_sesi_kul" => $this->uri->segment(5)
				);
				$this->session->set_userdata($arseni);
				$data["no"]	= 0;
			}else{
				$data["no"]	= $this->uri->segment(4);
			}
			$kd_matkul = $this->session->userdata("matkul_sesi");
			$data["base_url"]		= base_url()."index.php/admin/peserta/input_nilai/";
			$data['per_page'] = 10;
			$data['total_rows'] = count($this->peserta_m->mhs_kuliah('','',$kd_matkul,$cari_nilai,$thn_akad));
			//echo $this->db->last_query();
			$this->pagination->initialize($data);
			$data["mhs_kuliah"]	= $this->peserta_m->mhs_kuliah($data['no'],$data['per_page'],$kd_matkul,$cari_nilai,$thn_akad);
			//echo $this->db->last_query();
			//$mhs_kul = $this->peserta_m->mhs_kuliah($kd_matkul);
			
			//echo $this->db->last_query();
			$data["main"]	= "admin/inilai_v";
			$this->load->view("admin/main_v",$data);
		}

		function simpan_nilai(){
			$thn_akad = $this->session->userdata("sesi_thn_akad").$this->session->userdata("sesi_semester");
			//$i = $this->input->post
			$awal	= $this->input->post("awal");
			$akhir	= $this->input->post("akhir");
			for($i=$awal; $i<$akhir; $i++){
				//echo $i.". ".$this->input->post("nim".$i)."<br />";
				//echo $i.". ".$this->input->post("nilai".$i)."<br />";
				$this->peserta_m->update_nilai($this->input->post("kode_kuliah"),$this->input->post("nim".$i),$this->input->post("nilai".$i),$thn_akad);
				//echo $this->db->last_query();
			}
			//$this->peserta_m->insert();
			$ke = $awal-1;
			redirect("admin/peserta/input_nilai/".$ke,"Refresh");
		}

		function pil_matkul_nilai(){
			$thn_akad = $this->session->userdata("sesi_thn_akad").$this->session->userdata("sesi_semester");
			if($this->uri->segment(4) == "awal"){
				$this->session->set_userdata("sesi_pil_kurmatkul","");			
			}
			if(!$this->uri->segment(4)){
				$data["no"] = 0;
			}else{
				$data["no"]		= $this->uri->segment(4);
			}
			$data["base_url"]		= base_url()."index.php/admin/kurmatakuliah/index/";
			$data["per_page"]		= 10;
			$data["main"]			= "admin/tMatkul_nilai_v";
			if($this->input->post("txtCari")){
				$newdata = array(
	                   "sesi_pil_kurmatkul"  => $this->input->post("txtCari")
	               );
				$this->session->set_userdata($newdata);
			}
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pil_kurmatkul")){
				$this->db->like('am.nama1', $this->session->userdata("sesi_pil_kurmatkul"));
				$this->db->from('akd_kurmk ak');
				$this->db->join('akd_matakuliah am','ak.id_mk = am.id_mk');
				//$this->db->where('
				$data["total_rows"]	= $this->db->count_all_results();
			}else{
				$data["total_rows"]	= $this->db->count_all("akd_kurmk");
			}
			$this->pagination->initialize($data);
			if($this->input->post("cmdCari") || $this->session->userdata("sesi_pil_kurmatkul")){
				$data["browse_kurmatakuliah"] = $this->kurmatakuliah_m->select_cari($data["no"],$data["per_page"],$this->session->userdata("sesi_pil_kurmatkul"),$thn_akad);
			}else{
				$data["browse_kurmatakuliah"] = $this->kurmatakuliah_m->select($data["no"],$data["per_page"],$thn_akad);
			}
			$this->load->view("admin/main_v",$data);
		}
	}
?>