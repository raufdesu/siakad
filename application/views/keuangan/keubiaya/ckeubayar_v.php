<?php
	if($extensi == 'doc'){
		$namafile = "Laporan_Pembayaran_".$thajaran.".doc";
		header("Content-type: application/msword");
	}else{
		$namafile = "Laporan_Pembayaran_".$thajaran.".xls";
		header("Content-type: application/excel");
	}
	
	header("Content-disposition: attachment; filename=".$namafile);
?>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Pembayaran</title>
	<style>
		.profil td{
			padding:5px 10px; 5px 10px;
		}
		.listing{
			width:100%;
		}
		.listing th{
			padding:5px 10px; 5px 10px;
			border-bottom: 1px solid #efefef;
			border-top: 1px solid #efefef;
		}
		.listing td{
			padding:5px 10px; 5px 10px;
			border-bottom: 1px solid #efefef;
		}
		hr{
			border:3px double #ABABAB;
		}
	</style>
</head>
<body>
<h3>Laporan Pembayaran Tahun Ajaran <?php echo $thajaran?><br />
<?php
	if($this->session->userdata('sesi_prodikeumhs')){
		echo "PRODI : ".$this->auth->get_namaprodi($this->session->userdata('sesi_prodikeumhs'));
	}
	if($this->session->userdata('sesi_angkatankeumhs')){
		echo "<br />Angkatan : ".$this->session->userdata('sesi_angkatankeumhs');
	}
	foreach($browse_keubayar as $bk):
?>
</h3>
<table class="profil">
	<tr>
		<td>NIM</td><td style="min-width:70px;">: <?php echo $bk->nim?></td><td>Prodi</td><td>: <?php echo $this->auth->get_namaprodi($bk->kodeprodi)?></td>
	</tr>
	<tr>
		<td>Nama</td><td>: <?php echo $bk->nama?></td><td>Angkatan</td><td>: <?php echo $bk->angkatan?></td>
	</tr>
</table>
<table class="listing" cellpadding="0" cellspacing="0">
	<tr>
		<th>No</th><th>Pembayaran</th><th>Biaya</th><th>Dibayar</th><th>Kekurangan</th><th>Status</th>
	</tr>
	<?php
		$sql = "SELECT *,
				(SELECT totalbiaya FROM keujenisbayar WHERE jenisbayar = keubayar.jenisbayar AND angkatan = '".$bk->angkatan."') AS totalbiaya
				FROM keubayar WHERE nim = '".$bk->nim."'";
		$que = mysql_query($sql);
		$i = 1; $totaldibayar = 0; $ttotalbiaya = 0; $totalkurang = 0;
		while($d = mysql_fetch_array($que)):
			$sq = "SELECT * FROM keudetbayar WHERE idbayar = ".$d['idbayar'];
			$qu = mysql_query($sq);
	?>
	<tr class="bg">
		<td><?php echo $i++?></td>
		<td class="first"><?php echo $d['jenisbayar'];?></td>
		<td style="text-align:right"><?php $totalbiaya = $d['totalbiaya']; echo rupiah($totalbiaya);?></td>
		<td style="text-align:right">
			<?php
				$jumlahbayar = 0;
				while($rec = mysql_fetch_array($qu)):
					$jumbayar = $rec['jumbayar'];
					echo rupiah($jumbayar).'<br />';
					$jumlahbayar = $jumlahbayar+$jumbayar;
				endwhile;
			?>
		</td>
		<td style="text-align:right"><?php $kurang = $totalbiaya - $jumlahbayar; echo rupiah($kurang)?></td>
		<td><?php echo $d['status']?></td>
	</tr>
	<?php
		$totaldibayar = $totaldibayar+$jumlahbayar;
		$ttotalbiaya = $ttotalbiaya+$totalbiaya;
		$totalkurang = $totalkurang+$kurang;
		endwhile;
	?>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align:right"><b>Total Pembayaran</b></td>
		<td style="text-align:right"><?php echo rupiah($ttotalbiaya)?></td>
		<td style="text-align:right"><?php echo rupiah($totaldibayar)?></td>
		<td style="text-align:right"><?php echo rupiah($totalkurang)?></td>
		<td>&nbsp;</td>
	</tr>
</table><hr /><br />
<?php endforeach; ?>
</body>
</html>