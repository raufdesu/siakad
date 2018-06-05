<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/loginmhs/ubahawal'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<div style="width:345px;text-align:center;margin:0px auto; float:center"><?php
		$arimg = array(
			"src"	=> "asset/images/design/logo.png",
			"style"	=> "width:110px; margin:10px auto;border:none !important;"
		);
		echo img($arimg);
	?><br />UNIV. MUHAMMADIYAH MATARAM
	</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<th class="full" colspan="2"><h2><br><br>FORM UBAH PASSWORD<br><br></h2></th>
	</tr>
		<tr>
		<th class="full" colspan="2">ANDA DIWAJIBKAN MERUBAH PASSWORD ANDA SEBELUM DAPAT MENGAKSES SIAKAD<br></th>
	</tr>
	<tr>
		<td class="first"><strong>NIM</strong></td>
		<td class="last">
			<input type="text" name="username" value="<?php echo $this->session->userdata('sesi_user_mhs')?>" readonly size="20">
			<?php echo form_error('username')?>
		</td>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Password Saat Ini</strong></td>
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
			<a href="javascript:void(0)" onclick='show("mhs/masmahasiswa/detail","#center-column")'></a>
		</td>
	</tr>
</table>
</div>
</form>