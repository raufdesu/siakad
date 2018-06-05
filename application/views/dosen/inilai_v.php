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
	<div style="float:right;margin-right:-32px;">
		<!--<select name="cbkelas" onchange="submitGantiKelas()">
			<option </?php if($this->session->userdata('sesi_kelas') == '1') echo 'selected'; ?> value="1">Reguler</option>
			<option </?php if($this->session->userdata('sesi_kelas') == '2') echo 'selected'; ?> value="2">Malam</option>
		</select>-->
		<a href="javascript:void(0)" class='button' onclick='show("dosen/nilai","#center-column")'>Back</a>
		<?php echo anchor('dosen/nilai/export/xls', 'Excel', array('class'=>'button'))?>
	</div>
	<h1>Daftar Mahasiswa Pengambil Matakuliah</h1>
	<div class="breadcrumbs"><a href="javascript:void(0)"><?php echo $namamatkul.' ('.$kodemk.') '.$kelas;?></a></div>
</div>
<div class="table">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('dosen/nilai/save'), 'update'=>'#confirm-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
?>
<div id="confirm-column"></div>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">No.</th><th>NIM</th><th>Nama Mahasiswa</th><th>Nilai (angka)</th><th width="41" class="last">Nilai</th>
	</tr>
	<?php
		$bg = '';
		$no=1;
		foreach($browse_mahasiswaambilmk->result() as $ds):
		$i = $no++;
		if($i % 2 == 0){
			$bg = 'bg';
		}else{
			$bg = '';
		}
		$jum = 0;
	?>
	<tr class="<?php echo $bg?>">
		<td><?php echo $i?></td>
		<td><?php echo $ds->nim?><input type='hidden' name='nim_<?php echo $i?>' value='<?php echo $ds->nim?>' id='nim_'/></td>
		<td class="first"><?php echo $this->auth->get_namamhsbynim($ds->nim)?></td>
		<td class="first"><input type='text' name='nilai_angka_<?php echo $i?>' value='<?php echo $ds->nilaiangka?>' id='nilai_angka_<?php echo $i?>'/></td>
		<td id='nilai_huruf_<?php echo $i?>'><input type='text' name='nilai_huruf_<?php echo $i?>' readonly style='float:left' value='<?php echo $ds->nilaihuruf?>' size='5'/></td>
		<input type='hidden' value='<?php echo $i ?>' name='i'/>
	
	</tr>
	<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
		
		$('#nilai_angka_<?php echo $i?>').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			autoFill: true,
			innerText: 'nilai',
			minimumSearchLength: 1
		});
		
		$("#nilai_angka_<?php echo $i?>").val('<?php echo $ds->nilaiangka?>');
		$("#nim").val('<?php echo $this->session->userdata('sesi_nim'); ?>');
		$("#nilai_angka_<?php echo $i?>").focus();
		
		
	});
	function searchFunction(str){
		showloading();
		load('dosen/nilai/cari_nilai_angka/'+str,'#nilai_huruf_<?php echo $i?>');
		stoploading();

	}
</script>
	<?php $n=$i; endforeach ?>
	<tr>
		<td style="text-align:right" class="last" colspan='5'>
			<input type='hidden' value='<?php echo $n ?>' name='n'/>
			<input type='submit' value="Simpan" name='simpan' onclick="load_submit()" id="simpanNilai"/>
		</td>
	</tr>
</table>
</form>
</div>