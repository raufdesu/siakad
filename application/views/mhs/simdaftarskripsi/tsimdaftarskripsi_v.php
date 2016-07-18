<head>
	<title>Biodata Mahasiswa</title>
	<style media="all" type="text/css">@import "<?php echo base_url();?>css/design.css";</style>
	<style>*{font-size:12;}</style>
</head>
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
				<div style="float:right">
					<?php
						if($dp->persetujuan == 'Disetujui'){
							echo 'Disetujui | ';
							echo anchor('mhs/simdaftarskripsi/cetak_sk/'.$dp->iddaftarskripsi, 'Cetak', array('target'=>'_blank'));
						}else{
							echo 'Belum Disetujui';
						}
					?>
				</div>
				DETAIL DATA PENDAFTARAN
				<?php echo $dp->jenisdaftar?>
			</th>
		</tr>
		<tr>
			<td class="first" width="200"><strong>NIM</strong></td>
			<td class="last">:
				<?php echo $dp->nim;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Nama Mahasiswa</strong></td>
			<td class="last">:
				<?php echo $dp->namamhs;?>
			</td>
		</tr>
		<tr>
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
		<tr>
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
		<?php if(!$dp->judulskripsi){ ?>
		<tr>
			<td colspan="2">
				<p>Tentukan Judul <?php echo $dp->jenisdaftar?> dan Usulan Dosen Pembimbing</p>
				<a style="color:brown;font-weight:bold;border:1px solid brown;margin:5px;padding:3px 10px 3px 10px" href="javascript:void(0)" onclick='show("mhs/simdaftarskripsi/input/<?php echo $dp->jenisdaftar.'/'.$dp->iddaftarskripsi?>","#center-column");'>Input</a>
				<br /><br />
			</td>
		</tr>
		<?php }else{ ?>
		<tr class="bg">
			<td class="first"><strong>Judul Yang Diajukan</strong></td>
			<td class="last">:
				<?php echo $dp->judulskripsi;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pembimbing 1</strong></td>
			<td class="last">:
				<?php echo $dp->nmpembimbing1?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pembimbing 2</strong></td>
			<td class="last">:
				<?php echo $dp->nmpembimbing2?>
			</td>
		</tr>
		<?php } ?>
	</table><br />
</div>
<?php endforeach;?>