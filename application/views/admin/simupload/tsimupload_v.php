<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/simupload/input","#center-column")'>Tambah</a>
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simupload'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_simupload"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","class='search'")."</label>";
	echo form_close();?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Nama File</th>
			<th>Untuk</th>
			<th>Tgl. Upload</th>
			<th>Hits</th>
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th class="last">Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_upload as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->namaupload;?></td>
		<td class="first"><?php echo $bm->untuk;?></td>
		<td class="first"><?php echo tgl_indo($bm->tglupload,1);?></td>
		<td><?php echo $bm->hits;?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/maskegiatan/edit/<?php echo $bm->idsimupload?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->idsimupload ?>)'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
		<?php endif?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(id){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simupload/delete/"+id,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
