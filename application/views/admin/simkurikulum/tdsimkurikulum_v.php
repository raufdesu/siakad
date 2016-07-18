<head>
<script>
	$(document).ready(function(){
		stoploading();
	})
</script>
</head>
<div class="box">
	<?php
		foreach($detail_simkurikulum as $dp):
	?>
	<div class="table">
		<table class="listing form" cellpadding="0" cellspacing="0">
			<tr>
				<th class="full" colspan="2">DETAIL DATA MATAKULIAH</th>
			</tr>
			<tr class="bg">
				<td class="first"><strong>Kode Matakuliah</strong></td>
				<td class="last">: <?php echo $dp->kodemk;?></td>
			</tr>
			<tr>
				<td class="first"><strong>Nama Matakuliah</strong></td>
				<td class="last">: <?php echo $dp->namamk;?></td>
			</tr>
			<tr class="bg">
				<td class="first"><strong>PRODI</strong></td>
				<td class="last">: <?php echo $dp->namaprodi;?>
				</td>
			</tr>
			<tr>
				<td class="first"><strong>SKS</strong></td>
				<td class="last">: <?php echo $dp->sks;?>
				</td>
			</tr>
			<tr class="bg">
				<td class="first"><strong>Teori/Praktek</strong></td>
				<td class="last">: <?php echo $dp->teori_praktek; ?>
				</td>
			</tr>
			<tr>
				<td class="first"><strong>Wajib/Pilihan</strong></td>
				<td class="last">: <?php echo $dp->wajib_pilihan; ?>
				</td>
			</tr>
			<tr class="bg">
				<td class="first"><strong>Semester</strong></td>
				<td class="last">: <?php echo $dp->semester;?></td>
			</tr>
			<tr>
				<td class="first"><strong>Inti</strong></td>
				<td class="last">: <?php echo $dp->inti;?></td>
			</tr>
			<tr class="bg">
				<td class="first"><strong>Sifat</strong></td>
				<td class="last">: <?php echo $dp->sifat;?></td>
			</tr>
			<tr>
				<td class="first"><strong>Pra Syarat</strong></td>
				<td class="last">: <?php echo $dp->prasyarat;?>
				</td>
			</tr>
			<tr class="bg">
				<td class="first"><strong>Tahun Kurikulum</strong></td>
				<td class="last">: <?php echo $dp->thnkur;?></td>
			</tr>
		</table>
	<?php endforeach;?>
	<div align="right" style="margin:15px 8px 5px 5px">
		<a href="javascript:void(0)" class="button" onclick='jQuery.facebox.close()'>Tutup</a>
	</div>
	</div>
</div>