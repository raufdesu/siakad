<head>
<script>
	function GetValueFromChild(myVal){
		document.getElementById('file').value = myVal;
	}
</script>
</head>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi' onclick='show("admin/maskegiatan/","#center-column")'>Browse</a>
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/maskegiatan/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'maskegiatan',
	'type'=>'post'));
	echo form_hidden('thajaran', $this->session->userdata('sesi_krs_thajaran_aktif'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM <?php echo $title?></th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Kegiatan</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('namakegiatan')?>" name="namakegiatan" size="60"/>
				<?php echo '<br />'.form_error('namakegiatan');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tingkat</strong></td>
			<td class="last">
				<select name="tingkat">
					<option value=""></option>
					<option <?php if($this->input->post('tingkat') == 'Perguruan Tinggi') echo 'selected';?> value="Perguruan Tinggi">Perguruan Tinggi</option>
					<option <?php if($this->input->post('tingkat') == 'Kopertis') echo 'selected';?> value="Kopertis">Kopertis</option>
					<option <?php if($this->input->post('tingkat') == 'Propinsi') echo 'selected';?> value="Propinsi">Propinsi</option>
					<option <?php if($this->input->post('tingkat') == 'Nasional') echo 'selected';?> value="Nasional">Nasional</option>
				</select>
				<?php echo '<br />'.form_error('tingkat');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Mulai</strong></td>
			<td class="last">
				<input type="text" name="tglmulai" class="required" size="8"/>
				<input type="button" value="..." OnClick="displayDatePicker('tglmulai', false, 'dmy', '-')">
				<?php echo '<br />'.form_error('tglmulai');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Selesai</strong></td>
			<td class="last">
				<input type="text" name="tglselesai" class="required" size="8"/>
				<input type="button" value="..." OnClick="displayDatePicker('tglselesai', false, 'dmy', '-')">
				<?php echo '<br />'.form_error('tglselesai');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Pembimbing 1</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $this->input->post('npp1')?>" name="npp1" size="40"/>
				<input type="text" readonly value="<?php echo $this->input->post('nmpembimbing1')?>" name="pembimbing1" size="40"/>
				<a href="javascript:void(0)" onclick='load_into_box("mhs/maspegawai/browse_dosen/pilih1");'>..</a>
				<?php echo '<br />'.form_error('pembimbing1');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Pembimbing 2</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $this->input->post('npp2')?>" name="npp2" size="40"/>
				<input type="text" readonly value="<?php echo $this->input->post('nmpembimbing2')?>" name="pembimbing2" size="40"/>
				<a href="javascript:void(0)" onclick='load_into_box("mhs/maspegawai/browse_dosen/pilih2");'>..</a>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan').form_reset('batal','Batal');?>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>