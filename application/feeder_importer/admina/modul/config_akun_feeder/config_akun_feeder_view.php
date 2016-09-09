
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
													<th>Status</th>
													
                          <th>Action</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                         <?php 
      $dtb=$db->fetch_custom("select config_user.username,config_user.password,config_user.url,config_user.port,config_user.id_sp,config_user.live,config_user.id from config_user ");
      $i=1;
      foreach ($dtb as $isi) {
        ?><tr id="line_<?=$isi->id;?>">
        <td><?=$isi->username;?></td>
<td><?=$isi->url;?></td>
<td><?=$isi->port;?></td>
<td><?=$isi->id_sp;?></td>
<td> <?php if ($isi->live=="Y") {
      ?>
      <button class="btn btn-success btn-flat"><i class="fa fa-check"></i> Live</button>
      <?php
    } else {
      ?>
      <button class="btn btn-danger btn-flat"><i class="fa fa-check"></i> SandBox</button>
      <?php
    }?></td>

        <td>
        <?=($role_act["up_act"]=="Y")?'<a href="'.base_index().'config-akun-feeder/edit/'.$isi->id.'" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>':"";?>  
        </td>
        </tr>
        <?php
        $i++;
      }
      ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
        
