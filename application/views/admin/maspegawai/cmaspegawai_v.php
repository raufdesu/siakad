<?php
	$namafile = "Data_dosen_dan_pegawai.doc";
	header("Content-type: application/msword");
	header("Content-disposition: attachment; filename=".$namafile);
?>
<head>
	<title>Daftar Pegawai Dan Dosen</title>
	<style>
		.listing td{
			font-size:15px;
			padding:5px 10px 5px 10px;
			border-bottom:1px solid #efefef;
		}
		.listing th{
			padding:5px 10px 5px 10px;
			border-top:1px solid #efefef;
			border-bottom:1px solid #efefef;
			font-weight:bold;
		}
	</style>
</head>
<h2>Data Pegawai dan Dosen </h2>
<table class="listing">
	<tr>
		<th class="first" width="5">No.</th>
		<th>NPP</th>
		<th>Nama Pegawai</th>
		<th>Jabatan</th>
	</tr>
<?php
	$i = 1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_maspegawai as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->npp;?></td>
		<td class="first"><?php echo $bm->nama; ?></td>
		<td class="first"><?php echo $bm->bagian;?></td>
	</tr>
<?php endforeach;?>
</table>