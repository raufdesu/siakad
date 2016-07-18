<html>
<head>
	<title>Login Sistem Iformasi Akademik</title>
	<link charset="utf-8" href="<?php echo base_url();?>asset/css/login/login.css" media="screen" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="<?php echo base_url()?>asset/images/design/favico.png" />
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
			color: #044C0A;
		}
	</style>
</head>
<body OnLoad="LoadFocus()">
	<?php echo form_open("admin/login/cek_login","name='form'"); ?>
	<div class='bglogin'>
	<div style="width:345px;text-align:center;margin:0px auto; float:right;color:#fff"><?php
		$arimg = array(
			"src"	=> "asset/images/design/logo.png",
			"style"	=> "width:100px; margin:10px auto;border:none !important;"
		);
		echo img($arimg);
	?><br />UNIV. MUHAMMADIYAH MATARAM
	</div>
	<div id="title-login" class='flash'>
		<center>
		<h1>SIAKAD</h1>
			Sistem Informasi Akademik
		</center>
		<!--<object>
			</ini gk kepakai kok param name="movie" value="</?php echo base_url()?>img/iklan/iklan_samara.swf">
			<embed src="</?php echo base_url()?>asset/images/design/simak.swf" width="346" height="115">
			</embed>
		</object>-->
	</div>
	<table>
		<tr>
			<td><b>Username</b></td>
			<td><input type="text" value="<?php echo $this->input->post('username')?>" name="username"></td>
		</tr>
		<tr>
			<td><b>Password</b></td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td><b>Pertanyaan</b></td>
			<td>
				<input type="hidden" value="<?php echo $c?>" name="jawaban" />
				<b>: <?php echo $a?></b>+<b><?php echo $b?></b>=<input type="text" name="c" maxlength="2" size="1">
			</td>
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
	<?php echo "<div align='center'>".form_error('c').'<br />'.form_error('username').'<br />'.form_error('password')."</div>"; ?>
	<?php echo "<div align='center'>".$alert."</div>"; ?>
	<?php echo form_close();?>
</body>
</html>