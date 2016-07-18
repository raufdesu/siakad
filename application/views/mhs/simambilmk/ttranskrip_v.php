<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function get_bythajaran(){
			var selected_thajaran = $('select[name=thajaran]').val();
			load('mhs/simambilmk/change_thajarantrans/'+selected_thajaran,'#center-column');
		}
	</script>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/design.css" type="text/css"/>
</head>
<?php
	$ipk = 0;
	$jums = 0;
	$jum_sks = 0;
	$jumsks = 0;
	foreach($browse_transkrip as $ip):
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
<div id='noprint' style="margin-bottom:10px; float:right;"><a href='#' id="noprint" class='print-button' onclick='print()'>cetak</a></div>
<h3>Hasil Nilai Keseluruhan</h3>
<div class="top-bar">
</div>
<div class="select-bar">
	<table width="100%">
		<tr>
			<td width="40">NIM </td><td width="330">: <?php echo $nim;?></td>
			<td><!--Semester--></td><td>
			<?php //if(substr($thakad,4,1) == '1'){ echo "Gasal"; }else{ echo "Genap"; } ?></td>
		</tr>
		<tr>
			<td width="50">Nama </td><td width="330">: <?php echo $this->session->userdata('sesi_nama_mhs');?></td>
			<td width="90">Tahun Ajaran</td>
			<td width="70">:
				<select name="thajaran" style="width:60px !important" onchange="get_bythajaran()">
					<?php foreach($browse_thajar as $bt):?>
					<option <?php if($thakad == $bt->thajaran) echo 'selected'; ?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
					<?php endforeach ?>
				</select>
			<?php
				//echo substr($thakad,0,4);
			?>
			</td>
		</tr>
	</table>
</div>
<div class="table">
	<table id="transno" class="listing form" cellpadding="0" cellspacing="0">
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
	foreach($browse_transkrip as $bk):
?>
      <tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bk->kodemk;?></td>
			<td class="first"><?php echo $bk->namamk;?></td>
			<td class="first"><?php echo "<center>".$bk->jumlahsks."</center>";?></td>
			<td class="first"><?php echo "<center>".$bk->nilaihuruf."</center>";?></td>
		</tr>
<?php $jumsks = $jumsks+$bk->jumlahsks; endforeach;?>
<?php
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
		</tr>
<?php
		$jumsks = $jumsks+$bm->sks;
	endforeach;
?>
	</table>
	<table class='total' cellspacing='0'>
		<tr>
			<td width='100'><b>Total SKS</b></td><td>: <?php echo $jumsks;?></td>
		</tr>
		<tr>
			<td><b>IP</b></td><td>:
			<?php
				if($jums){
					$ipnya = substr($jums/$jumsks,0,4);
					echo $ipnya;
				}else{
					echo '0';
				}
			?>
			</td>
		</tr>
	</table>
</div>