<div class="top-bar">
</div><br />
<div class="select-bar">
<h3>Hasil Nilai Keseluruhan</h3>
</div>
<div class="table">
	<img src="<?php echo base_url();?>images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th width="60">Kode </th>
			<th>Nama Matakuliah</th>
			<th width="20">SKS</th>
			<th class="last" width="35">Nilai</th>
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
		if($bk->nilaimhs == "A"){
			$bobot = 4;
		}elseif($bk->nilaimhs == "B"){
			$bobot = 3;
		}elseif($bk->nilaimhs == "C"){
			$bobot = 2;
		}elseif($bk->nilaimhs == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
		$js = $bk->jumlahsks * $bobot."<br />";
		$jums = $jums+$js;
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kdmk;?></td>
			<td class="first"><?php echo $bk->namamk;?></td>
			<td class="first"><?php echo "<center>".$bk->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaimhs."</center>";?></td>
		</tr>
<?php
	$jumsks = $jumsks+$bk->jumlahsks;
	endforeach;
?>
	</table>
	<table class='total' cellspacing='0'>
		<tr>
			<td width='100'><b>Total SKS</b></td><td>:<?php echo $jumsks;?></td>
		</tr>
		<tr>
			<td><b>IPK</b></td><td>:
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