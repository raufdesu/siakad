<?php
error_reporting(E_ERROR);
// database variables
$hostname = "localhost";
$user = "root";
$password = "qwerty123";
$database = "importer";
// Database connecten 
$connection= mysql_connect($hostname, $user, $password);    

mysql_select_db ($database, $connection);

$list_1st = "SELECT nim FROM siakadmataram.masmahasiswa where nim not in (SELECT nipd FROM importer.mhs_pt)";
		$result_1st = mysql_query($list_1st);
					$ij = 0;
					while ($row1 = mysql_fetch_array($result_1st)) 
					{
						$colom1[$ij] = $row1[0];
						$col1 =  $colom1[$ij];
						//echo $col1;
						$ij++;
					}
					$result_2nd = mysql_query($list_2nd);
					$jk = 0;
					while ($row2 = mysql_fetch_array($result_2nd)) 
					{
						$colom2[$jk] = $row2[0];
						$col2 =  $colom2[$jk];
						//echo $col1;
						$jk++;
					}
					if ($ij != null || $jk != null)
					{
					echo "<center>NIM Mahasiswa yang berhasil di import</center><br><br>";
					echo "<center>nim</center><br>";
					$n = 0;
					foreach($colom1 as $key=>$motherid)
					    {
							echo "<center>".$motherid.'</center><br>';
							$insert_1st = "insert into importer.mhs (nm_pd, jk, nisn, nik, tmpt_lahir, tgl_lahir, id_agama, id_kk, jln, rt, rw, 
										nm_dsn, ds_kel, id_wil, kode_pos, id_jns_tinggal, id_alat_transport, no_tel_rmh, no_hp, email, a_terima_kps, no_kps, stat_pd, nm_ayah, tgl_lahir_ayah, id_jenjang_pendidikan_ayah, id_pekerjaan_ayah, id_penghasilan_ayah, 
										id_kebutuhan_khusus_ayah, nm_ibu_kandung, tgl_lahir_ibu, id_jenjang_pendidikan_ibu, id_pekerjaan_ibu, id_penghasilan_ibu, id_kebutuhan_khusus_ibu, nm_wali, tgl_lahir_wali, id_jenjang_pendidikan_wali, id_pekerjaan_wali, id_penghasilan_wali, kewarganegaraan)
										SELECT nama, jeniskelamin, nisn, nik, tempatlahir, tgllahir, id_agama, '0', alamatsekarang, rt, rw, 
										nm_dsn, ds_kel, '999999', kodepos, id_jns_tinggal, id_alat_transport, notelportu, notelpmhs, email, a_terima_kps, no_kps, statusakademik, nm_ayah,
										tgl_lahir_ayah, id_jenjang_pendidikan_ayah, id_pekerjaan_ayah, id_penghasilan_ayah, '0', nm_ibu_kandung, tgl_lahir_ibu, id_jenjang_pendidikan_ibu, id_pekerjaan_ibu, id_penghasilan_ibu, '0', nm_wali, tgl_lahir_wali, id_jenjang_pendidikan_wali, id_pekerjaan_wali, id_penghasilan_wali, kewarganegaraan from siakadmataram.masmahasiswa
										WHERE masmahasiswa.nim = '".$motherid."';";
							$insert_2nd = "insert into importer.mhs_pt (id_mhs, kode_jurusan, id_jns_daftar, nipd, tgl_masuk_sp, mulai_smt)
										SELECT LAST_INSERT_ID(), kodeprodi, '1', nim, tglmasuk, RPAD(`angkatan`, 5, '1') from siakadmataram.masmahasiswa
										WHERE masmahasiswa.nim = '".$motherid."';";
							$mysql_insert_1st = mysql_query($insert_1st);
							$mysql_insert_2nd = mysql_query($insert_2nd);
										
						}
						$replace_1st = "update importer.mhs set mhs.jk = 'L' where mhs.jk = '1'";
						$replace_2nd = "update importer.mhs set mhs.jk = 'P' where mhs.jk = '0'";
						$replace_3rd = "update importer.mhs set mhs.stat_pd = 'A' where mhs.stat_pd = 'Belum Lulus'";
						$replace_4th = "update importer.mhs set mhs.stat_pd = 'L' where mhs.stat_pd = 'Lulus'";
							$mysql_replace_1st = mysql_query($replace_1st);
							$mysql_replace_2nd = mysql_query($replace_2nd);
							$mysql_replace_3rd = mysql_query($replace_3rd);
							$mysql_replace_4th = mysql_query($replace_4th);
						
					}
					else if ($ij == null && $jk == null)
					{
					echo "Semua data mahasiswa telah di import";
					}
	
	$this->load->view('admin/push_mhs_all');
?>	