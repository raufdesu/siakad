<head>
	<style>
	*{
		font-family:Arial;
		font-size:12px;
	}
	.custome-table{
		border-top:1px solid #000;
		border-right:1px solid #000;
		width:100%;
	}
	@media print{
		.noprint{
			display:none;
		}
	}
	.custome-table td, th{
		vertical-align:top;
		border-collapse:collapse;
		padding:3px 6px 3px 6px;
		border-left:1px solid #000;
		border-bottom:1px solid #000;
	}
	</style>
</head>
<div style="float:right" class="noprint"><?php
	if(!$this->uri->segment(5) == 'xls'){
		echo anchor('prodi/nilai/cetak_rekap_khs/0/xls', 'Excel');
	}
?></div>
<b><center>REKAP KHS 
<?php echo $thajaran;?>
<br /></center></b>
<div class="table">
	<table class="custome-table" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th>Nama Prodi</th>
			<th>idkrs</th>
			<th>Kode Matkul</th>
			<th>Nama Matkul</th>
			<th>Nilai_angka</th>
			<th>Nilai_huruf</th>
			<th>Tahun Ajaran</th>
		</tr>
<?php
	$i = 1;
	$totjumkekurangan = 0;
	$totjumsetoran = 0;
	$jl = 0;
	$jbl = 0;
	foreach($browse_rekap_krs->result() as $bm):
	$nomor = $i++;
	if($nomor % 2 == 0){
		$bg = 'bg';
	}else{
		$bg = '';
	}
?>
	<tr>
		<td class="first"><?php echo $nomor.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->namaprodi;?></td>
		<td class="first"><?php echo $bm->idkrs;?></td>
		<td class="first"><?php echo $bm->kodemk;?></td>
		<td class="first"><?php echo $bm->namamk;?></td>
		<td class="first"><?php echo $bm->nilaiangka;?></td>
		<td class="first"><?php echo $bm->nilaihuruf;?></td>
		<td class="first"><?php echo $bm->thajaran;?></td>
	</tr>
<?php
	endforeach;
?>
</table>
</div>