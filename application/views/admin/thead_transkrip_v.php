<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<?php $inner = "<div class='samar'></div>"?>
<script type="text/javascript">
	$(document).ready(function() {
	stoploading();
</script>
<div class="top-bar-adm">
<?php
	/*$atr = array(
		'class' => 'navi button',
		'target' => '_blank'
	);
	echo anchor('admin/simtranskrip/cetak', 'Cetak', $atr);*/
?>
<div style="float:right;margin-right:-32px;">
	<a href="javascript:void(0)" class='button' onclick='load_into_box("admin/simdetailyudisium/pracetak");'>Cetak</a>
	<a href="javascript:void(0)" class='button' onclick='show("admin/simyudisium/","#center-column")'>No. Yudisium</a>
</div>
	<h1>Transkrip Nilai Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#">Daftar Transkrip Nilai Mahasiswa</a></div>
</div>
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simtranskrip/index_browse'), 'update'=>'#detail-transkrip', 'name'=>'cari', 'id'=>'maspegawai',	'type'=>'post'));
?>
	<div style="float:right"><input type="checkbox" name="bythajaran" value="1" /> Berdasarkan Th. Ajaran</div>
	<div>
		<b>NIM Mahasiswa</b>
		<input type="text" size="12" name="txtNimMhs" />
		<input type="submit" value="OK" />
	</div>
</form>
</div>
<div id="detail-transkrip"></div>