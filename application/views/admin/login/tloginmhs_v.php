<head>
	<script type="text/javascript">
		$(document).ready(function() {
			stoploading();
		})
	</script>
</head>
<div class="top-bar-adm">
	<div style="float:right;margin:5px -32px 0">
		<a href="javascript:void(0)" class='button' onclick='show("admin/loginmhs/input","#center-column")'>
			Tambah</a>
		<a href="javascript:void(0)" class='button' onclick='show("admin/login/browse_admin","#center-column")'>
			Akun Operator</a>
	</div>
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/login/index_browse'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label><b>Masukkan NIM </b>".form_input("txtCari",$this->session->userdata("sesi_caripassword"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","class='search'")."</label>";
	echo form_close();?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Password</th>
			<th style="width: 50px" class="last">Kelola</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_login as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->password;?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/login/edit/<?php echo $bm->nim?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->nim?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(id){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/loginmhs/delete/"+id,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>