<html>
<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
	<title>Cetak KRS</title>
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
	$this->load->view('prodi/laporan/koplaporan_v', $fak);
?>
<div style="margin:5px;font-weight:bold;text-align:center;">KARTU HASIL STUDI</div>
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
<table id="kartu" cellpadding="0" cellspacing="0" border='0'>
	<tr>
		<th>No.</th><th>KODE MK</th><th>NAMA MATA KULIAH</th><th>NILAI</th><th>SKS</th><th>SKOR</th>
	</tr>
<?php
	$i = 1;
	$tot = 0;
	$skor = 0;
	foreach($browse_khs as $bk):
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
			$js = $bk->jumlahsks * $bobot;
			$jums = $jums+$js;
?>
	<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kodemk;?></td>
			<td class="first"><?php echo $bk->namamk;?></td>
			<td class="first"><?php echo "<center>".$bk->nilaihuruf."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$js."</center>";?></td>
	</tr>
<?php $jumsks = $jumsks+$bk->jumlahsks; $skor = $skor+$js; endforeach;?>
	<tr>
		<td>&nbsp;</td><td align="right" colspan="3">Total SKS/Skor</td>
		<td class="numeric" align='center'><?php echo $jumsks;?></td><td align="center"><?php echo $skor;?></td>
	</tr>
</table>
<table class="khs-bottom">
	<tr>
		<td>Mataram, <?php echo tgl_indo(date('Y-m-d'),1)?></td>
		<td align="right">Indeks Prestasi (IP) : </td><td><?php echo $ipnya = substr($jums/$jumsks,0,4)?></td>
	</tr>
	<tr>
		<td>Ketua Program Studi<br /></td>
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