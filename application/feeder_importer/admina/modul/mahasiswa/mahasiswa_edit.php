

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Mahasiswa
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>mahasiswa">Mahasiswa</a></li>
                        <li class="active">Edit Mahasiswa</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Mahasiswa</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/mahasiswa/mahasiswa_action.php?act=up">
                           <div class="form-group">
                        <label for="NIM" class="control-label col-lg-2">NIM</label>
                        <div class="col-lg-10">
                          <input type="text" value="<?=$data_edit->nipd;?>" name="nipd" placeholder="NIM" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Nama" class="control-label col-lg-2">Nama</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_pd" value="<?=$data_edit->nm_pd;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Kelamin" class="control-label col-lg-2">Jenis Kelamin</label>
                        <div class="col-lg-10">
            <select name="jk" data-placeholder="Pilih Jenis Kelamin ..." class="form-control chzn-select" tabindex="2" >
 <?php
 $stat = array(
  'L' => "Laki - Laki",
  'P' => "Perempuan"
  );
 foreach ($stat as $key => $value) {
    if ($data_edit->jk==$key) {
      echo "<option value='$data_edit->jk' selected>".$value."</option>";
    } else {
      echo "<option value='$key'>".$value."</option>";
    }
 }

?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">Nomor KTP</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="nik" value="<?=$data_edit->nik;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tempat Lahir" class="control-label col-lg-2">Tempat Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" name="tmpt_lahir" value="<?=$data_edit->tmpt_lahir;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir" class="control-label col-lg-2">Tanggal Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl1" data-rule-date="true" name="tgl_lahir" value="<?=$data_edit->tgl_lahir;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Agama" class="control-label col-lg-2">Agama</label>
                        <div class="col-lg-10">
                          <select name="id_agama" data-placeholder="Pilih Agama..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("agama") as $isi) {

                  if ($data_edit->id_agama==$isi->id_agama) {
                    echo "<option value='$isi->id_agama' selected>$isi->nm_agama</option>";
                  } else {
                  echo "<option value='$isi->id_agama'>$isi->nm_agama</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jalan" class="control-label col-lg-2">Jalan</label>
                        <div class="col-lg-10">
                          <input type="text" name="jln" value="<?=$data_edit->jln;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RT" class="control-label col-lg-2">RT</label>
                        <div class="col-lg-10">
                          <input type="text" name="rt" value="<?=$data_edit->rt;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RW" class="control-label col-lg-2">RW</label>
                        <div class="col-lg-10">
                          <input type="text" name="rw" value="<?=$data_edit->rw;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Dusun" class="control-label col-lg-2">Dusun</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_dsn" value="<?=$data_edit->nm_dsn;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kelurahan" class="control-label col-lg-2">Kelurahan</label>
                        <div class="col-lg-10">
                          <input type="text" name="ds_kel" value="<?=$data_edit->ds_kel;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Tinggal" class="control-label col-lg-2">Kecamatan</label>
                        <div class="col-lg-10">
                          <select name="id_wil" data-placeholder="Pilih Kecamatan..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("data_wilayah where id_level_wil=3") as $isi) {
                echo $data_edit->id_wil;

                  if ($data_edit->id_wil==$isi->id_wil) {
                    echo "<option value='$isi->id_wil' selected>$isi->nm_wil</option>";
                  } else {
                  echo "<option value='$isi->id_wil'>$isi->nm_wil</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kodepos" class="control-label col-lg-2">Kodepos</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_pos" value="<?=$data_edit->kode_pos;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Jenis Tinggal" class="control-label col-lg-2">Jenis Tinggal</label>
                        <div class="col-lg-10">
                          <select name="id_jns_tinggal" data-placeholder="Pilih Jenis Tinggal..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenis_tinggal") as $isi) {

                  if ($data_edit->id_jns_tinggal==$isi->id_jns_tinggal) {
                    echo "<option value='$isi->id_jns_tinggal' selected>$isi->nm_jns_tinggal</option>";
                  } else {
                  echo "<option value='$isi->id_jns_tinggal'>$isi->nm_jns_tinggal</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Telepon" class="control-label col-lg-2">Telepon</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="telepon_rumah" value="<?=$data_edit->telepon_rumah;?>" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="HP" class="control-label col-lg-2">HP</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="telepon_seluler" value="<?=$data_edit->telepon_seluler;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-2">Email</label>
                        <div class="col-lg-10">
                          <input type="text"  data-rule-email="true" name="email" value="<?=$data_edit->email;?>" class="form-control" required> 
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
                if ($isi->id_jns_daftar==$data_edit->id_jns_daftar) {
                  echo "<option value='$isi->id_jns_daftar' selected>$isi->nm_jns_daftar</option>";
                }
                  echo "<option value='$isi->id_jns_daftar'>$isi->nm_jns_daftar</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Masuk Kuliah" class="control-label col-lg-2">Tanggal Masuk Kuliah</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl3" data-rule-date="true" value="<?=$data_edit->tgl_masuk_sp;?>" name="tgl_masuk_sp" placeholder="Tanggal Masuk Kuliah" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Mulai Semester" class="control-label col-lg-2">Mulai Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="mulai_smt" placeholder="contoh (20091)" value="<?=$data_edit->mulai_smt;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Status" class="control-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                         <select name="stat_pd" data-placeholder="Pilih Status ..." class="form-control chzn-select" tabindex="2" required>
 <?php
 $stat = array(
  'A' => "Aktif",
  'C' => "Cuti",
  'D' => "Drop Out",
  'K' => "Keluar",
  'L' => "Lulus",
  'N' => "Non-aktif"
  );
 foreach ($stat as $key => $value) {
    if ($data_edit->status_kuliah==$key) {
      echo "<option value='$data_edit->status_kuliah' selected>".$value."</option>";
    } else {
      echo "<option value='$key'>".$value."</option>";
    }
 }

?>
</select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Ayah" class="control-label col-lg-2">Nama Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_ayah" value="<?=$data_edit->nm_ayah;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ayah" class="control-label col-lg-2">Tanggal Lahir Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl5" name="tgl_lahir_ayah" value="<?=$data_edit->tgl_lahir_ayah;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ayah" class="control-label col-lg-2">Pendidikan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_ayah" data-placeholder="Pilih Pendidikan Ayah..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {

                  if ($data_edit->id_jenjang_pendidikan_ayah==$isi->id_jenj_didik) {
                    echo "<option value='$isi->id_jenj_didik' selected>$isi->nm_jenj_didik</option>";
                  } else {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ayah" class="control-label col-lg-2">Pekerjaan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_ayah" data-placeholder="Pilih Pekerjaan Ayah..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {

                  if ($data_edit->id_pekerjaan_ayah==$isi->id_pekerjaan) {
                    echo "<option value='$isi->id_pekerjaan' selected>$isi->nm_pekerjaan</option>";
                  } else {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ayah" class="control-label col-lg-2">Penghasilan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_ayah" data-placeholder="Pilih Penghasilan Ayah..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {

                  if ($data_edit->id_penghasilan_ayah==$isi->id_penghasilan) {
                    echo "<option value='$isi->id_penghasilan' selected>$isi->nm_penghasilan</option>";
                  } else {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Ibu" class="control-label col-lg-2">Nama Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_ibu_kandung" value="<?=$data_edit->nm_ibu_kandung;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ibu" class="control-label col-lg-2">Tanggal Lahir Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl2" data-rule-date="true" name="tgl_lahir_ibu" value="<?=$data_edit->tgl_lahir_ibu;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ibu" class="control-label col-lg-2">Pendidikan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_ibu" data-placeholder="Pilih Pendidikan Ibu..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {

                  if ($data_edit->id_jenjang_pendidikan_ibu==$isi->id_jenj_didik) {
                    echo "<option value='$isi->id_jenj_didik' selected>$isi->nm_jenj_didik</option>";
                  } else {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ibu" class="control-label col-lg-2">Penghasilan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_ibu" data-placeholder="Pilih Penghasilan Ibu..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {

                  if ($data_edit->id_penghasilan_ibu==$isi->id_penghasilan) {
                    echo "<option value='$isi->id_penghasilan' selected>$isi->nm_penghasilan</option>";
                  } else {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ibu" class="control-label col-lg-2">Pekerjaan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_ibu" data-placeholder="Pilih Pekerjaan Ibu..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {

                  if ($data_edit->id_pekerjaan_ibu==$isi->id_pekerjaan) {
                    echo "<option value='$isi->id_pekerjaan' selected>$isi->nm_pekerjaan</option>";
                  } else {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="nm_wali" class="control-label col-lg-2">nm_wali</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_wali" value="<?=$data_edit->nm_wali;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Wali" class="control-label col-lg-2">Tanggal Lahir Wali</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl4" data-rule-date="true" name="tgl_lahir_wali" value="<?=$data_edit->tgl_lahir_wali;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenjang Pendidikan" class="control-label col-lg-2">Jenjang Pendidikan Wali </label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_wali" data-placeholder="Pilih Jenjang Pendidikan..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {

                  if ($data_edit->id_jenjang_pendidikan_wali==$isi->id_jenj_didik) {
                    echo "<option value='$isi->id_jenj_didik' selected>$isi->nm_jenj_didik</option>";
                  } else {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan" class="control-label col-lg-2">Pekerjaan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_wali" data-placeholder="Pilih Pekerjaan..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {

                  if ($data_edit->id_pekerjaan_wali==$isi->id_pekerjaan) {
                    echo "<option value='$isi->id_pekerjaan' selected>$isi->nm_pekerjaan</option>";
                  } else {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan" class="control-label col-lg-2">Penghasilan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_wali" data-placeholder="Pilih Penghasilan..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {

                  if ($data_edit->id_penghasilan_wali==$isi->id_penghasilan) {
                    echo "<option value='$isi->id_penghasilan' selected>$isi->nm_penghasilan</option>";
                  } else {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
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
        
 