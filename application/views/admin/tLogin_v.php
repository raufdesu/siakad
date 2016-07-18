<div class="top-bar">
	<?php
		$this->load->helper("html");
		echo anchor("admin/login/no_password/",open_img("design/","cache.png","button")." Generate Password","class='navi'");
	?>
	<h1><?php echo $title;?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php echo form_open("admin/login/cari_password");
	echo "<label>".form_input("txtCari",$this->session->userdata("sesi_caripassword"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari")."</label>";
	echo form_close();?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<!--<th>Kode Kuliah</th>-->
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th class="last">Password</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "630",
		"height" => "475",
		"screenx" => "320",
		"screeny" => "30"
	);
	foreach($browse_login as $bm):
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bm->nimhsmsmhs;?></td>
			<td class="first"><?php echo anchor_popup("admin/mahasiswa/detail/".$bm->nimhsmsmhs,$bm->nmmhsmsmhs,$atrib);?></td>
			<td class="first"><?php	echo $bm->password;?>
			</td>
		</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".$this->pagination->create_links()." Total Records <b>".$total_rows."</b></div>";?>
</div>
<script language="javascript">
	function tanya(){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			return true;
		}else{
			return false;
		}
	}
</script>
