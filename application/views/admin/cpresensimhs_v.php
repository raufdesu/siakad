<head>
	<title>Daftar Kehadiran Mahasiswa</title>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/report.css" type="text/css" media="all"/>
	<style>
		.head-table td{
			padding-top:0px;
			padding-bottom:0px;
		}
	</style>
</head>
<center><h3><?php echo $this->config->item('instansi_name')?><br />DAFTAR KEHADIRAN MAHASISWA</h3></center>
<table class="head-table" align="center" style="padding:0px !important;">
	<tr>
		<td width="80">MATAKULIAH</td><td>:  <?php echo $this->session->userdata('sesi_namamatkul')?></td>
		<td width="80">PRODI</td><td>: <?php echo $namaprodi?></td>
		<td width="80">DOSEN</td><td>: <?php echo $this->session->userdata('sesi_namadosen')?></td>
	</tr>
	<tr>
		<td width="20">SKS / SEM</td>
		<td>:
		<?php
			echo $sks;
			echo ' / '.semester($this->session->userdata('sesi_thajaran'));
		?>
		</td>
		<td>THN. AKD</td><td>: <?php echo thakademik($this->session->userdata('sesi_thajaran'))?></td>
		<td>KELAS</td><td>:
		<?php
			if($this->session->userdata('sesi_kelas') == '2'){
				echo "MALAM";
			}else{
				echo "REGULER";
			}
		?>
		</td>
	</tr>
</table>
<div class="table">
	<table width="900" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<th rowspan="2" class="nomor">No.</th>
			<th rowspan="2">NIM</th>
			<th rowspan="2">NAMA</th>
			<th class="last" colspan="14">TANGGAL HADIR</th>
		</tr>
		<tr>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		</tr>
		<?php
			$i=1; foreach($browse_mhs->result() as $bm):
			$namamhs = $this->auth->get_namamhsbynim($bm->nim);
			if($namamhs){
		?>
		<tr>
			<td class='nomor'><?php echo $i++.'.';?></td>
			<td class='nim'><?php echo $bm->nim?></td>
			<td class='nama'><?php echo $namamhs?></td>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		</tr>
		<?php } endforeach ?>
		<tr>
			<td colspan="3">Tanda Tangan Dosen</td>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		</tr>
	</table>
	NB: Bagi mahasiswa yang belum terdaftar, dapat langsung menghubungi bagian akademik dan menuliskan dihalaman paling bawah.
</div>