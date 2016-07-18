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
				<option value='A'>A</option>
				<option value='B'>B</option>
				<option value='C'>C</option>
				<option value='D'>D</option>
				<option value='E'>E</option>
				<option value='F'>F</option>
				<option value='G'>G</option>
				<option value='H'>H</option>
				<option value='I'>I</option>
				<option value='J'>J</option>
				<option value='K'>K</option>
				<option value='L'>L</option>
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