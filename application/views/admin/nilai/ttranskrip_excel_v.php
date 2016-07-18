<?php
	$namafile = 'Nilai-Keseluruhan-'.$nim.'.xls';
	header("Content-type: application/excel");
	header("Content-disposition: attachment; filename=".$namafile);
?>
<h3>Hasil Nilai Keseluruhan</h3>
<table>
	<tr>
		<td>NIM</td><td>: <?php echo $nim?></td>
	</tr>
	<!--<tr>
		<td>Nama</td><td>: </?php echo $nim?></td>
	</tr>-->
</table>
<div class="table">
	<table class="listing form" border="1" cellpadding="0" cellspacing="0">
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
	$jumsks = 0;
	$ip = 0;
	$jums = 0;
	foreach($browse_transkrip as $bk):
		if($bk->nilaihuruf == "A"){
			$bobot = 4;
		}elseif($bk->nilaihuruf == "B"){
			$bobot = 3;
		}elseif($bk->nilaihuruf == "C"){
			$bobot = 2;
		}elseif($bk->nilaihuruf == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
		$js = $bk->jumlahsks * $bobot."<br />";
		$jums = $jums+$js;
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kodemk;?></td>
			<td class="first"><?php echo $bk->namamk;?></td>
			<td class="first"><?php echo "<center>".$bk->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaihuruf."</center>";?></td>
		</tr>
<?php
	$jumsks = $jumsks+$bk->jumlahsks;
	endforeach;
	foreach($browse_matrikulasi as $bm):
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bm->kodemk;?></td>
			<td class="first"><?php echo $bm->namamk;?></td>
			<td class="first"><?php echo "<center>".$bm->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bm->nilaihuruf."</center>";?></td>
		</tr>
<?php
		if($bm->nilaihuruf == "A"){
			$bobot = 4;
		}elseif($bm->nilaihuruf == "B"){
			$bobot = 3;
		}elseif($bm->nilaihuruf == "C"){
			$bobot = 2;
		}elseif($bm->nilaihuruf == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
		
	$js = $bm->jumlahsks * $bobot;
	$jums = $jums+$js;
	$jumsks = $jumsks+$bm->jumlahsks;
	endforeach;
?>
		<tr>
			<td colspan="3">Total SKS</td><td colspan="2"><?php echo $jumsks?></td>
		</tr>
		<tr>
			<td colspan="3"><b>IPK</b></td><td colspan="2">
				<?php
					$ipk = $jums/$jumsks;
					if(strlen($ipk) > 2){
						echo substr($ipk,0,4);
					}else{
						echo $ipk;
					}
					//echo $jums/$jumsks;
				?>
			</td>
		</tr>
	</table>
</div>