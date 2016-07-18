<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function get_bythajaran(){
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
<div style="margin:10px">
<div class="top-bar">
</div>
<div style="margin-bottom:10px;float:right;">
<a href="javascript:void(0)" onclick="jQuery.facebox.close();"><b>X</b></a>
</div>
<div class="select-bar">
	<table width="100%">
		<tr>
			<td width='300'><h3>Detail Nilai<br />Tahun Ajaran <?php echo $thakad?></h3></td>
			<td>&nbsp;</td>
			<td>
				<div style="float: right"></div>
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
			<th width="35">Q 1</th>
			<th width="35">Q 2</th>
			<th width="35">T 1</th>
			<th width="35">T 2</th>
			<th width="35">UTS</th>
			<th width="35">UAS</th>
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
			<td class="first"><?php echo "<center>".$bk->quiz1."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->quiz2."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->tugas1."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->tugas2."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaiuts."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaiuas."</center>";?></td>
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
</div>