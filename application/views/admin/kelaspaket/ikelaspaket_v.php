<script type="text/javascript">
$(document).ready(function() {
	stoploading();
})
</script>
<div class="top-bar-adm">
	<?php if($this->session->userdata('sesi_user') == 'admin'): ?>
		<a href="javascript:void(0)" style="margin-right:-32px;float:right" class='button' onclick='show("admin/kelaspaket","#center-column")'>Browse</a>
	<?php endif ?>
	<h1>Form Penentuan Kelas Paket</h1>
	<div class="breadcrumbs"><a href="#">Penentuan kelas paket (update mode paket mahasiswa) </a></div>
</div>
<?php echo $this->pquery->form_remote_tag(array('url'=>site_url('admin/kelaspaket/save'),
	'update'=>'#center-column', 'name'=>'f1', 'id'=>'kelaspaket', 'type'=>'post'));?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT KELAS PAKET</th>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama PRODI</strong></td>
			<td class="last">
				<select name="kodeprodi" id="dropdown">
					<option value=""></option>
					<?php foreach($browse_prodi as $bp){ ?>
					<option <?php if($this->input->post('kodeprodi') == $bp->kodeprodi) echo 'selected'?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
					<?php } ?>
				</select>
				<?php echo form_error('kodeprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kelas</strong></td>
			<td class="last">
				<select name="kelas" id="dropdown">
					<option value=""></option>
					<option <?php if($this->input->post('kelas') == '1') echo 'selected'?> value="1">Kelas Pagi</option>
					<option <?php if($this->input->post('kelas') == '2') echo 'selected'?> value="2">Kelas Sore</option>
				</select>
				<?php echo form_error('kelas');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Angkatan</strong></td>
			<td class="last">
				<select name="angkatan" id="dropdown">
					<option value=""></option>
					<?php foreach($browse_angkatan as $ba){ ?>
					<option <?php if($this->input->post('angkatan') == $ba->angkatan) echo 'selected'?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
					<?php } ?>
				</select>
				<?php echo form_error('angkatan');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status</strong></td>
			<td class="last">
				<label style="color:#ababab"><input type="checkbox" checked disabled /> Ubah mode paket untuk mahasiswa bersangkutan</label>
				<?php echo form_error('status');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','onclick="showloading()"');?>
				<a href="javascript:void(0)" onclick='show("admin/kelaspaket", "#center-column")'>
					&laquo; Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>