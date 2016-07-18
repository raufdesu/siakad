<html>
<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
	<title>Cetak Kwitansi</title>
	<!--<link rel="stylesheet" href="</?php echo base_url();?>asset/css/design.css" type="text/css"/>-->
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
</head>
<body>
<div id='noprint' style="float:right;"><a href='#' id="noprint" class='print-button' onclick='print()'>cetak</a></div>
<div class="clear"><br /></div>
<div style="border:1px dotted #000; background:#fff; padding:10px">
<div style="float:right">No Kwitansi : <?php echo $dkw->idbayar?></div>
<h2><?php echo $this->config->item('project_company')?></h2>
Telah diterima pembayaran dari mahasiswa dengan :
<table>
	<tr>
		<td>NIM</td><td>:</td><td><?php echo $dkw->nim?></td>
		<td>PRODI</td><td>:</td><td><?php echo $namaprodi?></td>
	</tr>
	<tr>
		<td>Nama Mahasiswa</td><td>:</td><td colspan="2"><?php echo $dkw->nama?></td>
	</tr>
</table>
<div style="float:right; margin-bottom:20px;">
Mataram, <?php echo tgl_indo($dkw->tglbayar,1);?><br /><br /><br /><br /><br />
(...........................)
</div>
<div style="width:520px; border:1px dotted #000; padding:10px;">
Guna membayar <b><?php echo $dkw->jenisbayar?></b><br /> sebesar <b><?php echo rupiah($dkw->jumbayar)?></b>
</div>
<div style="margin-top:10px; clear:both; border-top:1px solid #efefef; height:30px"><small><i><?php echo $this->config->item('project_company');?></i></small></div>
</div>
</body>
</html>