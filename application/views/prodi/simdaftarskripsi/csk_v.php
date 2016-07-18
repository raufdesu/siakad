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
			<?php echo strtoupper("SURAT KEPUTUSAN KETUA PROGRAM STUDI ".$prodi->namaprodi."<br />".$this->config->item('instansi_name'))?><br />
			Nomor : <?php echo $daftar->nosk?><br />
			<p>TENTANG :<br />
			PEMBIMBINGAN <?php echo strtoupper($daftar->jenisdaftar)?></p>
		</th>
	</tr>
	<tr>
		<td>
			Ketua Program Studi <?php echo $prodi->namaprodi?> <?php echo $this->config->item('instansi_name')?>, setelah;
			<table width="100%">
				<tr>
					<td style="width:100px">Menimbang</td>
					<td style="width:2px;">:</td><td>Bahwa untuk kelancaran pelaksanaan <?php echo $daftar->jenisdaftar?> perlu adanya surat tugas
						pembimbingan.
					</td>
				</tr>
				<tr>
					<td>Mengingat</td><td>:</td>
					<td>
						<ol>
							<li>Kurikulum <?php echo $this->config->item('instansi_nick')?>.</li>
							<li>Peraturan pelaksanaan kegiatan akademik khususnya mengenai <?php echo $daftar->jenisdaftar?>.</li>
							<li>Peraturan-peraturan yang berlaku.</li>
						</ol>
					</td>
				</tr>
				<tr>
					<td>Memperhatikan</td><td>:</td>
					<td>Hasil pertemuan pimpinan <?php echo $this->config->item('instansi_nick')?>.</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="text-align:center !important"><h3>MEMUTUSKAN</h3></td>
	</tr>
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td style="width:100px">Menetapkan</td>
					<td style="width:2px;">:</td>
					<td>
						<ol>
							<li>
								Surat tugas menjadi dosen pembimbing <?php echo $daftar->jenisdaftar?> kepada :<br />
								Nama : <?php echo $daftar->namadosen1?><br />
								Jabatan Akademik : <?php echo $daftar->jabatanakademik?>
							</li>
							<li>
								Untuk mahasiswa :<br />
								Nama : <?php echo $this->auth->get_namamhsbynim($daftar->nim)?><br />
								NIM : <?php echo $daftar->nim?>
							</li>
						</ol>
						Surat keputusan ini mulai berlaku sejak tanggal ditetapkan, disampaikan kepada yang bersangkutan
						untuk diketahui dan dilaksanakan sebagaimana mestinya dengan ketentuan akan ditinjau kembali
						apabila dipandang perlu.
					<td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<div class="box-right" style="text-align:center">
			Ditetapkan di <?php echo $this->config->item('instansi_city')?><br />
			Tanggal <?php echo tgl_indo($daftar->tglsk, 1)?> <br />
			<?php echo $prodi->namaprodi?><br />
			Ketua<br /><br /><br />
			<?php echo $prodi->kaprodi?>
			</div><div style="clear:both"></div>
			Tembusan :<br />
			1. Ketua<br />
			2. Puket I<br />
			3. Arsip<br />
		</td>
	</tr>
</table>
</body>
</html>