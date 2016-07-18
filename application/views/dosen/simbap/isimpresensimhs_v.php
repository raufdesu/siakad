<script>
	$(document).ready(function(){
		stoploading();
	});
</script>
<script>
	function submitGantiKelas(){
		showloading();
		var selected_kelas = $('select[name=cbkelas]').val();
		load('dosen/nilai/change_kelas/'+selected_kelas,'#center-column');
	}
</script>
<div class="top-bar-adm">
	<!--<div style="float:right">
		<select name="cbkelas" onchange="submitGantiKelas()">
			<option </?php if($this->session->userdata('sesi_kelas') == '1') echo 'selected'; ?> value="1">Reguler</option>
			<option </?php if($this->session->userdata('sesi_kelas') == '2') echo 'selected'; ?> value="2">Malam</option>
		</select>
	</div>-->
	<div style="float:right;margin-right:-32px;">
		<a href="javascript:void(0)" class="button" onclick='show("dosen/simbap/input/<?php echo $id_kelas_dosen?>","#center-column")'>Input Materi</a>
		<a href="javascript:void(0)" class="button" onclick='show("dosen/nilai","#center-column")'>Daftar Matakuliah</a>
	</div>
	<h1>Daftar Mahasiswa Pengambil Matakuliah</h1>
	<div class="breadcrumbs"><a href="javascript:void(0)"><?php echo $namamatkul.' ('.$kodemk.') '.$kelas;?></a></div>
</div>
<div class="table">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('dosen/simbap/save_presensi'), 'update'=>'#confirm-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
?>
<div id="confirm-column"></div>
<?php
	echo form_hidden('idbap', $idbap);
?>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first" width="40">No.</th><th width="70">NIM</th><th>Nama Mahasiswa</th><th style="width:40px !important" class="last"> &nbsp;Abs</th>
	</tr>
	<?php $n=0; $no=1; foreach($mahasiswaambilmk->result() as $ds):?>
	<tr class="bg">
		<td><?php
				echo $i = $no++;
				echo form_hidden('idpresensimhs_'.$i, $ds->idpresensimhs);
		?></td>
		<td><?php echo $ds->nim?><input type='hidden' name='nim_<?php echo $i?>' value='<?php echo $ds->nim?>'/></td>
		<td class="first"><?php echo $ds->namamhs?></td>
		<td class="last">
			<select name='status_<?php echo $i?>'>
				<option <?php if($ds->status == "H") echo "selected";?> value="H">H</option>
				<option <?php if($ds->status == "A") echo "selected";?> value="A">A</option>
				<option <?php if($ds->status == "I") echo "selected";?> value="I">I</option>
				<option <?php if($ds->status == "S") echo "selected";?> value="S">S</option>
			</select>
		</td>
	</tr>
	<?php $n=$i; endforeach ?>
	<tr>
		<td class="full" style="text-align:right" colspan='4'>
			<input type='hidden' value='<?php echo $n ?>' name='n'/>
			<input type='submit' value="Simpan" name='simpan' onclick="load_submit()" id="simpanNilai"/>
		</td>
	</tr>
</table>
</form>
</div>
<script>
	function load_submit(){
		showloading();
	}
</script>