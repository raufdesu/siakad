<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
		<link rel="stylesheet" href="<?php echo base_url();?>css/login/validationEngine.jquery.css" type="text/css" media="screen" />
		<script src="<?php echo base_url();?>javascript/login/jquery.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>javascript/login/jquery.validationEngine-id.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>javascript/login/jquery.validationEngine.js" type="text/javascript"></script>
	<script>
		$(document).ready(function(){
			$("#formID").validationEngine()
		});
	</script>	

	<meta content="IE=EmulateIE7" http-equiv="X-UA-Compatible">
	<title>SIMAK STMIK EL RAHMA YOGYAKARTA</title>
	<link charset="utf-8" href="<?php echo base_url();?>css/login/library.css" media="screen" rel="stylesheet" title="mint product css" type="text/css">
	<link charset="utf-8" href="<?php echo base_url();?>css/login/tab.css" media="screen" rel="stylesheet" title="mint product css" type="text/css">
	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="/sc/ph1748.13.1/css/iehacks.css" />
	<![endif]
	-->
	<!--[if lt IE 7]>
	<script type="text/javascript" src="/sc/ph1748.13.1/js/lib/iepngfix_tilebg.js"></script>
	<![endif]-->
	<script src="<?php echo base_url();?>javascript/tab.js" type="text/javascript" charset="utf-8"></script>
	<script language="javascript">
		function setFocus(){
			document.getElementById("inUsername").focus();
		}
	</script>
</head>
<!--<body OnLoad="setFocus()">-->
<body>
	<p id='title'>SIMAK STMIK EL RAHMA YOGYAKARTA</p>
	<div style="text-align:center;">
		<ul class="basictab" id="hometabs">
			<li><a href="#" rel="tvimi">Login Mahasiswa</a></li>
			<li><a href="#" rel="tcompro" class="selected">EL Rahma Info !</a></li>
		</ul>
		<div id="tcompro" class="tabcontent">
			<fieldset id='fieldset'>
				<legend>Lupa Password</legend>
			Jika lupa dengan NIM atau Password anda, anda dapat menanyakan langsung ke Front Office (FO) dan tidak boleh diwakilkan.
			</fieldset>
		</div>
		<div id="tvimi" class="tabcontent">
			<?php
				$atrform = array(
					"id" => "formID",
					"nama" => "frmLogin",
					"class" => "formular"
				);
				$atrusername = array(
					"type" => "text",
					"name" => "username",
					"OnLoad" => "this.focus()",
					"maxlength" => "8",
					"size" => "15",
					"id" => "inUsername",
					"class" => "validate[required,custom[onlyNumber]] text-input"
				);
				$atrpassword = array(
					"type" => "password",
					"name" => "password",
					"size" => "20",
					"id" => "password",
					"class"=>"validate[required] text-input"
				);
				$atrlogin = array(
					"type" => "submit",
					"name" => "cmdLogin",
					"id" => "inButton",
					"value" => "Login"
				);
				$atrclose = array(
					"id" => "inCancel"
					//"OnClick" => "$.validationEngine.closePrompt('.formError',true)"
				);
				echo "<div id='form'>";
					echo form_open("mhs/loginmhs/cek_loginmhs",$atrform);
					$this->load->library('table');
					$this->table->add_row('<p>NIM</p>', form_input($atrusername));
					$this->table->add_row('<p>Password</p>', form_input($atrpassword));
					$this->table->add_row('', form_submit($atrlogin).anchor(base_url(),"Cancel",$atrclose));
					echo $this->table->generate();
					$this->table->clear();
					echo form_close();
					echo "<div id='alert'>".$alert."</div>";
				echo "</div>";
			?>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	var transaction=new ddtabcontent("hometabs")
	transaction.setpersist(true)
	transaction.setselectedClassTarget("link") //"link" or "linkparent"
	transaction.init()

	var load_method = (window.ie ? 'load' : 'domready');
	window.addEvent(load_method,function(){
		Lightbox.init({descriptions: '.lightboxDesc', showControls: true});
	});
</script>