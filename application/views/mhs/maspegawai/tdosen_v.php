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
			<th class="last">Pilih</th>
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
			<a href="javascript:void(0)" onclick='<?php echo $pilih?>("<?php echo $bm->npp?>","<?php echo $bm->nama?>")'>
				<?php
					$arim = array('src' => 'asset/images/design/check.gif','border'=>0);
					echo img($arim);
				?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
</div>
</div>
<div class='button' style='margin:10px;'><a href='javascript:void(0)' onclick='jQuery.facebox.close()'>Tutup</a></div>
<script>
	function pilih1(npp,nama){
		$('input[name=npp1]').val(npp);
		$('input[name=pembimbing1]').val(nama);
		jQuery.facebox.close();
	}
	function pilih2(npp2,nama2){
		$('input[name=npp2]').val(npp2);
		$('input[name=pembimbing2]').val(nama2);
		jQuery.facebox.close();
	}
</script>