<script type="text/javascript">
	$(document).ready(function(){
		stoploading();
	});
</script>
<div style="margin-right:3px;margin-top:-120px;float:right;">
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/add_biaya/<?php echo $mhs['nim']?>", "#form-pembayaran")' class="button">Tambah</a>
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/add/", "#form-pembayaran")' class="button">Form Pembayaran</a>
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/laporan_nim/<?php echo $mhs['nim']?>", "#center-column")' class="button">Laporan</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first" style="width:30px;">NO</th>
		<th>Nama Biaya</th>
		<th>Jenis</th>
		<th>Besar Biaya</th>
		<th class="last" style="width:50px">Kelola</th>
	</tr>
	<?php
		$no=1; foreach($browse_biaya as $bj){
	?>
	<tr>
		<td><?php echo $no++?></td>
		<td class="first"><?php echo $bj->namabiaya?></td>
		<td class="first"><?php echo $bj->jenis?></td>
		<td class="right"><?php echo rupiah($bj->jumbiaya)?></td>
		<td align="center">
			<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/edit_biaya/<?php echo $bj->idbiaya.'/'.$mhs['nim']?>", "#form-pembayaran")'>
				<img src="<?php echo base_url()?>asset/images/design/edit-icon.gif" />
			</a>
			<a href="javascript:void(0)" onclick='tanya("<?php echo $bj->idbiaya?>","<?php echo $mhs['nim']?>")'>
				<img src="<?php echo base_url()?>asset/images/design/hr.gif" />
			</a>
		</td>
	</tr>
	<?php } ?>
	</table>
</div>
<script>
	function tanya(idbiaya, nim){
		if(confirm("KONFIRMASI\nJika sudah pernah dilakukan pembayaran atas nama biaya ini,\npenghapusan juga akan menghapus pembayaran yang sudah dilakukan.\nTekan OK untuk melanjutkan penghapusan data")){
			load("keuangan/keubiaya/hapus_biaya/"+idbiaya+"/"+nim, "#form-pembayaran");
			return true;
		}else{
			return false;
		}
	}
</script>