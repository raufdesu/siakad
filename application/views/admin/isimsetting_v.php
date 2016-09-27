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
	'url'=>site_url('admin/simsetting/save'), 							
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
			<th class="full" colspan="2">FORM SETTING SIMAK</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tahun Ajaran</strong></td>
			<td class="last">
				<input type="text" name="thajaran" value="<?php echo $this->input->post('thajaran')?>" maxlength='5' size="5"/>
				<small class="samar">contoh : 20131</small>
				<?php echo form_error('thajaran');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Aktif</strong></td>
			<td class="last">
				<input type="radio" name="aktif" disabled <?php if($this->input->post('aktif') == 'Aktif') echo 'checked';?> value="Aktif"/>Aktif | 
				<input type="radio" name="aktif" checked <?php if($this->input->post('aktif') == 'Tidak Aktif') echo 'checked';?> value="Tidak Aktif"/>Tidak Aktif
				<?php echo form_error('aktif');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. KRS Awal</strong></td>
			<td class="last">
				<!--<input type="text" name="tglkrsawal" value="</?php echo $this->input->post('tglkrsawal')?>" size="8"/>-->
				<input type="text" name="tglkrsawal" size="8" value="<?php echo $this->input->post('tglkrsawal')?>"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglkrsawal', false, 'dmy', '-')">
				<?php echo form_error('tglkrsawal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. KRS Akhir</strong></td>
			<td class="last">
				<input type="text" name="tglkrsakhir" value="<?php echo $this->input->post('tglkrsakhir')?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglkrsakhir', false, 'dmy', '-')">
				<?php echo form_error('tglkrsakhir');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. PKRS Awal</strong></td>
			<td class="last">
				<input type="text" name="tglperubahankrsawal" value="<?php echo $this->input->post('tglperubahankrsawal')?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglperubahankrsawal', false, 'dmy', '-')">
				<?php echo form_error('tglperubahankrsawal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. PKRS Akhir</strong></td>
			<td class="last">
				<input type="text" name="tglperubahankrsakhir" value="<?php echo $this->input->post('tglperubahankrsakhir')?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglperubahankrsakhir', false, 'dmy', '-')">
				<?php echo form_error('tglperubahankrsakhir');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. KSP Awal</strong></td>
			<td class="last">
				<input type="text" name="tglkspawal" value="<?php echo $this->input->post('tglkspawal')?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglkspawal', false, 'dmy', '-')">
				<?php echo form_error('tglkspawal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. KSP Akhir</strong></td>
			<td class="last">
				<input type="text" name="tglkspakhir" value="<?php echo $this->input->post('tglkspakhir')?>" size="8"/>
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
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>