<div id="browse-matkul">
<div style="float:right;margin-right:27px;">
	<?php echo $this->pquery->form_remote_tag(array('url'=>site_url('admin/paket/cari'),
		'update'=>'#browse-matkul', 'name'=>'f1', 'id'=>'simprodi', 'type'=>'post')); ?>
		<label>Ketikkan Kode/Nama Matakuliah</label>
		<input type="text" name="carimk" value="<?php echo $carimk?>" />
		<input type="submit" name="cmdcari" id="cmdcari" value="Cari" onclick="carimatkul()" />
		<input type="button" value="Aneh Cari" style="display:none" id="cmddisabled" />
	</form>
</div>

<h3> &nbsp; Daftar Matakuliah</h3>
<div style="overflow:scroll; height:350px; margin:0 10px 0 10px;">
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Kode MK</th>
			<th>Nama Matakuliah</th>
			<th>Kurikulum</th>
			<th>SKS</th>
			<th style="width:20px" class="last">Pilih</th>
		</tr>
<?php
	$i = 1;
	foreach($browse_matakuliah as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->kodemk;?></td>
		<td class="first"><a href="javascript:void(0)"><?php echo $bm->namamk?></a></td>
		<td class="first"><?php echo $bm->nm_kurikulum_sp;?></td>
		<td class="first"><?php echo $bm->sks?></td>
		<td align='center'>
			<a href="javascript:void(0)" onclick='pilih("<?php echo $bm->kodemk?>","<?php echo $bm->namamk?>","<?php echo $bm->sks?>")'>
				<?php echo img('asset/images/design/check.png')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
</div>
</div>
<div style='float:right;margin:10px;'><a href='javascript:void(0)' class="button" onclick='jQuery.facebox.close()'>Tutup</a></div>
<script>
	function pilih(kodemk,namamk,sks){
		$('input[name=kodemk]').val(kodemk);
		$('input[name=namamk]').val(namamk);
		$('input[name=sks]').val(sks);
		/* $('input[name=kurikulum]').val(kurikulum); */
		jQuery.facebox.close();
	}
	function carimatkul(){
		/* alert('tes');
		$("#cmdcari").hide;
		$("#cmddisabled").show; */
	}
</script>
</div>