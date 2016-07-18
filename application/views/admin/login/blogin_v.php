<head>
	<title>Daftar Login</title>
</head>
<h3> &nbsp; Daftar Data Login</h3>
<div style="overflow:scroll; height:300px; margin:0 10px 0 10px;">
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Username</th>
			<th>Nama Lengkap</th>
			<th style="width:15px" class="last">Pilih</th>
		</tr>
<?php
	$i = 1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_login as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->username;?></td>
		<td class="first"><?php echo $this->auth->get_namauser($bm->username);?></td>
		<td align='center'>
			<a href="javascript:void(0)" onclick='pilih("<?php echo $bm->idlogin?>","<?php echo $bm->username?>")'>
				<?php
					$arim = array('src' => 'asset/images/design/check.png','border'=>0);
					echo img($arim);
				?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
</div>
</div>
<div class='button' style='float:right;margin:10px;'><a href='javascript:void(0)' onclick='jQuery.facebox.close()'>Tutup</a></div>
<script>
	function pilih(idlogin,username){
		$('input[name=idlogin]').val(idlogin);
		$('input[name=username]').val(username);
		jQuery.facebox.close();
	}
</script>