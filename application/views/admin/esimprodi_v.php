<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	$("#simprodi").validate({
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
	'url'=>site_url('admin/simprodi/update'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
	foreach($detail_simprodi as $dp):
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT PROGRAM STUDI</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Kode PRODI</strong></td>
			<td class="last">
				<input type="text" name="kodeprodi" value="<?php echo $dp->kodeprodi?>" size="5"/>
				<input type="hidden" value="<?php echo $dp->kodeprodi?>" name="kodeprodi2" size="5"/>
				<?php echo form_error('kodeprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Pref Kode PRODI</strong></td>
			<td class="last">
				<input type="text" name="prefkodeprodi" value="<?php echo $dp->prefkodeprodi?>" size="5"/>
				<?php echo form_error('prefkodeprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama PRODI</strong></td>
			<td class="last">
				<input type="text" name="namaprodi" value="<?php echo $dp->namaprodi?>" size="45"/>
				<?php echo form_error('namaprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jenjang</strong></td>
			<td class="last">
				<input type="text" name="jenjang" value="<?php echo $dp->jenjang?>" size="2"/>
				<?php echo form_error('jenjang');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Ijin</strong></td>
			<td class="last">
				<input type="text" name="ijin" value="<?php echo $dp->ijin?>" size="60"/>
				<?php echo form_error('ijin');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status</strong></td>
			<td class="last">
				<input type="text" name="status" value="<?php echo $dp->status?>" size="60"/>
				<?php echo form_error('status');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kepala Prodi</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $dp->npp?>" name="npp"/>
				<input type="text" readonly value="<?php echo $dp->kaprodi?>" name="namadosen" style="width:300px"/>
				<a href="javascript:void(0)" onclick='load_into_box("admin/maspegawai/browse_dosen");'>..</a>
				<?php echo '<br />'.form_error('npp');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/simprodi","#center-column")'>
					<< Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php endforeach; echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>