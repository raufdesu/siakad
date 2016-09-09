
           
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Mahasiswa
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>mahasiswa">Mahasiswa</a></li>
                        <li class="active">Tambah Mahasiswa</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12"> 
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah Mahasiswa</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/mahasiswa/mahasiswa_action.php?act=in">
                     <div class="form-group">
                        <label for="NIM" class="control-label col-lg-2">NIM</label>
                        <div class="col-lg-10">
                          <input type="text" name="nipd" placeholder="NIM" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Nama" class="control-label col-lg-2">Nama</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_pd" placeholder="Nama" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Kelamin" class="control-label col-lg-2">Jenis Kelamin</label>
                        <div class="col-lg-10">
            <select name="jk" data-placeholder="Pilih Jenis Kelamin ..." class="form-control chzn-select" tabindex="2" >
               <option value="L">Laki - Laki</option>
               <option value="P">Perempuan</option>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">Nomor KTP</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="nik" placeholder="Nomor KTP" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tempat Lahir" class="control-label col-lg-2">Tempat Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" name="tmpt_lahir" placeholder="Tempat Lahir" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir" class="control-label col-lg-2">Tanggal Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl1" data-rule-date="true" name="tgl_lahir" placeholder="Tanggal Lahir" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Agama" class="control-label col-lg-2">Agama</label>
                        <div class="col-lg-10">
                          <select name="id_agama" data-placeholder="Pilih Agama ..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("agama") as $isi) {
                  echo "<option value='$isi->id_agama'>$isi->nm_agama</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jalan" class="control-label col-lg-2">Jalan</label>
                        <div class="col-lg-10">
                          <input type="text" name="jln" placeholder="Jalan" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RT" class="control-label col-lg-2">RT</label>
                        <div class="col-lg-10">
                          <input type="text" name="rt" placeholder="RT" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RW" class="control-label col-lg-2">RW</label>
                        <div class="col-lg-10">
                          <input type="text" name="rw" placeholder="RW" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Dusun" class="control-label col-lg-2">Dusun</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_dsn" placeholder="Dusun" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kelurahan" class="control-label col-lg-2">Kelurahan</label>
                        <div class="col-lg-10">
                          <input type="text" name="ds_kel" placeholder="Kelurahan" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kodepos" class="control-label col-lg-2">Kodepos</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_pos" placeholder="Kodepos" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Tinggal" class="control-label col-lg-2">Jenis Tinggal</label>
                        <div class="col-lg-10">
                          <select name="id_jns_tinggal" data-placeholder="Pilih Jenis Tinggal ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenis_tinggal") as $isi) {
                  echo "<option value='$isi->id_jns_tinggal'>$isi->nm_jns_tinggal</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Telepon" class="control-label col-lg-2">Telepon</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="telepon_rumah" placeholder="Telepon" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="HP" class="control-label col-lg-2">HP</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="telepon_seluler" placeholder="HP" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-2">Email</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-email="true" name="email" placeholder="Email" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <select name="kode_jurusan" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" >
                                 <?php 
if ($_SESSION['level']==1) {
  $jur = $db->fetch_custom("select * from jurusan");
} else {
  $jur = $db->fetch_custom("select * from jurusan where kode_jurusan='".$_SESSION['jurusan']."'");
}
foreach ($jur as $isi) {

                  if ($id_jur==$isi->kode_jurusan) {
                    echo "<option value='$isi->kode_jurusan' selected>$isi->nama_jurusan</option>";
                  } else {
                     echo "<option value='$isi->kode_jurusan'>$isi->nama_jurusan</option>";
                  }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Pendaftaran" class="control-label col-lg-2">Jenis Pendaftaran</label>
                        <div class="col-lg-10">
                          <select name="id_jns_daftar" data-placeholder="Pilih Jenis Pendaftaran ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenis_pendaftaran") as $isi) {
                  echo "<option value='$isi->id_jns_daftar'>$isi->nm_jns_daftar</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Masuk Kuliah" class="control-label col-lg-2">Tanggal Masuk Kuliah</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl3" data-rule-date="true" name="tgl_masuk_sp" placeholder="Tanggal Masuk Kuliah" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Mulai Semester" class="control-label col-lg-2">Mulai Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="mulai_smt" placeholder="contoh (20091)" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Status" class="control-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                                                 <select name="stat_pd" id="Status"  class="form-control" tabindex="2" required>
               <option value="A">Aktif</option>
               <option value="C">Cuti</option>
               <option value="D">Drop Out</option>
                <option value="K">Keluar</option>
                 <option value="L">Lulus</option>
                 <option value="N">Non-aktif</option>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Ayah" class="control-label col-lg-2">Nama Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_ayah" placeholder="Nama Ayah" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ayah" class="control-label col-lg-2">Tanggal Lahir Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl5" name="tgl_lahir_ayah" placeholder="Tanggal Lahir Ayah" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ayah" class="control-label col-lg-2">Pendidikan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_ayah" data-placeholder="Pilih Pendidikan Ayah ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ayah" class="control-label col-lg-2">Pekerjaan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_ayah" data-placeholder="Pilih Pekerjaan Ayah ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ayah" class="control-label col-lg-2">Penghasilan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_ayah" data-placeholder="Pilih Penghasilan Ayah ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Ibu" class="control-label col-lg-2">Nama Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_ibu_kandung" placeholder="Nama Ibu" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ibu" class="control-label col-lg-2">Tanggal Lahir Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl2" data-rule-date="true" name="tgl_lahir_ibu" placeholder="Tanggal Lahir Ibu" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ibu" class="control-label col-lg-2">Pendidikan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_ibu" data-placeholder="Pilih Pendidikan Ibu ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ibu" class="control-label col-lg-2">Penghasilan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_ibu" data-placeholder="Pilih Penghasilan Ibu ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ibu" class="control-label col-lg-2">Pekerjaan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_ibu" data-placeholder="Pilih Pekerjaan Ibu ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="nm_wali" class="control-label col-lg-2">Nama Wali</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_wali" placeholder="Nama Wali" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Wali" class="control-label col-lg-2">Tanggal Lahir Wali</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl4" data-rule-date="true" name="tgl_lahir_wali" placeholder="Tanggal Lahir Wali" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenjang Pendidikan" class="control-label col-lg-2">Jenjang Pendidikan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_wali" data-placeholder="Pilih Jenjang Pendidikan ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan" class="control-label col-lg-2">Pekerjaan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_wali" data-placeholder="Pilih Pekerjaan ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan" class="control-label col-lg-2">Penghasilan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_wali" data-placeholder="Pilih Penghasilan ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->


                      
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <input type="submit" class="btn btn-primary btn-flat" value="submit">
                        </div>
                      </div><!-- /.form-group -->
                    </form>
 <a onclick="window.history.back(-1)" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
            