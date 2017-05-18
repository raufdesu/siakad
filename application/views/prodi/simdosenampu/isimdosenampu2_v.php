<script>
	$(document).ready(function(){
		stoploading();
	});
</script>
<?php 
$nidn = $_SESSION['nidn'];
$nama = $_SESSION['nama'];
?>
<input type='hidden' name='txt_kode_mk' value='<?php echo $kode_matkul?>'>
<input type='hidden' name='txt_nama_mk' value='<?php echo $nama_matkul?>'>
<input type='hidden' name='txt_kode_prodi' value='<?php echo $kode_prodi?>'>
<input type='hidden' name='txt_nidn' value='<?php echo $nidn?>'>
<input type='hidden' name='txt_nama' value='<?php echo $nama?>'>
<input type='hidden' name='txt_sks' value='<?php echo $sks?>'>
<table>
	<tr>
		<td colspan="5"><?php echo "[".$kode_matkul."] ".$nama_matkul;?></td>
	</tr>
	<tr>
		<td align="left">
		<strong>Ruang</strong>
		<select name='id_ruang'>
			<option value="">-:( Pilih Ruang ):-</option>
		<?php foreach($browse_simruang as $bs):?>
			<option value="<?php echo $bs->id_ruang?>"><?php echo $bs->nama?></option>
		<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td align="left"><strong>Kelas</strong>
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
	</tr>
	<tr>
		<td align="left"><strong>Hari</strong>
			<select name='hari'>
				<option value='Senin'>Senin</option>
				<option value='Selasa'>Selasa</option>
				<option value='Rabu'>Rabu</option>
				<option value='Kamis'>Kamis</option>
				<option value='Jumat'>Jumat</option>
				<option value='Sabtu'>Sabtu</option>
				<option value='Minggu'>Minggu</option>
			</select>
			<input type="text" name="jamawal" value="00:00" size="2" />
			<input type="text" name="jamselesai" value="00:00" size="2" />
		</td>
	</tr>
	<tr>
		<td align="left"><strong>Tatap Muka</strong><td><input type="text" name="rencana_tatap_muka"  size="3" /></td>
		</td>
	</tr>
	<tr>
		<td align="left"><strong>Tatap Muka Real</strong></td><td><input type="text" name="tatap_muka_real"  size="3" />
		</td>
	</tr>
	<tr>
		<td align="left"><strong>Bahasan</strong></td><td><input type="fieldtext" name="bahasan_case"  size="40" />
		</td>
		<td><input type='submit' value='Tambah' name='tambah' OnClick='setujui()'/></td>
	</tr>
</table>