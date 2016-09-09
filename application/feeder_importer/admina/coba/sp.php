<?php
//include "inc/config.php";
include "../lib/nusoap/nusoap.php";
/*
include "../inc/config.php";
$config = $db->fetch_single_row('config_user','id',1);

$url = 'http://'.$config->url.':8082/ws/live.php?wsdl'; // gunakan sandbox
//untuk coba-coba
// $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

$client = new nusoap_client($url, true);
$proxy = $client->getProxy();

echo "<pre>";

# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;

	//get id npsn
	$filter_sp = "npsn='".$config->id_sp."'";
	$get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

	$id_sp = $get_id_sp['result']['id_sp'];

//print_r($proxy->GetDictionary($token,'mahasiswa_pt'));

$filter_kelas = "nm_pd='eceng gonok' and soft_delete='1'";
$filter_sp = "p.id_reg_pd='09dc905b-bcc3-48ed-b0b6-8b289def8d59' and p.soft_delete='1'";
$temp_npm = $proxy->GetRecordset($token,'mahasiswa_pt',$filter_sp,'','','');

print_r($temp_npm);

exit();
$restore = array('nipd' => '12097050222' );
$restore_db = $proxy->restoreRecord($token,'mahasiswa_pt',json_encode($restore));

print_r($restore_db);


	   $hapus = array(     
									      'id_reg_pd'=> '642c139b-1e92-4408-a4c5-a562cae442ad'
									      );
									  $temp_result = $proxy->DeleteRecord($token, 'mahasiswa_pt', json_encode($hapus));



print_r($temp_npm);

            [id_reg_pd] => 642c139b-1e92-4408-a4c5-a562cae442ad
            [nipd] => 12097050222
            [id_pd] => 4e461adc-5ac6-40cc-bc10-4e6ed61700cd
            [nm_pd] => eceng gonok
            [tgl_lahir] => 1990-07-22
            [id_sms] => 09dc905b-bcc3-48ed-b0b6-8b289def8d59

	$data_insert_mhs_pt = array(
	  'id_sms' => '09dc905b-bcc3-48ed-b0b6-8b289def8d59',
      'id_pd' => '78537d6b-2bea-4a21-8134-3dbf7aad4039',
      'id_sp' => '1a7732db-e0b5-47c9-aa8a-cdc9a392bf49',
      'id_jns_daftar' => 1,
      'nipd' => '12097050222',
      'tgl_masuk_sp' => '2015-03-02',
      'a_pernah_paud' => '1',
      'a_pernah_tk' => '1',
      'mulai_smt' => '20151'
    );


	   $hapus = array(     
									      'id_pd'=> '642c139b-1e92-4408-a4c5-a562cae442ad'
									      );
									  $temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
print_r($temp_result);*/

/* $insert_mhs_pt =  $proxy->InsertRecord($token, 'mahasiswa_pt', json_encode($data_insert_mhs_pt));

print_r($insert_mhs_pt);*/


/*
$table = 'mahasiswa';
$result = $proxy->GetDictionary($token, $table);


$limit=10;
$offset=0;
$order= "";
$filter = "";


echo "<pre>";

	$nim = "12097050801";
		$filter_npm = "nipd like '%".$nim."%'";
		$temp_npm = $proxy->GetRecord($token,'mahasiswa_pt',$filter_npm);
		//var_dump($temp_npm);
		if ($temp_npm['result']) {
			$id_reg_pd = $temp_npm['result']['id_reg_pd'];
			$stat_reg = TRUE;
		}


$filter_sp = "id_reg_pd='".$id_reg_pd."' and id_smt='20151' and soft_delete='1'";
$get_id_sp = $proxy->GetRecord($token,'kuliah_mahasiswa',$filter_sp);

print_r($get_id_sp);

*/

/*	$filter_sms = "id_sp='".$id_sp."' and kode_prodi ilike '%55201%'";
		$temp_sms = $proxy->GetRecord($token,'sms',$filter_sms);
		if ($temp_sms['result']) {
			$id_sms = $temp_sms['result']['id_sms'];
		}
		$filter_kelas = "p.id_sms='".$id_sms."' and nipd like '%120970509%'";

//$temp_total = $proxy->GetCountRecordset($token,"mahasiswa_pt",$filter_kelas);
$order_by = "nipd ASC";
$temp_data = $proxy->GetRecordset($token,'mahasiswa_pt',$filter_kelas,$order_by,$limit,$offset);


print_r($temp_data);


echo "create table mhs_pt (";
foreach ($result['result'] as $isi) {
	if ($isi['type']=='uuid') {
		$type = "varchar(50)";
	} elseif($isi['type'] == 'smallint')
	{
		$type = "int(10)";
	} elseif ($isi['type'] == 'numeric(2,0)') {
		$type = "int(10)";
	}elseif ($isi['type'] == 'character(1)') {
		$type = "varchar(10)";
	}elseif ($isi['type'] == 'date') {
		$type = "date";
	}elseif ($isi['type'] == 'integer') {
		$type = "int(10)";
	} else {
		$type = "varchar(50)";
	}
	if (array_key_exists('not_null', $isi)) {
		$not_null = "not null";
	} else {
		$not_null = "";
	}
	echo $isi['column_name']." $type ".$not_null." comment '".$isi['desc']."', "."<br>";
}
echo ")";*/


