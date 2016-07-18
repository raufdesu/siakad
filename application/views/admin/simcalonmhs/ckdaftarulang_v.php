<style>
.kop-kwitansi{
	width:715px;
	padding:5px;
	border-bottom:3px double #ababab;
	height:55px;
}
.kop-kwitansi .logo img{
	width:50px; margin:3px; padding:3px;
}
.kop-kwitansi .teks{
	margin:3px; padding:10px 3px 3px 3px;
}
</style>
<?php
	foreach($biaya_spp->result() as $r):
		$spp = $r->jumbayar;
	endforeach;
?>
<div align="right">
	<a href="javascript:void(0)" class='noprint button navi' onclick='show("admin/simcalonmhs/pembayaran", "#center-column")'>Kembali</a>
	<!-- PADA BARIS DIBAWAH INI, PADA JENIS PEMBAYARAN HARUS ADA PEMBAYARAN DENGAN NAMA SPP(TIDAK BOLEH DIGANTI YANG LAIN) -->
	<?php if(!$spp > 0){ ?>
	<a href="javascript:void(0)" class='noprint button navi' onclick='load_into_box("admin/simcalonmhs/add_spp/<?php echo $nodaftar.'/'.$nim?>", "#center-column")'>Bayar SPP</a>
	<?php } ?>
	<a href="javascript:void(0)" class='noprint button navi' onclick='window.print()'>Cetak</a>
</div>
<div class="kop-kwitansi">
	<div class="logo"><img src="<?php echo base_url()?>asset/images/design/logo-laporan.png" align="left" /></div>
	<div class="teks">
		<?php echo $this->auth->get_profil()->nama?><br />
		<?php echo $this->auth->get_profil()->alamat?>
	</div>
</div>
<?php
	$que = mysql_query($sql);
	while($dm = mysql_fetch_assoc($que)):
?>
<p>Telah diterima dari calon mahasiswa</p>
<table style="clear:both;width:500px" class="daft">
	<tr class="bg">
		<td class="first"><strong>Nama Mahasiswa</strong></td>
		<td class="last">: <?php echo $dm['nama'];?></td>
	</tr>
	<tr class="bg">
		<td class="first"><strong>NIM</strong></td>
		<td class="last">: <?php echo $nim;?></td>
	</tr>
	<tr>
		<td class="first"><strong>PRODI Pilihan</strong></td>
		<td class="last">: <?php echo $this->auth->get_prodibypref($dm['pil_jurusan'])->namaprodi?></td>
	</tr>
	<tr class="bg">
		<td class="first"><strong>Gelombang</strong></td>
		<td class="last">: <?php echo $dm['gelombang'];?>
		</td>
	</tr>
	<tr>
		<td class="first"><strong>Alamat Asal</strong></td>
		<td class="last">: <?php echo $dm['alamat_rumah']; ?>
		</td>
	</tr>
	<tr>
		<td class="first"><strong>Asal SMA</strong></td>
		<td class="last">: <?php echo $dm['nama_sekolah'];?></td>
	</tr>
</table>
<?php endwhile;?>

<?php if($biaya_daftar->num_rows){ ?>
<div class="table">
<p>Untuk Pembayaran sbb: </p>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th>No.</th><th>Nama biaya</th><th width="120">Besar biaya</th>
	</tr>
	<?php
		$i=1;
		$biaya = 0;
		foreach($biaya_daftar->result() as $bt):
		$biaya = $biaya+$bt->besarbiaya;
	?>
	<tr>
		<td><?php echo $i++?></td>
		<td class="first"><?php echo $bt->namabiaya?></td>
		<td class="right"><?php echo rupiah($bt->besarbiaya)?></td>
	</tr>
	<?php endforeach; ?>
	<?php
		foreach($biaya_spp->result() as $bs):
		$biaya = $biaya+$bs->jumbayar;
	?>
	<tr class="bg">
		<td><?php echo $i++?></td>
		<td class="first">SPP</td>
		<td class="right"><?php echo rupiah($bs->jumbayar)?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan="2" class="right"><b>Total biaya : </b></td><td class="right"><?php echo rupiah($biaya)?></td>
	</tr>
</table>
<div style="float:right; width:200px;">
	<br />Bangkalan, <?php echo tgl_indo(date('Y-m-d'),1)?><br /><br /><br /><br />
	(...........................)
</div>
</div>
<?php } ?>