<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
</head>
<?php
	echo "Selamat Datang ".$this->session->userdata('sesi_nama_mhs');
?>