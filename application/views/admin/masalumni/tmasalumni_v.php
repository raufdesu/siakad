<head>
	<title>Daftar Alumni</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function submitChangeStatus(){
			showloading()
			var selected_status = $('select[name=statusakademik]').val();
			load('admin/masalumni/status/'+selected_status,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<h1>Data Alumni</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/masalumni/index'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'masalumni', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_masalumni"),'size=30')."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();
?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NIM (Ketika Kuliah)</th>
			<th>Nama Alumni</th>
			<th>Email</th>
			<th>Angkatan</th>
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th class="last">Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_masalumni as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/masalumni/detail/<?php echo $bm->nim?>","#center-column")'>
				<?php echo $bm->nama; ?>
			</a>
		</td>
		<td class="first"><?php echo $bm->email;?></td>
		<td class="first"><?php echo $bm->angkatan;?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/masalumni/edit/<?php echo $bm->nim?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->nim?>)'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
		<?php endif ?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(nim){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/masalumni/delete/"+nim,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
