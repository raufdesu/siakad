<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simyudisium/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simyudisium',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT NOMOR YUDISIUM</th>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Nomor Yudisium</strong></td>
			<td class="last">
				<input type="text" name="noyudisium" class="required" size="30"/>
				<?php echo form_error('noyudisium');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Tahun Ajaran</strong></td>
			<td class="last">
				<input type="text" name="thajaran" size="3" maxlength="5" value="<?php echo $this->session->userdata('sesi_thajaran')?>" />
				<small class="samar">contoh : 20131</small>
				<!--<input type="hidden" name="thajaran" value="</?php echo $this->session->userdata('sesi_thajaran')?>"/>-->
				<?php echo form_error('thajaran');?>
			</td>
		</tr>
		<!--<tr class="bg">
			<td class="first" width="172"><strong>Semester</strong></td>
			<td class="last">
				<input type="text" name="semester" size="5" value="</?php echo semester($this->session->userdata('sesi_thajaran'))?>"/>
				</?php echo form_error('thajaran');?>
			</td>
		</tr>-->
		<tr class="bg">
			<td class="first"><strong>Tanggal Yudisium</strong></td>
			<td class="last">
				<input type="text" name="tglyudisium" value="<?php echo date('d-m-Y')?>" maxlength="10" class="required" size="8"/>
				<?php echo form_error('tglyudisium');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan');?>
				<a href="javascript:void(0)" onclick='show("admin/simyudisium","#center-column")'>
					<< Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>