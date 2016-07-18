<html>
<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
	<title>Cetak KRS</title>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
</head>
<body>
<div id='noprint' style="float:right;"><a href='#' id="noprint" class='print-button' onclick='print()'>cetak</a></div>
<?php
	foreach($detail_mahasiswa->result() as $dm):
	$kodeprodi = $dm->kodeprodi;
	$nim = $dm->nim;
?>
<?php
	$fak['namafakultas'] = $this->auth->get_namafakultasbykodeprodi($dm->kodeprodi);
	$this->load->view('admin/laporan/koplaporan_v', $fak);
?>
<table id="kartu_header" width="90%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="5" align="center"><div style="padding-top:5px"><b>KARTU RENCANA STUDI</b></div></td>
	</tr>
	<tr>
		<td width="100">Nama&nbsp;Mahasiswa</td><td>: <?php echo $nm_mhs = $dm->nama;?></td><td>&nbsp;</td><td width="100">Jenjang</td><td width="150">: <?php echo $dm->jenjang?></td>
	</tr>
	<tr>
		<td>No. Mahasiswa</td><td>: <?php echo $dm->nim;?></td><td>&nbsp;</td>
		<td>Semester</td><td>:
		<?php
			$sem = substr($this->session->userdata('sesi_thajaran'),4,1);
			if($sem % 2 == 0) echo 'Genap'; else echo 'Ganjil';
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
	$tglkrs = $dm->tglkrs;
	//$nama_mhs = $dm->nmmhsmsmhs;
	//$nama_dpa = $dm->nama_dpa;
	break;
	endforeach;
?>
<table id="kartu" cellpadding="0" cellspacing="0" border='0'>
	<tr>
		<th>No.</th><th>KODE MK</th><th>NAMA MATA KULIAH</th><th>SKS</th><th>UTS</th><th>UAS</th>
	</tr>
<?php
	$no = 1;
	$tot = 0;
	foreach($detail_krs_peserta->result() as $dkp):
?>
	<tr>
		<td class="numeric"><?php echo $no++.".";?></td>
		<td class="record"><?php echo $dkp->kodemk;?></td>
		<td class="record"><?php echo $dkp->nama_mk; //.$dkp->status?></td>
		<td class="numeric"><?php echo $dkp->sks?></td>
		<td class="record">&nbsp;</td><td class="record">&nbsp;</td>
	</tr>
<?php $tot = $tot+$dkp->sks; endforeach;?>
	<tr>
		<td>&nbsp;</td><td align="right" colspan="2">Total SKS</td>
		<td class="numeric"><?php echo $tot;?></td><td colspan="2">&nbsp;</td>
	</tr>
</table>
<table width="98%" id="kartu_header">
	<tr>
		<td width="350" style='vertical-align:top'>
			<center><br />
				Dosen Pembimbing Akademik<br /><br /><br /><br />
				<?php
					echo '<u>'.$dpa['nama'].'</u><br />';
					echo 'NIDN.'.$dpa['nidn'];
				?>
			</center>
		</td>
		<td>&nbsp;</td>
		<td width="275" style='vertical-align:top'>
			Mataram, <?php echo tgl_indo($tglkrs,1);?>
			<center>Mahasiswa<br /><br /><br /><br />
				<?php
					echo '<u>'.$nm_mhs.'</u><br />';
					echo 'NIM.'.$nim;
				?>
			</center>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align:center">
			<br />Mengetahui,<br />Kaprodi,<br /><br /><br /><br />
			<?php
				echo '<u>'.$this->auth->get_prodi($kodeprodi)->kaprodi.'</u><br />';
				echo 'NIDN.'.$this->auth->get_prodi($kodeprodi)->nidn;
			?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			Dibuat rangkap 5 (lima) untuk :
			<ol>
				<li>Mahasiswa</li>
				<li>Dosen Pembimbing Akademik</li>
				<li>Subbag. Akademik/Fakultas</li>
				<li>Bag. Pendidikan/BAAK</li>
				<li>Bag. Keuangan/BAU</li>
			</ol>			
		</td>
	</tr>
</table>
</body>
</html>