<head>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
	<title>Laporan Biaya Perindividu</title>
</head>
<div id='noprint' style="float:right;">
	<a href='#' id="noprint" class='print-button' onclick='print()'>cetak</a>
</div>
<table class="kop-surat" align="center" width="95%">
	<tr>
		<td align="center"><img src="<?php echo base_url()?>asset/images/design/logo-laporan.png" width="70" /></td>
		<td align="center">
			<font size="5"><?php echo $this->config->item('instansi_name')?></font><br />
			<font size="4">STATUS TERAKREDITASI</font><br />
			<font size="3"><?php echo $this->config->item('instansi_address')?></font>
		</td>
	</tr>
</table>
<center><h3 style="margin:2px !important">KARTU PEMBAYARAN BIAYA PENDIDIKAN MAHASISWA</h3></center>
<table width="100%" cellspacing="0">
	<tr>
		<td>Nama</td><td> : <?php echo $mhs['nama']?></td>
		<td>SKS yang telah dimiliki</td>
		<td> : ..............</td>
	</tr>
	<tr>
		<td>NIM</td><td> : <?php echo $mhs['nim']?></td>
		<td>Masuk Semester</td>
		<td> : ..............</td>
	</tr>
	<tr>
		<td>Fakultas</td><td> : <?php echo $this->auth->get_namafakultasbykodeprodi($mhs['kodeprodi']); ?></td>
		<td>Beban Belajar yang harus ditempuh</td>
		<td> : .... SKS</td>
	</tr>
	<tr>
		<td>Jrs/Prog. Studi</td><td> : <?php echo $this->auth->get_prodibynim($mhs['nim'])->namaprodi?></td>
		<td>SPP/Semester/SKS</td>
		<td> : Rp. .......</td>
	</tr>
	<tr>
		<td>Tahun Masuk</td><td> : <?php echo $mhs['angkatan']?></td>
		<td>SP</td>
		<td> : Rp. .......</td>
	</tr>
	<tr>
		<td>Ijazah yang dipergunakan</td><td> : .......</td>
		<td>Jumlah yang harus dibayar</td>
		<td><div id="totalkeseluruhan"></div></td>
	</tr>
</table>
<table class="custome-table" cellspacing="0" cellpaddind="0" width="100%">
	<tr>
		<th rowspan="2">NO</th>
		<th rowspan="2">JENIS PEMBAYARAN / SETORAN</th>
		<th colspan="2">JUMLAH SETORAN</th>
		<th rowspan="2">JUMLAH</th>
		<th rowspan="2">TUNGGAKAN</th>
		<th rowspan="2">TGL. SETOR</th>
		<th rowspan="2">KET</th>
	</tr>
	<tr>
		<th>1</th><th>2</th>
	</tr>
	<?php
		$ke='A'; foreach($browse_jenis as $bj){
	?>
	<tr>
		<td><b><?php echo $ke?>.</b></td>
		<td><b><?php echo $bj->jenis?></b></td>
		<td colspan="6">&nbsp;</td>
	</tr>
		<?php
			$ke = chr(ord($ke) + 1);
			$browse_nimjenis = $this->keubiaya_m->get_bynimjenis($mhs['nim'], $bj->jenis);
			$i=1; $jumlah=0; $tunggakan=0; $jumsetor1=0;$jumsetor2=0;$totjumlah=0;$jumtunggakan=0;
			foreach($browse_nimjenis as $bn){
			$no = $i++;
		?>
		<tr>
			<td align="right"><?php echo $no?>.</td>
			<td><?php echo $bn->namabiaya?><?php if($bn->jumsks){ ?><div style="float:right"><?php echo $bn->jumsks?> SKS</div><?php } ?></td>
			<td align="right"><?php $setor1 = $this->keubiaya_m->get_setoran($bn->idbiaya, 1); echo rupiah($setor1['jumsetoran'])?></td>
			<td align="right"><?php $setor2 = $this->keubiaya_m->get_setoran($bn->idbiaya, 2); echo rupiah($setor2['jumsetoran'])?></td>
			<td align="right"><?php $jumlah = $setor1['jumsetoran']+$setor2['jumsetoran']; echo rupiah($jumlah)?></td>
			<td align="right"><?php $tunggakan = $bn->jumbiaya - $jumlah; echo rupiah($tunggakan)?></td>
			<td><?php
				if(!$setor2['tglsetor']){
					echo tgl_indo($setor1['tglsetor']);
				}else{
					echo tgl_indo($setor2['tglsetor']);
				}
			?></td>
			<!--<td></?php echo $setor1['keterangan'].'<br />'.$setor2['keterangan']?></td>-->
			<td align="center"><?php echo inisial($bn->status)?></td>
		</tr>
		<?php
			$jumsetor1 = $jumsetor1+$setor1['jumsetoran'];
			$jumsetor2 = $jumsetor2+$setor2['jumsetoran'];
			$totjumlah = $totjumlah+$jumlah;
			$jumtunggakan = $jumtunggakan+$tunggakan;
			}
		?>
		<tr>
			<td>&nbsp;</td>
			<td align="center"><b>Jumlah</b></td>
			<td align="right"><?php echo rupiah($jumsetor1)?></td>
			<td align="right"><?php echo rupiah($jumsetor2)?></td>
			<td align="right"><?php echo rupiah($totjumlah)?></td>
			<td align="right"><?php echo rupiah($jumtunggakan)?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<?php } ?>
</table>
<?php
	$totalkeseluruhan = $totjumlah+$jumtunggakan;
	$mtotalkeseluruhan = rupiah($totalkeseluruhan);
?>
<script>
	$(document).ready(function(){
		var tk = "<?php echo ' : '.$mtotalkeseluruhan?>";
		document.getElementById("totalkeseluruhan").innerHTML = tk;
	});
</script>