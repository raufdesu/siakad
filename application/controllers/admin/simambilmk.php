<?php
	// BELUM KEPAKAI INI CONTROLLER
	Class Simmktawar extends Controller{
		function __construct(){
			parent::Controller();
			$this->load->model(array("simmktawar_m","simprodi_m","simsetting_m","masmahasiswa_m","simdosenampu_m"));
			$this->load->library(array('simpliparse','simplival','pquery','form_validation'));
			$this->load->helper(array('globals','html'));
		}
		function presensi(){
			if($this->input->post('txtCari')){
				$this->session->set_userdata('sesicari_matakuliahtawar', $this->input->post('txtCari'));
			}else{
				$this->session->set_userdata('sesicari_matakuliahtawar', '');
			}
			$this->listpresensi();
		}
		function pilih_kelas(){
			$n = $this->input->post('n');
			if($this->session->userdata('sesi_thajaran')){
				// $thajaran = $this->session->userdata('sesi_thajaran');
				$thajaran = '20102';
				$kodemk = $this->session->userdata('sesi_kodemk');
				for($i=0;$i<=$n;$i++){
					// echo $this->input->post('nim_'.$i).'='.$this->input->post('nilai_'.$i).'<br />';
					$this->simkrs_m->update_nilai($this->input->post('nim_'.$i),$thajaran,$kodemk,$this->input->post('nilai_'.$i));
					// echo $this->db->last_query().'<br />';
				}
			}
			redirect('admin/nilai/pilih_matakuliah/'.$this->session->userdata('sesi_kodemk'));
		}
	}
?>