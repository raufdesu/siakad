<head>
	<title>Daftar Matakuliah dan fakultas</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){ showloading(); this.form.submit(); }
	</script>
</head>
<div class="top-bar-adm">
	<?php if($this->session->userdata('sesi_user') == 'admin'): ?>
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/simfakultas/add","#center-column")'> Tambah</a>
	<?php endif ?>
	<h1>Data Fakultas</h1>
	<div class="breadcrumbs"><a href="#">Daftar Data Fakultas</a></div>
</div><br />
<div class="select-bar">
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Kode Fakultas</th>
			<th>Nama Fakultas</th>
			<th>Nama Kepala Fakultas</th>
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th class="last">Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_simfakultas as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->kodefakultas;?></td>
		<td class="first"><?php echo $bm->namafakultas; ?></td>
		<td class="first"><?php echo $this->auth->get_namauser($bm->npp);?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/simfakultas/edit/<?php echo $bm->kodefakultas?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->kodefakultas?>")'>
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
	function tanya(kodefakultas){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simfakultas/delete/"+kodefakultas,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>