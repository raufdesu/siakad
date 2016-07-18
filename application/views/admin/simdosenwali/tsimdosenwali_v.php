<head>
	<title>Daftar Dosen Pengampu Matakuliah</title>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
</head>
<div class="top-bar-adm">
	<h1>Dosen Penasehat Akademik</h1>
	<div class="breadcrumbs"><a href="#">Daftar Dosen Pembimbing Akademik (Dosen Wali)</a></div>
</div><br />
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simdosenwali/index'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari", $this->session->userdata("cari_dosenpa"))."</label>";
	echo "<label>".form_submit("cmdCari", "Cari", "OnClick='showloading()' class='search'")."</label>";
	echo form_close();?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NPP</th>
			<th>Nama Dosen</th>
			<th>Jabatan</th>
			<th style="width:22px;" class="last">#</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_maspegawai as $bm):
	$x = $i++;
	if($x % 2 == 0){
		$bg = '';
	}else{
		$bg = 'bg';
	}
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $x.'.';?></td>
		<td class="first"><?php echo $bm->npp;?></td>
		<td class="first"><?php echo $bm->nama; ?></td>
		<td class="first"><?php echo $bm->bagian;?></td>
		<td class="last">
			<a href="javascript:void(0)" title='Detail PA' onclick='show("admin/simdosenwali/pilih_pa/<?php echo $bm->npp?>","#center-column")'>
				<?php echo img('asset/images/design/detail.gif')?>
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
			show("admin/maspegawai/delete/"+npp,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
