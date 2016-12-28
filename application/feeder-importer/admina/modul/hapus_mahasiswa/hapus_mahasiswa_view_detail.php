<?php
include "lib/nusoap/nusoap.php";
?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Mahasiswa <?php echo $db->fetch_single_row('jurusan','kode_jurusan',$id_jur)->nama_jurusan;?>
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>hapus-mahasiswa">Hapus Mahasiswa</a></li>
                        <li class="active">Hapus Mahasiswa List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                             
                                <div class="box-body table-responsive">
<?php

$config = $db->fetch_single_row('config_user','id',1);

if ($config->live=='Y') {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
} else {
  $url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
}
  $client = new nusoap_client($url, true);
  $proxy = $client->getProxy();



  # MENDAPATKAN TOKEN
  $username = $config->username;
  $password = $config->password;
  $result = $proxy->GetToken($username, $password);
  $token = $result;

  $semester = $proxy->GetRecordset($token,"semester", '',"id_smt DESC", '','');

?>


                                    <table id="dtb_hapus_kelas" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>    
                                        <th><input type="checkbox"  id="bulkDelete"  /> <button id="deleteTriger"><i class="fa fa-trash"></i></button></th>
     
                             <th>Nama</th>              
                          <th>NIM</th>
                          <th>Tanggal Lahir </th>
                          <th>Angkatan</th>
                          <th>Action</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                                       <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <button type="button" data-id="<?=$id_jur;?>" data-uri="<?=base_admin();?>modul/hapus_kelas/hapus.php" class="btn btn-danger" id="hapus_massal"><i class="fa fa-recycle"></i> Hapus Data Massal</button>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
<div class="modal modal-danger" id="mass_info" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Hapus Data Massal</h4> </div> <div class="modal-body"> 
<div class="form-group" style="margin-bottom:32px">
                        <label style="padding-top:6px" for="Jurusan" class="control-label col-lg-2">Angkatan</label>
                        <div class="col-lg-10">
                          <select  name="sem_delete" id="sem_delete"  class="form-control " tabindex="2" required>
                           <?php 
                   $firstYear = (int)date('Y') - 20;
$current_year = $firstYear+20;
for($i=$current_year;$i>=$firstYear;$i--)
{
    echo '<option value='.$i.'1>'.$i.'</option>';
}
?>

              </select>
                        </div>
<input type="hidden" id="semester_selected">
                      </div><!-- /.form-group -->
 </div> <div class="modal-footer"> <button type="button" id="delete_mhs_massal" class="btn btn-danger">Delete</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->
        <?php
       foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url) {
                          if ($role_act["insert_act"]=="Y") {
                    ?>
          <a href="<?=base_index();?>hapus-kelas/tambah/<?=$id_jur;?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
                          <?php
                          } 
                       } 
}
      
  foreach ($db->fetch_all("sys_menu") as $isi) {

  //jika url = url dari table menu
  if ($path_url==$isi->url) {
   if ($role_act["up_act"]=="Y") {
  $edit = '<a href="'.base_index()."hapus-mahasiswa/edit/'+aData[indek]+'".'" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>';
  } else {
    $edit ="";
  }
  if ($role_act['del_act']=='Y') {
   $del = "<span data-id='+aData[indek]+' data-uri=".base_admin()."modul/hapus_mahasiswa/hapus.php".' class="btn btn-danger hapus_feeder_kelas btn-flat"><i class="fa fa-trash"></i></span>';
  } else {
    $del="";
  }
                   } 
  }
  
?>  
                </section><!-- /.content -->
        <script type="text/javascript">
$(document).ready(function() {





var dataTable = $("#dtb_hapus_kelas").dataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var indek = aData.length-1;           
     $('td:eq('+indek+')', nRow).html('<?=$edit.'&nbsp'.$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
           'bProcessing': true,
            'bServerSide': true,
              "searching": true,
               "ordering": false,
                 "columnDefs": [ {
              "targets": [0,4],
              "orderable": false,
              "searchable": true

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/hapus_mahasiswa/hapus_mahasiswa_data.php",
            type: "post",  // method  , by default get
            data: function ( d ) {
              
                      d.jurusan = "<?=$id_jur;?>";
                  },
          error: function (xhr, error, thrown) {
            console.log(xhr);
              $(".dtb_akm-error").html("");
              $("#dtb_akm").append('<tbody class="dtb_akm-error"><tr><th colspan="9">No data found in the server</th></tr></tbody>');
              $("#dtb_akm_processing").css("display","none");

            }
          },
          "language": {
             searchPlaceholder: "Pencarian dengan NIM atau Nama",
          "processing": "<i class=\"fa fa-spinner fa-spin\"></i> Loading data, please wait..." //add a loading image,simply putting <img src="loader.gif" /> tag.
   },

        });




$("#bulkDelete").on('click',function() { // bulk checked
          var status = this.checked;
          $(".deleteRow").each( function() {
            $(this).prop("checked",status);
          });
        });

$('#deleteTriger').on("click", function(event){
          if( $('.deleteRow:checked').length > 0 ){
            event.preventDefault();


            var ids = [];
            $('.deleteRow').each(function(){
              if($(this).is(':checked')) {
                ids.push($(this).val());
              }
            });
            var ids_string = ids.toString();


            $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

          $("#loadnya").show();
          $.ajax({
              type: "POST",
              url: "<?=base_admin();?>modul/hapus_mahasiswa/hapus.php?act=del_massal",
              data: {data_ids:ids_string},
               async: true,
              success: function(result) {
                console.log(result);
                $("#loadnya").hide();
                window.location.reload();
              },
              async:true
            });
          $('#ucing').modal('hide');



        });


          }
        });

$('#delete_mhs_massal').on("click", function(event){
  event.preventDefault();
   $('#mass_info').modal('hide');
    $("#loadnya").show();

          $.ajax({
              type: "POST",
              url: "<?=base_admin();?>modul/hapus_mahasiswa/hapus.php?act=delete_all",
              data: {data_ids:$("#sem_delete").val(),jurusan: "<?=$id_jur;?>"},
               async: true,
              success: function(result) {
               // console.log(result);
                $("#loadnya").hide();
                window.location.reload();
              },
              async:true
            });
        });


  $("#sem_filter").change(function(){
    $("#matkul").html('');
    $("#matkul").chosen();
    $("#loadnya").show();
    $("#img_loader").show();
    
      $.ajax({
          url : "<?=base_admin();?>modul/hapus_kelas/matakuliah.php",
          type : "post",
          data : {jurusan : "<?=$id_jur;?>",semester : $(this).val() },
          success : function(data) {
            $("#loadnya").hide();
            $("#img_loader").hide();
              $("#matkul").html(data);
              $("#matkul").trigger('chosen:updated');

          }

      });
     
  });


});



</script>  
            