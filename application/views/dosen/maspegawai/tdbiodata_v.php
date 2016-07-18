<head>
	<script type="text/javascript">
		$(document).ready(function() {
			stoploading();
		})
	</script>
</head>
<?php
	foreach($detail_maspegawai as $dp):
?>
<div style="float:right; height:25px;">
	<a href="javascript:void(0)" class="button" onclick='show("dosen/maspegawai/edit", "#center-column")'>Edit</a>
</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">DETAIL DATA DOSEN DAN PEGAWAI</th>
		</tr>
		<tr>
			<td class="first" width="160"><strong>NPP</strong></td>
			<td class="last"><?php echo $dp->npp;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>NIP</strong></td>
			<td class="last"><?php echo $dp->nip;?></td>
		</tr>
		<tr>
			<td class="first"><strong>Nama</strong></td>
			<td class="last"><?php echo $dp->nama;?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Pegawai</strong></td>
			<td class="last"><?php echo $dp->statuspegawai;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Alamat</strong></td>
			<td class="last"><?php echo $dp->alamat;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon</strong></td>
			<td class="last"><?php echo $dp->notelp; ?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Email</strong></td>
			<td class="last"><?php echo $dp->email; ?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>PRODI</strong></td>
			<td class="last"><?php echo $this->auth->get_namaprodi($dp->kodeprodi);?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Status Nikah</strong></td>
			<td class="last"><?php echo $dp->statusnikah; ?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pendidikan Terakhir</strong></td>
			<td class="last"><?php echo $dp->pendidikanterakhir;?></td>
		</tr>
		<tr>
			<td class="first"><strong>NIDN</strong></td>
			<td class="last"><?php echo $dp->nidn;?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Bagian</strong></td>
			<td class="last"><?php echo $dp->bagian;?></td>
		</tr>
		<tr>
			<td class="first"><strong>Tgl. Masuk</strong></td>
			<td class="last"><?php echo tgl_indo($dp->tglmasuk,1);?>
			</td>
		</tr>
	</table>
<?php endforeach;?>
</div>
