<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	});
</script>
<div class="top-bar-adm">
	<h1>Daftar Panduan-panduan</h1>
	<div class="breadcrumbs"><a href="#">Tempat download panduan-panduan untuk dosen</a></div>
</div>
<div class="table">
<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first" width="5">No.</th>
		<th>Nama File</th>
		<th>Keterangan</th>
		<th style="width:80px;" class="last">Download</th>
	</tr>
	<?php $i=1; foreach($browse_upload as $bm){ ?>
	<tr>
		<td class="first"><?php echo $i++?></td>
		<td class="first"><?php echo $bm->namaupload?></td>
		<td class="first"><?php echo $bm->keterangan?></td>
		<td>
			<a href="<?php echo base_url()?>asset/upload/<?php echo $bm->file?>">
				<?php echo img('asset/images/design/download.png')?>
			</a>
		</td>
	</tr>
	<?php } ?>
</table>