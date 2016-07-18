<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	});
</script>
<script>
	function get_bythajaran(){
		var selected_thajaran = $('select[name=thajaran]').val();
		load('admin/nilai/change_thajarankhs/'+selected_thajaran,'#detail-transkrip');
	}
</script>
<div id="noprint">
<div class="top-bar-adm">
<?php
	$atr = array(
		'class' => 'navi button',
		'target' => '_blank',
		'onclick' => 'return cekkosong()'
	);
	echo anchor('admin/nilai/transkrip_excel', 'Export to Excel', $atr);
	/*echo anchor('admin/nilai/cetak_khs', 'Cetak', $atr);*/
?>
	<h1>Nilai Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#"><?php echo $title?></a></div>
</div>
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/nilai/cari_nimtranskrip'), 'update'=>'#detail-transkrip', 'name'=>'cari', 'id'=>'maspegawai', 'type'=>'post'));
?>
	<div>
		<b>NIM Mahasiswa</b>
		<input type="text" size="8" name="txtNimMhs" id="nim" />
		<input type="submit" onclick="return cekkosong()" value="OK" />
	</div>
<?php echo form_close()?>
</div>
</div>
<div id="detail-transkrip"><center>
<h3 style="padding: 10px; margin: 10px; border: 1px dotted #ABABAB;">Masukkan NIM untuk melihat Nilai Keseluruhan Mahasiswa</h3></center></div>
<script>
	function cekkosong(){
		if(document.getElementById('nim').value == false){
			alert('PERINGATAN\nNIM masih kosong, Harap mengisi NIM terlebih dahulu.');
			document.getElementById('nim').focus();
			return false;
		}
	}
</script>