<table cellpadding="0" cellspacing="0" width="100%" style="margin:0px 0px 5px 0px">
	<tr>
		<td class="first right" width="70"><strong>NIM</strong></td>
		<td class="last">: <?php echo $this->session->userdata('sesi_nimtranskrip')?></td>
		<td class="first right" width="118"><strong>PRODI</strong></td>
		<td class="last" width="175">: <?php echo $this->auth->get_namaprodi($this->session->userdata('sesi_prodi'))?></td>
	</tr>
	<tr class="bg">
		<td class="first right"><strong>Nama</strong></td>
		<td class="last">: <?php echo $this->auth->get_namamhsbynim($this->session->userdata('sesi_nimtranskrip'));?></td>
		<td class='right'><strong>Thn. Akademik</strong></td><td class='first'>:
			<?php echo $this->auth->get_thactive()->thajaran;?>
		</td>
	</tr>
	</tr>
</table>
<div class="table">
	<img src="<?php echo base_url();?>images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
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
		$js = $bk->jumlahsks * $bobot;
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
		<tr class="bg">
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
	</table>
	<table class='total' cellspacing='0'>
		<tr>
			<td width='100'><b>Total SKS</b></td><td>: <?php echo $jumsks;?> SKS</td>
		</tr>
		<tr>
			<td><b>IPK</b></td><td>:
			<?php
				$ipk = $jums/$jumsks;
				if($jums){
					echo round($ipk,2);
				}else{
					echo '0';
				}
			?>
			</td>
		</tr>
	</table>
</div>