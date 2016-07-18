<head>
<title>Daftar Pegawai Dan Dosen</title>
<!--<link rel="stylesheet" href="<?php echo base_url();?>asset/css/design.css" type="text/css" media="screen"/>-->
<style>
	th{ border:1px solid #ABABAB; border-right:none; padding:5px; }
	td{ border-bottom:1px solid #ABABAB; border-left:1px solid #ABABAB; padding:3px; }
</style>
<script language="javascript" type="text/javascript">
	function SendValueToParent(npp, nama){
		var myVal = npp;
		var myVal2 = nama;
		window.opener.GetValueFromChild(myVal, myVal2);
		window.close();
		return false;
	}
</script>
</head>
<div class="top-bar-adm">
	<h3>Daftar Dosen</h3>
</div>
<div class="select-bar">
<?php
	/*echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/masmahasiswa/cari_dosen'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_maspegawai"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();*/
?>
</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NPP</th>
			<th>Nama Pegawai</th>
			<th class="last">Pilih</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_maspegawai as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->npp;?></td>
		<td class="first"><?php echo $bm->nama; ?></td>
		<td class="first"><a href='#' onclick='SendValueToParent("<?php echo $bm->npp?>","<?php echo $bm->nama?>")'>pilih</a></td>
	</tr>
<?php endforeach;?>
	</table>
<?php //echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(npp){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/maspegawai/delete/"+npp,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
