<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	})
</script>
<div class="top-bar-adm">
	<div style="float:right;margin:5px -32px 0">
	<?php if($this->session->userdata('sesi_user') == 'admin'):?>
		<a href="javascript:void(0)" class='button' onclick='show("admin/paket","#center-column")'> Browse</a>
	<?php endif?>
	</div>
	<h1>Matakuliah Paket</h1>
	<div class="breadcrumbs"><a href="#">Penentuan Matakuliah Paket</a></div>
</div>
<?php echo $this->pquery->form_remote_tag(array('url'=>site_url('admin/paket/save'),
	'update'=>'#center-column', 'name'=>'fpaket', 'id'=>'simprodi', 'type'=>'post')); ?>
<div class="select-bar" style="height:22px;" class='obj-right'>
	<select name='kodeprodi' style="width:auto !important;">
		<option <?php if($kodeprodi == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($kodeprodi == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>
	<select name='angkatan' style="width:auto !important">
		<option <?php if($angkatan == '') echo 'selected'; ?> value="">Angkatan</option>
		<?php foreach($browse_angkatan as $ba):?>
		<option <?php if($angkatan == $ba->angkatan) echo 'selected'; ?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
		<?php endforeach; ?>
	</select>
	<select name='kelas' style="width:auto !important">
		<option <?php if($kelas == '') echo 'selected'; ?> value="">Kelas</option>
		<option <?php if($kelas == '1') echo 'selected'; ?> value="1">Kelas Pagi</option>
		<option <?php if($kelas == '2') echo 'selected'; ?> value="2">Kelas Sore</option>
	</select>
	<label>&nbsp; Tahun Ajaran </label><input type="text" value="<?php if(!$this->input->post('thajaran')){ echo $this->session->userdata('sesi_thajaranpaket'); }else{ echo $this->input->post('thajaran'); } ?>" name="thajaran" maxlength="5" size="5"/>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT MATAKULIAH PAKET</th>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kode Matakuliah</strong> <small></small></td>
			<td class="last">
				<input type="text" name="kodemk" value="<?php if(!$baru) echo $this->input->post('kodemk')?>" readonly size="12"/>
				<input type="button" onclick='loadmatakuliah()' value="..." />
				<?php echo form_error('kodemk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="170"><strong>Nama Matakuliah</strong></td>
			<td class="last">
				<input type="text" name="namamk" value="<?php if(!$baru) echo $this->input->post('namamk')?>" readonly size="60"/>
				<?php echo form_error('namamk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>SKS</strong></td>
			<td class="last">
				<input type="text" name="sks" value="<?php if(!$baru) echo $this->input->post('sks')?>" readonly size="2"/>
				<?php echo form_error('sks');?>
			</td>
		</tr>
		<!--<tr class="bg">
			<td class="first"><strong>Tahun Kurikulum</strong></td>
			<td class="last">
				<input type="text" name="kurikulum" size="5"/>
				</?php echo form_error('kurikulum');?>
			</td>
		</tr>-->
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/paket", "#center-column")'>&laquo; Batal</a>
			</td>
		</tr>
	</table>
	<?php
		if($baru){
			echo '<div style="border:1px solid green;padding:10px;margin-top:10px;width:97%">
				<b>KONFIRMASI</b> Data berhasil disimpan kedalam database.
			</div>';
		}
		echo form_error('kodeprodi');
		echo form_error('angkatan');
		echo form_error('kelas');
		echo form_error('thajaran');
	?>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
	}
	function loadmatakuliah(){
		var kodeprodi = $('select[name=kodeprodi]').val();
		var angkatan = $('select[name=angkatan]').val();
		var kelas = $('select[name=kelas]').val();
		var thajaran = $('input[name=thajaran]').val();
		if(kodeprodi && angkatan && kelas && thajaran){
			load_into_box("admin/paket/browse_matakuliah/"+kodeprodi+"/"+angkatan+"/"+kelas+"/"+thajaran);
		}else if(kodeprodi == false){
			alert('KONFIRMASI\nPilih Program Studi Terlebih Dahulu');
		}else if(angkatan == false){
			alert('KONFIRMASI\nPilih Angkatan Terlebih Dahulu');
		}else if(kelas == false){
			alert('KONFIRMASI\nPilih Kelas Terlebih Dahulu');
		}else if(thajaran == false){
			alert('KONFIRMASI\nInputkan Tahun Ajaran Terlebih Dahulu');
		}
	}
</script>