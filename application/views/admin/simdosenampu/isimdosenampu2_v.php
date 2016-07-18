<script>
	$(document).ready(function(){
		stoploading();
	});
</script>
<input type='hidden' name='txt_kode_mk' value='<?php echo $kode_matkul?>'>
<input type='hidden' name='txt_nama_mk' value='<?php echo $nama_matkul?>'>
<input type='hidden' name='txt_sks' value='<?php echo $sks?>'>
<table>
	<tr>
		<td colspan="5"><?php echo "[".$kode_matkul."] ".$nama_matkul;?></td>
	</tr>
	<tr>
		<td align="right">
		<strong>Ruang</strong>
		<select name='id_ruang'>
			<option value="">-:( Pilih Ruang ):-</option>
		<?php foreach($browse_simruang as $bs):?>
			<option value="<?php echo $bs->id_ruang?>"><?php echo $bs->nama?></option>
		<?php endforeach; ?>
		</select>
		</td>
		<td align="right"><strong>Kelas</strong>
			<select name='kelas'>
				<option value='A1'>A1</option>
				<option value='B1'>B1</option>
				<option value='C1'>C1</option>
				<option value='D1'>D1</option>
				<option value='E1'>E1</option>
				<option value='F1'>F1</option>
				<option value='A2'>A2</option>
				<option value='B2'>B2</option>
				<option value='C2'>C2</option>
				<option value='D2'>D2</option>
				<option value='E2'>E2</option>
				<option value='F2'>F2</option>
			</select>
		</td>
		<td align="right"><strong>Hari</strong>
			<select name='hari'>
				<option value='Senin'>Senin</option>
				<option value='Selasa'>Selasa</option>
				<option value='Rabu'>Rabu</option>
				<option value='Kamis'>Kamis</option>
				<option value='Jumat'>Jumat</option>
				<option value='Sabtu'>Sabtu</option>
				<option value='Minggu'>Minggu</option>
			</select>
		</td>
		<td>
			<input type="text" name="jamawal" value="00:00" size="2" />
		</td>
		<td>
			<input type="text" name="jamselesai" value="00:00" size="2" />
		</td>
		<td><input type='submit' value='Tambah' name='tambah' OnClick='setujui()'/></td>
	</tr>
</table>