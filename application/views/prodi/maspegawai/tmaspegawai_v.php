<head>
	<title>Daftar Pegawai Dan Dosen</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){ showloading(); this.form.submit(); }
	</script>
</head>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi add' onclick='show("prodi/maspegawai/add","#center-column")'>
		Tambah
	</a>
	<h1>Data Pegawai Dan Dosen</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/maspegawai/index'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_maspegawai"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NPP</th>
			<th>Nama Dosen dan Pegawai</th>
			<th>Nama PRODI</th>
			<?php if($this->session->userdata('sesi_status') == 'prodi'):?>
			<th class="last">Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_maspegawai as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->npp;?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("prodi/maspegawai/detail/<?php echo $bm->npp?>","#center-column")'>
				<?php echo $bm->nama; ?>
			</a>
		</td>
		<td class="first"><?php echo $this->auth->get_namaprodi($bm->kodeprodi);?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("prodi/maspegawai/edit/<?php echo $bm->npp?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->npp?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(npp){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("prodi/maspegawai/delete/"+npp,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
