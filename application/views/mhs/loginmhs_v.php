<html>
<head>
	<title>LOGIN SYSTEM</title>
	<link charset="utf-8" href="<?php echo base_url();?>asset/css/login/login.css" media="screen" rel="stylesheet" type="text/css">
	<link type="text/css" href="<?php echo base_url()?>asset/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="<?php echo base_url()?>asset/js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>asset/js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript">
		$(function(){
			// Dialog
			$('#dialog').dialog({
				autoOpen: true,
				width: 350,
				buttons: {
					"Ok, Tutup": function() { 
						$(this).dialog("close"); 
					} 
				}
			});
			// Dialog Link
			$('#dialog_link').click(function(){
				$('#dialog').dialog('open');
				return false;
			});
			
		});
	</script>
	<script language="javascript">
		function LoadFocus(){
			document.form.username.focus();
			return false;
		}
	</script>
	<style>
		#title-login{
			color: #000;
		}
		#title-login h1{
			font-size:35px;
			padding-top: 16px;
			font-family:Arial,Georgia,Serif;
			margin: 0px;
			padding:0px;
			color: #044C0A;
		}
	</style>
</head>
<body OnLoad="LoadFocus()">
	<!--<div id="dialog" title="Petunjuk Pemakaian"></?php $this->load->view('mhs/loginmhs/tpengumuman_v')?></div>-->
	<?php //$this->load->view('mhs/supportonline_v'); ?>
	<?php echo form_open("mhs/loginmhs/cek_loginmhs","name='form'"); ?>
	<div class='bglogin'>
	<!--<a href="#" style="float:right; margin:-35px -35px 0 0" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-newwin"></span>
	</?php $arimg1 = array("style" => "border:none", "src" => "asset/images/design/help.png"); echo img($arimg1) ?>
	</a>-->
	<div style="width:345px;text-align:center;margin:0px auto; float:right;color:#fff"><?php
		$arimg = array(
			"src"	=> "asset/images/design/logo.png",
			"style"	=> "width:110px; margin:10px auto;border:none !important;"
		);
		echo img($arimg);
	?><br />UNIV. MUHAMMADIYAH MATARAM
	</div>
	<div class='flash' id='title-login'>
		<center>
			<h1>SIAKAD</h1>Sistem Informasi Akademik
		</center>
	</div>
	<!--<div class='flash'>
		<object>
			<embed src="</?php echo base_url()?>asset/images/design/simak.swf" width="346" height="115">
			</embed>
		</object>	
	</div>-->
	<table align="center" style="margin-top:35px">
		<tr>
			<td><b>Username</b></td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td><b>Password</b></td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<?php echo form_submit('cmdLogin', 'Login', 'Class="button"');?>
				<?php echo anchor(base_url(),'Batal','Class="hight_link"');?>
			</td>
		</tr>
	</table>
	</div>
	<?php echo "<div align='center'>".form_error('username')."</div>"; ?>
	<?php echo "<div align='center'>".$alert."</div>"; ?>
	<?php echo form_close();?>
	<?php echo anchor(base_url().'index.php/admin/login/','.','style="float:right;color:#EFEFEF;text-decoration:none"')?>
</body>
</html>