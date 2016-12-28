<div id="editampuan">
<style>
	.child td{
		padding:2px 5px 2px 5px;
	}
	.child{
		margin:15px;
	}
</style>
<!--<input type='hidden' name='txt_kode_mk' value='</?php echo $dosenampu->kodemk?>'>
<input type='hidden' name='txt_nama_mk' value='</?php echo $dosenampu->namamatkul?>'>-->
<!--<input type='hidden' name='txt_sks' value='</?php echo $sks?>'>-->
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simdosenampu/update'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'maspegawai', 'type'=>'post'));
	echo form_hidden('id_kelas_dosen', $dosenampu->id_kelas_dosen);
	echo form_hidden('thajaran', $dosenampu->thajaran);
?>
<table class="child">
	<tr>
		<td align="right"><strong>NPP Dosen</strong></td><td><input type="text" name="npp" value="<?php echo $dosenampu->npp?>" size="10" />
			<small>Untuk pergantian dosen pengajar</small>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Kode Matakuliah</strong></td><td><input type="text" readonly name="kodemk" value="<?php echo $dosenampu->kodemk?>" size="10" /></td>
	</tr>
	<tr>
		<td align="right"><strong>Nama&nbsp;Matakuliah</strong></td><td><input type="text" readonly name="namamatkul" value="<?php echo $dosenampu->namamatkul;?>" size="45" /></td>
	</tr>
	<tr>
		<td align="right"><strong>Ruang</strong></td>
		<td>
			<select name='id_ruang'>
				<option value="">-:( Pilih Ruang ):-</option>
				<?php foreach($browse_simruang as $bs):?>
				<option <?php if($dosenampu->id_ruang == $bs->id_ruang) echo 'selected'; ?> value="<?php echo $bs->id_ruang?>"><?php echo $bs->nama?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Kelas</strong></td>
		<td>
			<select name='kelas'>
				<option <?php if($dosenampu->kelas == 'A1') echo 'selected'; ?> value='A1'>A1</option>
				<option <?php if($dosenampu->kelas == 'B1') echo 'selected'; ?> value='B1'>B1</option>
				<option <?php if($dosenampu->kelas == 'C1') echo 'selected'; ?> value='C1'>C1</option>
				<option <?php if($dosenampu->kelas == 'D1') echo 'selected'; ?> value='D1'>D1</option>
				<option <?php if($dosenampu->kelas == 'E1') echo 'selected'; ?> value='E1'>E1</option>
				<option <?php if($dosenampu->kelas == 'F1') echo 'selected'; ?> value='F1'>F1</option>
				<option <?php if($dosenampu->kelas == 'A2') echo 'selected'; ?> value='A2'>A2</option>
				<option <?php if($dosenampu->kelas == 'B2') echo 'selected'; ?> value='B2'>B2</option>
				<option <?php if($dosenampu->kelas == 'C2') echo 'selected'; ?> value='C2'>C2</option>
				<option <?php if($dosenampu->kelas == 'D2') echo 'selected'; ?> value='D2'>D2</option>
				<option <?php if($dosenampu->kelas == 'E2') echo 'selected'; ?> value='E2'>E2</option>
				<option <?php if($dosenampu->kelas == 'F2') echo 'selected'; ?> value='F2'>F2</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Hari</strong></td>
		<td>
			<select name='hari'>
				<option <?php if($dosenampu->hari == 'Senin') echo 'selected'; ?> value='Senin'>Senin</option>
				<option <?php if($dosenampu->hari == 'Selasa') echo 'selected'; ?> value='Selasa'>Selasa</option>
				<option <?php if($dosenampu->hari == 'Rabu') echo 'selected'; ?> value='Rabu'>Rabu</option>
				<option <?php if($dosenampu->hari == 'Kamis') echo 'selected'; ?> value='Kamis'>Kamis</option>
				<option <?php if($dosenampu->hari == 'Jumat') echo 'selected'; ?> value='Jumat'>Jumat</option>
				<option <?php if($dosenampu->hari == 'Sabtu') echo 'selected'; ?> value='Sabtu'>Sabtu</option>
				<option <?php if($dosenampu->hari == 'Minggu') echo 'selected'; ?> value='Minggu'>Minggu</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Jam Awal</strong></td>
		<td>
			<input type="text" name="jamawal" value="<?php echo $dosenampu->jamawal?>" size="2" />
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Jam Akhir</strong></td>
		<td>
			<input type="text" name="jamselesai" value="<?php echo $dosenampu->jamselesai?>" size="2" />
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Tatap Muka</strong></td>
		<td>
			<input type="text" name="rencana_tatap_muka" value="<?php echo $dosenampu->rencana_tatap_muka?>" size="2" />
		</td>
	</tr>
	<tr>
		<td align="right"><strong>Tatap Muka Real</strong></td>
		<td>
			<input type="text" name="tatap_muka_real" value="<?php echo $dosenampu->tatap_muka_real?>" size="2" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type='submit' value='Update' name='tambah' OnClick='jQuery.facebox.close()'/>
			<input type='button' value='Tutup' OnClick='jQuery.facebox.close()'/>
		</td>
	</tr>
</table>
</div>