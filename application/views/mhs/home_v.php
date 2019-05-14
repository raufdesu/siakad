<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
</head>
<?php
	echo "Selamat Datang ".$this->session->userdata('sesi_nama_mhs')."<br><br><br>";
	
	echo "Petunjuk penggunaan SIAKAD dapat di download <a href='/siakad/asset/upload/PANDUAN_SIAKAD.pdf'><font color='red'>Disini</font></a>";
?>