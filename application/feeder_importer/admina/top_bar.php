<header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo"><b>Feeder Importer</b></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
       
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?=base_url();?>upload/back_profil_foto/<?=$db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->foto_user?>" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?=ucwords($db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->first_name)?> <?=ucwords($db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->last_name);?></span>
                </a>

                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?=base_url();?>upload/back_profil_foto/<?=$db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->foto_user?>" class="img-circle" alt="User Image" />
                    <p>
                                        <?=ucwords($db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->first_name)?> <?=ucwords($db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->last_name);?> - <?=$db->fetch_single_row('sys_group_users','id',$_SESSION['level'])->deskripsi?>
                                        <small>Member since <?=$db->fetch_custom_single("SELECT MONTHNAME(STR_TO_DATE(month(date_created), '%m')) as bulan from sys_users where id=? ",array('id'=>$_SESSION['id_user']))->bulan;?> <?=$db->fetch_custom_single("select year(date_created) as tahun from sys_users where id=?",array('id'=>$_SESSION['id_user']))->tahun;?> </small>
                                    </p>
                  </li>
                  <!-- Menu Body -->
        
                  <!-- Menu Footer-->
                   <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?=base_index();?>profil" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?=base_admin();?>logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

<div class="modal" data-backdrop="static" data-keyboard="false" id="ucing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Konfirmasi</h4> </div> <div class="modal-body"> <p>Apakah Anda yakin ingin menghapus data ini?</p> </div> <div class="modal-footer"> <button type="button" id="delete" class="btn btn-danger">Delete</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->
<div class="modal modal-danger" id="hapus_error" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Konfirmasi</h4> </div> <div class="modal-body"> <p><i class="fa fa-remove fa-5x"></i><span class="text-confirm"> Apakah Anda yakin ingin menghapus semua data error?</span></p> </div> <div class="modal-footer"> <button type="button" id="delete" class="btn btn-danger">Delete</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->
<div class="modal modal-danger" data-backdrop="static" data-keyboard="false" id="kosong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Konfirmasi</h4> </div> <div class="modal-body"> <p><i class="fa fa-remove fa-5x"></i><span class="text-confirm"> Apakah Anda yakin ingin menghapus semua data?</span></p> </div> <div class="modal-footer"> <button type="button" id="delete" class="btn btn-danger">Delete</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->

<div class="modal modal-warning" id="informasi" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Informasi</h4> </div> <div class="modal-body"> <p id="isi_informasi">

</p> </div> <div class="modal-footer"> <button type="button" id="ok_info" class="btn btn-outline pull-left">Close</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->


