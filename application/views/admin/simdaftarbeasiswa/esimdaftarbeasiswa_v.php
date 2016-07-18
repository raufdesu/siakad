<head>
<script>
	function GetValueFromChild(myVal){
		document.getElementById('file').value = myVal;
	}
</script>
</head>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi button' onclick='show("admin/simdaftarbeasiswa/browse","#center-column");'>Browse</a>
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
<?php
	foreach($detail_simdaftarbeasiswa as $ds):
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simdaftarbeasiswa/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simdaftarbeasiswa',
	'type'=>'post'));
	echo form_hidden('iddaftarbeasiswa', $ds->iddaftarbeasiswa);
	echo form_hidden('nim', $ds->nim);
	echo form_hidden('tgldaftar', $ds->tgldaftar);
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
			<td class="first" width="190"><strong>Jenis Beasiswa</strong></td>
			<td class="last">
				<select name="jenisbeasiswa">
					<option value=""></option>
					<option <?php if($ds->jenisbeasiswa == 'PPA') echo 'selected';?> value="PPA">PPA</option>
					<option <?php if($ds->jenisbeasiswa == 'BBM') echo 'selected';?> value="BBM">BBM</option>
					<option <?php if($ds->jenisbeasiswa == 'Dikpora') echo 'selected';?> value="Dikpora">Dikpora</option>
					<option <?php if($ds->jenisbeasiswa == 'Supersmar') echo 'selected';?> value="Supersmar">Supersmar</option>
				</select>
				<?php echo '<br />'.form_error('jenisdaftar');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Status Pendaftaran</strong></td>
			<td class="last">
				<select name="status">
					<option <?php if($ds->status == 'Menunggu') echo 'selected';?> value="Menunggu">Menunggu</option>
					<option <?php if($ds->status == 'Diterima') echo 'selected';?> value="Diterima">Diterima</option>
					<option <?php if($ds->status == 'Ditolak') echo 'selected';?> value="Ditolak">Ditolak</option>
				</select>
				<?php echo '<br />'.form_error('status');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Pekerjaan Orang Tua</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $ds->pekerjaanortu?>" name="pekerjaanortu" size="40"/>
				<?php echo '<br />'.form_error('pekerjaanortu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>IPK</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $ds->ipk?>" name="ipk" size="2"/>
				<?php echo '<br />'.form_error('ipk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Gaji Orang Tua</strong></td>
			<td class="last">
				Rp. <input type="text" value="<?php echo $ds->penghasilanortu?>" name="penghasilanortu" size="8"/><small> perbulan</small>
				<?php echo '<br />'.form_error('penghasilanortu');?>
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