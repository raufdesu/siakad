<head>
	<style>
		.waktu td{
			border-bottom:1px solid #ABABAB;
			padding:5px 12px 5px 12px;
		}
	</style>
</head>
<body>
<table class="waktu" cellspacing="0" width="100%">
	<tr>
		<td>Tanggal KRS</td>
		<td> : <?php echo tgl_indo($ds->tglkrsawal,1).' sampai dengan '.tgl_indo($ds->tglkrsakhir,1); ?></td>
	</tr>
	<tr>
		<td>Tanggal Perubahan KRS</td>
		<td> : <?php echo tgl_indo($ds->tglperubahankrsawal,1).' sampai dengan '.tgl_indo($ds->tglperubahankrsakhir,1); ?></td>
	</tr>
	<tr>
		<td>Tanggal KSP Awal</td>
		<td> : <?php echo tgl_indo($ds->tglkspawal,1).' sampai dengan '.tgl_indo($ds->tglkspakhir,1); ?></td>
	</tr>
</table>
</body>