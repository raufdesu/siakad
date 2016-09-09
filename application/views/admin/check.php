<?php
error_reporting(E_ERROR);
// database variables
$hostname = "localhost";
$user = "root";
$password = "";
$database = "importer";
// Database connecten 
$connection= mysql_connect($hostname, $user, $password);    

mysql_select_db ($database, $connection);

$list_1st = "SELECT nim FROM siakadtest.masmahasiswa where nim not in (SELECT nipd FROM importer.mhs_pt)";
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
							$insert_1st = "insert into importer.mhs (nm_pd, jk, nik, tmpt_lahir, tgl_lahir, id_agama, id_kk, id_sp, rt, rw, 
										nm_dsn, ds_kel, id_wil, kode_pos, telepon_seluler, email, a_terima_kps, no_kps, stat_pd, nm_ayah, 
										id_kebutuhan_khusus_ayah, nm_ibu_kandung, id_kebutuhan_khusus_ibu, kewarganegaraan)
										SELECT nama, jeniskelamin, nik, tempatlahir, tgllahir, id_agama, '0', '', rt, rw, 
										alamatasal, '-', '999999', kodepos, notelpmhs, email, '0', '', 'A', namaortu,
										'0', '-', '0', 'ID' from siakadtest.masmahasiswa
										WHERE masmahasiswa.nim = '".$motherid."';";
							$insert_2nd = "insert into importer.mhs_pt (id_mhs, kode_jurusan, id_jns_daftar, nipd, tgl_masuk_sp, mulai_smt)
										SELECT LAST_INSERT_ID(), kodeprodi, '1', nim, tglmasuk, angkatan from siakadtest.masmahasiswa
										WHERE masmahasiswa.nim = '".$motherid."';";
							$mysql_insert_1st = mysql_query($insert_1st);
							$mysql_insert_2nd = mysql_query($insert_2nd);
										
						}
					}
					else if ($ij == null && $jk == null)
					{
					echo "Semua data mahasiswa telah di import";
					}
?>	