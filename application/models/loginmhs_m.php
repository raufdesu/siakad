<?php 
	class Loginmhs_m extends Model {
		function __construct() {
			parent::Model();
		}
		
		function selectAll(){
			$this->db->select("*");
			$this->db->from("loginmhs");
			$this->db->where("status !=","1");
			$hasil = $this->db->get();
			if($hasil->num_rows() == true){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function insert(){
			$data = array(
				'nim' => $this->input->post('nim'),
				'password' => $this->input->post('password')
			);
			if($this->input->post('nim2')){
				$this->db->where('nim', $this->input->post('nim2'));
				$this->db->update('loginmhs', $data);
			}else{
				$this->db->insert('loginmhs', $data);
			}
		}
		
		function update(){
			$data = array(
				'nim' => $this->input->post('username'),
				'password' => $this->input->post('newpassword')
			);
			$this->db->where('nim', $this->input->post('username'));
			$this->db->update('loginmhs', $data);
		}
		function reset_password(){
			$data = array(
				'nim' => $this->input->post('nim'),
				'password' => $this->input->post('nim')
			);
			$this->db->where('nim', $this->input->post('nim'));
			$this->db->update('loginmhs', $data);
		}
		// UNTUK LOGIN MAHASISWA
		function cekcount_loginmhs(){
			$this->db->select('nim');
			$this->db->from('loginmhs');
			$this->db->where('nim', $this->input->post('username'));
			$this->db->where('password', $this->input->post('password'));
			return $this->db->count_all_results();
		}
		function cek_tgllhr_mhs(){
			$this->db->select('nim');
			$this->db->from('masmahasiswa');
			$this->db->where('nim', $this->input->post('nim'));
			$this->db->where('tgllahir', $this->input->post('tgllahir'));
			return $this->db->count_all_results();
		}
		function cek_ada($nim){
			$this->db->select('nim');
			$this->db->from('loginmhs');
			$this->db->where('nim', $nim);
			return $this->db->count_all_results();
		}
		function loginmhs() {
			$data = array();
			$username = $this->input->post('username');
			
			$healthy = array("'", '"');
			$yummy   = array("\'", '\"');
			$pass = str_replace($healthy, $yummy, $this->input->post('password'));
			
			$sql = "SELECT
						nim, password, status,
						(SELECT nama FROM masmahasiswa WHERE nim = L.nim) AS namamhs
						FROM loginmhs L 
						WHERE
							nim = '".$username."' AND
							password = '".$pass."'
					";
			$hasil = $this->db->query($sql);
			if ($hasil->num_rows() > 0)	 {
				$data = $hasil->row_array();
			}
			$hasil->free_result();
			return $data;
		}
		function checkpass() {
			$data = array();
			$username = $this->input->post('username');
			
			$sql = "SELECT
						nim from loginmhs
						WHERE
							nim = '".$username."' AND
							password = '".$username."'
					";
			$hasil = $this->db->query($sql);
			if ($hasil->num_rows() > 0)	 {
				$data = $hasil->row_array();
			}
			$hasil->free_result();
			return $data;
		}
		// UNTUK MAHASISWA
		/*function loginmhs_mhs() {
			$data = array();
			$this->db->select('*, L.nimmhs nim');
			$this->db->from('loginmhs L');
			$this->db->join('mastermhs M', 'L.nimmhs=M.nimmhs');
			$this->db->where('L.nimmhs', $this->input->post('username'));
			$this->db->where('L.password', $this->input->post('password'));
			//$this->db->where('L.kunci', '2');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array(); //return row sebagai associative array
			}			
			
			if($hasil->num_rows() == true){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}*/
		
		function cek_ubah() {
			$data = array();
			$username = $this->session->userdata("sesi_user");		
			$password = $this->input->post('passlama');
			$sql = "SELECT * FROM loginmhs U WHERE U.username ='$username' AND U.password=md5('$password')";
			$hasil = $this->db->query($sql);
			if ($hasil->num_rows() > 0)	 {
				$data = $hasil->row_array();
			}
			$hasil->free_result();
			return $data;
		}
		function get_one($id){
			$sql = "SELECT loginmhs.nim AS nim, nama, password FROM loginmhs INNER JOIN masmahasiswa
			ON loginmhs.nim = masmahasiswa.nim WHERE loginmhs.nim = '".$id."'";
			$que = $this->db->query($sql);
			if($que->num_rows() > 0){
				return $que->row();
			}else{
				return false;
			}
		}
		function delete($nim){
			$this->db->delete('loginmhs', array('nim' => $nim));
		}
	}
?>