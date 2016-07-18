<script type='text/javascript' src='<?php echo base_url()?>asset/plugin/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/css/jquery.autocomplete.css" />
<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	})
</script>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('dosen/maspegawai/update'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'maspegawai',
	'type'=>'post'));
	foreach($detail_maspegawai as $dm):
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM UPDATE DATA PEGAWAI</th>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NPP Pegawai</strong></td>
			<td class="last">
				<input type="text" name="npp" value="<?php echo $dm->npp?>" class="required" readonly size="20"/>
				<input type="hidden" name="npp2" value="<?php echo $dm->npp?>" class="required" size="20"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIP Pegawai</strong></td>
			<td class="last">
				<input type="text" name="nip" value="<?php echo $dm->nip?>" class="required" size="30"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama</strong></td>
			<td class="last">
				<input type="text" name="nama" value="<?php echo $dm->nama?>" readonly class="required" size="35"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Pegawai</strong></td>
			<td class="last">
				<select name='statuspegawai'>
					<option disabled <?php if($dm->statuspegawai == 'Dosen PK') echo 'selected';?> value='Dosen PK'>Dosen PK</option>
					<option disabled <?php if($dm->statuspegawai == 'Dosen Tetap Yayasan') echo 'selected';?> value='Dosen Tetap Yayasan'>Dosen Tetap Yayasan</option>
					<option disabled <?php if($dm->statuspegawai == 'Dosen Tidak Tetap') echo 'selected';?> value='Dosen Tidak Tetap'>Dosen Tidak Tetap</option>
					<option disabled <?php if($dm->statuspegawai == 'Pegawai Tetap') echo 'selected';?> value='Pegawai Tetap'>Pegawai Tetap</option>
					<option disabled <?php if($dm->statuspegawai == 'Pegawai Kontrak') echo 'selected';?> value='Pegawai Kontrak'>Pegawai Kontrak</option>
				</select>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat</strong></td>
			<td class="last">
				<input type="text" name="alamat" value="<?php echo $dm->alamat?>" class="required" size="50"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon</strong></td>
			<td class="last">
				<input type="text" name="notelp" value="<?php echo $dm->notelp?>" class="required" size="20"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Email</strong></td>
			<td class="last">
				<input type="text" name="email" value="<?php echo $dm->email?>" size="30"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Nikah</strong></td>
			<td class="last">
				<input type="radio" <?php if($dm->statusnikah == 'Menikah') echo 'checked';?> name="statusnikah" class="required" value="Menikah"/>Menikah | 
				<input type="radio" <?php if($dm->statusnikah == 'Belum Menikah') echo 'checked';?> name="statusnikah" class="required" value="Belum Menikah"/>Belum Menikah
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pendidikan Terakhir</strong></td>
			<td class="last">
				<select name='pendidikanterakhir'>
					<option <?php if($dm->pendidikanterakhir == 'SD') echo 'selected';?> value='SD'>SD</option>
					<option <?php if($dm->pendidikanterakhir == 'SMP') echo 'selected';?> value='SMP'>SMP</option>
					<option <?php if($dm->pendidikanterakhir == 'SMA') echo 'selected';?> value='SMA'>SMA</option>
					<option <?php if($dm->pendidikanterakhir == 'D1') echo 'selected';?> value='D1'>D1</option>
					<option <?php if($dm->pendidikanterakhir == 'D3') echo 'selected';?> value='D3'>D3</option>
					<option <?php if($dm->pendidikanterakhir == 'S1') echo 'selected';?> value='S1'>S1</option>
					<option <?php if($dm->pendidikanterakhir == 'S2') echo 'selected';?> value='S2'>S2</option>
					<option <?php if($dm->pendidikanterakhir == 'S3') echo 'selected';?> value='S3'>S3</option>
				</select>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>NIDN</strong></td>
			<td class="last">
				<input type="text" name="nidn" value="<?php echo $dm->nidn?>" class="required" size="15"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jabatan</strong></td>
			<td class="last">
				<input type="text" id="suggest14" value="<?php echo $dm->bagian?>" readonly name="bagian" />
				<div id="jabatan"></div>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Masuk</strong></td>
			<td class="last">
				<input type="text" value="<?php echo tgl_indo($dm->tglmasuk)?>" readonly name="tglmasuk" class="required" size="8"/>
				<input type="button" value="..." OnClick="displayDatePicker('tglmasuk', false, 'dmy', '-')"></td>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit("cmdSimpan","Update",'OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("dosen/maspegawai/biodata","#center-column")'>
					&laquo; Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php endforeach; echo form_close();?>
<script>
	function setujui(){
		showloading();
	}
</script>