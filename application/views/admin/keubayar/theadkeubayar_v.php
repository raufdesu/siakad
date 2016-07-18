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
	function ChangeThajaran(){
		var selected_thajaran = $('select[name=thajaran]').val();
		load('admin/keubayar/change_thajaran3/'+selected_thajaran,'#detail-transkrip');
	}
</script>
<div id="noprint">
<div class="top-bar-adm">
	<h1>Pembayaran</h1>
	<div class="breadcrumbs"><a href="#"><?php echo $title?></a></div>
</div>
<div class="select-bar">
	<div style="float: right">
		<b>Tahun Ajaran</b>
		<select name="thajaran" onchange="ChangeThajaran()">
		<?php foreach($browse_thajaran as $bt):?>
			<option <?php if($thajaran == $bt->thajaran) echo 'selected'; ?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
		<?php endforeach; ?>
		</select>
	</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/keubayar/detail_bynim'), 'update'=>'#detail-transkrip', 'name'=>'cari', 'id'=>'maspegawai', 'type'=>'post'));
?>
	<div>
		<b>NIM Mahasiswa</b>
		<input type="text" size="8" name="txtNimMhs" id="nim" />
		<input type="submit" value="OK" />
	</div>
<?php echo form_close()?>
</div>
</div>
<div id="detail-transkrip"><center>
<h3 style="padding: 10px; margin: 10px; border: 1px dotted #ABABAB;">Ketikkan NIM untuk melihat pembayaran mahasiswa</h3></center></div>
<script>
	function cekkosong(){
		if(document.getElementById('nim').value == false){
			alert('PERINGATAN\nNIM masih kosong, Harap mengisi NIM terlebih dahulu sebelum melakukan pencetakan');
			document.getElementById('nim').focus();
			return false;
		}
	}
</script>