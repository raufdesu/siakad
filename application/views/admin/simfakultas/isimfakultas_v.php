<script type="text/javascript">
$(document).ready(function() {
	stoploading();
})
</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simfakultas/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simfakultas',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT PROGRAM STUDI</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Kode Fakultas</strong></td>
			<td class="last">
				<input type="text" name="kodefakultas" value="<?php echo $this->input->post('kodefakultas')?>" size="5"/>
				<?php echo form_error('kodefakultas');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama fakultas</strong></td>
			<td class="last">
				<input type="text" name="namafakultas" value="<?php echo $this->input->post('namafakultas')?>" size="45"/>
				<?php echo form_error('namafakultas');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Ijin</strong></td>
			<td class="last">
				<input type="text" name="ijin" value="<?php echo $this->input->post('ijin')?>" size="30"/>
				<?php echo form_error('ijin');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status</strong></td>
			<td class="last">
				<input type="text" name="status" value="<?php echo $this->input->post('status')?>" size="30"/>
				<?php echo form_error('status');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kepala fakultas</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $this->input->post('npp')?>" name="npp"/>
				<input type="text" readonly value="<?php echo $this->input->post('kafakultas')?>" name="namadosen" style="width:300px"/>
				<a href="javascript:void(0)" onclick='load_into_box("admin/maspegawai/browse_dosen");'>..</a>
				<?php echo '<br />'.form_error('npp');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Update','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/simfakultas","#center-column")'>
					&laquo; Batal
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
	}
</script>