<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/login/update_passdosen'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="full" colspan="2">FORM UBAH PASSWORD</th>
	</tr>
	<tr>
		<td class="first"><strong>NPP / Username</strong></td>
		<td class="last">
			<input type="text" name="username" value="<?php echo $username?>" size="20">
			<input type="hidden" name="idlogin" value="<?php echo $this->input->post('idlogin')?>">
			<a href="javascript:void(0)" class="small-button" onclick='load_into_box("admin/login/browse_username")'>..</a>
			<?php echo form_error('username')?>
		</td>
	</tr>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Password Baru</strong></td>
		<td class="last"><input type="password" name="passbaru" value="<?php echo $this->input->post('passbaru')?>" size="30">
			<?php echo form_error('passbaru')?>
		</td>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Ulangi Password Baru</strong></td>
		<td class="last"><input type="password" name="upassbaru" value="<?php echo $this->input->post('upassbaru')?>" size="30">
			<?php echo form_error('upassbaru')?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="last">
			<?php echo form_submit('cmdSimpan', 'Simpan Perubahan');?>
			<a href="javascript:void(0)" onclick='show("admin/login/browse_admin","#center-column")'>Batal &raquo;</a>
		</td>
	</tr>
</table>
</div>
</form>