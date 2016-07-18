<head>
<script>
	function GetValueFromChild(myVal){
		document.getElementById('file').value = myVal;
	}
</script>
</head>
<div class="top-bar-adm">
	<div class='button'>
		<a href="javascript:void(0)" onclick='show("mhs/simdaftarbeasiswa/browse","#center-column");'>Browse</a>
	</div>
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
	'url'=>site_url('mhs/simdaftarbeasiswa/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simdaftarbeasiswa',
	'type'=>'post'));
	echo form_hidden('nim', $this->session->userdata('sesi_krs_nim'));
	echo form_hidden('tgldaftar', date('Y-m-d'));
	echo form_hidden('status', 'Menunggu');
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
					<option <?php if($this->input->post('jenisbeasiswa') == 'PPA') echo 'selected';?> value="PPA">PPA</option>
					<option <?php if($this->input->post('jenisbeasiswa') == 'BBM') echo 'selected';?> value="BBM">BBM</option>
					<option <?php if($this->input->post('jenisbeasiswa') == 'Dikpora') echo 'selected';?> value="Dikpora">Dikpora</option>
					<option <?php if($this->input->post('jenisbeasiswa') == 'Supersmar') echo 'selected';?> value="supersmar">Supersmar</option>
				</select>
				<?php echo '<br />'.form_error('jenisbeasiswa');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Pekerjaan Ortu</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('pekerjaanortu')?>" name="pekerjaanortu" size="40"/>
				<?php echo '<br />'.form_error('pekerjaanortu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Penghasilan Ortu</strong></td>
			<td class="last">
				Rp.<input type="text" value="<?php echo $this->input->post('penghasilanortu')?>" name="penghasilanortu" align="right" size="8"/> <small>(Perbulan)</small>
				<?php echo '<br />'.form_error('penghasilanortu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>IPK</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('ipk')?>" name="ipk" align="right" size="2"/>
				<?php echo '<br />'.form_error('ipk');?>
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