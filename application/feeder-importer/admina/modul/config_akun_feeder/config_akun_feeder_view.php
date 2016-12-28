<?php
      function is_connected($url,$port)
      {
       
        if(!$sock = @fsockopen($url, $port))
        {
           return false;
        }
        else
        {
            return true;
        }

      }
//include "inc/config.php";
include "lib/nusoap/nusoap.php";


  //    foreach ($dtb as $isi) {

?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Config Akun Feeder
                    </h1>
                       <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>config-akun-feeder">Config Akun Feeder</a></li>
                        <li class="active">Akun Feeder</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                  <h3 class="box-title">Config Akun Feeder</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
                          <th>Username Feeder</th>
                          <th>URL Feeder</th>
                          <th>PORT</th>
                          <th>Kode PT</th>
                          <th>Mode</th>
                          <th>Status</th>
                          
                          <th>Action</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                         <?php 
      $datas=$db->fetch_custom_single("select * from config_user");
     
function isValidMd5($result)
{
     return preg_match('/^[a-f0-9]{32}$/i', $result);
}

    
        $url = 'http://'.$datas->url.':'.$datas->port.'/ws/live.php?wsdl'; // gunakan sandbox

     
            $file_headers = @get_headers('http://'.$datas->url.':'.$datas->port.'/ws/mahasiswa.php');

            if (!is_connected($datas->url,$datas->port)) {


              $status = '<button type="button" class="btn btn-warning btn-xs">Not Connected</button>';

              $error_server = "Server PDDIKTI tidak aktif";
              $error_url = "";
              $error = "";
         

      

      } else {

                      if($file_headers[0] == 'HTTP/1.1 404 Not Found') {

              $error = "";
              $error_url = "Tidak menemukan PDDIKTI Server/Url Salah";
              $error_server = "";
              $status = '<button type="button" class="btn btn-warning btn-xs">Not Connected</button>';

            } else {


        $error_server = "";
   
        $client = new nusoap_client($url, true);
        $proxy = $client->getProxy();

        # MENDAPATKAN TOKEN
        $username = $datas->username;
        $password = $datas->password;
        $result = "";
        $result = $proxy->GetToken($username, $password);



        if (isValidMd5($result)) {
            $status = '<button type="button" class="btn btn-success btn-xs">Connected</button>';
            if ($datas->status_connected=='N') {
              $filter = "npsn = '".$datas->id_sp."'";
              $temp_sp = $proxy->getrecord($result,'satuan_pendidikan',$filter);
              $nm_lemb = $temp_sp['result']['nm_lemb'];
              $db->update('config_user',array('status_connected' => 'Y','nm_lemb' => $nm_lemb),'id',1);
            }

            $error = "";
        } else {
          $status = '<button type="button" class="btn btn-warning btn-xs">Not Connected</button>';
          $db->update('config_user',array('status_connected' => 'N','nm_lemb' => ''),'id',1);
            $error = $result;
        }
        
        $error_url = "";


            }
      }
        ?><tr id="line_<?=$datas->id;?>">
        <td><?=$datas->username;?></td>
<td><?=$datas->url;?></td>
<td><?=$datas->port;?></td>
<td><?=$datas->id_sp;?></td>
<td> <?php if ($datas->live=="Y") {
      ?>
      <button class="btn btn-success btn-flat btn-xs"><i class="fa fa-check"></i> Live</button>
      <?php
    } else {
      ?>
      <button class="btn btn-danger btn-flat btn-xs"><i class="fa fa-check"></i> SandBox</button>
      <?php
    }?></td>
<td> <?=$status;?> <?=$error_server;?> <?=$error_url;?> <?=$error;?></td>

        <td>
        <?=($role_act["up_act"]=="Y")?'<a href="'.base_index().'config-akun-feeder/edit/'.$datas->id.'" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>':"";?>  
        </td>
        </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->