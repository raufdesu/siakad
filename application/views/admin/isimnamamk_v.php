<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	$("#simnamamk").validate({
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
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simnamamk/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simnamamk',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT NAMA MATAKULIAH</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Matakuliah</strong></td>
			<td class="last">
				<input type="text" name="namamk" size="30"/>
				<?php echo form_error('namamk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Matakuliah Inggris</strong></td>
			<td class="last">
				<input type="text" name="namamkinggris" size="30"/>
				<?php echo form_error('namamkinggris');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/simkurikulum/add","#center-column")'>
					<< Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>