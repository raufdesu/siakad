<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function get_bythajaran(){
			showloading();
			var selected_thajaran = $('select[name=thajaran]').val();
			load('mhs/simambilmk/change_thajarankhs/'+selected_thajaran,'#center-column');
		}
	</script>
</head>
<?php
	$ipk = 0;
	$jums = 0;
	$jum_sks = 0;
	$jumsks = 0;
	foreach($browse_khs as $ip):
		if($ip->nilaihuruf == "A"){
			$bobot = 4;
		}elseif($ip->nilaihuruf == "B"){
			$bobot = 3;
		}elseif($ip->nilaihuruf == "C"){
			$bobot = 2;
		}elseif($ip->nilaihuruf == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
		$js = $ip->jumlahsks * $bobot."<br />";
		$jums = $jums+$js;
	endforeach;
	
	//$ipk = $jums/$jum_sks;
	//echo substr($ipk,0,4);
	/*if(strlen($ipk) >= 5){
		$ipk = substr($ipk, 0, 4);
	} */
?>
<div class="top-bar">
</div>
<div id="noprint" style="margin-bottom:10px;float:right;">
	<!--<a href='javascript:void(0)' style="float:left;margin-top:-4px;border:1px solid #e8e8e8;padding:4px;" class='button' onclick='load_into_box("mhs/simambilmk/detailkhs")'>Detail Nilai</a>-->
	<a href='javascript:void(0)' class='print-button' onclick='show("mhs/simambilmk/cetak_khs", "#center-column")'>Preview KHS</a>
</div>
<div class="select-bar">
	<table width="100%">
		<tr>
			<td width='300'><h3>Kartu Hasil Studi</h3></td>
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
<?php
	if(!$cek_khs){
		echo "<center><b>Konfirmasi</b>, Anda belum memiliki KHS pada tahun ajaran ini</center>";
	}else{
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th width="60">Kode </th>
			<th>Nama Matakuliah</th>
			<th width="20">SKS </th>
			<th class="last" width="35">Nilai </th>
		</tr>
<?php
	$atrib = array(
		"width" => "635",
		"height" => "430",
		"screenx" => "320",
		"screeny" => "30"
	);
	$i = 1;
	foreach($browse_khs as $bk):
?>
      <tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kodemk;?></td>
			<td class="first"><?php echo $bk->namamk;?></td>
			<td class="first"><?php echo "<center>".$bk->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaihuruf."</center>";?></td>
		</tr>
<?php $jumsks = $jumsks+$bk->jumlahsks; endforeach;?>
	</table>
	<table class='total' cellspacing='0'>
		<tr>
			<td width='100'><b>Total SKS</b></td><td>: <?php echo $jumsks;?></td>
		</tr>
		<tr>
			<td><b>IP</b></td><td>:
			<?php
				if($jums){
					echo $ipnya = substr($jums/$jumsks,0,4);
				}
				//echo //number_format($ipnya);
			?>
			</td>
		</tr>
	</table>	
</div>
<?php } ?>