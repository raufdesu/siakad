<?php 
	class Login_m extends Model {
		function __construct() {
			parent::Model();
		}
		function get_all($limit1, $limit2, $cari=''){
			$data = array();
			$sql = 'SELECT *,
				(SELECT nama FROM maspegawai WHERE npp = login.username LIMIT 1)AS nama FROM login ';
			$sql .= ' WHERE username <> "" ';
			if($cari == true){
				$sql .= 'AND username LIKE "%'.$cari.'%" ';
			}
			$sql .= ' LIMIT '.$limit1;
			if($limit2) $sql .= ", ".$limit2;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() == true){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function get_onebyusername($username = ''){
			$data = array();
			$sql = 'SELECT *, (SELECT nama FROM maspegawai WHERE npp=username)nama FROM login WHERE username = "'.$username.'"';
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() == true){
				return $hasil->row();
			}
		}
		function get_allmhs($limit1, $limit2, $cari=''){
			$data = array();
			$sql = "SELECT *,(SELECT nama FROM masmahasiswa WHERE nim = loginmhs.nim LIMIT 1)AS nama FROM loginmhs ";
			if($cari == true){
				$sql .= "WHERE nim LIKE '%".$cari."%' ";
			}
			$sql .= "ORDER BY nim DESC";
			$sql .= " LIMIT ".$limit1;
			if($limit2) $sql .= ", ".$limit2;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() == true){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_allmhs($cari=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("loginmhs");
			if($cari == true){
				$this->db->like("nim", $cari);
			}
			return $this->db->count_all_results();
		}
		function get_user($limit1, $limit2, $cari=''){
			$data = array();
			$sql = "SELECT * FROM login";
			$sql .= " LIMIT ".$limit1;
			if($limit2) $sql .= ", ".$limit2;
			$hasil = $this->db->query($sql);
			if($hasil->num_rows() == true){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_all($cari=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("loginmhs");
			if($cari == true){
				$this->db->like("nim", $cari);
			}
			return $this->db->count_all_results();
		}
		function count_alladm($cari=''){
			$data = array();
			$this->db->select('*');
			$this->db->from('login');
			if($cari == true){
				$this->db->like('username', $cari);
			}
			return $this->db->count_all_results();
		}
		function select($limit1,$limit2,$cari=''){
			$data = array();
			$this->db->select("*");
			$this->db->from("loginmhs log");
			$this->db->join("akd_mhs mhs","log.username = mhs.nimhsmsmhs");
			$this->db->where("log.status !=","1");
			$this->db->where("mhs.kdpeg !=","");
			if($cari == true){
				$this->db->like("nimhsmsmhs",$cari);
				$this->db->or_like("nmmhsmsmhs",$cari);
			}
			$this->db->limit($limit2,$limit1);
			$hasil = $this->db->get();
			if($hasil->num_rows() == true){
				$data = $hasil->result();
			}
			$hasil->free_result();
			return $data;
		}
		function count_login($cari=''){
			$this->db->from("loginmhs log");
			$this->db->join("akd_mhs mhs","log.username = mhs.nimhsmsmhs");
			$this->db->where("log.status !=","1");
			$this->db->where("mhs.kdpeg !=","");
			if($cari == true){
				$this->db->like("nimhsmsmhs",$cari);
				$this->db->or_like("nmmhsmsmhs",$cari);
			}
			return $this->db->count_all_results();
		}
		function cek_byusername($username){
			$this->db->from('login');
			$this->db->where('username', $username);
			return $this->db->count_all_results();
		}

		function simpan() {
			$data = array(
				'nip' => $this->input->post('nip'),
				'nm_login' => $this->input->post('nip'),
				'password' => md5($this->input->post('nip')),
				'status' => $this->input->post('petugas')
			);			
			$this->db->insert('login', $data);
		}
		function ubah() {
            $status = $this->session->userdata("sesi_status");
			$data = array(
				'username' => $this->session->userdata('sesi_user'),
				'password' => md5($this->input->post('passbaru'))
			);
			$this->db->where('username', $this->session->userdata("sesi_user"));
			$this->db->update('login', $data);
		}
		function insert(){
			$data = array(
				'username'	=> $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'status' => $this->input->post('status'),
				'prodi' => $this->input->post('kodeprodi'),
				'statusopen' => 'Open'
			);
			$this->db->insert('login', $data);
		}
		function update_passdosen(){
			if($this->input->post('username')){
				$username = $this->input->post('username');
			}else{
				$username = $this->session->userdata('sesi_user');
			}
            //$status = $this->session->userdata("sesi_status");
			$data = array(
				'username' => $username,
				'password' => md5($this->input->post('passbaru'))
			);
			$this->db->where('username', $username);
			$this->db->update('login', $data);
		}
		function getThajaran(){
			$data = array();
			$this->db->select('*');
			$this->db->where('aktif','Aktif');
			$this->db->from('simsetting');
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0){
				return $hasil->row_array();
			}
		}
		// UNTUK ADMIN
		function login(){
			$data = array();
			$username = $this->input->post('username');
			$healthy = array("'", '"');
			$yummy   = array("\'", '\"');
			$user = str_replace($healthy, $yummy, $this->input->post('username'));
			$pass = str_replace($healthy, $yummy, $this->input->post('password'));

			$sql = "SELECT * FROM login L WHERE L.username ='".$user."' AND L.password=md5('".$pass."')";
			$hasil = $this->db->query($sql);
			if ($hasil->num_rows() > 0)	 {
				$data = $hasil->row_array();
			}
			$hasil->free_result();
			return $data;
		}
		// Untuk Dosen
		function ceklogin_dosen(){
			$data = array();
			$username = $this->input->post('username');
			$healthy = array("'", '"');
			$yummy   = array("\'", '\"');
			$pass = str_replace($healthy, $yummy, $this->input->post('password'));

			$sql = "SELECT * FROM login L WHERE L.username ='$username'
						AND L.password=md5('$pass')";
			$hasil = $this->db->query($sql);
			return $hasil->num_rows();
		}
		
		// UNTUK MAHASISWA
		function login_mhs() {
			$data = array();
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$sql = "SELECT * FROM login L WHERE L.username ='$username' AND L.password=md5('$password') AND L.status='2'";
			$hasil = $this->db->query($sql);
			if ($hasil->num_rows() > 0)	 {
				$data = $hasil->row_array();
			}
			$hasil->free_result();
			return $data;
		}
		
		function cek_ubah() {
			$data = array();
			$username = $this->session->userdata("sesi_user");		
			$password = $this->input->post('passlama');
			$sql = "SELECT * FROM login U WHERE U.username ='$username' AND U.password=md5('$password')";
			$hasil = $this->db->query($sql);
			if ($hasil->num_rows() > 0)	 {
				$data = $hasil->row_array();
			}
			$hasil->free_result();
			return $data;
		}
		function delete($username){
			$this->db->delete('login', array('username' => $username));
		}

	}
?>