<div id="editampuan">
<style>
	.child td{
		padding:2px 5px 2px 5px;
	}
	.child{
		margin:15px;
	}
</style>
<!--<input type='hidden' name='txt_kode_mk' value='</?php echo $dosenampu->kodemk?>'>
<input type='hidden' name='txt_nama_mk' value='</?php echo $dosenampu->namamatkul?>'>-->
<!--<input type='hidden' name='txt_sks' value='</?php echo $sks?>'>-->
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('keuangan/keubiaya/update_biayasks'), 'update'=>'#form-pembayaran', 'name'=>'cari', 'id'=>'maspegawai', 'type'=>'post'));
	echo form_hidden('idbiaya', $js->idbiaya);
	echo form_hidden('nim', $js->nim);
?>
<table class="child">
	<tr>
		<td align="right"><strong>Besar Biaya</strong></td>
		<td><input type="text" name="jumbiaya" style="text-align:right" value="<?php echo $js->jumbiaya?>" size="10" /></td>
	</tr>
	<tr>
		<td align="right"><strong>Biaya Per SKS</strong></td>
		<td><input type="text" name="jumbiaya_awal" style="text-align:right" value="<?php echo $js->jumbiaya_awal?>" size="10" /></td>
	</tr>
	<tr>
		<td align="right"><strong>Jumlah</strong></td>
		<td><input type="text" name="jumsks" style="text-align:right" value="<?php echo $js->jumsks;?>" size="1" /> SKS</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type='submit' value='Update' name='tambah' OnClick='jQuery.facebox.close()'/>
			<input type='button' value='Tutup' OnClick='jQuery.facebox.close()'/>
		</td>
	</tr>
</table>
</div>