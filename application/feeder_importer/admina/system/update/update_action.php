<?php
include "../../inc/config.php";


$check_latest_version = $db->fetch_custom_single("select version from sys_update where status_complete='Y' order by id desc limit 1");

$check_count = file_get_contents('http://feeder-update.wildantea.com/count_version_left.php?local_last='.$check_latest_version->version);

$dta_server_version = json_decode($check_count);


if (count($dta_server_version)>0) {
            $msg_sukses=array();
            $sukses=0;
    foreach ($dta_server_version as $version) {
          $data_update = file_get_contents('http://feeder-update.wildantea.com/update.php?version='.$version->version);

          $data_update = json_decode($data_update);



          $success=array();

          $create = "";
            foreach ($data_update as $dt) {
              $file_name = explode(".", $dt->nama_file);
              $data_file = file_get_contents('http://wildantea.com/feeder-update/data/'.$version->version.'/'.$dt->modul_name.'/'.$file_name[0].'.txt');
              $create = $db->buat_file('../../modul/'.$dt->modul_name.'/'.$dt->nama_file,$data_file);
              if ($create==1) {
                $sukses++;
                //$success[] = "modul/".$dt->modul_name.'/'.$dt->nama_file." Berhasil Dibuat";
                array_push($msg_sukses, "modul/".$dt->modul_name.'/'.$dt->nama_file." Berhasil Dibuat");
              } else {
               //$success[] = "Pastikan Direktori".$dt->modul_name." writable";
                array_push($msg_sukses, "Pastikan Direktori ".$dt->modul_name." writable");
              }
            }
            $db->insert('sys_update',array('version' => $version->version,'status_complete' => 'Y'));


          }



                if (($sukses>0)) {
            $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <font color=\"#3c763d\">".$sukses." File baru berhasil di Update</font><br />";
                if (!$sukses==0) {
                  $msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail</a>";
                }
                //echo "<br />Total: ".$i." baris data";
                $msg .= "<div class=\"collapse\" id=\"collapseExample\">";
                    $i=1;
                    foreach ($msg_sukses as $pesan) {
                        $msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
                      $i++;
                      }
                $msg .= "</div>
              </div>";
          }

            echo $msg;
} else {
  echo "Aplikasi Masih Terbaru";
}

?>
