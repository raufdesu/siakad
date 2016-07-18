<script type="text/javascript">
$(document).ready(function() {
	stoploading();
})
</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simaktifsemester/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'maspegawai',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT MAHASISWA AKTIF SEMESTER</th>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIM</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nim')?>" name="nim" class="required" size="10"/>
				<?php echo form_error('nim');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nama')?>" name="nama" class="required" size="35"/>
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Akademik</strong></td>
			<td class="last">
				<select name='status'>
					<option value=''></option>
					<option value='Aktif'>Aktif</option>
					<option value='Non Aktif'>Non Aktif</option>
					<option value='Cuti'>Cuti</option>
					<option value='Keluar'>Keluar</option>
				</select>
				<?php echo form_error('status');?>
			</td>
		</tr>		
		<tr class="bg">
			<td class="first"><strong>Tahun Ajaran</strong></td>
			<td class="last">
				<input type="text" readonly value="<?php echo $this->session->userdata('sesi_thajaran')?>" name="thajaran" class="required" size="4"/>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("prodi/simaktifsemester","#center-column")'><< Batal</a>
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