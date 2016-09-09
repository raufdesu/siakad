<?php
include "../../inc/config.php";
include "../../lib/nusoap/nusoap.php";

$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}

  $client = new nusoap_client($url, true);
  $proxy = $client->getProxy();



  # MENDAPATKAN TOKEN
  $username = $config->username;
  $password = $config->password;
  $result = $proxy->GetToken($username, $password);
  $token = $result;




switch ($_GET["act"]) {
  case 'delete_all':
   $prodi = $_POST['jurusan'];
    //get id npsn
  $filter_sp = "npsn='".$config->id_sp."'";
  $get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

  $id_sp = $get_id_sp['result']['id_sp'];

  $filter_sms = "id_sp='".$id_sp."' and kode_prodi ilike '%".$prodi."%'";
    $temp_sms = $proxy->GetRecord($token,'sms',$filter_sms);
    if ($temp_sms['result']) {
      $id_sms = $temp_sms['result']['id_sms'];
    }
  $filter_semester = "p.id_sms='".$id_sms."' and p.mulai_smt='".$_POST['data_ids']."'";
  $all_kelas = $proxy->GetRecordset($token,'mahasiswa_pt',$filter_semester,'','','');
      foreach($all_kelas['result'] as $id) {

            $filter_nilai = "p.id_reg_pd='".$id['id_reg_pd']."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    foreach ($temp_sms['result'] as $reg) {
      $hapus = array(
      'id_kls' => $reg['id_kls'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );  
     // print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'nilai', json_encode($hapus));
      print_r($temp_result);
    }
  $filter_akm = "id_reg_pd='".$id['id_reg_pd']."'";
    $temp_akm = $proxy->GetRecordset($token,'kuliah_mahasiswa',$filter_akm,'','','');
    foreach ($temp_akm['result'] as $reg) {
      $hapus = array(
      'id_smt' => $reg['id_smt'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
  //  print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'kuliah_mahasiswa', json_encode($hapus));
    print_r($temp_result);
  }

  //hapus mahasiswa_pt
  $filter_akm = "id_reg_pd='".$id['id_reg_pd']."'";
    $temp_akm = $proxy->GetRecord($token,'mahasiswa_pt',$filter_akm);
      $id_pd = $temp_akm['result']['id_pd'];
      $hapus = array(
        'id_reg_pd'=>$id['id_reg_pd']
      );
  //  print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'mahasiswa_pt', json_encode($hapus));
    print_r($temp_result);
  
   $hapus = array(     
      'id_pd'=>$id_pd
      );
  $temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
  print_r($temp_result);

      }

    break;
  case "delete":
 
    $filter_nilai = "p.id_reg_pd='".$_GET['id']."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    foreach ($temp_sms['result'] as $reg) {
      $hapus = array(
      'id_kls' => $reg['id_kls'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );  
     // print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'nilai', json_encode($hapus));
      print_r($temp_result);
    }
  $filter_akm = "id_reg_pd='".$_GET['id']."'";
    $temp_akm = $proxy->GetRecordset($token,'kuliah_mahasiswa',$filter_akm,'','','');
    foreach ($temp_akm['result'] as $reg) {
      $hapus = array(
      'id_smt' => $reg['id_smt'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
  //  print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'kuliah_mahasiswa', json_encode($hapus));
    print_r($temp_result);
  }

  //hapus mahasiswa_pt
  $filter_akm = "id_reg_pd='".$_GET['id']."'";
    $temp_akm = $proxy->GetRecord($token,'mahasiswa_pt',$filter_akm);
      $id_pd = $temp_akm['result']['id_pd'];
      $hapus = array(
        'id_reg_pd'=>$_GET['id']
      );
  //  print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'mahasiswa_pt', json_encode($hapus));
    print_r($temp_result);
  
   $hapus = array(     
      'id_pd'=>$id_pd
      );
  $temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
  print_r($temp_result);

  break;

  case 'del_massal':
     $data_ids = $_REQUEST['data_ids'];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
      foreach($data_id_array as $id) {

    $filter_nilai = "p.id_reg_pd='".$id."'";
    $temp_sms = $proxy->GetRecordset($token,'nilai',$filter_nilai,'','','');
    foreach ($temp_sms['result'] as $reg) {
      $hapus = array(
      'id_kls' => $reg['id_kls'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );  
     // print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'nilai', json_encode($hapus));
      print_r($temp_result);
    }
  $filter_akm = "id_reg_pd='".$id."'";
    $temp_akm = $proxy->GetRecordset($token,'kuliah_mahasiswa',$filter_akm,'','','');
    foreach ($temp_akm['result'] as $reg) {
      $hapus = array(
      'id_smt' => $reg['id_smt'],
      'id_reg_pd'=>$reg['id_reg_pd']
      );
  //  print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'kuliah_mahasiswa', json_encode($hapus));
    print_r($temp_result);
  }

  //hapus mahasiswa_pt
  $filter_akm = "id_reg_pd='".$id."'";
    $temp_akm = $proxy->GetRecord($token,'mahasiswa_pt',$filter_akm);
      $id_pd = $temp_akm['result']['id_pd'];
      $hapus = array(
        'id_reg_pd'=>$id
      );
  //  print_r($hapus);
    $temp_result = $proxy->DeleteRecord($token, 'mahasiswa_pt', json_encode($hapus));
    print_r($temp_result);
  
   $hapus = array(     
      'id_pd'=>$id_pd
      );
  $temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
  print_r($temp_result);

      }

    }
    break;

}