<?php
	 $date = getdate();
	 $hrs = $date['hours'];
	 $min = $date['minutes'];
	 $sec = $date['seconds'];
	 $mon = $date['mon'];
	 $day = $date['mday'];
	 $yr = $date['year'];
	 $ip         = $_SERVER['REMOTE_ADDR'];
	 $hostname     = gethostbyaddr($ip);
	 $time        = mktime($hrs,$min,$sec,$mon,$day,$yr);
	 mysql_query("INSERT INTO web_stat (`ip`,`hostname`,`time`) VALUES ('".$ip."','".$hostname."','".$time."');");


	 $date = getdate();
			$hrs = $date['hours'];
			$min = $date['minutes'];
			$sec = $date['seconds'];
			$mon = $date['mon'];
			$day = $date['mday'];
			$yr = $date['year'];

			//Mengambil query terhadap total klik pada halaman
			$total_klik = mysql_num_rows(mysql_query("SELECT * FROM web_stat"));
			//Mengambil query terhadap total unique visitor
			$unique = mysql_num_rows(mysql_query("SELECT DISTINCT (`ip`) FROM web_stat"));
			//Mengambil nilai waktu dari 24jam(1 hari) yang lalu
			$satu_hari = mktime($hrs,$min,$sec,$mon,$day-1,$yr);
			//Mengambil query terhadap total klik pada halaman dalam 24 jam terakhir
			$totalklik_24jam = mysql_num_rows(mysql_query("SELECT * FROM web_stat WHERE time > ".$satu_hari));
			//Mengambil query terhadap total unique visitor pada halaman dalam 24 jam terakhir
			$total_24jam = mysql_num_rows(mysql_query("SELECT DISTINCT (`ip`) FROM web_stat WHERE time > ".$satu_hari));
			//Mengambil nilai waktu dari 5menit yang lalu (patokan user yang sedang online)
			$online = mktime($hrs,$min-2,$sec,$mon,$day,$yr);
			//Mengambil query terhadap total user yang sedang online berdasarkan batas waktu di atas (contoh: 5menit)
			$total_online = mysql_num_rows(mysql_query("SELECT DISTINCT (`ip`) FROM web_stat WHERE time > ".$online));
?>
<div id="counter_cd">
	<span class="label">Now</span><span>: <b><?php echo $total_online;?></b></span><br />
	<span class="label">To Day</span><span>: <b><?php echo $total_24jam;?></b></span><br />
	<span class="label">Click To Day</span><span>: <b><?php echo $totalklik_24jam;?></b></span><br />
	<span class="label">Click Total</span><span>: <b><?php echo $total_klik;?></b></span><br />
	<span class="label">Total All</span><span>: <b><?php echo $unique;?></b></span><br />
</div>