<fieldset class="area" style="margin:10px 5px 5px 5px;">
<legend>Cetak Transkrip Mahasiswa<br />Dengan NIM : <?php echo $nim?></legend>
	<?php echo form_open('admin/simtranskrip/cetak', array('target'=>'_blank')); ?>
		<b>Tanggal Cetak </b> <input type="text" value="<?php echo date('d-m-Y')?>" size="9" name="tglcetak" />
		<input type="submit" value="Preview Transkrip" />
		<!--echo anchor('admin/simtranskrip/cetak','cetak',
			array('target'=>'_blank','class'=>'button','style'=>'right','onclick'=>'jQuery.facebox.close();'));
		-->
	<?php echo form_close(); ?>
</fieldset>
<div style="float:right;margin:10px;">
	<a href="javascript:void(0)" onclick='load_into_box("admin/simdetailyudisium/pracetak/edit")'>Edit</a>
	<a href='javascript:void(0)' class='button' onclick='jQuery.facebox.close();'>Tutup</a>
</div>