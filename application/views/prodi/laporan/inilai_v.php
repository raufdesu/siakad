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
			load('prodi/nilai/change_thajarankhs3/'+selected_thajaran, '#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<h1>Pengisian Nilai Massal</h1>
	<B>LANGKAH PERTAMA		: Download data nilai berdasarkan tahun ajaran </B><br><br>
	Tahun Ajaran
		<select name='thajaran' style="width:auto;" onchange='changeThajaran()'>
			<?php foreach($browse_thajaran as $bt){ ?>
			<option <?php if($thajaran == $bt->thajaran) echo 'selected'?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
			<?php } ?>
		</select>
	<?php echo anchor('prodi/nilai/cetak_rekap_nilai', 'Preview', array('style'=>'margin:0 -32px 0', 'class'=>'navi print-button', 'target'=>'_blank'))?>
	
	<br><br><br><B>LANGKAH KEDUA		: Isi kolom nilai angka di file excel yang di download sebelumnya. Untuk nilai huruf akan menyeseuaikan 
	dengan skala nilai masing-masing prodi<br><br>
	LANGKAH KETIGA						: upload file excel yang sudah diisikan nilai
</div>
