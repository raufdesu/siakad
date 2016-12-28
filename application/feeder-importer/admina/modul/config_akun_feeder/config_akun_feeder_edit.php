

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Config Akun Feeder
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>config-akun-feeder">Config Akun Feeder</a></li>
                        <li class="active">Edit Config Akun Feeder</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Config Akun Feeder</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/config_akun_feeder/config_akun_feeder_action.php?act=up">
                      <div class="form-group">
                        <label for="Username Feeder" class="control-label col-lg-2">Username Feeder</label>
                        <div class="col-lg-10">
                          <input type="text" name="username" value="<?=$data_edit->username;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Password Feeder" class="control-label col-lg-2">Password Feeder</label>
                        <div class="col-lg-10">
                          <input type="text" name="password" value="<?=$data_edit->password;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="URL Feeder" class="control-label col-lg-2">URL Feeder</label>
                        <div class="col-lg-10">
                          <input type="text" name="url" value="<?=$data_edit->url;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="PORT" class="control-label col-lg-2">PORT</label>
                        <div class="col-lg-10">
                          <input type="text" name="port" value="<?=$data_edit->port;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode PT" class="control-label col-lg-2">Kode PT</label>
                        <div class="col-lg-10">
                          <input type="text" name="id_sp" value="<?=$data_edit->id_sp;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="live" class="control-label col-lg-2">live</label>
                        <div class="col-lg-10">
                          <?php if ($data_edit->live=="Y") {
      ?>
      <input name="live" class="make-switch" type="checkbox" checked>
      <?php
    } else {
      ?>
      <input name="live" class="make-switch" type="checkbox">
      <?php
    }?>
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <input type="submit" class="btn btn-primary btn-flat" value="submit">
                        </div>
                      </div><!-- /.form-group -->
                    </form>
                    <a href="<?=base_index();?>config-akun-feeder" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
 