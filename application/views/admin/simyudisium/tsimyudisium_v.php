<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/simyudisium/input","#center-column")'>Tambah</a>
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simyudisium/'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_noyudisium"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","class='search'")."</label>";
	echo form_close();?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Nomor Yudisium</th>
			<th>Tahun Ajaran</th>
			<th>Semester</th>
			<th>Tgl. Yudisium</th>
			<th class="last">Kelola</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_simyudisium as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->noyudisium;?></td>
		<td class="first"><?php echo thakademik($bm->thajaran); ?></td>
		<td class="first"><?php echo semester($bm->thajaran)?></td>
		<td class="first"><?php echo tgl_indo($bm->tglyudisium,1);?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/simyudisium/edit/<?php echo $bm->idyudisium?>","#center-column")'><?php echo img('asset/images/design/detail.gif')?></a>
			<a href="javascript:void(0)" onclick='show("admin/simyudisium/edit/<?php echo $bm->idyudisium?>","#center-column")'><?php echo img('asset/images/design/edit-icon.gif')?></a>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->idyudisium?>)'><?php echo img('asset/images/design/hr.gif')?></a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(id){
		if(confirm("PERINGATAN\nDengan Penghapusan No. Yudisium Ini, Data Mahasiswa Yang Diyudisium Dengan Nomor Ini, Akan Terhapus Juga.\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			return false;
			//show("admin/simyudisium/delete/"+id,"#center-column");
			//return true;
		}else{
			return false;
		}
	}
</script>
