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
		<td width="170">MATAKULIAH</td><td>:  <?php echo $this->session->userdata('sesi_namamatkul').' ('.$ampu->kelas.')';?></td>
	</tr>
	<tr>
		<td width="170">KODE MATKUL</td><td>:  <?php echo $kodematkul;?></td>
	</tr>
	<tr>
		<td>PROGRAM STUDI</td><td>: <?php echo $namaprodi?></td>
	</tr>
	<tr>
		<td>RUANG</td><td>: <?php echo $ruang?></td>
	</tr>
	<tr>
		<td>HARI</td><td>: <?php echo $hari;?>
			<?php
				if($jamawal <> '00:00:00'){
					echo ', Pukul: '.$jamawal.' - '.$jamselesai;
				}
			?>
			</td>
	</tr>
	<tr>
		<td>BOBOT / SEM</td><td>:
		<?php
			echo $sks.' / '.$semester;
		?>
		</td>
	</tr>
	<tr>
		<td>DOSEN</td><td>: <?php echo $this->session->userdata('sesi_namadosen')?></td>
	</tr>
	<tr>
		<td>JUMLAH MHS</td><td>: <?php echo $this->session->userdata('sesi_jummhs')?> Mahasiswa</td>
	</tr>
</table><br />
<div class="cover-table">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="10">PERTE MUAN</th>
			<th width="65">TGL</th>
			<th width="">MATERI</th>
			<th width="10">MHS HADIR</th>
			<th width="65">TANDA TANGAN</th>
		</tr>
		<?php
			if($namaprodi == 'Sistem Informasi' && (substr($kodematkul,3,1) == '2')){
				$n = 11;
			}elseif(substr(strrev($kodematkul),2,1) == '2'){
				$n = 11;
			}else{
				$n = 15;
			}
			for($i=1;$i<$n;$i++):
		?>
		<tr>
			<td align="center"><?php echo $i?>.</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		</tr>
		<?php endfor ?>
	</table>
</div>
</div>