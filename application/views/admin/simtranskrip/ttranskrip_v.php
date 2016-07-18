<head>
	<title>Transkrip Mahasiswa</title>
	<script>
		$(document).ready(function(){ stoploading(); });
	</script>
</head>
<div class="select-bar">
<table width="100%">
<tr>
	<td width='30'>NIM</td><td width='80'>: <?php echo $nim?></td>
	<td width="100">&nbsp;</td><td width='30'>PRODI</td><td width='80'>:
	<?php echo $prodi; ?>
	</td>
</tr>
<tr>
	<td width='30'>Nama</td><td width='80'>: <?php echo $nama?></td>
	<td width="100">&nbsp;</td><td width='30'>Kelas</td><td width='80'>: <?php echo $kelas?></td>
</tr>
</table>
</div>
<div class="table">
	<?php if($this->uri->segment(4) != 'xls'):?>
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<?php endif ?>
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" style="width:30px !important">No.</th>
			<th>Kode Matkul</th>
			<th>Nama Matakuliah</th>
			<th>SKS</th>
			<th>Nilai</th>
			<?php if($this->uri->segment(4) != 'xls'):?>
			<th class="last">#</th>
			<?php endif ?>
		</tr>
<?php
	$i = 1;
	$jumsks = 0;
	$jums = 0;
	foreach($detail_transkrip->result() as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->kodemk;?></td>
		<td class="first">
			<a href="javascript:void(0)">
				<?php echo $bm->nama; ?>
			</a>
		</td>
		<td><?php echo $bm->sks;?></td>
		<td><?php echo $bm->nilai;?></td>
		<?php if($this->uri->segment(4) != 'xls'):?>
		<td class="first">
			<!--<a href="javascript:void(0)" onclick='show("admin/maspegawai/edit/</?php echo $bm->npp?>","#center-column")'>
				</?php echo img('asset/images/design/edit-icon.gif')?>
			</a>-->
			<a href="javascript:void(0)" onclick='return tanyahapus("<?php echo $bm->kodemk?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
		<?php endif ?>
	</tr>
<?php
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
	$jumsks = $jumsks+$bm->sks;
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
				if($jums){
					$ipk = $jums/$jumsks;
				}else{
					$ipk = 0;
				}
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
<!--</?php if($this->uri->segment(4) != 'xls'):?>
<p align="right"></?php echo anchor('admin/simtranskrip/browse/xls', 'excel', array('class'=>'button')); ?></p>
</?php endif ?>-->
</div>
<script>
function tanyahapus(id){
	if(confirm('KONFIRMASI\nTekan OK untuk melanjutkan penghapusan data terpilih?')){
		show("admin/simtranskrip/delete/"+id,"#detail-mhs");
		return true;
	}else{
		return false;
	}
}
</script>