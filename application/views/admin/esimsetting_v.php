<script type="text/javascript">
$(document).ready(function() {
	stoploading();
})
</script>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simsetting/update'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simsetting',
	'type'=>'post'));
?>
<?php foreach($detail_simsetting as $ds):?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM SETTING SIMAK</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tahun Ajaran</strong></td>
			<td class="last">
				<input type="text" name="thajaran" readonly value="<?php echo $ds->thajaran?>" maxlength='5' size="5"/>
				<?php echo form_error('thajaran');?>
			</td>
		</tr>
		<!--<tr class="bg">
			<td class="first" width="190"><strong>Aktif</strong></td>
			<td class="last">
				<input type="radio" name="aktif" disabled </?php if($ds->aktif == 'Aktif') echo 'checked';?> value="Aktif"/>Aktif | 
				<input type="radio" name="aktif" checked </?php if($ds->aktif == 'Tidak Aktif') echo 'checked';?> value="Tidak Aktif"/>Tidak Aktif
				</?php echo form_error('aktif');?>
			</td>
		</tr>-->
		<tr class="bg">
			<td class="first"><strong>Tgl. KRS Awal</strong></td>
			<td class="last">
				<input type="text" name="tglkrsawal" size="8" value="<?php echo tgl_indo($ds->tglkrsawal)?>"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglkrsawal', false, 'dmy', '-')">
				<?php echo form_error('tglkrsawal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. KRS Akhir</strong></td>
			<td class="last">
				<input type="text" name="tglkrsakhir" value="<?php echo tgl_indo($ds->tglkrsakhir)?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglkrsakhir', false, 'dmy', '-')">
				<?php echo form_error('tglkrsakhir');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. PKRS Awal</strong></td>
			<td class="last">
				<input type="text" name="tglperubahankrsawal" value="<?php echo tgl_indo($ds->tglperubahankrsawal)?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglperubahankrsawal', false, 'dmy', '-')">
				<?php echo form_error('tglperubahankrsawal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. PKRS Akhir</strong></td>
			<td class="last">
				<input type="text" name="tglperubahankrsakhir" value="<?php echo tgl_indo($ds->tglperubahankrsakhir)?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglperubahankrsakhir', false, 'dmy', '-')">
				<?php echo form_error('tglperubahankrsakhir');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. ksp Awal</strong></td>
			<td class="last">
				<input type="text" name="tglkspawal" value="<?php echo tgl_indo($ds->tglkspawal)?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglkspawal', false, 'dmy', '-')">
				<?php echo form_error('tglkspawal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. ksp Akhir</strong></td>
			<td class="last">
				<input type="text" name="tglkspakhir" value="<?php echo tgl_indo($ds->tglkspakhir)?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglkspakhir', false, 'dmy', '-')">
				<?php echo form_error('tglkspakhir');?>
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
<?php endforeach; echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>