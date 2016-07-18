<head>
	<script language="javacript">
		function peringatan(){
			alert('Dor');
		}
	</script>
</head>
<body onload="peringatan()">
	<div style="clear:both"></div>
	<div style="color:red;margin:5px auto;padding:10px;
		border:1px dotted red;text-align:center;position:relative;">
		<?php
			if($err == 'dpa_kosong'){
				echo 'Anda Belum Memasukkan Nama Dosen Pembimbing Akademik';
			}elseif($err == 'dpa_kosong'){
				echo 'Jumlah Maksimal SKS Anda Pada Semester Ini Adalah '.$this->session->userdata('sesi_jumgab').' SKS,
				Harap Mengurangi Pengambilan Matakuliah';
			}elseif($err == 'quota_habis'){
				echo 'Quota Matakuliah dengan kode : '.$kodehabis.' Baru Saja Habis, <br />Harap Menghapus Mata
					kuliah tersebut dari daftar. <br />
					Dan untuk selanjutnya, anda dapat mengisi Waiting List Matakuliah di Front Office';
			}
		?>
	</div>
</body>