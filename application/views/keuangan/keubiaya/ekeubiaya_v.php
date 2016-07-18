<head>
	<script>
		$(document).ready(function(){ stoploading(); });
	</script>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('keuangan/keubiaya/simpan_biaya'),
	'update'=>'#form-pembayaran',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
?>
<div style="margin-right:3px;margin-top:-120px;float:right;">
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/add/", "#form-pembayaran")' class="button">Form Pembayaran</a>
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/atur_bynim/<?php echo $nim?>", "#form-pembayaran")' class="button">Back</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM PENENTUAN BIAYA
			</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Biaya</strong></td>
			<td class="last">
				<input type="text" readonly value="<?php echo $biaya->namabiaya?>" name="namabiaya" size="50" />
				<input type="hidden" value="<?php echo $biaya->idbiaya?>" name="idbiaya" />
				<input type="hidden" value="<?php echo $nim?>" name="nim" />
				<?php echo form_error('namabiaya');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Jenis</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $biaya->jenis?>" name="jenis" size="30" />
				<?php echo form_error('jenis');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Besar Biaya</strong></td>
			<td class="last">
				Rp. <input style="text-align:right" type="text" value="<?php echo $biaya->jumbiaya?>" name="jumbiaya" size="10" />,00 &nbsp;
				<a href="javascript:void(0)" title="Untuk perubahan jumlah SKS" onclick='load_into_box("keuangan/keubiaya/biayasks/<?php echo $biaya->idbiaya?>")'>
					<img src="<?php echo base_url()?>asset/images/design/edit-icon.gif" style="margin-top:3px;position:absolute;" />
				</a>
				<?php echo "&nbsp; &nbsp; &nbsp;".form_error('jumbiaya');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Keterangan</strong></td>
			<td class="last">
				<textarea rows="1" cols="50" name="keterangan"><?php echo $biaya->keterangan?></textarea>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Dispensasi</strong></td>
			<td class="last">
				<input name="dispensasi" type="radio" <?php if($biaya->dispensasi == 'Tidak') echo 'checked'?> value="Tidak" /> Tidak &nbsp; 
				<input name="dispensasi" type="radio" <?php if($biaya->dispensasi == 'Ya') echo 'checked'?> value="Ya" /> Ya
				<?php echo form_error('dispensasi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Status</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $biaya->status?>" readonly name="status" size="11" />
				<?php echo form_error('jumbiaya');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Update','OnClick="setujui()"');?>
				<input type="reset" value="Reset" />
				<!--<a href="javascript:void(0)" onclick='show("keuangan/simprodi","#center-column")'>
					<< Batal
				</a>-->
			</td>
		</tr>
	</table>
	<center><?php echo form_error('petugas');?></center>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
	}
</script>