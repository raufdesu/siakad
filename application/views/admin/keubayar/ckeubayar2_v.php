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
		.listing{
			width:100%;
		}
		.listing th{
			vertical-align:top;
			padding:5px 10px; 5px 10px;
			border-bottom: 1px solid #efefef;
			border-top: 1px solid #efefef;
		}
		.listing td{
			vertical-align:top;
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
?>
</h3>
<table class="listing" cellpadding="0" cellspacing="0">
	<tr>
		<th>No</th><th>NIM</th><th>Nama</th><th>Pembayaran</th><th>Tahun Ajaran</th><th>Semester</th><th>Biaya</th><th>Dibayar</th><th>Kekurangan</th><th>Status</th>
	</tr>
	<?php
		$no = 1;
		$jumbiaya = 0;
		$jumtotbayar = 0;
		$jumkekurangan = 0;
		foreach($browse_keubayar as $bk):
	?>
	<tr>
		<td><?php echo $no++?></td>
		<td><?php echo $bk->nim?></td>
		<td><?php echo $bk->nama?></td>
		<td><?php echo $bk->jenisbayar?></td>
		<td><?php echo thakademik($bk->thajaran)?></td>
		<td><?php echo semester($bk->thajaran)?></td>
		<td><?php $biaya = $bk->biaya; echo rupiah($biaya)?></td>
		<td>
		<?php
			$sql = "SELECT * FROM keudetbayar WHERE idbayar = ".$bk->idbayar;
			$que = mysql_query($sql);
			$totbayar = 0;
			while($d = mysql_fetch_array($que)):
				echo rupiah($d['jumbayar']).'<br />';
				$totbayar = $totbayar + $d['jumbayar'];
			endwhile;
		?>
		</td>
		<td><?php $kekurangan = $biaya - $totbayar; echo rupiah($kekurangan); ?></td>
		<td><?php echo $bk->status?></td>
	</tr>
	<?php
		$jumbiaya = $jumbiaya + $biaya;
		$jumtotbayar = $jumtotbayar + $totbayar;
		$jumkekurangan = $jumkekurangan + $kekurangan;
		endforeach;
	?>
	<tr>
		<td colspan="6" align="right"><b>Total</b></td>
		<td><?php echo rupiah($jumbiaya); ?></td>
		<td><?php echo rupiah($jumtotbayar); ?></td>
		<td><?php echo rupiah($jumkekurangan); ?></td>
		<td>&nbsp;</td>
	</tr>
</table>
</body>
</html>