<head>
	<title>Daftar Data Ruangan</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){ showloading(); this.form.submit(); }
	</script>
</head>
<div class="top-bar-adm">
	<?php if($this->session->userdata('sesi_status') == 'admin'): ?>
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/simruang/add","#center-column")'> Tambah</a>
	<?php endif ?>
	<h1>Data Ruangan</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Nama Ruangan</th>
			<th>Lantai</th>
			<th>Nomor</th>
			<th>Kapasitas</th>
			<th>Jenis Ruangan</th>
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th class="last">Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_simruang as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->lantai;?></td>
		<td class="first"><?php echo $bm->nomor; ?></td>
		<td class="first"><?php echo $bm->kapasitas;?></td>
		<td class="first"><?php echo $bm->jenisruang;?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/simruang/edit/<?php echo $bm->id_ruang?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->id_ruang?>)'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
		<?php endif ?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging).'</div><div class="total-rows"> Total : '.$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(koderuang){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simruang/delete/"+koderuang,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>