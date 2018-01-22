<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function get_bythajaran(){
			showloading();
			var selected_thajaran = $('select[name=thajaran]').val();
			load('mhs/pembayaran/change_thajaranpembayaran/'+selected_thajaran,'#center-column');
		}
	</script>
</head>
<div class="top-bar">
</div>
<div class="select-bar">
	<table width="100%">
		<tr>
			<td width='300'><h3>History Pembayaran</h3></td>
			<!--<td width="110">Tahun Akademik</td><td width="100">: </?php echo substr($thakad,0,4);?></td>-->
			<td><b>Tahun Ajaran</b></td>
			<td>
				<div style="float: right">
					<select name="thajaran" onchange="get_bythajaran()">
						<?php foreach($browse_thajar as $bt):?>
						<option <?php if($thakad == $bt->thajaran) echo 'selected'; ?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
						<?php endforeach ?>
					</select>
				</div>
				<!--</?php if(substr($thakad,4,1) == '1'){ echo "Gasal"; }else{ echo "Genap"; } ?>-->
			</td>
		</tr>
	</table>
</div>

<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Jenis Bayar </th>
			<th width="90">Jumlah Total</th>
			<th width="90">Sudah di Bayar</th>
			<th width="90">Status</th>
		</tr>
<?php
	$atrib = array(
		"width" => "635",
		"height" => "430",
		"screenx" => "320",
		"screeny" => "30"
	);
	$i = 1;
	foreach($browse_bayar as $bk):
?>
    <tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->jenis;?></td>
			<td class="first"><?php echo "<center>".$bk->jumbiaya."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->totalsetoran."</center>";?></td>
			<td class="first"><?php echo $bk->status;?></td>
<?php endforeach;?>
	</tr>
	</table>
</div>
