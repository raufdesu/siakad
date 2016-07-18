<div class="top-bar">
</div><br />
<div class="select-bar">
	<?php
		$tot_point = 0;
		$tot_sks = 0;
		foreach($transkrip_atas as $tat):
			$tot_point = $tot_point+$tat->point."<br />";
			$tot_sks = $tot_sks+$tat->sks;
		endforeach;
		$ipk = $tot_point/$tot_sks;
	?>

	<table border="0" width="100%">
		<tr>
			<td width="110">Total SKS</td><td width="100">: <?php echo $tot_sks;?></td>
			<td width="210">&nbsp;</td><td colspan="2" width="100"><?php echo anchor("mhs/transkrip","Transkrip per Semester");?></td>
		</tr>
		<tr>
			<td>IP Komulatif</td><td>: <?php echo substr($ipk, 0, 4);?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		</tr>
	</table>
</div>
<div class="table">
	<img src="<?php echo base_url();?>images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th width="60">Kode </th>
			<th>Nama Matakuliah</th>
			<th width="20">SKS </th>
			<th class="last" width="65">Nilai </th>
		</tr>
<?php
	$atrib = array(
		"width" => "635",
		"height" => "430",
		"screenx" => "320",
		"screeny" => "30"
	);
	$i = 1;
	$sks = 0;
	$js = 0;
	$jums = 0;
	$jumsks = 0;
	foreach($transkrip_generate as $dt):
		if($dt->nilai == "A"){
			$bobot = 4;
		}elseif($dt->nilai == "B"){
			$bobot = 3;
		}elseif($dt->nilai == "C"){
			$bobot = 2;
		}elseif($dt->nilai == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
		$js = $dt->sks * $bobot."<br />";
		$jums = $jums+$js;
		$jumsks = $jumsks+$dt->sks;
		$ip = $jums / $jumsks;
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $dt->kode_mk;?></td>
			<td class="first"><?php echo $dt->nama1;?></td>
			<td class="first"><?php echo "<center>".$dt->sks."</center>";?></td>
			<td class="first"><?php echo "<center>".$dt->nilai."</center>";?></td>
		</tr>
<?php endforeach; ?>
</table>
</div>