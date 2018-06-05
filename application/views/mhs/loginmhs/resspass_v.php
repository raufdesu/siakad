<head>
<script src="<?php echo base_url()?>asset/javascript/DatePicker.js" type="text/javascript" ></script>

	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
	
	
</head>
<body background="asset/images/design/logo.png">
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/loginmhs/ubah_password'), 							
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
		<th class="full" colspan="2"><h2><br><br>FORM RESET PASSWORD<br><br></h2></th>
	</tr>
	<tr>
		<td class="first" width="172"><strong>NIM</strong></td>
		<td class="last">
			<input type="text" name="nim" value="<?php echo $this->input->post('nim')?>" size="30">
			<?php echo form_error('nim')?>
		</td>
	</tr>
	<tr>
		<td id="label" class="first" width="190"><strong>Tanggal Lahir</strong></td>
			<td class="last">
				<input type="text" name="tgllahir" value="<?php echo $this->input->post('tgllahir')?>" size="8"/>(YYYY-MM-DD) contoh 1999-12-31
				
				<?php echo form_error('tgllahir')?>
			</td>
	</tr>
	<tr>
		<td id="label" class="first" width="190"><strong>Konfirmasi Tanggal Lahir</strong></td>
			<td class="last">
				<input type="text" name="contgllahir" value="<?php echo $this->input->post('contgllahir')?>" size="8"/>(YYYY-MM-DD) contoh 1999-12-31

				<?php echo form_error('contgllahir')?>
			</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="last">
			<?php echo form_submit('cmdSimpan', 'Reset Password');?>
			<a href="javascript:void(0)" onclick='show("mhs/masmahasiswa/detail","#center-column")'></a>
		</td>
	</tr>
</table>
</div>
</form>
</body>