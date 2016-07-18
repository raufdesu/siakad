<div class="top-bar-adm">
	<a href="javascript:void(0)" style="margin-right:-32px" class='navi add' onclick='show("prodi/simdaftarskripsi/add_sk","#center-column")'>Tambah</a>
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">KP-TA-SKRIPSI</a></div>
</div><br />
<div class="select-bar">
<?php
	/*echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simdaftarskripsi/index'), 'update'=>'#center-column', 'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_simdaftarskripsi"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","class='search'")."</label>";
	echo form_close(); */?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>No. SK</th>
			<th>Jenis Pendaftaran</th>
			<th>Tgl. Pendaftaran</th>
			<th>Tgl. Berakhir</th>
			<th class="last">Kelola</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_sk as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nosk;?></td>
		<td class="first"><?php echo $bm->jenisdaftar;?></td>
		<td class="first"><?php echo tgl_indo($bm->tglsk);?></td>
		<td class="first"><?php echo tgl_indo($bm->tglakhir);?></td>
		<td class="first" style="width:58px;">
			<a href="javascript:void(0)" onclick='show("prodi/simdaftarskripsi/edit_sk/<?php echo force_segment($bm->nosk)?>","#center-column")' title='Rubah SK'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='show("prodi/simdaftarskripsi/detail_sk/<?php echo force_segment($bm->nosk)?>","#center-column")' title='Detail'>
				<?php echo img('asset/images/design/detail.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo force_segment($bm->nosk)?>")' title='Hapus SK'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(nosk){
		if(confirm("KONFIRMASI\nPenghapusan ini akan menghapus seluruh data pendaftaran yang bernomor SK '"+nosk+"' Tekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("prodi/simdaftarskripsi/delete_sk/"+nosk,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
