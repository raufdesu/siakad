<div class="table">
	<img src="<?php echo base_url();?>images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Kode</th>
			<th>Nama Matakuliah</th>
			<th>SKS</th>
			<th width="30" class="last">Del</th>
		</tr>
<?php
	$no = 1;
	$tot = 0;
	foreach($detail_krs_peserta as $dkp):
?>
		<tr>
			<td><?php echo $no++;?></td>
			<td><?php echo $dkp->kdmk;?></td>
			<td class="first"><?php echo $dkp->nama1;?></td>
			<td width="33"><?php echo $dkp->sks;?></td>
			<td><?php echo anchor("mhs/krs/hapus/".$dkp->kdkuliah."/".$dkp->nim,img('images/design/hr.gif'),"OnClick='return tanya()'");?></td>
		</tr>
<?php $tot = $tot+$dkp->sks; endforeach; ?>
	</table>
	<?php
		$atrcetak = array(
			"width" => "1050",
			"height" => "750",
			"screenx" => "100",
			"screeny" => "20"
		);
		echo anchor_popup("mhs/krs/cetak_krs","Cetak",$atrcetak);
	?>
	<div class="select">
		<font>&nbsp; &nbsp; Total SKS &nbsp; : <b><?php echo $tot;?></b> &nbsp;SKS</font>
	</div>
</div>