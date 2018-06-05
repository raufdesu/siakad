<html>
<head>
	<title>Cetak Transkrip</title>
	<!--<link rel="stylesheet" href="</?php echo base_url();?>asset/css/design.css" type="text/css"/>-->
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
</head>
<body>
<?php if($this->uri->segment(4) != 'xls'){ ?>
<div id='noprint' style="float:right;">
	<a href='#' id="noprint" class='print-button' onclick='print()'>cetak</a>
</div>
<?php } ?>
<?php
	foreach($detail_mahasiswa->result() as $dm):
?>
<?php
	$fak['namafakultas'] = $this->auth->get_namafakultasbykodeprodi($dm->kodeprodi);
	$this->load->view('admin/laporan/koplaporan_v', $fak);
?>
<div style="margin:5px;font-weight:bold;text-align:center;">Transkrip Nilai</div>
<table id="kartu_header" cellpadding="0" cellspacing="0">
	<?php
		$ipk = 0;
		$jums = 0;
		$jum_sks = 0;
		$jumsks = 0;
		/*foreach($browse_khs as $ip):
		endforeach; */
		
		//$ipk = $jums/$jum_sks;
		//echo substr($ipk,0,4);
		/*if(strlen($ipk) >= 5){
			$ipk = substr($ipk, 0, 4);
		} */
	?>
	<tr>
		<td width="100">Nama&nbsp;Mahasiswa</td><td>: <?php echo $nm_mhs = $dm->nama;?></td><td>&nbsp;</td><td width="100">Jenjang</td><td width="150">: <?php echo $dm->jenjang?></td>
	</tr>
	<tr>
		<td>No. Mahasiswa</td><td>: <?php echo $dm->nim;?></td><td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
		<td>Semester</td><td>:
		<?php
			$sem = substr($thakad,4,1);
			if($sem % 2 == 0) echo 'Genap'; else echo 'Gasal';
		?>
		</td>
	</tr>
	<tr>
		<td>Program Studi</td><td>: <?php echo $dm->nama_prodi;?></td><td>&nbsp;</td><td>Tahun Ajaran</td>
		<td>:
			<?php
				$thajar = substr($this->session->userdata('sesi_thajaran'),0,4);
				$thajar2 = substr($this->session->userdata('sesi_thajaran'),0,4)+1;
				echo $thajar.'/'.$thajar2;
			?></td>
	</tr>
</table>
<?php
	//$nama_mhs = $dm->nmmhsmsmhs;
	//$nama_dpa = $dm->nama_dpa;
	$nim = $dm->nim;
	break;
	endforeach;
?>
<div class="table">
	<img src="<?php echo base_url();?>images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th width="60">Kode </th>
			<th>Nama Matakuliah</th>
			<th width="20">SKS </th>
			<th class="last" width="35">Nilai </th>
		</tr>
