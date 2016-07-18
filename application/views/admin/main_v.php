<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?php echo 'SIAKAD '.$this->config->item('project_title')?></title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/design_admin.css" type="text/css" media="all"/>
	<link rel="shortcut icon" href="<?php echo base_url()?>asset/images/design/favico.png" />
	<!-- BELUM KEPAKAI -->
	<!--<script src="</?php echo base_url()?>javascript/jquery-1.2.3.pack.js" type="text/javascript"></script>
	<script src="</?php echo base_url()?>javascript/jquery.validate.pack.js" type="text/javascript"></script>-->
	<!-- END BELUM KEPAKAI -->
	<script src="<?php echo base_url();?>asset/javascript/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/javascript/jquery.js"></script>
    <script type='text/javascript' src='<?php echo base_url();?>asset/plugin/lightbox/facebox.js'></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/javascript/jquery-latest.pack.js"></script>
	
    <link href="<?php echo base_url();?>asset/css/kartu/noprint.css" rel="stylesheet" media="print" type="text/css" />
    <link href="<?php echo base_url();?>asset/plugin/lightbox/facebox.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url()?>asset/javascript/DatePicker.js" type="text/javascript"></script>
    <script type='text/javascript'>
        var site = "<?php echo site_url()?>";
        var loading_image_large = "<?php echo base_url();?>asset/images/design/loading-good.gif";
    </script>	
	<script src="<?php echo base_url();?>asset/javascript/loading.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>asset/javascript/app.js" type="text/javascript"></script>
	
	<script>
	var x = 1;
	function cek(){
	    $.ajax({
			url: "<?php echo base_url()?>index.php/admin/simcalonmhs/notifikasi/",
	        cache: true,
	        success: function(msg){
	            $("#notifikasi").html(msg);
	        }
	    });
	    var waktu = setTimeout("cek()",300000);
	}

	$(document).ready(function(){
	    cek();
	    $("#pesan").mouseover(function(){
	        $("#loading").show();
	        if(x==1){
	            $("#pesan").css("background-color","#efefef");
	            x = 0;
	        }else{
	            $("#pesan").css("background-color","#4B59a9");
	            x = 1;
	        }
	        $("#info").toggle();
	        //ajax untuk menampilkan pesan yang belum terbaca
	        $.ajax({
	            url: "<?php echo base_url()?>masuk/lihatnotifikasi/",
	            cache: true,
	            success: function(msg){
	                $("#loading").hide();
	                $("#konten-info").html(msg);
	            }
	        });

	    });
	    $("#content").mouseover(function(){
	        $("#info").hide();
	        $("#pesan").css("background-color","#4B59a9");
	        x = 1;
	    });
	});
	</script>
	
	<script type='text/javascript'>
		$(document).ready(function() {
			//When page loads...
			$(".tab_content").hide(); //Hide all content
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content

			//On Click Event
			$("ul.tabs li").click(function() {

				$("ul.tabs li").removeClass("active"); //Remove any "active" class
				$(this).addClass("active"); //Add "active" class to selected tab
				$(".tab_content").hide(); //Hide all tab content

				var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
				$(activeTab).fadeIn(); //Fade in the active ID content
				return false;
			});
		});
		function load_submit(){
			var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
			$.ajax({
				beforeSend: function(){
					$(div).html(image_load);
				},
				success: function(response){
					$(div).html(response);
				},
				dataType:"html"
			});
		}
		function show(page,div){
			do_scroll(0);
			var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
			var site = "<?php echo site_url()?>";
			$.ajax({
				url: site+"/"+page,
				beforeSend: function(){
					$(div).html(image_load);
				},
				success: function(response){
					$(div).html(response);
				},
				dataType:"html"
			});
			return false;
		}
		function load(page,div){
			do_scroll(0);
			var site = "<?php echo site_url()?>";
			$.ajax({
			  url: site+"/"+page,
			  success: function(response){			
			  $(div).html(response);
			  },
			dataType:"html"  		
			});
			return false;
		}
	</script>
</head>
<body>
<div id="main">
	<div id="header">
		<div class="log">
		<!--<div id="notifikasi"></div>-->
		<?php
			date_default_timezone_set("Asia/Jakarta");
			if($this->session->userdata('sesi_status') == 'dosen'){
				echo $this->auth->get_namauser($this->session->userdata('sesi_user'));
			}elseif($this->session->userdata('sesi_status') == 'prodi'){
				echo $this->auth->get_namaprodi($this->session->userdata('sesi_prodi'));
			}else{
				echo $this->session->userdata('sesi_status');
			}
		?> |
		<?php echo anchor("admin/login/logout","LogOut", array('style'=>'color:red'));?>
		</div>
		<a class="logo"><h2><?php echo $this->config->item('project_title')?></h2></a>
		<p><?php echo $this->config->item('project_desc')?></p>
		<?php $this->load->view('admin/topmenu_v')?>
	</div>
	<div id="middle">
		<div id="left-column">
			<?php echo $this->load->view("admin/menu_kiri_v");?>
		</div>
		<div id="center-column">
		  <?php echo $this->load->view($main);?>
		</div>
		<!--<div id="right-column">
			<strong class="h">Profil</strong>
			<div class="box">
				</?php echo anchor("admin/perguruantinggi","*Perguruan Tinggi")."<br />";?>
				</?php echo anchor("admin/badanhukum","*Badan Hukum")."<br />";?>
				</?php echo $this->load->view("admin/asesoris_v");?>
			</div>
		</div>-->
	</div>
	<div id="footer"></div>
</div>


</body>
</html>
