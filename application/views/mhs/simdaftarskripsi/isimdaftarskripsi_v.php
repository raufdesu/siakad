<head>
<script>
	function GetValueFromChild(myVal){
		document.getElementById('file').value = myVal;
	}
</script>
</head>
<div class="top-bar-adm">
	<h2><?php echo $title?></h2>
	<!--<div class="breadcrumbs"><a href="#">tes&nbsp;</a></div>-->
</div>
<div class="select-bar">
<div style="text-align:left;">
	<table class="" cellpadding="0" cellspacing="0">
		<tr>
			<td class="right"><strong>NIM</strong></td>
			<td class="last" width='250'>: <?php echo $this->session->userdata('sesi_krs_nim')?></td>
			<td class='right'><strong>Jurusan</strong></td>
			<td class='first'>:
				<?php echo $this->session->userdata('sesi_krs_prodi')?>
				<?php if($this->session->userdata('sesi_krs_kelas')=='2'){ echo '(Malam)'; } ?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first right"><strong>Nama</strong></td>
			<td class="last">: <?php echo $this->session->userdata('sesi_krs_nama');?></td>
			<td class='right'><strong>Thn. Akademik</strong></td><td class='first'>:
				<?php echo thakademik($this->session->userdata('sesi_krs_thajaran_aktif'))?>
				<?php echo '('.semester($this->session->userdata('sesi_krs_thajaran_aktif')).')';?>
			</td>
		</tr>
	</table>
</div>
</div>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/simdaftarskripsi/save_mahasiswa'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simdaftarskripsi',
	'type'=>'post'));
	echo form_hidden('nim', $this->session->userdata('sesi_krs_nim'));
	echo form_hidden('tgldaftar', date('Y-m-d'));
	echo form_hidden('status', 'Menunggu');
	echo form_hidden('iddaftarskripsi', $iddaftarskripsi);
	echo form_hidden('thajaran', $this->session->userdata('sesi_krs_thajaran_aktif'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM <?php echo $title?></th>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Jenis Pendaftaran</strong></td>
			<td class="last">
				<select name="jenisdaftar">
					<option <?php if($jenisdaftar != 'KP') echo 'disabled'; if($jenisdaftar == 'KP') echo 'selected';?> value="KP">Kerja Praktek(KP)</option>
					<option <?php if($jenisdaftar != 'TA') echo 'disabled'; if($jenisdaftar == 'TA') echo 'selected';?> value="TA">Tugas Akhir(TA)</option>
					<option <?php if($jenisdaftar != 'Skripsi') echo 'disabled'; if($jenisdaftar == 'Skripsi') echo 'selected';?> value="Skripsi">Skripsi</option>
				</select>
				<?php echo '<br />'.form_error('jenisdaftar');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Judul Yang Diajukan</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('judulskripsi')?>" name="judulskripsi" style="width: 430px"/>
				<?php echo '<br />'.form_error('judulskripsi');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Usulan Pembimbing 1</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $this->input->post('npp1')?>" name="npp1" size="40"/>
				<input type="text" readonly value="<?php echo $this->input->post('pembimbing1')?>" name="pembimbing1" style="width:360px"/>
				<a href="javascript:void(0)" onclick='load_into_box("mhs/maspegawai/browse_dosen/pilih1");'>..</a>
				<?php echo '<br />'.form_error('pembimbing1');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Usulan Pembimbing 2</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $this->input->post('npp2')?>" name="npp2" size="40"/>
				<input type="text" readonly value="<?php echo $this->input->post('pembimbing2')?>" name="pembimbing2" style="width:360px"/>
				<a href="javascript:void(0)" onclick='load_into_box("mhs/maspegawai/browse_dosen/pilih2");'>..</a>
				<?php echo '<br />'.form_error('pembimbing2');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan');?>
				<a href="javascript:void(0)" onclick='show("mhs/simdaftarskripsi/browse","#center-column");'>&lt;&lt; Back</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>