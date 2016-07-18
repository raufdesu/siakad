<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	});
</script>
<script>
	function get_bythajaran(){
		showloading();
		var selected_thajaran = $('select[name=thajaran]').val();
		load('admin/nilai/change_thajarankhs/'+selected_thajaran,'#detail-transkrip');
	}
	function preview(){
		cekkosong();
		show("admin/nilai/cetak_khs", "#detail-transkrip");
	}
</script>
<div id="noprint">
<div class="top-bar-adm">
	<div style='float:right'>
		<!--<a href='javascript:void(0)' class='button' onclick='return preview()'>Preview</a>-->
	</div>
	<h1>KHS Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#"><?php echo $title?></a></div>
</div>
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/nilai/cari_browse_khs'), 'update'=>'#detail-transkrip', 'name'=>'cari', 'id'=>'maspegawai',	'type'=>'post'));
?>
	<div style="float: right">
		<b>Tahun Ajaran</b>
		<select name="thajaran" onchange="get_bythajaran()" style="width:auto">
			<?php foreach($browse_thajar as $bt):?>
			<option value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div>
		<b>NIM Mahasiswa</b>
		<input type="text" size="12" name="txtNimMhs" id="nim" />
		<input type="submit" value="OK" onclick="return cekkosong()" />
	</div>
<?php echo form_close()?>
</div>
</div>
<div id="detail-transkrip"><center><h3 style="padding: 10px; margin: 10px; border: 1px dotted #ABABAB;">Masukkan NIM untuk melihat KHS Mahasiswa</h3></center></div>
<script>
	function cekkosong(){
		if(document.getElementById('nim').value == false){
			alert('PERINGATAN\nNIM masih kosong,\nHarap mengisi NIM terlebih dahulu sebelum melakukan pencetakan');
			document.getElementById('nim').focus();
			return false;
		}else{
			showloading();
		}
	}
</script>