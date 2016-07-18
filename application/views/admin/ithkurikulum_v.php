<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	$("#simsetting").validate({
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
	'url'=>site_url('admin/simsetting/save_thkurikulum'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simsetting',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM TAMBAH TAHUN KURIKULUM</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tahun Kurikulum</strong></td>
			<td class="last">
				<input type="text" name="thkurikulum" value="<?php echo $this->input->post('thkurikulum')?>" maxlength='4' size="4"/>
				<?php echo form_error('thkurikulum');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/simsetting","#center-column")'>
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