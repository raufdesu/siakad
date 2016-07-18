<head>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
	<script>
		$(document).ready(function(){
			stoploading();
		});
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
<div id='noprint' style="float:right;margin-top:-90px;margin-bottom:5px;">
	<!--</?php echo anchor('admin/nilai/cetak_khs/xls', 'Excel', array('class'=>'button'));?>-->
	<a href='#' id="noprint" class='button' onclick='show("admin/nilai/cetak_khs", "#detail-transkrip")'>Preview</a>
</div>
<div style='clear:both'></div>
<table width="100%">
	<tr>
		<td><b>NIM</b></td><td>: <?php echo $nim?></td>
		<td width="110"><b>Prodi</b></td><td width="210">: <?php echo $this->auth->get_prodibynim($nim)->namaprodi?></td>
	</tr>
	<tr>
		<td width="60"><b>Nama</b></td><td>: <?php echo $this->auth->get_namamhsbynim($nim)?></td>
		<td><b>Thn. Ajaran</b></td><td>: <?php echo $thakad?></td>
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
	$atrib = array(
		"width" => "635",
		"height" => "430",
		"screenx" => "320",
		"screeny" => "30"
	);
	$i = 1;
	foreach($browse_khs as $bk):
		if($bk->nilaihuruf == 'A'){
			$na = 4;
		}elseif($bk->nilaihuruf == 'B'){
			$na = 3;
		}elseif($bk->nilaihuruf == 'C'){
			$na = 2;
		}elseif($bk->nilaihuruf == 'D'){
			$na = 1;
		}else{
			$na = 0;
		}
?>
      <tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kodemk;?></td>
			<td class="first"><?php echo $bk->namamk;?></td>
			<td class="first"><?php echo "<center>".$bk->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaihuruf."</center>";?></td>
			<td class="first"><?php echo "<center>".$na * $bk->jumlahsks."</center>";?></td>
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
				}else{
					echo '0';
				}
			?>
			</td>
		</tr>
	</table>	
</div>