/*	$filter_sp = "npsn='".$config->id_sp."'";
	$get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

	$id_sp = $get_id_sp['result']['id_sp'];

	echo "<pre>";*/



	/*	$filter_sms = "id_sp='".$id_sp."'";
		
		$prodi = $proxy->GetRecordset($token,"sms", $filter_sms,"", "","");
		$id_sms = '';

		$id_sms = $prodi['result']['id_sms'];


		foreach ($prodi['result'] as $data) {
			

			$filter_jenjang = "id_jenj_didik='".$data['id_jenj_didik']."'";
			$jenjang = $proxy->GetRecord($token,'jenjang_pendidikan',$filter_jenjang);

			$datas = array(
				'kode_jurusan' => $data['kode_prodi'],
				'nama_jurusan' => $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $data['nm_lemb']),
				'status' => $data['stat_prodi'],
				'jenjang' => $jenjang['result']['nm_jenj_didik']
				);

			$db->insert('jurusan',$datas);
				
			}
*/
/*	$mulai_berlaku = "20151";
			$kode_prodi ='55201';
 $filter = "p.kode_prodi='".$kode_prodi."'";
$limit='10';
$offset=0;
$order= "";
$resultrecordset = $proxy->GetRecordset($token,'sms',$filter,$order,$limit,$offset);

print_r($resultrecordset);

	

		$filter_ptk = "p.id_sp='".$id_sp."' and p.kode_prodi='".$kode_prodi."'";
		$temp_ptk = $proxy->GetRecord($token,'sms',$filter_ptk);
		if ($temp_ptk['result']) {
			$id_jenj_didik = $temp_ptk['result']['id_jenj_didik'];
			$id_sms = $temp_ptk['result']['id_sms'];
		}




		$filter_check = "id_sms='".$id_sms."' and id_jenj_didik='".$id_jenj_didik."' and id_smt_berlaku='".$mulai_berlaku."'";

		print_r($filter_check);
		$temp_check = $proxy->GetRecord($token,'kurikulum',$filter_check);

		print_r($temp_check);


			$mulai_berlaku = "20151";
			$kode_prodi ='55201';
$filter_ptk = "p.id_sp='".$id_sp."' and p.kode_prodi='".$kode_prodi."'";
		$temp_ptk = $proxy->GetRecord($token,'sms',$filter_ptk);
		if ($temp_ptk['result']) {
			$id_jenj_didik = $temp_ptk['result']['id_jenj_didik'];
			$id_sms = $temp_ptk['result']['id_sms'];
		}
print_r($temp_ptk);





*/

$limit=3000;
$offset=0;
$order= "";

/*$filter_ptk = "p.id_sp='".$id_sp."' and p.kode_prodi='".$kode_prodi."'";
		$temp_ptk = $proxy->GetRecord($token,'sms',$filter_ptk);
		if ($temp_ptk['result']) {
			$id_jenj_didik = $temp_ptk['result']['id_jenj_didik'];
			$id_sms = $temp_ptk['result']['id_sms'];
		}

$resultrecordset = $proxy->GetRecordset($token,'mahasiswa_pt', $filter,$order,$limit,$offset);


$i=1;
foreach ($resultrecordset['result'] as $isi) {*/

	
/*	$filter_nim = "";

*/

/*//	$data_kuliah = $proxy->GetRecord($token,'kuliah_mahasiswa',$filter_nim);
	$data_kuliah = $proxy->GetRecordset($token,'wilayah', "",$order,$limit,$offset);

	foreach ($data_kuliah['result'] as $isi) {
		$data = array(
			'id_wil' => $isi['id_wil'],
			'nm_wil' => $isi['nm_wil'],
			'id_level_wil' => $isi['id_level_wil'],
			'id_induk_wilayah' => $isi['id_induk_wilayah']
			);
		$db->insert('data_wilayah',$data);
	}*/
?>