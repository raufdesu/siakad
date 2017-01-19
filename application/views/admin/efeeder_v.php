<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	$("#maspegawai").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
	<script language='javascript' type='text/javascript'>
	function load(page,div)
	{
		var site = "<?php echo site_url();?>";
		$.ajax({
			url: site+"/"+page,
			success: function(response){
				$(div).html(response);
			},
		dataType:"html"
		});
		return false;
	}
	</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/feeder/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'maspegawai',
	'type'=>'post'));
	foreach($feeder as $dm):
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">UPDATE USER FEEDER</th>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Username Feeder</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->username;?>" name="username" class="required" size="12"/>
				<input type="hidden" value="<?php echo $dm->id;?>" name="id"/>
				<?php echo form_error('username');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Password Feeder</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->password;?>" name="password" class="required" size="35"/>
				<?php echo form_error('password');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>URL Feeder</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->url;?>" name="url" class="required" size="35"/>
				<?php echo form_error('url');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Port</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->port;?>" name="port" class="required" size="35"/>
				<?php echo form_error('port');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Kode PT</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->id_sp;?>" name="id_sp" class="required" size="35"/>
				<?php echo form_error('id_sp');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Live</strong></td>
			<td class="last">
				<input type="radio" <?php if($dm->live=='Y') echo 'checked';?> name="live" class="required" value="Y"/>Yes
				<input type="radio" <?php if($dm->live=='N') echo 'checked';?> name="live" class="required" value="N"/>No
				<?php echo form_error('live');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Update','OnClick="showloading()"');?>
				<a href="javascript:void(0)" onclick='show("admin/feeder","#center-column")'>
					&laquo; Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php endforeach; echo form_close();?>