<head>
	<title>Biodata Mahasiswa</title>
	<style>*{font-size:12;}</style>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
</head>
<div class='button'>
	<a href="javascript:void(0)" onclick='show("mhs/loginmhs/edit","#center-column");'>Ubah Password</a>
</div>
<?php
	foreach($detail_masmahasiswa as $dp):
?>
	<div class="table" id="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">DETAIL DATA MAHASISWA</th>
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
				<?php echo $dp->nama;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>PRODI</strong></td>
			<td class="last">:
				<?php echo $dp->nama_prodi;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Kelas</strong></td>
			<td class="last">:
				<?php
					if($dp->statusmasuk == "1"){
						echo "Reguler";
					}elseif($dp->statusmasuk == "2"){
						echo "Kelas Malam";
					}
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tempat/Tgl. Lahir</strong></td>
			<td class="last">:
				<?php
					echo $dp->tempatlahir." / ".$dp->tgllahir;
				?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Jenis Kelamin</strong></td>
			<td class="last">:
				<?php
					if($dp->jeniskelamin == "L"){
						echo "Laki-laki";
					}elseif($dp->jeniskelamin == "P"){
						echo "Perempuan";
					}
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Angkatan</strong></td>
			<td class="last">:
				<?php echo $dp->angkatan;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Agama</strong></td>
			<td class="last">:
				<?php
					echo $dp->agama;
				?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Alamat Mahasiswa</strong></td>
			<td class="last">:
				<?php echo $dp->alamatasal; ?>
			</td>
		</tr>
	</table>
<?php endforeach;?>
</div>
