<style>
	.daft td{
		border-bottom:1px solid #efefef;
		padding:2px 10px 2px 10px;
	}
</style>
<script>
	function tanya_penghapusan(id){
		if(confirm('Tekan OK Untuk Penghapusan Biaya')){
			load_no_loading("admin/simcalonmhs/hapus_biayadaftar/"+id, "#hasil")
			return true;
		}else{
			return false;
		}
	}
</script>
<?php if($biaya_daftar->num_rows){ ?>
<table style="width:500px" class="daft">
	<tr>
		<th>No.</th><th>Nama biaya</th><th width="120">Besar biaya</th><th width="10">hapus</th>
	</tr>
	<?php
		$i=1;
		$biaya = 0;
		foreach($biaya_daftar->result() as $bt):
		$biaya = $biaya+$bt->besarbiaya;
	?>
	<tr>
		<td><?php echo $i++?></td>
		<td><?php echo $bt->namabiaya?></td>
		<td align="right"><?php echo rupiah($bt->besarbiaya)?></td>
		<td align="center"><a onclick='return tanya_penghapusan("<?php echo $bt->idpendaftaran?>")' href="javascript:void(0)">X</a></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan="3" align="right"><b>Total biaya : </b><?php echo rupiah($biaya)?></td><td>&nbsp;</td>
	</tr>
</table>
<a href="javascript:void(0)" style="float:right;margin-top:-25px;margin-bottom:5px;" class="button" onclick='load_into_box("admin/simcalonmhs/set_nim/<?php echo $this->session->userdata('sesi_nodaft').'/'.$this->session->userdata('sesi_nimdaftar')?>")'>Bayar SPP</a>
<?php } ?>
<script>
	function selesai(){
		load_no_loading("admin/simcalonmhs/pembayaran", "#center-column")
		jQuery.facebox.close();
	}
</script>