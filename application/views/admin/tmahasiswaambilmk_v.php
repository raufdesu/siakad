<script>
	$(document).ready(function(){
		stoploading();
	});
</script>
<h2>Daftar Mahasiswa Pengambil Matakuliah <?php echo $this->session->userdata('sesi_namamatkul').' ('.$this->session->userdata('sesi_kodematkul').')';?></h2>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/nilai/save'), 'update'=>'#confirm-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
?>
<div id="confirm-column"></div>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">No.</th><th>NIM</th><th>Nama Mahasiswa</th><th>Nilai (angka)</th><th style="width:20px !important" class="last">Nilai</th>
	</tr>
	<?php $n=0; $no=1; foreach($browse_mahasiswaambilmk->result() as $ds):?>
	<tr class="bg">
		<td><?php echo $i = $no++?></td>
		<td><?php echo $ds->nim?><input type='hidden' name='nim_<?php echo $i?>' value='<?php echo $ds->nim?>'/></td>
		<td class="first"><?php echo $this->auth->get_namamhsbynim($ds->nim)?></td>
		<td class="first"><input type='text' name='nilai_angka_<?php echo $i?>' value='<?php echo $ds->nilaiangka?>'/></td>
		<td class="last">
			<select name='nilai_<?php echo $i?>'>
				<option <?php if($ds->nilaihuruf == "") echo "selected";?> value=""></option>
				<option <?php if($ds->nilaihuruf == "A+") echo "selected";?> value="A+">A+</option>
				<option <?php if($ds->nilaihuruf == "A") echo "selected";?> value="A">A</option>
				<option <?php if($ds->nilaihuruf == "A-") echo "selected";?> value="A-">A-</option>
				<option <?php if($ds->nilaihuruf == "B+") echo "selected";?> value="B+">B+</option>
				<option <?php if($ds->nilaihuruf == "B") echo "selected";?> value="B">B</option>
				<option <?php if($ds->nilaihuruf == "B-") echo "selected";?> value="B-">B-</option>
				<option <?php if($ds->nilaihuruf == "C+") echo "selected";?> value="C+">C+</option>
				<option <?php if($ds->nilaihuruf == "C") echo "selected";?> value="C">C</option>
				<option <?php if($ds->nilaihuruf == "C-") echo "selected";?> value="C-">C-</option>
				<option <?php if($ds->nilaihuruf == "D") echo "selected";?> value="D">D</option>
				<option <?php if($ds->nilaihuruf == "E") echo "selected";?> value="E">E</option>
			</select>
		</td>
	</tr>
	<?php $n=$i; endforeach ?>
	<tr>
		<td colspan='4'></td>
		<td class="last">
			<input type='hidden' value='<?php echo $n ?>' name='n'/>
			<input type='submit' value="Simpan" name='simpan'/>
		</td>
	</tr>
</table>
</form>
<!--<script language="javascript">
	function setujui(tombolSubmit){
		document.getElementById(tombolSubmit).disabled = true;
		showloading();
	}
</script>-->