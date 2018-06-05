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
			load('prodi/simkrs/change_thajarankrs/'+selected_thajaran, '#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<h1>Rekap KRS</h1>
	Tahun Ajaran
		<select name='thajaran' style="width:auto;" onchange='changeThajaran()'>
			<?php foreach($browse_thajaran as $bt){ ?>
			<option <?php if($thajaran == $bt->thajaran) echo 'selected'?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
			<?php } ?>
		</select>
	<?php echo anchor('prodi/simkrs/cetak_rekap_krs', 'Preview', array('style'=>'margin:0 -32px 0', 'class'=>'navi print-button', 'target'=>'_blank'))?>
</div>
<script language="javascript">
	function tanya(id){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("keuangan/keubiaya/delete/" + id, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>