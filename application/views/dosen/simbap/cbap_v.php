<?php
	if($this->uri->segment(4) == 'doc'){
		$the_filename = 'Cover '.str_replace(' ','_',$this->session->userdata('sesi_namamatkul'));
		header( 'Pragma: public' );
		header( 'Content-Type: application/msword' );
		header( 'Content-Disposition: attachment; filename="' . $the_filename . '.doc"' );
	}
?>
<head>
	<title>Daftar Kehadiran Mahasiswa</title>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/report.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/noprint.css" type="text/css" media="print"/>
</head>
<div class="header-preview">
	<?php if($this->uri->segment(4) != 'doc') echo anchor('admin/simmktawar/cetak_coverpresensi/doc', 'Ekspor ke Word','class="noprint"')?>
</div>
<div class="kontiner">
<!--<img src="</?php echo base_url()?>asset/images/design/head-logo.jpg"/>-->
<center><h1 style="text-transform:uppercase; font-size:30px;">DAFTAR HADIR DOSEN<br />SEMESTER <?php echo semester($this->session->userdata('sesi_thajaran')).' ';?>
TAHUN AKADEMIK <?php echo thakademik($this->session->userdata('sesi_thajaran'))?></h1></center>
<table class="headcover-table">
	<tr>
		<td width="150">MATAKULIAH</td><td>:  <?php echo $namamk.' ('.$kelas.')';?></td>
	</tr>
	<tr>
		<td>PROGRAM STUDI</td><td>: <?php echo $namaprodi?></td>
	</tr>
	<tr>
		<td>BOBOT / SEM</td><td>:
		<?php
			echo $sks.' / '.$semester;
		?>
		</td>
	</tr>
	<tr>
		<td>DOSEN</td><td>: <?php echo $ampu->nama.' ('.$ampu->npp.')';?></td>
	</tr>
	<tr>
		<td>JUMLAH MHS</td><td>: <?php echo $this->session->userdata('sesi_jummhs')?> Mahasiswa</td>
	</tr>
</table><br />
<div class="cover-table">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th rowspan="2" width="10">PERTE MUAN</th>
			<th rowspan="2" width="130">TGL</th>
			<th rowspan="2" width="">MATERI</th>
			<th colspan="4" width="85">MHS HADIR</th>
		</tr>
		<tr>
			<th>H</th>
			<th>A</th>
			<th>I</th>
			<th>S</th>
		</tr>
		<?php
			if($namaprodi == 'Sistem Informasi' && (substr($kodematkul,3,1) == '2')){
				$n = 11;
			}elseif(substr(strrev($kodematkul),2,1) == '2'){
				$n = 11;
			}else{
				$n = 15;
			}
			// for($i=1;$i<$n;$i++):
			$i = 1;
			foreach($browse_bap->result() as $bb):
		?>
		<tr>
			<td align="center"><?php echo $i++?>.</td>
			<td><?php echo tgl_indo($bb->tglkuliah,1)?></td><td><?php echo $bb->materi?></td>
			<td align="center"><?php echo $bb->jumhadir?></td>
			<td align="center"><?php echo $bb->jumalpha?></td>
			<td align="center"><?php echo $bb->jumijin?></td>
			<td align="center"><?php echo $bb->jumsakit?></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>
</div>