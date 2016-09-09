<?php
session_start();
include "../../inc/config.php";

  /** PHPExcel_IOFactory */
require_once '../../lib/PHPExcel/IOFactory.php';

session_check();
switch ($_GET["act"]) {
  case 'import':
     if (!is_dir("../../../upload/mahasiswa")) {
              mkdir("../../../upload/mahasiswa");
            }


   if (!preg_match("/.(xls|xlsx)$/i", $_FILES["semester"]["name"]) ) {

              echo "pastikan file yang anda pilih xls|xlsx";
              exit();

            } else {
              move_uploaded_file($_FILES["semester"]["tmp_name"], "../../../upload/mahasiswa/".$_FILES['semester']['name']);
              $semester = array("semester"=>$_FILES["semester"]["name"]);

            }


      $objPHPExcel = PHPExcel_IOFactory::load("../../../upload/mahasiswa/".$_FILES['semester']['name']);

  $data = $objPHPExcel->getActiveSheet()->toArray();
      $error_count = 0;
      $error = array();
      $sukses = 0;

foreach ($data as $key => $val) {

    if ($key>0) {

      if ($val[0]!='') {
          
              $check = $db->check_exist('mhs_pt',array('nipd' => filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)));
                if ($check==true) {
                  $error_count++;
                  $error[] = $val[0]." ".$val[1]." Sudah Ada";
                } else {
                  $sukses++;

                $data = array(
                        'nm_pd'      => filter_var($val[1], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'tmpt_lahir' => filter_var($val[2], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'tgl_lahir'  => filter_var($val[3], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'jk'         => filter_var($val[4], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'id_agama'   => filter_var($val[5], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        'id_kk'      => filter_var($val[6], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "jln"        => filter_var($val[10], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "rt"         => filter_var($val[11], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "rw"         => filter_var($val[12], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "nm_dsn"     => filter_var($val[13], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "ds_kel"     => filter_var($val[14], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_wil"     => filter_var($val[15], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "kode_pos"   => filter_var($val[16], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_jns_tinggal"      => filter_var($val[17], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "telepon_rumah"       => filter_var($val[18], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "telepon_seluler"     => filter_var($val[19], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "email"               => filter_var($val[20], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "a_terima_kps"        => filter_var($val[21], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "no_kps"              => filter_var($val[22], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "stat_pd"             => filter_var($val[23], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "nm_ayah"             => filter_var($val[24], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "tgl_lahir_ayah"      => filter_var($val[25], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_jenjang_pendidikan_ayah" => filter_var($val[26], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_pekerjaan_ayah"   => filter_var($val[27], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_penghasilan_ayah" => filter_var($val[28], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "nm_ibu_kandung"      => filter_var($val[29], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "tgl_lahir_ibu"       => filter_var($val[30], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_jenjang_pendidikan_ibu" => filter_var($val[31], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                         "id_pekerjaan_ibu"    => filter_var($val[32], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_penghasilan_ibu"  => filter_var($val[33], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "nm_wali"             => filter_var($val[34], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "tgl_lahir_wali"      => filter_var($val[35], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_jenjang_pendidikan_wali" => filter_var($val[36], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_pekerjaan_wali"   => filter_var($val[37], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                        "id_penghasilan_wali" => filter_var($val[38], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)
                       
                );

               
                  $in = $db->insert('mhs',$data);

                  $last_id = $db->get_last_id();

                       $data_mhs_pt = array(
                  'nipd' => filter_var($val[0], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                  'kode_jurusan' => $_POST['jurusan'],
                  'id_mhs' => $last_id,
                  'id_jns_daftar' => filter_var($val[7], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                  'tgl_masuk_sp' => filter_var($val[8], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH),
                  'mulai_smt' => filter_var($val[9], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)
                  );

                  $in = $db->insert('mhs_pt',$data_mhs_pt);

              }

      }
      
    }
   
}

          unlink("../../../upload/mahasiswa/".$_FILES['semester']['name']);
          $msg = '';
      if (($sukses>0) || ($error_count>0)) {
        $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <font color=\"#3c763d\">".$sukses." data Mahasiswa baru berhasil di import</font><br />
            <font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
            if (!$error_count==0) {
              $msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
            }
            //echo "<br />Total: ".$i." baris data";
            $msg .= "<div class=\"collapse\" id=\"collapseExample\">";
                $i=1;
                foreach ($error as $pesan) {
                    $msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
                  $i++;
                  }
            $msg .= "</div>
          </div>";
      }
     echo $msg;
          break;

  case "in":
  $data_mhs = array(
    "nm_pd"=>$_POST["nm_pd"],"jk"=>$_POST["jk"],"nik"=>$_POST["nik"],"tmpt_lahir"=>$_POST["tmpt_lahir"],"tgl_lahir"=>$_POST["tgl_lahir"],"id_agama"=>$_POST["id_agama"],"jln"=>$_POST["jln"],"rt"=>$_POST["rt"],"rw"=>$_POST["rw"],"nm_dsn"=>$_POST["nm_dsn"],"ds_kel"=>$_POST["ds_kel"],"kode_pos"=>$_POST["kode_pos"],"id_jns_tinggal"=>$_POST["id_jns_tinggal"],"telepon_rumah"=>$_POST["telepon_rumah"],"telepon_seluler"=>$_POST["telepon_seluler"],"email"=>$_POST["email"],"stat_pd"=>$_POST["stat_pd"],"nm_ayah"=>$_POST["nm_ayah"],"tgl_lahir_ayah"=>$_POST["tgl_lahir_ayah"],"id_jenjang_pendidikan_ayah"=>$_POST["id_jenjang_pendidikan_ayah"],"id_pekerjaan_ayah"=>$_POST["id_pekerjaan_ayah"],"id_penghasilan_ayah"=>$_POST["id_penghasilan_ayah"],"nm_ibu_kandung"=>$_POST["nm_ibu_kandung"],"tgl_lahir_ibu"=>$_POST["tgl_lahir_ibu"],"id_jenjang_pendidikan_ibu"=>$_POST["id_jenjang_pendidikan_ibu"],"id_penghasilan_ibu"=>$_POST["id_penghasilan_ibu"],"id_pekerjaan_ibu"=>$_POST["id_pekerjaan_ibu"],"nm_wali"=>$_POST["nm_wali"],"tgl_lahir_wali"=>$_POST["tgl_lahir_wali"],"id_jenjang_pendidikan_wali"=>$_POST["id_jenjang_pendidikan_wali"],"id_pekerjaan_wali"=>$_POST["id_pekerjaan_wali"],"id_penghasilan_wali"=>$_POST["id_penghasilan_wali"],"id_penghasilan_wali"=>$_POST["id_penghasilan_wali"],"id_wil" => $_POST['id_wil']);

   $data_mhs_pt = array("kode_jurusan"=>$_POST["kode_jurusan"],"id_jns_daftar"=>$_POST["id_jns_daftar"],"nipd"=>$_POST["nipd"],"tgl_masuk_sp"=>$_POST["tgl_masuk_sp"],"mulai_smt"=>$_POST["mulai_smt"]);
  
  
  
   
    $in = $db->insert("mhs",$data_mhs);
    $last_id = $db->get_last_id();
    $last = array('id_mhs' => $last_id);
    $data_mhs_pt = array_merge($data_mhs_pt,$last);

    $in_mhs_pt = $db->insert("mhs_pt",$data_mhs_pt);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    $id = $db->fetch_single_row('mhs_pt','id',$_GET['id']);
    
    $db->delete("mhs","id",$id->id_mhs);
    break;
  case "up":
   $data = array("nm_pd"=>$_POST["nm_pd"],"jk"=>$_POST["jk"],"nik"=>$_POST["nik"],"tmpt_lahir"=>$_POST["tmpt_lahir"],"tgl_lahir"=>$_POST["tgl_lahir"],"id_agama"=>$_POST["id_agama"],"jln"=>$_POST["jln"],"rt"=>$_POST["rt"],"rw"=>$_POST["rw"],"nm_dsn"=>$_POST["nm_dsn"],"ds_kel"=>$_POST["ds_kel"],"kode_pos"=>$_POST["kode_pos"],"id_jns_tinggal"=>$_POST["id_jns_tinggal"],"telepon_rumah"=>$_POST["telepon_rumah"],"telepon_seluler"=>$_POST["telepon_seluler"],"email"=>$_POST["email"],"stat_pd"=>$_POST["stat_pd"],"nm_ayah"=>$_POST["nm_ayah"],"tgl_lahir_ayah"=>$_POST["tgl_lahir_ayah"],"id_jenjang_pendidikan_ayah"=>$_POST["id_jenjang_pendidikan_ayah"],"id_pekerjaan_ayah"=>$_POST["id_pekerjaan_ayah"],"id_penghasilan_ayah"=>$_POST["id_penghasilan_ayah"],"nm_ibu_kandung"=>$_POST["nm_ibu_kandung"],"tgl_lahir_ibu"=>$_POST["tgl_lahir_ibu"],"id_jenjang_pendidikan_ibu"=>$_POST["id_jenjang_pendidikan_ibu"],"id_penghasilan_ibu"=>$_POST["id_penghasilan_ibu"],"id_pekerjaan_ibu"=>$_POST["id_pekerjaan_ibu"],"nm_wali"=>$_POST["nm_wali"],"tgl_lahir_wali"=>$_POST["tgl_lahir_wali"],"id_jenjang_pendidikan_wali"=>$_POST["id_jenjang_pendidikan_wali"],"id_pekerjaan_wali"=>$_POST["id_pekerjaan_wali"],"id_penghasilan_wali"=>$_POST["id_penghasilan_wali"],"id_penghasilan_wali"=>$_POST["id_penghasilan_wali"],"id_wil" => $_POST['id_wil']);
   

     $data_mhs_pt = array("kode_jurusan"=>$_POST["kode_jurusan"],"id_jns_daftar"=>$_POST["id_jns_daftar"],"nipd"=>$_POST["nipd"],"tgl_masuk_sp"=>$_POST["tgl_masuk_sp"],"mulai_smt"=>$_POST["mulai_smt"]);


     $id = $db->fetch_single_row('mhs_pt','id',$_POST['id']);
    $up = $db->update("mhs",$data,"id",$id->id_mhs);
     $up_pt = $db->update("mhs_pt",$data_mhs_pt,"id",$_POST["id"]);
    if ($up=true) {
      echo "good";
    } else {
      return false; 
    }
    break;
       case 'del_massal':
    $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
           $ids = $db->fetch_single_row('mhs_pt','id',$id);
          $db->delete("mhs","id",$ids->id_mhs);
         }
    }
    break;

  default:
    # code...
    break;
}

?>