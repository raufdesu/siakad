<head>
	<title>Biodata Mahasiswa</title>
	<style media="all" type="text/css">@import "<?php echo base_url();?>css/design.css";</style>
	<style>*{font-size:12;}</style>
</head>
<?php
	foreach($detail_mahasiswa as $dp):
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">DETAIL DATA MAHASISWA</th>
		</tr>
		<tr>
			<td class="first" width="200"><strong>NIM</strong></td>
			<td class="last">:
				<?php echo $dp->nimmhs;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Mahasiswa</strong></td>
			<td class="last">:
				<?php echo $dp->namamhs;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>PRODI</strong></td>
			<td class="last">:
				<?php
					if(substr($dp->nimmhs, 0, 2) == "23"){
						echo "Manajemen Informatika";
					}elseif(substr($dp->nimmhs, 0, 2) == "12"){
						echo "Teknik Informatika";
					}elseif(substr($dp->nimmhs, 0, 2) == "25"){
						echo "Komputerisasi Akuntansi";
					}elseif(substr($dp->nimmhs, 0, 2) == "11"){
						echo "Sistem Informasi";
					}else{
						echo "Teknik Komputer";
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Kelas</strong></td>
			<td class="last">:
				<?php
					if($dp->kdkelas == "1"){
						echo "Reguler";
					}elseif($dp->kdkelas == "2"){
						echo "Kelas Malam";
					}
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tempat/Tgl. Lahir</strong></td>
			<td class="last">:
				<?php
					if($dp->nimmhs == "12100911"){
						echo "Kasihan Buanget";
					}elseif(!$dp->tplhrmhs){
						echo "-";
					}else{
						echo $dp->tplhrmhs;
					}
					echo " / ".tgl_indo($dp->tglhrmhs);
				?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Jenis Kelamin</strong></td>
			<td class="last">:
				<?php
					if($dp->kdjnsklmn == "1"){
						echo "Laki-laki";
					}elseif($dp->kdjnsklmn == "2"){
						echo "Perempuan";
					}
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Angkatan</strong></td>
			<td class="last">:
				<?php echo $dp->tahunmhs;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Agama</strong></td>
			<td class="last">:
				<?php
					if($dp->kdagama == '1'){
						echo "Islam";
					}else{
						echo "Non Islam";
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Alamat Mahasiswa</strong></td>
			<td class="last">:
				<?php echo $dp->almtaslmhs; ?>
			</td>
		</tr>
	</table>
<?php endforeach;?>
<div align="right"><hr /><?php echo form_button("cmdClose","<< Back","OnClick='history.back()'");?></div>
</div>
