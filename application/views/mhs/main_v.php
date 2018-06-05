<?php
	//if($this->session->userdata("sesiuser")== false) header("Location:login");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?php echo $this->config->item('project_title')?></title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/design.css" type="text/css" media="screen"/>
	<!-- BELUM KEPAKAI -->
	<!--<script src="</?php echo base_url()?>javascript/jquery-1.2.3.pack.js" type="text/javascript"></script>
	<script src="</?php echo base_url()?>javascript/jquery.validate.pack.js" type="text/javascript"></script>-->
	<!-- END BELUM KEPAKAI -->
	<script src="<?php echo base_url();?>asset/javascript/jquery-1.3.2.min.js" type="text/javascript"></script>

	<script type="text/javascript" src="<?php echo base_url();?>asset/javascript/jquery.js"></script>
    <script type='text/javascript' src='<?php echo base_url();?>asset/plugin/lightbox/facebox.js'></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/javascript/jquery-latest.pack.js"></script>

    <link href="<?php echo base_url();?>asset/plugin/lightbox/facebox.css" rel="stylesheet" type="text/css" />
    <script type='text/javascript'>
        var site = "<?php echo site_url()?>";
        var loading_image_large = "<?php echo base_url();?>asset/images/design/loading-good.gif";
    </script>	
	
	
	<script src="<?php echo base_url()?>javascript/DatePicker.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url();?>asset/javascript/loading.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>asset/javascript/app.js" type="text/javascript"></script>

	<!--<script language='javascript'>
		function confirmasi(){
			alert("KONFIRMASI\nDalam Waktu 10 Menit sejak sekarang, SIMAK dilakukan Maintenece, Jadi Gk bisa diakses. Sabar ya... Cuma 10 Menit Aja Koks");
		}
	</script>-->
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
			var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
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
		<a href="#" style="padding-top:5px; margin:10px;">
			<h2 style="margin-left:20px;">SIAKAD <?php echo $pt->nama?></h2>
			<!--<img class="noprint" src="</?php echo base_url();?>asset/images/design/logo.gif" width="780" height="29" alt="" />-->
		</a>
		<ul id="top-navigation" class="tabs">
			<li><span><span><a href="javascript:void(0)" onclick='show("mhs/main/home","#center-column")'>Home</a></span></span></li>
			<?php if($aktifsemester){?>
			<li class=""><span><span>
				<a href="javascript:void(0)" class="tab" onclick='show("mhs/simkrs","#center-column");switch_tab(this)'>Pengisian KRS</a>
			</span></span></li>
			<?php } ?>
			<?php if($aktifksp){?>
			<li class=""><span><span>
				<a href="javascript:void(0)" class="tab" onclick='show("mhs/simkrs_ksp","#center-column");switch_tab(this)'>KRS KSP</a>
			</span></span></li>
			<?php } ?>
			<li><span><span>
				<!--<a href="javascript:void(0)" onclick='show("mhs/simkrs/khs","#center-column")'>KHS</a>-->
				<a href="javascript:void(0)" class="tab" onclick='show("mhs/simambilmk/krs","#center-column");switch_tab(this)'>File KRS</a>
			</span></span></li>
			<li><span><span>
				<!--<a href="javascript:void(0)" onclick='show("mhs/simkrs/khs","#center-column")'>KHS</a>-->
				<a href="javascript:void(0)" class="tab" onclick='show("mhs/simambilmk/khs","#center-column");switch_tab(this)'>KHS</a>
			</span></span></li>
			<li><span><span>
				<a href="javascript:void(0)" class="tab" onclick='show("mhs/simambilmk/transkrip","#center-column");switch_tab(this)'>Transkrip</a>
			</span></span></li>
			<li><span><span>
				<!--<a href="javascript:void(0)" onclick='show("mhs/simkrs/khs","#center-column")'>KHS</a>-->
				<a href="javascript:void(0)" class="tab" onclick='show("mhs/pembayaran/bayar","#center-column");switch_tab(this)'>History Pembayaran</a>
			</span></span></li>
			<li><span><span><a href="javascript:void(0)" onclick='show("mhs/simambilmk/jadwal_bynim","#center-column")'>Jadwal Kuliah</a></span></span></li>
			<li><span><span><a href="javascript:void(0)" onclick='show("mhs/masmahasiswa/detail","#center-column")'>Profil</a></span></span></li>
			<li><span><span><a href="javascript:void(0)" onclick='show("mhs/utility/about","#center-column")'>About</a></span></span></li>
			<li><span><span><a href="javascript:void(0)" onclick='show("mhs/utility/help","#center-column")'>? Help</a></span></span></li>
			<div id="loading"></div>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
			<h3>SIMAK MENU</h3>
			<ul class="nav">
			<?php if($aktifsemester){?>
				<li><a href="javascript:void(0)" onclick='show("mhs/simkrs","#center-column")'>KRS</a></li>
			<?php } ?>
			<?php if($aktifksp){?>
				<li><a href="javascript:void(0)" onclick='show("mhs/simkrs_ksp","#center-column")'>KRS KSP</a></li>
			<?php } ?>
				<li><a href="javascript:void(0)" onclick='show("mhs/simambilmk/krs","#center-column");switch_tab(this)'>File KRS</a></li>
				<li><a href="javascript:void(0)" onclick='show("mhs/simambilmk/khs","#center-column");switch_tab(this)'>KHS</a></li>
				<li><a href="javascript:void(0)" onclick='show("mhs/simambilmk/transkrip","#center-column");switch_tab(this)'>Transkrip</a></li>
				<li><a href="javascript:void(0)" onclick='show("mhs/pembayaran/bayar","#center-column");switch_tab(this)'>History Pembayaran</a></li>
				<li><a href="javascript:void(0)" onclick='show("mhs/simambilmk/jadwal_bynim","#center-column")'>Jadwal Kuliah</a></li>
				<li><a href="javascript:void(0)" onclick='show("mhs/masmahasiswa/detail","#center-column")'>Profil</a></li>
				<li><a href="javascript:void(0)" onclick='show("mhs/utility/about","#center-column")'>About</a></li>
				<li><a href="javascript:void(0)" onclick='show("mhs/utility/help","#center-column")'>? Help</a></li>
				<li class="last"><?php echo anchor("mhs/loginmhs/logout","LogOut");?></li>
			</ul>
			<h3>Pendaftaran</h3>
			<!--<ul class="nav">-->
				<!--<li><a href="javascript:void(0)" onclick='show("mhs/simdaftarbeasiswa/input","#center-column")'>Beasiswa</a></li>-->
				<!--<li><a href="javascript:void(0)" onclick='show("mhs/simdaftarskripsi/browse","#center-column")'>KP/TA/Skripsi</a></li>-->
			<!--</ul>-->
			<a href="javascript:void(0)" target="_black" class="link">Official Site</a>
			<a href="javascript:void(0)" target="_blank" class="link">e-Learning</a>
			<!--<div style="border:1px solid #ababab;padding:8px;height:34px;">
			<a href="ymsgr:sendIM?ramah_sekali">
				<img border="0" src="http://opi.yahoo.com/online?u=ramah_sekali&amp;m=g&amp;t=1" title="Rahma PMB Support" width="131" alt="Rahma" align="left" valign="middle">
			</a>
			</div>-->
		</div>
		<div id="center-column">
	      <?php
			$this->load->view('mhs/home_v');
	      ?>
		</div>
		<div id="right-column">
			<strong class="h">INFO</strong>
			<div class="box">
				Kritik dan Saran dapat menghubungi <?php echo $pt->nama?>, <?php echo $pt->alamat?>
			</div>
		</div>
		<div id="right-column">
			<strong class="h">Web Stat</strong>
			<div class="box">
				<?php echo $this->load->view("mhs/web_stat");?>
			</div>
		</div>
	</div>
	<div id="footer"></div>
</div>
</body>
</html>
