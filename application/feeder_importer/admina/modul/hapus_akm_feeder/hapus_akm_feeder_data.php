<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";


$filter = "";
$semester = "";
$status = "";
if (isset($_POST['semester'])) {
  
  if ($_POST['semester']=='all') {
    $semester ="";
  } else {
    $semester = "id_smt='".$_POST['semester']."'";
  }

  if ($_POST['status']=='all') {
    $status = "";
  } else {
    $status = "and id_stat_mhs='".$_POST['status']."'";
  }

  $filter = "$semester $status";

}


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

//get id npsn
$filter_sp = "npsn='".$config->id_sp."'";
	$get_id_sp = $proxy->GetRecord($token,'satuan_pendidikan',$filter_sp);

	$id_sp = $get_id_sp['result']['id_sp'];

$id_sms = '';



		$requestData= $_REQUEST;

		$sSearch = $requestData['search']['value'];
		
		//$Data = $this->input->get('columns');
		//$orders = $requestData['order'];
		//$temp_order = 


		$iStart = $requestData['start'];
		$iLength = $requestData['length'];

		$temp_limit = $iLength;
		$temp_offset = $iStart?$iStart : 0;





	

	$temp_total = $proxy->GetCountRecordset($token,"kuliah_mahasiswa",$filter);
	


		$totalData = $temp_total['result'];



		$totalFiltered = $totalData;
		$temp_rec = $proxy->GetRecordset($token,"kuliah_mahasiswa",$filter,"id_smt DESC", $temp_limit,$temp_offset);
		//var_dump($temp_rec);
		$temp_error_code = $temp_rec['error_code'];
		$temp_error_desc = $temp_rec['error_desc'];

		if (($temp_error_code==0) && ($temp_error_desc=='')) {
			$temp_data = array();
			$i=0;
			foreach ($temp_rec['result'] as $key) {
				$temps = array();

				$filter_nim = "id_reg_pd='".$key['id_reg_pd']."'";
				$data_mhs = $proxy->GetRecord($token,'mahasiswa_pt',$filter_nim);

				if ($data_mhs['result']) {
					$nim = $data_mhs['result']['nipd'];
					$nama = $data_mhs['result']['nm_pd'];

					$filter_sms = "id_sms='".$data_mhs['result']['id_sms']."'";
	                $dump_sms = $proxy->GetRecord($token,'sms',$filter_sms);
	                            
	                $filter_jenjang = "id_jenj_didik='".$dump_sms['result']['id_jenj_didik']."'";
	                $dump_jenjang = $proxy->GetRecord($token,'jenjang_pendidikan',$filter_jenjang);

	                $filter_smt = "id_smt='".$key['id_smt']."'";
	                $dump_smt = $proxy->GetRecord($token,'semester',$filter_smt);

	                $filter_stat = "id_stat_mhs='".$key['id_stat_mhs']."'";
	                $dump_stat = $proxy->GetRecord($token,'status_mahasiswa',$filter_stat);



					$temps[] = ++$i+$temp_offset." <input type='checkbox'  class='deleteRow' value='".$key['id_smt']."_".$key['id_reg_pd']."'/>";
					$temps[] = $nim;
					$temps[] = $nama;
					$temps[] = $dump_jenjang['result']['nm_jenj_didik']." ".$data_mhs['result']['fk__sms'];
					$temps[] = $dump_smt['result']['nm_smt'];
					$temps[] = substr($data_mhs['result']['mulai_smt'],0,-1);
	                $temps[] = $key['ips'];
	                $temps[] = $key['ipk'];
	                $temps[] = $key['sks_smt'];
	                $temps[] = $key['sks_total'];
	                $temps[] = $dump_stat['result']['nm_stat_mhs'];
	                 $temps[] = $key['id_smt']."_". $key['id_reg_pd'];;
					
					$temp_data[] = $temps;
					
				}

          		
			}
			$temp_output = array(
									'draw' => intval($requestData['draw']),
									'recordsTotal' => intval( $totalData ),
									'recordsFiltered' => intval( $totalFiltered ),
									'data' => $temp_data
				);
			echo json_encode($temp_output);
}