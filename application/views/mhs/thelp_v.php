<html>
<head>
	<title>Help SIMAK</title>
	<script>
		$(document).ready(function(){
			stoploading();
		})
	</script>
	<style>
	#fieldset{border:1px solid silver;padding:10px 10px 10px 10px;margin:10px 10px 10px 10px;}
	#fieldset legend{padding:5px 10px 5px 10px;border:1px solid silver;font-weight:bold;font-size:13px;}	
	#linkpower{float:right;}	
	#linkpower a{font-weight:bold;font-size:13px;color:red;float:right;}	
	</style>
</head>
<body>
<fieldset id="fieldset">
	<legend>Input KRS (Kartu Rencana Studi)</legend>
	Berikut ini adalah langkah-langkah untuk melakukan key-in/input KRS.<br />
	<ol>
	<li>Download terlebih dahulu <b>Daftar matakuliah tawaran</b> pada semester yang
	akan berjalan melalui link download seperti gambar dibawah ini.<br />
	<?php echo img('asset/manual/images/link-download-tawar.jpg')?>
	</li>
	<li>
		Ketikkan kode matakuliah yang akan anda ambil pada kolom input seperti gambar dibawah ini
		(Kode matakuliah dapat dilihat pada file yang anda download di langkah 1 diatas).<br />
		<?php echo img('manual/images/input-kodemk.jpg')?>
		Pilih pilihan <b>Baru</b>jika anda belum pernah mengambil matakuliah tersebut, dan pilih
		<b>Mengulang</b> jika pernah mengambil. Tekan tombol <b>Tambah</b> untuk menyimpan ke list
		daftar matakuliah yang diambil.
	</li>
	<li>
		Tekan tombol <b>Simpan dan Lanjutkan</b> untuk menyimpan data yang anda masukkan.
	</li>
	<li>
		Setelah data tersimpan, selanjutnya halaman yang muncul adalah halaman pencetakan KRS.
		<img src='<?php echo base_url()?>asset/manual/images/krs-prev1.jpg' width='500'><br />
		Pada pencetakan KRS ini, ada 2 cara/langkah untuk melakukan pencetakan, <br />
		<ul>
		<li><b>Print preview</b> menggunakan fasilitas browser anda terlebih dahulu halaman ini. Jika telah sesuai, tekan
			tombol print yang disediakan oleh browser anda. Namu jika blm sesuai(posisi halaman terlalu besar atau kecil)
			Sesuaikan terlebih dahulu posisinya, dan tekan tombol print untuk mencetaknya.</li>
		<li>Atau Langsung tekan tombol <b>cetak</b> pada pojok kanan halaman ini.</li>
		</ul>
	</li>
	</ol>
</fieldset>
<!--<div id='linkpower'>Powered by&nbsp;<a href="http://craftanddesigns.com/about/profil" target="_blank">Alphatih</a></div>-->
</body>
</html>