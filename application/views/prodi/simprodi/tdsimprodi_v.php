<script>
	$(document).ready(function() {
		stoploading();
	})
</script>
<?php
	foreach($detail_prodi as $dm):
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="3">DETAIL DATA PRODI</th>
		</tr>
		<tr>
			<td class="first" width="160"><strong>Kode PRODI</strong></td>
			<td class="last">: <?php echo $dm->kodeprodi;?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Prodi</strong></td>
			<td class="last">: <?php echo $dm->namaprodi;?></td>
		</tr>
		<tr>
			<td class="first"><strong>Nama Kepala PRODI</strong></td>
			<td class="last">: <?php echo $this->auth->get_namauser($dm->npp);?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>NPP Kepala PRODI</strong></td>
			<td class="last">: <?php echo $dm->npp;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jenjang</strong></td>
			<td class="last">: <?php echo $dm->jenjang;?></td>
		</tr>
		<tr>
			<td class="first"><strong>Ijin</strong></td>
			<td class="last">: <?php echo $dm->ijin;?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status</strong></td>
			<td class="last">: <?php echo $dm->status;?></td>
		</tr>
		<tr>
			<td class="first"><strong>Fakultas</strong></td>
			<td class="last">: <?php echo $this->simfakultas_m->get_namabykode($dm->kodefakultas);?></td>
		</tr>
	</table>
<?php endforeach;?>
<div align="right"><hr />
	<a href="javascript:void(0)" onclick='show("prodi/simprodi/edit","#center-column")'>Edit &raquo;</a>
</div>
</div>
