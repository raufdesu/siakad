<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";


$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
	$url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}
//untuk coba-coba
// $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

$client = new nusoap_client($url, true);
$proxy = $client->getProxy();



# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;

//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


	$id_sms = '';
	$id_mk = '';
	$nidn = '';
	$id_ptk = '';
	$sks_mk = '';
	$sks_tm = '';
	$sks_prak = '';
	$sks_prak_lap = '';
	$sks_sim = '';
	$temp_data = array();
	$sukses_count = 0;
	$sukses_count_mat = 0;
	$sukses_count_kur = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error_count_mat = 0;
	$error_count_kur = 0;
	$error_msg = array();
	$error_msg_mat = array();
	$error_msg_kur = array();

	//get id npsn
	$filter_sp = "npsn='".$config->id_sp."'";
	$get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

	$id_sp = $get_id_sp['result']['id_sp'];


	$arr_data = $db->fetch_custom("select kurikulum.*,jurusan.kode_jurusan from kurikulum inner join jurusan on kurikulum.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and mulai_berlaku='".$_GET['tahun']."'");






$i=1;



	foreach ($arr_data as $value) {



	//	print_r($value);
		$nama_kurikulum = $value->nama_kur;
		$jml_sks_wajib = $value->jml_sks_wajib;
		$jml_sks_pilihan = $value->jml_sks_pilihan;

		$mulai_berlaku = $value->mulai_berlaku;
		$kode_prodi = $value->kode_jurusan;

		$filter_ptk = "p.id_sp='".$id_sp."' and p.kode_prodi='".$kode_prodi."'";
		$temp_ptk = $proxy->GetRecord($token,'sms',$filter_ptk);
		if ($temp_ptk['result']) {
			$id_jenj_didik = $temp_ptk['result']['id_jenj_didik'];
			$id_sms = $temp_ptk['result']['id_sms'];
		}

		$filter_check = "id_sms='".$id_sms."' and id_jenj_didik='".$id_jenj_didik."' and id_smt_berlaku='".$mulai_berlaku."' and soft_delete='0'";
		$temp_check = $proxy->GetRecord($token,'kurikulum',$filter_check);
		if ($temp_check['result']) {
			$id_kur = $temp_check['result']['id_kurikulum_sp'];
			++$error_count_kur;
				$error_msg_kur[] = "<h4>Error Kurikulum ini Sudah Ada<h4>";
		} else {
					//var_dump($temp_kls['result']);
			$temp_data = array(
				'nm_kurikulum_sp' => $nama_kurikulum,
				'jml_sks_wajib' => $jml_sks_wajib,
				'jml_sks_pilihan' => $jml_sks_pilihan,
				'jml_sks_lulus' => $jml_sks_wajib+$jml_sks_pilihan,
				'id_smt_berlaku' => $mulai_berlaku,
				'id_jenj_didik' => $id_jenj_didik,
				'id_sms' => $id_sms,
				);

			$insert_kur = $proxy->InsertRecord($token, "kurikulum", json_encode($temp_data));

				if ($insert_kur['result']) {
					$id_kur = $insert_kur['result']['id_kurikulum_sp'];
				}
			++$sukses_count_kur;
		}

		$wajib = '';
		$mats = $db->fetch_custom("select * from mat_kurikulum where id_kurikulum='$value->id' and status_error!=1");
		$options = array(
	    'filename' => $_GET['jurusan'].'_progress.json',
	    'autoCalc' => true,
	    'totalStages' => 1
		);
		$pu = new Manticorp\ProgressUpdater($options);





		$stageOptions = array(
		    'name' => 'This AJAX process takes a long time',
		    'message' => 'But this will keep the user updated on it\'s actual progress!',
		    'totalItems' => $mats->rowCount(),
		);


		$pu->nextStage($stageOptions);

		foreach ($mats as $mat) {


		$filter_check = "id_sms='".$id_sms."' and id_jenj_didik='".$id_jenj_didik."' and kode_mk='".$mat->kode_mk."' and soft_delete='0'";
		$temp_check = $proxy->GetRecord($token,'mata_kuliah',$filter_check);
		if ($temp_check['result']) {
			$id_mk = $temp_check['result']['id_mk'];

			$jmlsks_mk= $temp_check['result']['sks_mk'];
			++$error_count;
			$db->update('mat_kurikulum',array('status_error' => 2, 'keterangan'=>"Error $mat->kode_mk sudah ada"),'id',$mat->id);
		$error_msg[] = "<h4>Error Matakuliah $mat->kode_mk sudah ada</h4>";

		} else {
			$jmlsks_mk=$mat->sks_tm+$mat->sks_prak+$mat->sks_prak_lap+$mat->sks_sim;
		$wajib = $mat->jns_mk;
		$data = array(
		'id_sms' => $id_sms,
		'id_jenj_didik' => $id_jenj_didik,
        'kode_mk' => $mat->kode_mk,
        'nm_mk' => $mat->nama_mk,
        'jns_mk' => $wajib,
        'sks_mk' => $jmlsks_mk,
        'sks_tm' => $mat->sks_tm,
        'sks_prak' => $mat->sks_prak,
        'sks_prak_lap' => $mat->sks_prak_lap,
        'sks_sim' => $mat->sks_sim,
        'a_sap' => $mat->a_sap,
        'a_silabus' => $mat->s_silabus,
        'a_bahan_ajar' => $mat->a_bahan_ajar,
        );

		//insert matakuliah
		$in_mat = $proxy->InsertRecord($token, "mata_kuliah", json_encode($data));
		if ($in_mat['result']['error_desc']==NULL) {
			$id_mk = $in_mat['result']['id_mk'];
			++$sukses_count;
			$db->update('mat_kurikulum',array('status_error'=>1,'keterangan'=>''),'id',$mat->id);
		} else {
			++$error_count_mat;
			$error_msg_mat[] = "<h4>Error,</h4>".$in_mat['result']['error_desc'];
		}




	}



	//check if wajib
	if ($wajib=='A') {
		$wajib = 1;
	} else {
		$wajib = 0;
	}
	//insert matakuliah kurikulum
	$in_mat_kur = array(
				'id_kurikulum_sp' => $id_kur,
				'id_mk' => $id_mk,
				'smt' => $mat->semester,
				'sks_mk' => $jmlsks_mk,
				'sks_tm' =>$mat->sks_tm,
			    'sks_prak' =>  $mat->sks_prak,
		   		'sks_prak_lap' =>$mat->sks_prak_lap,
				'sks_sim' => $mat->sks_sim,
				'a_wajib' => $wajib
				);

$insert_mat_kur = $proxy->InsertRecord($token, "mata_kuliah_kurikulum", json_encode($in_mat_kur));

	if ($insert_mat_kur['result']['error_desc']==NULL) {
				++$sukses_count_mat;
			} else {
				++$error_count_mat;
				$error_msg_mat[] = "<h4>Error Matakuliah Kurikulum $mat->kode_mk</h4>".$insert_mat_kur['result']['error_desc'];
			}

			 $pu->incrementStageItems(1, true);
		}

	$i++;

	}


