<head>
	<title>Biodata Mahasiswa</title>
	<style media="all" type="text/css">@import "<?php echo base_url();?>css/design.css";</style>
	<style>*{font-size:12;}</style>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
	<script type="text/javascript">
			$(document).ready(function() {
				//When page loads...
				$(".tab_content").hide(); //Hide all content
				//$("ul.tabs li:first").addClass("active").show(); //Activate first tab
				//$(".tab_content:first").show(); //Show first tab content

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
	</script>
	<style>
	.nonactive{
		color:#fff !important;
	}
	</style>
</head>
<div id="tabs">
	<ul class="tabs">
		<li class=''><a href='javascript:void(0);' onclick='load("mhs/masmahasiswa/detail","#table");'>Data Mahasiswa</a></li>
		<li class=''><a href='javascript:void(0);' onclick='load("barangsilver","#table");'>Ubah Password</a></li>
	</ul>
</div>
<div id="table"></div>