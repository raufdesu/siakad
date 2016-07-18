<head>
	<title>Daftar Pegawai Dan Dosen</title>
</head>
<h3> &nbsp; Daftar Data Dosen</h3>
<div style="overflow:scroll; height:300px; margin:0 10px 0 10px;">
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NPP</th>
			<th>Nama Pegawai</th>
			<th style="width:20px" class="last">Pilih</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_maspegawai as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->npp;?></td>
		<td class="first">
			<a href="javascript:void(0)">
				<?php echo $bm->nama; ?>
			</a>
		</td>
		<td align='center'>
			<a href="javascript:void(0)" onclick='pilih("<?php echo $bm->npp?>","<?php echo $bm->nama?>")'>
				<?php
					$arim = array('src' => 'asset/images/design/check.png','border'=>0);
					echo img($arim);
				?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
</div>
</div>
<div style='float:right;margin:10px;'><a href='javascript:void(0)' class="button" onclick='jQuery.facebox.close()'>Tutup</a></div>
<script>
	function pilih(npp,namadosen){
		$('input[name=npp]').val(npp);
		$('input[name=namadosen]').val(namadosen);
		jQuery.facebox.close();
	}
</script>