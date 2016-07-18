<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/loginmhs/ubah'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<div class='button'>
	<a href="javascript:void(0)" onclick='show("mhs/masmahasiswa/detail","#center-column");'>Profil</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="full" colspan="2">FORM UBAH PASSWORD</th>
	</tr>
	<tr>
		<td class="first"><strong>NIM</strong></td>
		<td class="last">
			<input type="text" name="username" value="<?php echo $this->session->userdata('sesi_user_mhs')?>" readonly size="20">
			<?php echo form_error('username')?>
		</td>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Password</strong></td>
		<td class="last">
			<input type="password" name="password" value="<?php echo $this->input->post('password')?>" size="30">
			<?php echo form_error('password')?>
		</td>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Password Baru</strong></td>
		<td class="last"><input type="password" name="newpassword" value="<?php echo $this->input->post('newpassword')?>" size="30">
			<?php echo form_error('newpassword')?>
		</td>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Konfirmasi Password</strong></td>
		<td class="last"><input type="password" name="renewpassword" value="<?php echo $this->input->post('renewpassword')?>" size="30">
			<?php echo form_error('renewpassword')?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="last">
			<?php echo form_submit('cmdSimpan', 'Simpan Perubahan');?>
			<a href="javascript:void(0)" onclick='show("mhs/masmahasiswa/detail","#center-column")'>&lt;&lt; Batal</a>
		</td>
	</tr>
</table>
</div>
</form>