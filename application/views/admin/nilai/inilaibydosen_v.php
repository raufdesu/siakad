<script>
	$(document).ready(function(){
		stoploading();
	});
</script>
<script>
	function submitGantiKelas(){
		showloading();
		var selected_kelas = $('select[name=cbkelas]').val();
		load('admin/nilai/change_kelas/'+selected_kelas,'#center-column');
	}
</script>
<div class="top-bar-adm">
	<div style="float:right">
		<select name="cbkelas" onchange="submitGantiKelas()">
			<option <?php if($this->session->userdata('sesi_kelas') == '1') echo 'selected'; ?> value="1">Reguler</option>
			<option <?php if($this->session->userdata('sesi_kelas') == '2') echo 'selected'; ?> value="2">Non Reguler</option>
		</select>
	</div>
	<h1>Daftar Mahasiswa Pengambil Matakuliah</h1>
	<div class="breadcrumbs"><a href="javascript:void(0)"><?php echo $namamatkul.' ('.$kodemk.') '.$kelas;?></a></div>
</div>
<div class="table">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/nilai/save_bydosen'), 'update'=>'#confirm-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	$disabled = '';
	if($this->session->userdata('sesi_status') == 'prodi'){
		$disabled = 'disabled';
	}
?>
<div id="confirm-column"></div>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">No.</th><th>NIM</th><th>Nama Mahasiswa</th><th width="41" class="last">Nilai</th>
	</tr>
	<?php $n=0; $no=1; foreach($browse_mahasiswaambilmk->result() as $ds):?>
	<tr class="bg">
		<td><?php echo $i = $no++?></td>
		<td><?php echo $ds->nim?><input type='hidden' name='nim_<?php echo $i?>' value='<?php echo $ds->nim?>'/></td>
		<td class="first"><?php echo $this->auth->get_namamhsbynim($ds->nim)?></td>
		<td class="last">
			<select name='nilai_<?php echo $i?>'>
				<option <?php if($ds->nilaihuruf == "") echo "selected";?> value=""></option>
				<option <?php if($ds->nilaihuruf == "A") echo "selected";?> value="A">A</option>
				<option <?php if($ds->nilaihuruf == "B") echo "selected";?> value="B">B</option>
				<option <?php if($ds->nilaihuruf == "C") echo "selected";?> value="C">C</option>
				<option <?php if($ds->nilaihuruf == "D") echo "selected";?> value="D">D</option>
				<option <?php if($ds->nilaihuruf == "E") echo "selected";?> value="E">E</option>
			</select>
		</td>
	</tr>
	<?php $n=$i; endforeach ?>
	<tr>
		<td colspan='3'></td>
		<td class="last" colspan='2'>
			<input type='hidden' value='<?php echo $n ?>' name='n'/>
			<input type='submit' value="Simpan" name='simpan' onclick="load_submit()" id="simpanNilai"/>
		</td>
	</tr>
</table>
</form>
</div>