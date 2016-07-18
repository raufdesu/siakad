<head>
	<title>Biodata Mahasiswa</title>
	<style media="all" type="text/css">@import "<?php echo base_url();?>css/design.css";</style>
	<style>*{font-size:12;}</style>
</head>
<div class="top-bar-adm">
	<a href="javascript:void(0)" style="margin-right:-32px" class='navi button' onclick='show("prodi/simdaftarskripsi/","#center-column");'>Browse</a>
	<h2>Detail Pendaftaran</h2>
	<!--<div class="breadcrumbs"><a href="#">tes&nbsp;</a></div>-->
</div>
<?php
	if($cek_daftar == 0){
		echo "<div class='alert' style='margin-top:40px;'>";
			echo "<h3>KONFIRMASI</h3>Anda belum pernah mendaftar KP/TA/Skripsi";
		echo "</div>";
	}
	foreach($detail_simdaftarskripsi as $dp):
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">
				<div style="float:right;">
					<?php echo $dp->persetujuan?>
					&nbsp; - &nbsp;
[<a href="javascript:void(0)" onclick='show("prodi/simdaftarskripsi/edit/<?php echo $dp->iddaftarskripsi?>", "#center-column")' >Edit</a>]
<?php
	if($dp->persetujuan == 'Disetujui' && $dp->nosk <> ''){
		echo '['.anchor('prodi/simdaftarskripsi/cetak_sk/'.$dp->iddaftarskripsi.'/'.$dp->nim, 'Cetak SK', array('target'=>'_blank')).']';
	}
?>
				</div>
				DETAIL DATA PENDAFTARAN
				<?php
					echo $dp->jenisdaftar;
				?>
			</th>
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
			<td class="first"><strong>Judul Yang Diajukan</strong></td>
			<td class="last">:
				<?php echo $dp->judulskripsi;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jenis Daftar</strong></td>
			<td class="last">:
				<?php echo $dp->jenisdaftar;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Status Pendaftaran</strong></td>
			<td class="last">:
				<?php echo $dp->statusdaftar;?>
			</td>
		</tr>
		<?php if($dp->persetujuan == 'Disetujui'){?>
		<tr>
			<td class="first"><strong>No. SK</strong></td>
			<td class="last">:
				<?php echo $dp->nosk;?>
			</td>
		</tr>
		<?php } ?>
		<tr class="bg">
			<td class="first"><strong>Tgl. Daftar</strong></td>
			<td class="last">:
				<?php echo tgl_indo($dp->tgldaftar,1);?>
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
			<td class="first"><strong>Pembimbing 1</strong></td>
			<td class="last">:
				<?php echo $dp->nmpembimbing1?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Pembimbing 2</strong></td>
			<td class="last">:
				<?php echo $dp->nmpembimbing2?>
			</td>
		</tr>
	</table><br />
</div>
<?php endforeach;?>