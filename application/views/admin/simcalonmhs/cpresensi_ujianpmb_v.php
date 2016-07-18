<head>
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" />
</head>
<h2>Presensi PMB PRODI <?php echo $nama_prodi?></h2>
<div class="table">
	<table id="kartu" cellpadding="0" cellspacing="0" border='0'>
		<tr>
			<th class="first" width="5">No.</th>
			<th style="width: 50px">No. Daftar</th>
			<th>Nama Calon Mahasiswa</th>
			<th>Nama Sekolah Asal</th>
			<th colspan="2">Tanda Tangan</th>
		</tr>
<?php
	$i = 1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	$que = mysql_query($sql);
	while($bm = mysql_fetch_array($que)):
	$no = $i++;
?>
	<tr>
		<td><?php echo $no.'.';?></td>
		<td><?php echo $bm['no_daftar'];?></td>
		<td><?php echo $bm['nama'];?></td>
		<td><?php echo $bm['nama_sekolah'];?></td>
		<?php if($no % 2 != 0){ ?>
		<td style="vertical-align: top" rowspan="2"><small><?php echo $no?></small></td>
		<td style="vertical-align: top" rowspan="2"><small><?php echo $no+1?></small></td>
		<?php } ?>
	</tr>
<?php
	endwhile;
	if($no % 2 != 0){
		echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	}
?>
	</table>
	<p>Bangkalan, <?php echo tgl_indo(date('Y-m-d'),1)?><br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Pengawas</p>
	<br /><br /><br /><br />( ..................................... )
</div>