$msg_kur = '';
if ((!$sukses_count_kur==0) || (!$error_count_kur==0)) {
	$msg_kur =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count_kur." data Kurikulum baru berhasil ditambah</font><br />
			<font color=\"#ce4844\" >".$error_count_kur." data tidak bisa ditambahkan </font>";
			if (!$error_count_kur==0) {
				$msg_kur .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg_kur .= "<div class=\"collapse\" id=\"collapseExample\">";
					$i=1;
					foreach ($error_msg_kur as $pesan) {
							$msg_kur .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg_kur .= "</div>
		</div>";
}

$msg='';
if ((!$sukses_count==0) || (!$error_count==0)) {
	$msg =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count." data Matakuliah baru berhasil ditambah</font><br />
			<font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
			if (!$error_count==0) {
				$msg .= "<a data-toggle=\"collapse\" href=\"#collapseExamples\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg .= "<div class=\"collapse\" id=\"collapseExamples\">";
					$i=1;
					foreach ($error_msg as $pesan) {
							$msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg .= "</div>
		</div>";
}

$msg_mat = '';
if ((!$sukses_count_mat==0) || (!$error_count_mat==0)) {
	$msg_mat =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count_mat." data Matakuliah baru berhasil ditambah ke kurikulum</font><br />
			<font color=\"#ce4844\" >".$error_count_mat." data tidak bisa ditambahkan </font>";
			if (!$error_count_mat==0) {
				$msg_mat .= "<a data-toggle=\"collapse\" href=\"#collapseExampled\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg_mat .= "<div class=\"collapse\" id=\"collapseExampled\">";
					$i=1;
					foreach ($error_msg_mat as $pesan) {
							$msg_mat .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg_mat .= "</div>
		</div>";
}



$pu->totallyComplete($msg_kur.$msg.$msg_mat);


