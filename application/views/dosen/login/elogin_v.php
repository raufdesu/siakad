<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('dosen/login/do_gantipassword'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<!--</?php if($this->session->userdata('sesi_status') == 'admin'){ ?>
<a href="javascript:void(0)" style="margin:0px -8px 4px 4px" class='navi button' onclick='show("admin/login/gantipassword_dosen","#center-column")'>Edit Login Dosen</a>
</?php } ?>-->
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="full" colspan="2">FORM UBAH PASSWORD</th>
	</tr>
	<tr>
		<td class="first"><strong>NPP / Username</strong></td>
		<td class="last">
			<input type="text" name="username" value="<?php echo $this->session->userdata('sesi_user')?>" readonly size="20">
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
	<tr class="bg">
		<td class="last" colspan="2">Masukkan password baru dibawah ini untuk mengubah password anda sebelumnya.</td>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Password Baru</strong></td>
		<td class="last"><input type="password" name="passbaru" value="<?php echo $this->input->post('passbaru')?>" size="30">
			<?php echo form_error('passbaru')?>
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
			<!--<a href="javascript:void(0)" onclick='show("mhs/masmahasiswa/detail","#center-column")'>&lt;&lt; Batal</a>-->
		</td>
	</tr>
</table>
</div>
</form>