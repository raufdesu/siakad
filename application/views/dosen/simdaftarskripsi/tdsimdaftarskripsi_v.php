<head>
	<script type="text/javascript">
		$(document).ready(function() {
			stoploading();
		})
	</script>
</head>
<div style="float:right; height:25px;">
	<a href="javascript:void(0)" class="button" onclick='show("dosen/simdaftarskripsi", "#center-column")'>Back</a>
</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">DETAIL DATA PENDAFTARAN SKRIPSI</th>
		</tr>
		<tr>
			<td class="first" width="160"><strong>NIM</strong></td>
			<td class="last">: <?php echo $dp->nim;?>
			</td>
		</tr>
		<tr>
			<td class="first" width="160"><strong>No. SK</strong></td>
			<td class="last">: <?php echo $dp->nosk;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Nama</strong></td>
			<td class="last">: <?php echo $dp->namamhs;?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Judul</strong></td>
			<td class="last">: <?php echo $dp->judulskripsi;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jenis Daftar</strong></td>
			<td class="last">: <?php echo $dp->jenisdaftar;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Status Pendaftaran</strong></td>
			<td class="last">: <?php echo $dp->statusdaftar;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Tgl. Daftar</strong></td>
			<td class="last">: <?php echo tgl_indo($dp->tgldaftar,1);?>
			</td>
		</tr>
	</table>
</div>
