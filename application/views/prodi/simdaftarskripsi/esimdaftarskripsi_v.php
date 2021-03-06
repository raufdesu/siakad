<?php
	$nim = $this->session->userdata('sesi_krs_nim');
?>
<head>
<script>
	function GetValueFromChild(myVal){
		document.getElementById('file').value = myVal;
	}
</script>
</head>
<div class="top-bar-adm">
	<div style="margin-right:-32px" >
		<a href="javascript:void(0)" class='navi button' onclick='show("prodi/simdaftarskripsi/","#center-column");'>Browse</a>
		<a href="javascript:void(0)" class='navi button' onclick='show("prodi/masmahasiswa/pendaftaran/<?php echo $nim?>","#center-column");'>Back</a>
	</div>
<h2><?php echo $title?></h2>
	<!--<div class="breadcrumbs"><a href="#">tes&nbsp;</a></div>-->
</div>
<div class="select-bar">
<div style="text-align:left;">
	<table class="" cellpadding="0" cellspacing="0">
		<tr>
			<td class="right"><strong>NIM</strong></td>
			<td class="last" width='250'>: <?php echo $nim?></td>
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
<?php
	foreach($detail_simdaftarskripsi as $ds):
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simdaftarskripsi/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simdaftarskripsi',
	'type'=>'post'));
	echo form_hidden('iddaftarskripsi', $ds->iddaftarskripsi);
	echo form_hidden('nim', $ds->nim);
	echo form_hidden('tgldaftar', $ds->tgldaftar);
	echo form_hidden('thajaran', $ds->thajaran);
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM <?php echo $title?></th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Jenis Pendaftaran</strong></td>
			<td class="last">
				<input type="text" readonly value="<?php echo $ds->jenisdaftar?>" name="jenisdaftar" />
				<?php echo '<br />'.form_error('jenisdaftar');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Status Pendaftaran</strong></td>
			<td class="last">
				<input type="radio" value="Baru" <?php if($ds->statusdaftar == 'Baru') echo 'checked';?> name="statusdaftar"> Baru &nbsp;
				<input type="radio" value="Melanjutkan" <?php if($ds->statusdaftar == 'Melanjutkan') echo 'checked';?> name="statusdaftar"> Melanjutkan
				<?php echo '<br />'.form_error('statusdaftar');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Judul Yang Diajukan</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $ds->judulskripsi?>" name="judulskripsi" size="60"/>
				<?php echo '<br />'.form_error('judulskripsi');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Usulan Pembimbing 1</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $ds->pembimbing1?>" name="npp1" size="40"/>
				<input type="text" readonly value="<?php echo $ds->nmpembimbing1?>" name="pembimbing1" size="40"/>
				<a href="javascript:void(0)" onclick='load_into_box("mhs/maspegawai/browse_dosen/pilih1");'>..</a>
				<?php echo '<br />'.form_error('pembimbing1');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Usulan Pembimbing 2</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $ds->pembimbing2?>" name="npp2" size="40"/>
				<input type="text" readonly value="<?php echo $ds->nmpembimbing2?>" name="pembimbing2" size="40"/>
				<a href="javascript:void(0)" onclick='load_into_box("mhs/maspegawai/browse_dosen/pilih2");'>..</a>
			</td>
		</tr>
		<!--<tr>
			<td class="first" width="190"><strong>No. SK</strong></td>
			<td class="last">
				</?php
					if($ds->nosk){
						$nosk = $ds->nosk;
					}
				?>
				<input type="text" value="</?php echo $nosk?>" name="nosk" size="30"/>
				</?php echo '<br />'.form_error('nosk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tgl. SK</strong></td>
			<td class="last">
				<input type='text' name='tglsk' value='</?php echo tgl_indo($ds->tglsk)?>' size='8'/>
				<input type='button' value='..' class='date' OnClick="displayDatePicker('tglsk', false, 'dmy', '-')"/>
				</?php echo '<br />'.form_error('tglsk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tgl. Akhir</strong></td>
			<td class="last">
				<input type='text' name='tglakhir' value='</?php echo tgl_indo($ds->tglakhir)?>' size='8'/>
				</?php echo '<br />'.form_error('tglakhir');?>
			</td>
		</tr>-->
		<tr class="bg">
			<td class="first" width="190"><strong>Status Persetujuan</strong></td>
			<td class="last">
				<select name="persetujuan">
					<option <?php if($ds->persetujuan == 'Disetujui') echo 'selected';?> value="Disetujui">Disetujui</option>
					<option <?php if($ds->persetujuan == 'Belum Disetujui') echo 'selected';?> value="Belum Disetujui">Belum Disetujui</option>
				</select>
				<?php echo '<br />'.form_error('persetujuan');?>
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
<?php echo form_close(); endforeach;?>