<div style="float:right;margin:5px 5px 0px 5px">
	<a href="javascript:void()" onclick="jQuery.facebox.close()"><b>X</b></a>
</div>
<?php
	echo $this->pquery->form_remote_tag(array('url'=>site_url('prodi/simdaftarskripsi/tmp_pengambil'), 'update'=>'#browse_pengambil',
	'name'=>'f1', 'id'=>'simdaftarskripsi','type'=>'post'));
?>
<div class="table" style="margin:0px 10px 10px 10px; max-height:550px; overflow:auto;">
	<h3><?php echo $title?></h3>
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th width="5">No.</th>
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th>Jenis Daftar</th>
			<th>Kelola</th>
		</tr>
<?php
	$i = 1; $no=1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	if($nosk){
	foreach($browse_simdaftarskripsi as $bm): 
?>
	<tr>
		<td class="first"><?php echo $no++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->jenisdaftar?></td>
		<td>
			<input type="checkbox" <?php if($bm->nosk) echo 'checked';?> name="nim[]" value="<?php echo $bm->nim?>"/>
		</td>
	</tr>
<?php endforeach; } // echo form_hidden('n', $no); ?>
<?php
	foreach($browse_simdaftarskripsino as $bm):
?>
	<tr>
		<td class="first"><?php echo $no++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->jenisdaftar?></td>
		<td>
			<?php echo $bm->nosk?><input type="checkbox" <?php if($bm->nosk) echo 'checked';?> name="nim[]" value="<?php echo $bm->nim?>"/>
		</td>
	</tr>
<?php endforeach; echo form_hidden('n', $no); ?>	<tr>
		<td colspan="4"></td>
		<td><input onclick="jQuery.facebox.close()" type="submit" value="OK" /></td>
	</tr>
	</table>
	<form>
</div>
<script language="javascript">
	function tanya(id){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simdaftarskripsi/delete/"+id,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
