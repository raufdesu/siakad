<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simcalonmhs/insert_nim'), 'update'=>'#center-column', 'name'=>'f1',
	'id'=>'simcalonmhs', 'type'=>'post'));
	echo form_hidden('nodaft', $nodaft);
?>
	<p>Tentukan NIM <input type='text' id="nim" name='nim' size='8' />
	<input type="submit" value="OK" onclick='return cek()' /></p>
</form>