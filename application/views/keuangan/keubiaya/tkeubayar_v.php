<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Pembayaran</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function ChangeThajaran(){
			var selected_thajaran = $('select[name=thajaran]').val();
			load('admin/keubayar/change_thajaran2/'+selected_thajaran,'#center-column');
		}
		function ChangeProdi(){
			showloading();
			var selected_prodi = $('select[name=prodi]').val();
			load('admin/keubayar/prodi/'+selected_prodi,'#center-column');
		}
		function ChangeAngkatan(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('admin/keubayar/angkatan/'+selected_angkatan,'#center-column');
		}
	</script>
</head>
<body>
<div class="top-bar-adm">
	<?php echo anchor('admin/keubayar/export2/xls', 'Ekspor ke Excel', array('class'=>'navi button'));?>
	<a href="javascript:void(0)" class='navi button print' onclick="window.print()">Print</a>
	<?php
		/* echo anchor('admin/keubayar/export/doc', 'Ekspor ke Ms-Word', array('class'=>'navi button')); */
	?>
	<h1>Pembayaran</h1>
	<div class="breadcrumbs">
	<select name='prodi' style="width:290px !important;" onchange='ChangeProdi()'>
		<option <?php if($this->session->userdata('sesi_prodikeumhs') == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($this->session->userdata('sesi_prodikeumhs') == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>

	</div>
</div>
<div class="select-bar">
	<div style="float: right">
		<b>Tahun Ajaran</b>
		<select name="thajaran" onchange="ChangeThajaran()">
		<?php foreach($browse_thajaran as $bt):?>
			<option <?php if($thajaran == $bt->thajaran) echo 'selected'; ?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
		<?php endforeach; ?>
		</select>
	</div>
	<div style="float:right">
		<b>Angkatan</b>
		<select name="angkatan" style="width:60px !important" onchange="ChangeAngkatan()">
			<option value=""></option>
		<?php foreach($browse_angkatan as $ba):?>
			<option <?php if($this->session->userdata('sesi_angkatankeumhs') == $ba->angkatan) echo 'selected'; ?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
		<?php endforeach; ?>
		</select>
	</div>
<?php
	/* echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simaktifsemester/cari'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'simaktifsemester', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_simaktifsemester"),'readonly')."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close(); */
?>
</div>
<?php foreach($browse_keubayar as $bk):?>
<table width="100%">
	<tr>
		<td>NIM</td><td style="min-width:70px;">: <?php echo $bk->nim?></td><td>Prodi</td><td>: <?php echo $this->auth->get_namaprodi($bk->kodeprodi)?></td>
	</tr>
	<tr>
		<td>Nama</td><td>: <?php echo $bk->nama?></td><td>Angkatan</td><td>: <?php echo $bk->angkatan?></td>
	</tr>
</table>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th>No</th><th>Pembayaran</th><th>Biaya</th><th>Dibayar</th><th>Kekurangan</th><th>Status</th>
	</tr>
	<?php
		$sql = "SELECT *,
				(SELECT totalbiaya FROM keujenisbayar WHERE jenisbayar = keubayar.jenisbayar AND angkatan = '".$bk->angkatan."') AS totalbiaya
				FROM keubayar WHERE nim = '".$bk->nim."' AND thajaran = '".$thajaran."'";
		$que = mysql_query($sql);
		$i = 1; $totaldibayar = 0; $ttotalbiaya = 0; $totalkurang = 0;
		while($d = mysql_fetch_array($que)):
			$sq = "SELECT * FROM keudetbayar WHERE idbayar = ".$d['idbayar'];
			$qu = mysql_query($sq);
	?>
	<tr class="bg">
		<td><?php echo $i++?></td>
		<td class="first"><?php echo $d['jenisbayar'];?></td>
		<td style="text-align:right"><?php $totalbiaya = $d['totalbiaya']; echo rupiah($totalbiaya);?></td>
		<td style="text-align:right">
			<?php
				$jumlahbayar = 0;
				while($rec = mysql_fetch_array($qu)):
					$jumbayar = $rec['jumbayar'];
					echo rupiah($jumbayar).'<br />';
					$jumlahbayar = $jumlahbayar+$jumbayar;
				endwhile;
			?>
		</td>
		<td style="text-align:right"><?php $kurang = $totalbiaya - $jumlahbayar; echo rupiah($kurang)?></td>
		<td><?php echo $d['status']?></td>
	</tr>
	<?php
		$totaldibayar = $totaldibayar+$jumlahbayar;
		$ttotalbiaya = $ttotalbiaya+$totalbiaya;
		$totalkurang = $totalkurang+$kurang;
		endwhile;
	?>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align:right"><b>Total Pembayaran</b></td>
		<td style="text-align:right"><?php echo rupiah($ttotalbiaya)?></td>
		<td style="text-align:right"><?php echo rupiah($totaldibayar)?></td>
		<td style="text-align:right"><?php echo rupiah($totalkurang)?></td>
		<td>&nbsp;</td>
	</tr>
</table><hr /><br />
<?php endforeach; ?>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</body>
</html>