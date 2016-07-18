<?php
	$namafile = str_replace(' ','-',$title).".xls";
	header("Content-type: application/ms-excel");
	header("Content-disposition: attachment; filename=".$namafile);
?>
<head>
	<title>Daftar Mahasiswa</title>
	<style>
		.listing td{
			padding:2px 8px 2px 8px;
		}
		.listing th{
			padding:2px 8px 2px 8px;
			font-weight:bold;
		}
	</style>
</head>
<body>
	<b><?php echo $title?></b>
	<?php
		if($this->session->userdata('sesi_angkatanmhs')){
			echo 'Angkatan '.$this->session->userdata('sesi_angkatanmhs');
		}
		if($this->session->userdata('sesi_shiftmhs')){
			if($this->session->userdata('sesi_shiftmhs') == 2){
				$kelas = 'Malam';
			}else{
				$kelas = 'Siang';
			}
			echo ' Kelas '.$kelas;
		}
		if($this->session->userdata('sesi_statusakademik')){
			echo ' Yang '.$this->session->userdata('sesi_statusakademik');
		}
	?>
	<table class="listing" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="40">No.</th>
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th>PRODI</th>
			<th>Angkatan</th>
			<th>Status Masuk</th>
			<th>Tgl. Masuk</th>
			<th>Agama</th>
			<th>Tempat / Tgl. Lahir</th>
			<th>Jenis Kelamin</th>
			<th>Status Akademik</th>
			<th>SMA Asal</th>
			<th>Alamat SMA</th>
			<th>Jurusan SMA</th>
			<th>Th. Lulus</th>
			<th>Nama Orangtua</th>
			<th>Pekerjaan Orangtua</th>
			<th>Kabupaten</th>
		</tr>
<?php
	$i = 1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_masmahasiswa as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->nama_prodi;?></td>
		<td class="first"><?php echo $bm->angkatan;?></td>
		<td class="first"><?php echo $bm->statusmasuk;?></td>
		<td class="first"><?php echo tgl_indo($bm->tglmasuk);?></td>
		<td class="first"><?php echo $bm->agama;?></td>
		<td class="first"><?php echo $bm->tempatlahir.'/'.tgl_indo($bm->tgllahir);?></td>
		<td class="first"><?php
			if($bm->jeniskelamin == '1')
				echo 'Laki-laki';
			else
				echo 'Perempuan';
		?></td>
		<td class="first"><?php echo $bm->statusakademik;?></td>
		<td class="first"><?php echo $bm->asalsma;?></td>
		<td class="first"><?php echo $bm->alamatsma;?></td>
		<td class="first"><?php echo $bm->jurusansma;?></td>
		<td class="first"><?php echo $bm->thlulus;?></td>
		<td class="first"><?php echo $bm->namaortu;?></td>
		<td class="first"><?php echo $bm->kerjaortu;?></td>
		<td class="first">&nbsp;</td>
	</tr>
<?php endforeach;?>
	</table>
</body>