<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	});
</script>
<div class="top-bar-adm">
	<!--<a style="float:right;margin-right:-32px;" href="javascript:void(0)" onclick='show("dosen/simbap/daftarmatkul_bydosen/","#center-column")' class="button">Cek Presensi</a>-->
	<h1>Daftar Matakuliah Ampuan</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div>
<div class="table">
<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first" width="5">No.</th>
		<th>Kode MK</th>
		<th>Nama Matakuliah</th>
		<th>SKS</th>
		<th>PRODI</th>
		<th>Kelas</th>
		<th style="width:52px;" class="last">Kelola</th>
	</tr>
<?php
	$i=1; foreach($browse_matakuliah->result() as $bm):
	$no = $i++;
	if($no % 2 == 0)
		$bg = 'bg';
	else
		$bg = '';
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $no.'.';?></td>
		<td class="first"><?php echo $bm->kodemk;?></td>
		<td class="first">
			<?php echo $bm->namamk; ?>
		</td>
		<td class="center"><?php echo $bm->sks; ?></td>
		<td class="first">
		<?php
			echo $this->auth->get_prodi($bm->kodeprodi)->namaprodi;
		?>
		</td>
		<td class="center"><?php echo $bm->kelas; ?></td>
		<td>
			<!--<a href="javascript:void(0)" onclick='show("dosen/simbap/browse/</?php echo $bm->id_kelas_dosen?>","#center-column")' title='Lihat BAP'>
				</?php echo img('asset/images/design/detail.gif')?>
			</a>-->
			<!--<a href="javascript:void(0)" onclick='show("dosen/simbap/input/</?php echo $bm->id_kelas_dosen?>","#center-column")' title='Input Materi'>
				</?php echo img('asset/images/design/detail_add.png')?>
			</a>-->
			<a href="javascript:void(0)" onclick='show("dosen/nilai/index_input/<?php echo $bm->id_kelas_dosen?>","#center-column")' title='Input Nilai Mahasiswa'>
				<?php echo img('asset/images/design/login-icon.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
</table>