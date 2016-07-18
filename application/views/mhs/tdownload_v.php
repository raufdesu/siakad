<?php
	$namafile = 'Matakuliah-Tawar-'.$tahunajaran.'-'.$semester.'.doc';
	header("Content-type: application/msword");
	header("Content-Disposition: inline; filename=".$namafile);
?>
<head>
<title>Daftar Matakuliah Yang Ditawarkan</title>
<style>
	td,th{ padding:5px; }
</style>
</head>
<h2>PRODI <?php echo $this->session->userdata('sesi_krs_prodi')?></h2>
<b>Daftar Matakuliah Yang Ditawarkan Semester <?php echo $semester ?> Tahun Ajaran <?php echo $tahunajaran?></b><hr />
<table border='1' cellpadding='0' cellspacing='0'>
	<tr>
		<th width='15'>No.</th><th width='50'>Kode MK</th><th width='300'>Nama Matakuliah Tawaran</th><th>Semester</th>
	</tr>
	<?php $i=1; foreach($browse_mktawar->result() as $bm):?>
	<tr>
		<td><?php echo $i++?></td>
		<td align='center'><?php echo $bm->kodemk?></td>
		<td><?php echo $bm->namamk?></td>
		<td align='center'><?php echo $bm->semester?></td>
	</tr>
	<?php endforeach; ?>
</table>