<?php
	$atrib = array(
		"width" => "635",
		"height" => "430",
		"screenx" => "320",
		"screeny" => "30"
	);
	$i = 1;
	$jumsks = 0;
	$ip = 0;
	$jums = 0;
	foreach($cetak_transkrip as $bk):
	if($kodeprodi == 70233 or $kodeprodi == 88204 or $kodeprodi == 86232){
		if($bk->nilaihuruf == "A+"){
			$bobot = 4;
		}elseif($bk->nilaihuruf == "A"){
			$bobot = 3.75;
		}elseif($bk->nilaihuruf == "A-"){
			$bobot = 3.5;
		}elseif($bk->nilaihuruf == "B+"){
			$bobot = 3.25;
		}elseif($bk->nilaihuruf == "B"){
			$bobot = 3;
		}elseif($bk->nilaihuruf == "B-"){
			$bobot = 2.75;
		}elseif($bk->nilaihuruf == "C+"){
			$bobot = 2.50;
		}elseif($bk->nilaihuruf == "C"){
			$bobot = 2.25;
		}elseif($bk->nilaihuruf == "C-"){
			$bobot = 2;
		}elseif($bk->nilaihuruf == "D"){
			$bobot = 1.75;
		}else{
			$bobot = 0;
		}
	}
	else
	{
		if($bk->nilaihuruf == "A"){
			$bobot = 4;
		}elseif($bk->nilaihuruf == "B"){
			$bobot = 3;
		}elseif($bk->nilaihuruf == "C"){
			$bobot = 2;
		}elseif($bk->nilaihuruf == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
	}
		$js = $bk->jumlahsks * $bobot;
		$jums = $jums+$js;
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kodemk;?></td>
			<td class="first"><?php echo $bk->namamk;?></td>
			<td class="first"><?php echo "<center>".$bk->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaihuruf."</center>";?></td>
		</tr>
<?php
	$jumsks = $jumsks+$bk->jumlahsks;
	endforeach;
	foreach($cetak_matrikulasi as $bm):
?>
		<tr class="bg">
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bm->kodemk;?></td>
			<td class="first"><?php echo $bm->namamk;?></td>
			<td class="first"><?php echo "<center>".$bm->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bm->nilaihuruf."</center>";?></td>
		</tr>
<?php
			if($kodeprodi == 70233 or $kodeprodi == 88204 or $kodeprodi == 86232){
		if($bm->nilaihuruf == "A+"){
			$bobot = 4;
		}elseif($bm->nilaihuruf == "A"){
			$bobot = 3.75;
		}elseif($bm->nilaihuruf == "A-"){
			$bobot = 3.5;
		}elseif($bm->nilaihuruf == "B+"){
			$bobot = 3.25;
		}elseif($bm->nilaihuruf == "B"){
			$bobot = 3;
		}elseif($bm->nilaihuruf == "B-"){
			$bobot = 2.75;
		}elseif($bm->nilaihuruf == "C+"){
			$bobot = 2.50;
		}elseif($bm->nilaihuruf == "C"){
			$bobot = 2.25;
		}elseif($bm->nilaihuruf == "C-"){
			$bobot = 2;
		}elseif($bm->nilaihuruf == "D"){
			$bobot = 1.75;
		}else{
			$bobot = 0;
		}
	}
	else
	{
		if($bm->nilaihuruf == "A"){
			$bobot = 4;
		}elseif($bm->nilaihuruf == "B"){
			$bobot = 3;
		}elseif($bm->nilaihuruf == "C"){
			$bobot = 2;
		}elseif($bm->nilaihuruf == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
	}
		
	$js = $bm->jumlahsks * $bobot;
	$jums = $jums+$js;
	$jumsks = $jumsks+$bm->jumlahsks;
	endforeach;
?>
	</table>
	<table class='total' cellspacing='0'>
		<tr>
			<td width='100'><b>Total SKS</b></td><td>: <?php echo $jumsks;?> SKS</td>
		</tr>
		<tr>
			<td><b>IPK</b></td><td>:
			<?php
				$ipk = $jums/$jumsks;
				if($jums){
					echo round($ipk,2);
				}else{
					echo '0';
				}
			?>
			</td>
		</tr>
	</table>
</div>
<table class="khs-bottom">
	<tr>
		<td>Mataram, <?php echo tgl_indo(date('Y-m-d'),1)?></td>
	</tr>
	<tr>
		<td>Ketua Program Studi<br /><br /><br /></td>
		<td align="right"><!--Indeks&nbsp;Prestasi&nbsp;Kumulatif&nbsp;(IPK)&nbsp;: --></td><td></td>
	</tr>
	<tr>
		<td><br /><?php echo '<u>'.$this->auth->get_prodibynim($nim)->kaprodi?></u><br />
			<?php echo 'NPP : '.$this->auth->get_prodibynim($nim)->nppkaprodi?>
		</td><td></td>
	</tr>
</table>
</body>
</html>