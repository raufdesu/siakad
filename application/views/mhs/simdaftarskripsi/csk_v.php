<html>
<head>
	<title>Surat SK</title>
	<style>
		*{
			font-size:1.01em;
		}
		.table td{
			padding:5px;
			text-align:justify;
			vertical-align:top;
		}
		.box-right{
			float:right;
			margin:10px;
		}
	</style>
</head>
<body>
<table class="table">
	<tr>
		<th>
			<div style="border-bottom:3px double #ababab;font-size:18px;">
			<?php echo strtoupper("PROGRAM STUDI ".$prodi->namaprodi."<br />".$this->config->item('instansi_name'))?>
			</div>
			<u><h3>SURAT PEMBERITAHUAN PEMBIMBINGAN <?php echo strtoupper($daftar->jenisdaftar)?></h3></u>
		</th>
	</tr>
	<tr>
		<td>
			Untuk kelancaran <?php echo strtoupper($daftar->jenisdaftar)?>, Ketua Program Studi
			<?php echo $prodi->namaprodi?> <?php echo $this->config->item('instansi_name')?>, memberitahukan kepada
			<table width="100%">
				<tr>
					<td style="width:100px">NIM</td>
					<td style="width:2px;">:</td><td><?php echo $daftar->nim?></td>
				</tr>
				<tr>
					<td style="width:100px">Nama</td>
					<td style="width:2px;">:</td><td><?php echo $this->auth->get_namamhsbynim($daftar->nim)?></td>
				</tr>
				<tr>
					<td colspan="3">Sudah dapat melakukan bimbingan <?php echo $daftar->jabatanakademik?> kepada :</td>
				</tr>
				<tr>
					<td style="width:100px">NPP</td>
					<td style="width:2px;">:</td><td><?php echo $daftar->pembimbing1?></td>
				</tr>
				<tr>
					<td style="width:100px">Nama Dosen</td>
					<td style="width:2px;">:</td><td><?php echo $daftar->namadosen1?></td>
				</tr>
				<!--<tr>
					<td style="width:100px">Jabatan Akademik</td>
					<td style="width:2px;">:</td><td></?php echo $daftar->jabatanakademik?></td>
				</tr>-->
			</table>
		</td>
	</tr>
	<tr>
		<td>
			Surat pemberitahuan ini mulai berlaku sejak tanggal diberitahukan, disampaikan kepada yang bersangkutan
			untuk diketahui dan dilaksanakan sebagaimana mestinya dengan ketentuan akan ditinjau kembali
			apabila dipandang perlu.
		</td>
	</tr>
	<tr>
		<td>
			<div class="box-right" style="text-align:center">
			Yogyakarta, <?php echo tgl_indo($daftar->tglsk, 1)?><br />
			Ketua Prodi</br /><?php echo $prodi->namaprodi?><br /></b>TTD</b><br />
			<?php echo $prodi->kaprodi?>
			</div><div style="clear:both"></div>
		</td>
	</tr>
</table>
<p style="position:absolute;bottom:5px;"><b>NB : </b>Setelah mahasiswa mendapatkan surat pemberitahuan ini,
	mahasiswa dapat langsung melakukan bimbingan ke dosen pembimbing yang bersangkutan (tanpa ke Kaprodi)</p>
</body>
</html>