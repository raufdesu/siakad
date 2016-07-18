<head>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
</head>
<table width="100%">
	<tr>
		<td><b>NIM</b></td><td>: <?php echo $nim?></td>
		<td width="110"><b>Prodi</b></td><td width="200">: <?php echo $this->auth->get_prefnamaprodi(substr($nim,0,2))?></td>
	</tr>
	<tr>
		<td><b>Nama</b></td><td>: <?php echo $this->auth->get_namamhsbynim($nim)?></td>
		<td><b>Thn. Ajaran</b></td><td>: <?php echo $this->auth->get_thactive()->thajaran;?></td>
	</tr>
</table>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th width="60">Kode </th>
			<th>Nama Matakuliah</th>
			<th width="40">SKS </th>
			<th width="35">Nilai</th>
			<th class="last" width="40">Skor</th>
		</tr>
<?php
	$jumtot_sks = 0;
	$i = 1;
	$jumtot_bobot = 0;
	$jumsks = 0;
	$jums = 0;
	foreach($browse_matrikulasi->result() as $bm):
		if($bm->nilai == "A"){
			$bobot = 4;
		}elseif($bm->nilai == "B"){
			$bobot = 3;
		}elseif($bm->nilai == "C"){
			$bobot = 2;
		}elseif($bm->nilai == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
		$js = $bm->sks * $bobot;
		$jums = $jums+$js;
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bm->kodemk;?></td>
			<td class="first"><?php echo $bm->nama; if($bm->status=='matrikulasi') echo '<div style="float:right;color:#ababab;"><small>matrikulasi</small></div>';?></td>
			<td class="first"><?php echo "<center>".$bm->sks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bm->nilai."</center>";?></td>
			<td class="first"><?php echo "<center>".$bobot * $bm->sks."</center>";?></td>
		</tr>
<?php
		$jumsks = $jumsks+$bm->sks;
	endforeach;
	if($jumsks){
?>
		<tr>
			<td colspan="6" class="first">
				<b>Hasil Matrikulasi - </b>
				<b>Jumlah SKS</b> : <?php echo $jumsks.' SKS,';?>
				<b>IP Semester</b> : <?php if($jumsks){ echo $ipnya = substr($jums/$jumsks,0,4).', '; } ?>
				<b>IPK</b> :
				<?php
					$jumtot_bobot = $jumtot_bobot+$jums;
					$jumtot_sks = $jumtot_sks+$jumsks;
					echo substr($jumtot_bobot/$jumtot_sks, 0,4);
				?>
			</td>
		</tr>
		<tr>
			<td colspan="6"><hr /></td>
		</tr>
<?php
	}
foreach($browse_thajaran as $bt):
	$thajaran = $bt->thajaran;
	$detail_transkrip = $this->simtranskrip_m->get_onebythajaran($nim, $thajaran);
	$i = 1;
	foreach($detail_transkrip->result() as $bk){
		if($bk->nilai == "A"){
			$bobot = 4;
		}elseif($bk->nilai == "B"){
			$bobot = 3;
		}elseif($bk->nilai == "C"){
			$bobot = 2;
		}elseif($bk->nilai == "D"){
			$bobot = 1;
		}else{
			$bobot = 0;
		}
		$js = $bk->sks * $bobot;
		$jums = $jums+$js;

		//echo $this->db->last_query();
?>
		<tr class="bg">
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kodemk;?></td>
			<td class="first"><?php echo $bk->nama; if($bk->status=='matrikulasi') echo '<div style="float:right;color:#ababab;"><small>matrikulasi</small></div>';?></td>
			<td class="first"><?php echo "<center>".$bk->sks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilai."</center>";?></td>
			<td class="first"><?php echo "<center>".$bobot * $bk->sks."</center>";?></td>
		</tr>
	<?php
		$jumsks = $jumsks+$bk->sks;
		}
		if(!$jumsks){
			echo '<tr class="bg"><td colspan="6" class="first"><h4>Data Nilai Tahun Ajaran '.$thajaran.' Masih Kosong</h4></td></tr>';
		}else{
	?>
		<tr>
			<td colspan="6" class="first">
				<b>Th. Ajaran</b> : <?php echo $thajaran.', ';?>
				<b>Jumlah SKS</b> : <?php echo $jumsks.' SKS,';?>
				<b>IP Semester</b> : <?php if($jumsks){ echo $ipnya = substr($jums/$jumsks,0,4).', '; } ?>
				<b>IPK</b> :
				<?php
					$jumtot_bobot = $jumtot_bobot+$jums;
					$jumtot_sks = $jumtot_sks+$jumsks;
					echo substr($jumtot_bobot/$jumtot_sks, 0,4);
				?>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td colspan="6"><hr /></td>
		</tr>
<?php endforeach; ?>
	</table>
</div>