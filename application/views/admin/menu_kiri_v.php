<?php if($this->session->userdata('sesi_status') != 'keuangan'){ ?>
<h3>Menu Akademik</h3>
<ul class="nav">
<?php if($this->session->userdata('sesi_status') == 'operator'){ ?>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simdosenampu","#center-column")'>Dosen Ampu</a></li>
	<?php } ?>
<?php if($this->session->userdata('sesi_status') == 'admin'){ ?>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simkrs/awal_input","#center-column")'>KRS Mahasiswa</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simaktifsemester","#center-column")'>Aktif Semester</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simaktifksp","#center-column")'>Aktif KSP</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simdosenampu","#center-column")'>Dosen Ampu</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/paket","#center-column")'>Matakuliah Paket</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simmktawar","#center-column")'>Matakuliah Tawar</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/nilai","#center-column")'>Data Nilai</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simmatrikulasi","#center-column")'>Konversi Nilai</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simtranskrip/awal_yudisium","#center-column")'>Yudisium Semester</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simupload","#center-column")'>Upload File</a></li>
</ul>
<h3>Pengaturan</h3>
<ul class="nav">
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simdosenwali","#center-column")'>Dosen Pembimbing Akademik</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/kelaspaket","#center-column")'>Kelas Paket</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simruang","#center-column")'>Data Ruangan</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simsetting","#center-column")'>Setting SIAKAD</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/feeder","#center-column")'>Setting Akun Feeder</a></li>
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/importold","#center-column")'>Import from Old Data</a></li-->
	<!--<li class=""><a href="<?php echo base_url().'application/feeder_importer/admina/index.php';?>" target="_blank">Export Ke PDPT</a></li>-->
	<li class=""><a href="javascript:void(0)" onclick='show("admin/login/index_browse","#center-column")'>Pengelolaan Akun</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/login/gantipassword/","#center-column")'>Ganti Password</a></li>
	<?php }elseif($this->session->userdata('sesi_status') == 'dosen'){ ?>
	<!--<li class=""><a href="javascript:void(0)" onclick='alert("KONFIRMASI\nLagi Dikembangkan, So : Ishbiru Wa Shobiru.")'>Update Status</a></li>-->
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/nilai","#center-column")'>Matakuliah Ampuan</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/simdosenwali/","#center-column")'>Dosen Pembimbing Akademik</a></li>
	<!--<li class=""><a href="javascript:void(0)" onclick='show("dosen/simdaftarskripsi/","#center-column")'>Pembimbing KP/TA/Skripsi</a></li>-->
	<!--<li class=""><a href="javascript:void(0)" onclick='show("dosen/nilai/khs/","#center-column")'>KHS Mahasiswa</a></li>-->
	<!--<li class=""><a href="javascript:void(0)" onclick='show("dosen/simdaftarskripsi/mhsbimbingan","#center-column")' title="Pembimbing Skripsi dan TA">Mhs. Bimbingan</a></li>-->
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/maspegawai/biodata","#center-column")'>Biodata</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/login/gantipassword/","#center-column")'>Ganti Password</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/simupload/","#center-column")'>Panduan & Download</a></li>
	<!--<li class=""><a href="</?php echo base_url()?>asset/upload/help/Panduan-simak-dosen.docx">? Panduan</a></li>-->
<?php }elseif($this->session->userdata('sesi_status') == 'prodi'){ ?>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/simaktifsemester/","#center-column")'>Aktif Semester</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/simmktawar","#center-column")'>Matakuliah Tawar</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/simkrs/awal_input","#center-column")'>KRS Mahasiswa</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/nilai/khs","#center-column")'>K H S</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/nilai/transkrip","#center-column")'>Transkrip Nilai</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/simmatrikulasi","#center-column")'>Matrikulasi</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/simdosenampu","#center-column")'>Dosen Ampu</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/simmktawar/presensi","#center-column")'>Kelas Mahasiswa</a></li>
    <li class=""><a href="javascript:void(0)" onclick='show("keuangan/keubiaya/index_daftar_pembayaran_prodi","#center-column")'>Daftar Pembayaran</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/login/gantipassword/","#center-column")'>Ganti Password</a></li>
	<!--<li class=""><a href="javascript:void(0)" onclick='show("prodi/simdaftarskripsi","#center-column")'>Pendaftar KP/TA/Skripsi</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("prodi/simdaftarskripsi/browse_sk","#center-column")'>Surat Keputusan</a></li>-->
	<?php } ?>
</ul>
<?php if($this->session->userdata('sesi_status') == 'admin'){ ?>
<!--<h3>MAHASISWA</h3>
<ul class="nav">
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simtranskrip/awal_yudisium","#center-column")'>Yudisium Semester</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simdaftarskripsi","#center-column")'>KP/TA/Skripsi</a></li>-->
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/simdaftarbeasiswa","#center-column")'>Beasiswa</a></li>-->
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/maskegiatan/","#center-column")' title='Daftar Kegiatan Mahasiswa'>Kegiatan Mhasiswa</a></li>-->
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/simcalonmhs","#center-column")'>Calon Mahasiswa</a></li>-->
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/masalumni","#center-column")'>Data Alumni</a></li>-->
<!--</ul>-->
<h3>Laporan</h3>
<ul class="nav">
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simmktawar/presensi","#center-column")'>Kelas Mahasiswa</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/simtranskrip/header","#center-column")'>Transkrip Nilai</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/nilai/khs","#center-column")'>K H S</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("admin/nilai/transkrip","#center-column")'>Nilai Keseluruhan</a></li>
</ul>
<?php } ?>
<?php } ?>
<?php if($this->session->userdata('sesi_status') == 'keuangan'){ ?>
<h3>Menu Keuangan</h3>
<ul class="nav">
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/simaktifsemester","#center-column")'>Aktif Semester</a></li>-->
	<li class=""><a href="javascript:void(0)" onclick='show("keuangan/keubiaya","#center-column")'>Form Pembayaran</a></li>
	<li class=""><a href="javascript:void(0)" onclick='show("keuangan/keubiaya/index_daftar_pembayaran","#center-column")'>Daftar Pembayaran</a></li>
	<!--<li class=""><a href="javascript:void(0)" onclick='show("keuangan/keubiaya","#center-column")'>Atur Persiswa</a></li>-->
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/simcalonmhs/pembayaran","#center-column")'>Bayar Pendaftaran</a></li>-->
	<li class=""><a href="javascript:void(0)" onclick='show("keuangan/keuaturbiaya","#center-column")'>Pengaturan Biaya</a></li>
	<!--<li class=""><a href="javascript:void(0)" onclick='show("admin/biayadaftar","#center-column")'>Atur Biaya Daftar</a></li>-->
	<li class=""><a href="javascript:void(0)" onclick='show("dosen/login/gantipassword/","#center-column")'>Ganti Password</a></li>
</ul>
<?php } ?>
<!--<h3>UTILITY</h3>
<ul class="nav">
	<li class=""><a href="javascript:void(0)" onclick='show("admin/login/gantipassword/","#center-column")'>Ganti Password</a></li>
</ul>-->
<!--<a href="#" class="link">Link here</a>
<a href="#" class="link">Link here</a>-->