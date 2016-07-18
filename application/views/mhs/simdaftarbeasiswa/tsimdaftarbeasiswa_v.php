<head>
	<title>Biodata Mahasiswa</title>
	<style media="all" type="text/css">@import "<?php echo base_url();?>css/design.css";</style>
	<style>*{font-size:12;}</style>
</head>
<div class='button'>
	<a href="javascript:void(0)" onclick='show("mhs/simdaftarbeasiswa/input","#center-column");'>Input</a>
</div>
<?php
	foreach($detail_simdaftarbeasiswa as $dp):
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">DETAIL DATA PENDAFTARAN BEASISWA <?php echo $dp->jenisbeasiswa?></th>
		</tr>
		<tr>
			<td class="first" width="200"><strong>NIM</strong></td>
			<td class="last">:
				<?php echo $dp->nim;?>
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
					if(substr($dp->nim, 0, 2) == "23"){
						echo "Manajemen Informatika";
					}elseif(substr($dp->nim, 0, 2) == "12"){
						echo "Teknik Informatika";
					}elseif(substr($dp->nim, 0, 2) == "25"){
						echo "Komputerisasi Akuntansi";
					}elseif(substr($dp->nim, 0, 2) == "11"){
						echo "Sistem Informasi";
					}else{
						echo "Teknik Komputer";
					}
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pekerjaan Orang Tua</strong></td>
			<td class="last">:
				<?php echo $dp->pekerjaanortu;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Penghasilan Orang Tua</strong></td>
			<td class="last">:
				<?php echo $dp->penghasilanortu.'/bulan';?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>IPK</strong></td>
			<td class="last">:
				<?php echo $dp->ipk;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Pendaftaran</strong></td>
			<td class="last">:
				<?php echo $dp->status;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Tgl. Daftar</strong></td>
			<td class="last">:
				<?php echo tgl_indo($dp->tgldaftar,1);?>
			</td>
		</tr>
	</table><br />
<?php endforeach;?>
</div>
