<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";



$requestData= $_REQUEST;

$kode_prodi = $requestData['jurusan'];

$sSearch = $requestData['search']['value'];



$semester = '';
$kode_mk = '';
$nama = "";
if (isset($sSearch)) {

	if (is_numeric($sSearch)) {
		$nama = "and nipd like '%".$sSearch."%'";
	} else {
		$nama = "and nm_pd like '%".$sSearch."%'";
	}

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

		$filter = '';

		$kode_prodi = $requestData['jurusan'];


		$filter_sms = "id_sp='".$id_sp."' and kode_prodi ilike '%".$kode_prodi."%'";
		$temp_sms = $proxy->GetRecord($token,'sms',$filter_sms);
		if ($temp_sms['result']) {
			$id_sms = $temp_sms['result']['id_sms'];
		}
		$filter_kelas = "p.id_sms='".$id_sms."' $nama";

		$temp_total = $proxy->GetCountRecordset($token,"mahasiswa_pt",$filter_kelas);

		$totalData = $temp_total['result'];


		$order_by = "mulai_smt DESC";

		$totalFiltered = $totalData;
		$temp_rec = $proxy->GetRecordset($token,"mahasiswa_pt", $filter_kelas,$order_by, $temp_limit,$temp_offset);
		//var_dump($temp_rec);
		$temp_error_code = $temp_rec['error_code'];
		$temp_error_desc = $temp_rec['error_desc'];

		if (($temp_error_code==0) && ($temp_error_desc=='')) {
			$temp_data = array();
			$i=0;
			foreach ($temp_rec['result'] as $key) {
				$temps = array();
				$temps[] = ++$i+$temp_offset." <input type='checkbox'  class='deleteRow' value='".$key['id_reg_pd']."'/>";
				$temps[] = $key['nm_pd'];
				$temps[] = $key['nipd'];
				$temps[] = $key['tgl_lahir'];
				$temps[] = substr($key['mulai_smt'], 0,4);
				$temps[] = $key['id_reg_pd'];
			
				$temp_data[] = $temps;
			}
			$temp_output = array(
									'draw' => intval($requestData['draw']),
									'recordsTotal' => intval( $totalData ),
									'recordsFiltered' => intval( $totalFiltered ),
									'data' => $temp_data
				);
			echo json_encode($temp_output);
}