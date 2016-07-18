<html>
<head>
	<title>Cetak Transkrip Nilai</title>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/report.css" type="text/css"/>
</head>
<body>
<div id='noprint' style="position:absolute;"><a href='#' class='print-button' onclick='print()'>cetak</a></div>
<div class="trans-container">
<table class="trans-header" cellpadding="0" cellspacing="0">
	<tr>
		<th width="90">
			<img src="<?php echo base_url()?>asset/images/design/logo-laporan.png" />
		</th>
		<th colspan="4">
			<p>U N I V E R S I T A S &nbsp; M U H A M M A D I Y A H &nbsp; M A T A R A M<br />
			<?php echo $this->config->item('long_level')?></p>
			<h1><?php echo $this->config->item('long_nextlevel')?></h1>
			<!--SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN ILMU KOMPUTER</p>
			<h1>EL RAHMA YOGYAKARTA</h1>-->
			<span><?php echo $this->config->item('instansi_address')?></span>
		</th>
		<th width="90"></th>
	</tr>
</table>
<?php
	foreach($detail_mahasiswa as $dm):
?>
<div class="trans-title"><u>TRANSKRIP AKADEMIK</u><br />
Nomor : <?php echo $dm->notranskrip?></div>
<table class="trans-biomhs">
	<tr>
		<td>Diberikan Kepada</td><td>: <?php echo $dm->nama;?></td>
	</tr>
	<tr>
		<td>Tempat / Tgl. Lahir</td><td>: <?php echo $dm->tempatlahir.' / '.tgl_indo($dm->tgllahir,1);?></td>
	</tr>
	<tr>
		<td>NPM</td><td>: <?php echo $dm->nim;?></td>
	</tr>
	<tr>
		<td>Program Studi</td><td>: <?php echo $dm->nama_prodi?></td>
	</tr>
	<tr>
		<td>Jenjang</td><td>: <?php if(substr($dm->nim,0,1) == '1'){ echo 'Strata 1'; }else{ echo 'Diploma 3'; }?></td>
	</tr>
	<tr>
		<td>Ijin Penyelenggaraan</td><td>: <?php echo $dm->ijin_prodi;?></td>
	</tr>
	<tr>
		<td>Status Program Studi</td><td>: <?php echo $dm->status_prodi;?></td>
	</tr>
	<tr>
		<td>No. Ijazah</td><td>: <?php echo $dm->noijazah;?></td>
	</tr>
</table>
	<?php
		if(substr($dm->nim,0,1) == '1'){
			$jud = 'Skripsi';
		}else{
			$jud = 'Tugas Akhir';
		}
		$judulskripsi = $dm->judulskripsi;
		$tglyudisium = $dm->tglyudisium;
		$tglijazah = $dm->tglijazah;
		endforeach;
	?>
<table class="trans-list" cellpadding="0" cellspacing="0" border='0'>
	<tr>
		<th>No.</th><th>NAMA MATA KULIAH</th><th>SKS</th><th>NILAI</th>
	</tr>
<?php
	$no = 1;
	$tot = 0;
	foreach($detail_simtranskrip->result() as $dkp):
?>
	<tr>
		<td class="numeric"><?php echo $no++.".";?></td>
		<td class="record"><?php echo $dkp->nama; //.$dkp->status?></td>
		<td class="numeric" align="center"><?php echo $dkp->sks?></td>
		<td class="numeric" align="center"><?php echo $dkp->nilai?></td>
	</tr>
<?php $tot = $tot+$dkp->sks; endforeach;?>
</table>
<table class="trans-list" cellpadding="0" cellspacing="0" border='0'>
	<tr>
		<th>No.</th><th>NAMA MATA KULIAH</th><th>SKS</th><th>NILAI</th>
	</tr>
<?php
	foreach($detail_simtranskrip2->result() as $dkp):
?>
	<tr>
		<td class="numeric"><?php echo $no++.".";?></td>
		<td class="record"><?php echo $dkp->nama; //.$dkp->status?></td>
		<td class="numeric" align="center"><?php echo $dkp->sks?></td>
		<td class="numeric" align="center"><?php echo $dkp->nilai?></td>
	</tr>
<?php $tot = $tot+$dkp->sks; endforeach; ?>
</table>
<table class="trans-listbottom">
	<tr>
		<td width="177">Judul <?php echo $jud?> </td><td colspan="3" valign="top" align="left"><div style="text-align:center"><?php echo $judulskripsi?></div></td>
	</tr>
	<tr>
		<td>Total SKS</td>
		<td width="200">: <?php echo $tot?></td>
		<td width="177">Predikat</td>
		<td>:
		<?php
			if($jum_ipk >= 3.5 ){
				echo 'Dengan Pujian (Cumlaude)';
			}elseif($jum_ipk > 2.75){
				echo 'Sangat Memuaskan';
			}elseif($jum_ipk <= 2.75){
				echo 'Memuaskan';
			}
		?>
		</td>
	<tr>
		<td>Indeks Prestasi Kumulatif</td><td>: <?php echo number_format($jum_ipk,2) ?></td>
		<td>Tanggal Kelulusan</td><td>: <?php echo tgl_indo($tglijazah,1)?></td>
	</tr>
</table>
<table width="90%" class="trans-ttd">
	<tr>
		<td width="285">
			Mengetahui,<br />
				Rektor<br /><br /><br /><br /><br />
				<?php
					$nama_ketua = $this->auth->namadekan()->namadekan;
					$npp_ketua = $this->auth->namadekan()->nppdekan;
					echo '<u>'.$nama_ketua.'</u><br />NPP.'.$npp_ketua;
				?>
			</center>
		</td>
		<td>&nbsp;</td>
		<td width="285" style='vertical-align:top'>
			Mataram, <?php echo tgl_indo($tglcetak, 1);?>
			<center>
				Ketua Bidang Akademik<br /><br /><br /><br /><br />
				<?php
					$nama_akad = $this->auth->namaakad()->namaakad;
					$npp_akad = $this->auth->namaakad()->nppakad;
					echo '<u>'.$nama_akad.'</u><br />NIP.'.$npp_akad;
				?>
			</center>
		</td>
	</tr>
</table>
</div>
</body>
</html>