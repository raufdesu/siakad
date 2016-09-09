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


$table1 = 'kelas_kuliah';
# MENDAPATKAN TOKEN
$username = $config->username;
$password = $config->password;
$result = $proxy->GetToken($username, $password);
$token = $result;

//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


	$id_sms = "";
	$id_mk = "";
	$id_kls = "";
	$sks_mk = 0;
	$sks_tm = 0;
	$sks_prak = 0;
	$sks_prak_lap = 0;
	$sks_sim = 0;
	$temp_data = array();
	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error_msg = array();
	$data_id = array();
	$error_id = array();
	$error_mk = "";

	$matkul = '';
	$kelas = '';

	if ($_GET['matkul']!='all') {
		$matkul = "and kode_mk='".$_GET['matkul']."'";
	}
	if ($_GET['kelas']!='all') {
		$kelas  = "and nama_kelas='".$_GET['kelas']."'";
	}
	
	
	//get id npsn
	$filter_sp = "npsn='".$config->id_sp."'";
	$get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

	$id_sp = $get_id_sp['result']['id_sp'];


	$count = $db->fetch_custom("select * from kelas_kuliah where kode_jurusan='".$_GET['jurusan']."' and semester='".$_GET['sem']."' and status_error!=1 $matkul $kelas");
	$jumlah = $count->rowCount();



	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error = array();




		$options = array(
		    'filename' => $_GET['jurusan'].'_progress.json',
		    'autoCalc' => true,
		    'totalStages' => 1
		);
		$new_pu = new Manticorp\ProgressUpdater($options);
	

	$data = $db->fetch_custom("select kelas_kuliah.id as id_kelas,kelas_kuliah.*,jurusan.kode_jurusan from kelas_kuliah inner join jurusan on kelas_kuliah.kode_jurusan=jurusan.kode_jurusan where jurusan.kode_jurusan='".$_GET['jurusan']."' and kelas_kuliah.semester='".$_GET['sem']."' and status_error!=1 $matkul $kelas limit 0,$jumlah");

			//let's push first page

			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => $jumlah,
			);

			$new_pu->nextStage($stageOptions);

			foreach ($data as $value) {

		$kode_mk = $value->kode_mk;

		$semester = $value->semester;
		$kelas = $value->nama_kelas;
		$nama_mk = $value->nama_mk;
		$kode_prodi = trim($value->kode_jurusan);

		$filter_sms = "id_sp='".$id_sp."' and kode_prodi ilike '%".$kode_prodi."%'";
		$temp_sms = $proxy->GetRecord($token,'sms',$filter_sms);
		if ($temp_sms['result']) {
			$id_sms = $temp_sms['result']['id_sms'];
		}


		$filter_mk = "kode_mk='".$kode_mk."' and id_sms='".$id_sms."' and soft_delete='0'";
		$temp_mk = $proxy->GetRecord($token,'mata_kuliah',$filter_mk);


		if ($temp_mk['result']) {
			$id_mk = $temp_mk['result']['id_mk'];
			$sks_mk = $temp_mk['result']['sks_mk'];
			$sks_tm = $temp_mk['result']['sks_tm'];
			if ($temp_mk['result']['sks_prak']=="") {
				$sks_prak = 0;
			} else {
				$sks_prak = $temp_mk['result']['sks_prak'];
			}

			if ($temp_mk['result']['sks_prak_lap']=="") {
				$sks_prak_lap = 0;
			} else {
				$sks_prak_lap = $temp_mk['result']['sks_prak_lap'];
			}

			if ($temp_mk['result']['sks_tm']=="") {
				$sks_tm = 0;
			} else {
				$sks_tm = $temp_mk['result']['sks_tm'];
			}


			if ($temp_mk['result']['sks_sim']=="") {
				$sks_sim = 0;
			} else {
				$sks_sim = $temp_mk['result']['sks_sim'];
			}

			$error_mk = "";
				$temp_data = array(
				'id_sms' => $id_sms,
				'id_smt' => $semester,
				'id_mk' => $id_mk,
				'nm_kls' => $kelas,
				'sks_mk' => $sks_mk,
				'sks_tm' => $sks_tm,
			    'sks_prak' => $sks_prak,
		   		'sks_prak_lap' => $sks_prak_lap,
				'sks_sim' => $sks_sim
				);

	$temp_result = $proxy->InsertRecord($token, $table1, json_encode($temp_data));

	
	if ($temp_result['result']['error_desc']==NULL) {
		$sukses_count++;
		$db->update('kelas_kuliah',array('status_error'=>1,'keterangan'=>''),'id',$value->id_kelas);
	} else {
				++$error_count;
				$db->update('kelas_kuliah',array('status_error' => 2, 'keterangan'=>"Error ".$temp_result['result']['error_desc']),'id',$value->id_kelas);
				$error_msg[] = "Error ".$temp_result['result']['error_desc'];
			}


			
		} else {
				++$error_count;
				$db->update('kelas_kuliah',array('status_error' => 2, 'keterangan'=>"Error Pastikan Kode MK $kode_mk Matkul $nama_mk Sudah Ada di Feeder "),'id',$value->id_kelas);
				$error_msg[] = "Error Pastikan Kode MK $kode_mk Matkul $nama_mk Sudah Ada di Feeder ";
		}

	$new_pu->incrementStageItems(1, true);


		}

$msg = '';
if ((!$sukses_count==0) || (!$error_count==0)) {
	$msg =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count." data Kelas baru berhasil ditambah</font><br />
			<font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
			if (!$error_count==0) {
				$msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg .= "<div class=\"collapse\" id=\"collapseExample\">";
					$i=1;
					foreach ($error_msg as $pesan) {
							$msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg .= "</div>
		</div>";
}

		$new_pu->totallyComplete($msg);
