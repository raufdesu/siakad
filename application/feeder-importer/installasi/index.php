<!DOCTYPE>
<html>
<head>
  <title>Feeder Importer Installation Wizard</title>
 
</head>

 <link href="../admina/assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
     <script src="../admina/assets/login/js/jquery.js"></script>
      <style type="text/css">
    #loadnya {
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:1000;
    background-color:#fff;
    opacity: .4;
 }
 .ajax-loader {
    position: fixed;
    left: 50%;
    top: 50%;
    margin-left: -32px; /* -1 * image width / 2 */
    margin-top: -32px;  /* -1 * image height / 2 */
    display: block;
}
.text-wait {
    position: fixed;
    top: 43%;
    left: 36%;
    font-size: 23px;
}
.sc {
    background-color: #00a65a !important;
    border-color: #00733e;
    color:#fff;
    border-left: 5px solid #eee;
    display: none;
}
.er {
  display: none;
}

.alert {
    border-radius: 3px;
}

.bg-red, .callout.callout-danger, .alert-danger{
    background-color: #dd4b39 !important;
    border-radius: 3px;
    margin: 0 0 20px 0;
    padding: 15px 30px 15px 15px;
    border-left: 5px solid #eee;
        border-color: #c23321;
        color:#fff;
}

  </style>
<body>
   <div id="loadnya" style="display:none">
<img src="../admina/assets/dist/img/loadnya.gif" class="ajax-loader"/>
<span class='text-wait' style="display:none">Mohon Tunggu, Sedang Installasi</span>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form class="form-horizontal">
<fieldset>


<!-- change col-sm-N to reflect how you would like your column spacing (http://getbootstrap.com/css/#forms-control-sizes) -->


<!-- Form Name -->
<legend>Installasi Feeder Importer</legend>

<div class="form-group">
  <div class="col-sm-12">
   <div id="result">

<div class="alert alert-success sc alert-dismissible">
                <h4>Installasi Berhasil. klik <a href="../admina/login.php">disini</a> untuk login. Anda bisa menggunakan username : admin, password : admin</h4>
              </div>
</div>
<div class="callout callout-danger er">
                <h4>Error</h4>

                <p class="error-content"></p>
              </div>
  </div>

</div>

<div class="form-install">

<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="server" class="control-label col-sm-3">Server Host</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="server" value="localhost">
    
  </div>
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="database" class="control-label col-sm-3">Database Name</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="database" value="importer_free" required="">
    
  </div>
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="dbuser" class="control-label col-sm-3">Database User</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="dbuser" value="root">
    
  </div>
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="dbpass" class="control-label col-sm-3">Database Password</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="dbpass">
    
  </div>
</div>
<!-- Button http://getbootstrap.com/css/#buttons -->
<div class="form-group">
  <label class="control-label col-sm-3" for="install"></label>
  <div class="text-left col-sm-9">
    <input type="submit" id="install" name="install" class="btn btn-primary" aria-label="" value="Install Now">
    
  </div>
</div>
</div>

</fieldset>
</form>
    </div>
  </div>
</div>

<script type="text/javascript">



 $('#install').click(function()
{

      var host= $("#server").val();
      var db= $("#database").val();
      var db_user= $("#dbuser").val();
      var db_pass= $("#dbpass").val();


      if (host=='' || db=='' || db_user=='')
      {
          if (host=='') {
              $("#server").focus();
          }
          if (db=='') {
              $("#database").focus();
          }
          if (db_user=='') {
              $("#dbuser").focus();
          }


      } else {

        var data_install = {
            host: host,
            db: db,
            db_user: db_user,
            db_pass: db_pass
        }

         $('#loadnya').show();
         $(".text-wait").show();
             $.ajax({
              url: "install.php",
              type : "post",
              data : data_install,
              success: function(data) {
                console.log(data);
                      $('#loadnya').hide();
                       $(".text-wait").hide();
                          if (data=='good') {
                            $(".form-install").html('');
                            $('.sc').show();
                            $('.er').hide();
                            //redirect jika berhasil login
                            //window.location="./index.php/";
                          } else {
                             $('.er').fadeIn();
                             $(".error-content").html(data);
                          }

              }
            });
      }

return false;
});
</script>
</body>
</html>