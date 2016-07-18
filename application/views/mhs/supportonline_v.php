<?php
	$status = '';
	$id = "ibnu_muhammad22"; //Ubah sesuai Yahoo ID anda
	$online = base_url()."asset/images/design/fancy_closebox.png"; //URL ke gambar jika status online
	$offline = base_url()."asset/images/design/thumb-logo.png"; //URL ke gambar jika status offline
	$buka = fopen("http://opi.yahoo.com/online?u=".$id."&m=t","r")
	or die
	("<img src='http://opi.yahoo.com/online?u=".$id."&m=g&t=2'/>");
	while ($baca = fread( $buka, 2048 )){
		$status .= $baca;
	}
	fclose($buka);
	if($status == $id." is ONLINE"){
		echo "<a class='sup-on' href='ymsgr:sendIM?ibnu_muhammad22'>Sedang Online</a>";
	} else {
		echo "<a class='sup-off' href='ymsgr:sendIM?ibnu_muhammad22'>Sedang Offline</a>";
	}
?>