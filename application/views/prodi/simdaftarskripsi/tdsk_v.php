<style>
	.table td{
		padding:5px;
		text-align:justify;
		vertical-align:top;
	}
	.box-right{
		float:right;
		margin:10px;
	}
	.direset{
		margin:0px;
	}
</style>
<div id='noprint' style="margin-bottom:10px; float:right;"><a href='#' class="noprint" class='print-button' onclick='print()'>cetak</a></div>
<table>
	<tr>
		<td><img src='<?php echo base_url()?>asset/images/design/logo-laporan.png'/></td>
		<td>
			<div style="border-top:3px solid #000;border-bottom:3px solid #000;">
				<h3 class="direset"><?php echo $this->config->item('long_level')?></h3>
				<h1 class="direset"><?php echo $this->config->item('long_nextlevel')?></h1>
				<p style="font-size:10px" class="direset"><?php echo $this->config->item('instansi_address')?></p>
			</div>
		</td>
	</tr>
</table>
<table class="table">
	<tr>
		<th>
			<?php echo strtoupper("SURAT KEPUTUSAN KETUA PROGRAM STUDI ".$namaprodi."<br />".$this->config->item('instansi_name'))?><br />
			Nomor : <?php echo $daftar->nosk?><br />
			<p>TENTANG :<br />
			PEMBIMBINGAN <?php echo strtoupper($daftar->jenisdaftar)?></p>
		</th>
	</tr>
	<tr>
		<td>
			Ketua Program Studi <?php echo $namaprodi?> <?php echo $this->config->item('instansi_name')?>, setelah;
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
						1. Kurikulum <?php echo $this->config->item('instansi_nick')?>.<br />
						2. Peraturan pelaksanaan kegiatan akademik khususnya mengenai <?php echo $daftar->jenisdaftar?>.<br />
						3. Peraturan-peraturan yang berlaku.
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
						Surat tugas sebagai pembimbing <?php echo $daftar->jenisdaftar?> kepada dosen yang ditunjuk untuk 
						mahasiswa <?php echo $namaprodi?> sebagaimana terlampir.
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
			<?php echo $namaprodi?><br />
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
<div class="page-break"></div>
<b>Lampiran SK Kaprodi <?php echo inisial($prodi->kaprodi).' '.$daftar->nosk?></b>
<table class="custome" width="100%" cellspacing="0">
	<tr>
		<th>No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Dosen Pembimbing</th>
	</tr>
<?php $no=1; foreach($browse_daftar as $bd){ ?>
	<tr>
		<td><?php echo $no++; ?></td>
		<td><?php echo $bd->nim?></td>
		<td><?php echo $this->auth->get_namamhsbynim($bd->nim)?></td>
		<td><?php echo $this->auth->get_namauser($bd->pembimbing1)?></td>
	</tr>
<?php } ?>
</table>
</body>
</html>