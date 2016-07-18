<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function get_bythajaran(){
			var selected_thajaran = $('select[name=thajaran]').val();
			load('dosen/simambilmk/change_thajarankhs/'+selected_thajaran,'#center-column');
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
<?php echo '<div id="noprint" style="margin-bottom:10px;float:right;">'.anchor('dosen/simambilmk/cetak_khs', 'cetak', array('class'=>'print-button','target'=>'_blank')).'</div>'?>
<br />
<div class="select-bar">
	<table width="100%">
		<tr>
			<td width="100">Nama&nbsp;Mahasiswa</td><td>: <?php echo $this->auth->get_namamhsbynim($this->session->userdata('sesi_nimmhs'));?></td><td>&nbsp;</td>
			<td width="100">Jenjang</td><td width="150">:
				<?php echo $this->auth->get_prodibynim($this->session->userdata('sesi_nimmhs'))->jenjang?>
			</td>
		</tr>
		<tr>
			<td>NIM</td><td>: <?php echo $this->session->userdata('sesi_nimmhs');?></td><td>&nbsp;</td>
			<td>Semester</td><td>:
			<?php
				$sem = substr($thakad,4,1);
				if($sem % 2 == 0) echo 'Genap'; else echo 'Gasal';
			?>
			</td>
		</tr>
		<tr>
			<td>Program Studi</td><td>:
			<?php echo $this->auth->get_prodibynim($this->session->userdata('sesi_nimmhs'))->namaprodi;?></td><td>&nbsp;</td><td>Tahun Ajaran</td>
			<td>:
				<select name="thajaran" style="width:70px" onchange="get_bythajaran()">
					<?php foreach($browse_thajar as $bt):?>
					<option <?php if($thakad == $bt->thajaran) echo 'selected'; ?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
					<?php endforeach ?>
				</select>
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
				echo $ipnya = substr($jums/$jumsks,0,4);
				//echo //number_format($ipnya);
			?>
			</td>
		</tr>
	</table>	
</div>
<?php } ?>