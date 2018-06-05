<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function setujui(){
			showloading();
		}
		function changeThajaran(){
			showloading();
			var selected_thajaran = $('select[name=thajaran]').val();
			load('prodi/nilai/change_thajarankhs2/'+selected_thajaran, '#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<h1>Rekap KHS</h1>
	Tahun Ajaran
		<select name='thajaran' style="width:auto;" onchange='changeThajaran()'>
			<?php foreach($browse_thajaran as $bt){ ?>
			<option <?php if($thajaran == $bt->thajaran) echo 'selected'?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
			<?php } ?>
		</select>
	<?php echo anchor('prodi/nilai/cetak_rekap_khs', 'Preview', array('style'=>'margin:0 -32px 0', 'class'=>'navi print-button', 'target'=>'_blank'))?>
</div>
