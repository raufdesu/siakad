
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Data Wilayah
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>data-wilayah">Data Wilayah</a></li>
                        <li class="active">Data Wilayah List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                <h3 class="box-title">List Data Wilayah</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="dtb_data_wilayah" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>

                          <th>ID Kecamatan</th>
                          <th>Provinsi</th>
                          <th>Kabupaten</th>
													<th>Kecamatan</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
        <?php
       foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url) {
                          if ($role_act["insert_act"]=="Y") {
                    ?>
          <a href="<?=base_index();?>data-wilayah/tambah" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
                          <?php
                          } 
                       } 
}
      ?>
                </section><!-- /.content -->
        <script type="text/javascript">


var dataTable = $("#dtb_data_wilayah").dataTable({

           'bProcessing': true,
            'bServerSide': true,
    
            'ajax':{
              url :'<?=base_admin();?>modul/data_wilayah/data_wilayah_data.php',
            type: 'post',  // method  , by default get
          error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });

</script>  
            