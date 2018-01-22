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
<?php if($this->session->userdata('sesi_user') == 'keuangan'): ?>
<div style="float:right" class="noprint"><?php
	if(!$this->uri->segment(5) == 'xls'){
		echo anchor('keuangan/keubiaya/cetak_pembayaran/0/xls', 'Excel');
	}
?></div>
<b><center>DAFTAR PEMBAYARAN<br />
	<?php
		if($prodi){
			echo 'PRODI '.$this->auth->get_namaprodi($prodi);
		}
		if($angkatan){
			echo ' ANGKATAN '.$angkatan;
		}
		if($status){
			echo ' YANG '.strtoupper($status);
		}
	?>
</center></b>
<div class="table">
	<table class="custome-table" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th>Tahun Ajaran</th>
			<th>Jenis Pembayaran</th>
			<th>Jumlah Biaya</th>
			<th>Setoran</th>
			<th>Kekurangan</th>
			<th>Status</th>
		</tr>
<?php
	$i = $no+1;
	$totjumkekurangan = 0;
	$totjumsetoran = 0;
	$jl = 0;
	$jbl = 0;
	foreach($browse_pembayaran->result() as $bm):
	$nomor = $i++;
	if($nomor % 2 == 0){
		$bg = 'bg';
	}else{
		$bg = '';
	}
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $nomor.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->thajaran;?></td>
		<td class="first"><?php echo $bm->jenis;?></td>
		<td style="text-align:right"><?php echo rupiah($bm->jumbiaya);?></td>
		<td style="text-align:right">&nbsp;<?php
			$setor1 = $this->keubiaya_m->get_setoran($bm->idbiaya, 1);
				echo jika_ada(rupiah($setor1['jumsetoran']), '', '<br />');
			$setor2 = $this->keubiaya_m->get_setoran($bm->idbiaya, 2);
				echo jika_ada(rupiah($setor2['jumsetoran']), '', '<br />');
			$setor3 = $this->keubiaya_m->get_setoran($bm->idbiaya, 3);
				echo jika_ada(rupiah($setor3['jumsetoran']), '', '<br />');
		?></td>
		<td style="text-align:right">&nbsp;<?php
			$jumsetoran = $setor1['jumsetoran']+$setor2['jumsetoran']+$setor3['jumsetoran'];
			$kekurangan = $bm->jumbiaya - $jumsetoran;
			echo rupiah($kekurangan);
		?></td>
		<td><?php echo inisial($bm->status);?></td>
	</tr>
<?php
	$totjumkekurangan = $totjumkekurangan+$kekurangan;
	$totjumsetoran = $totjumsetoran+$jumsetoran;
	if($bm->status == 'Lunas'){
		$lns = 1;
		$blns = 0;
	}else{
		$lns = 0;
		$blns = 1;
	}
	$jbl = $jbl+$blns;
	$jl = $jl+$lns;
	endforeach;
?>
	<tr>
		<td colspan="6" style="text-align:right">TOTAL</td>
		<td style="text-align:right"><?php echo rupiah($totjumsetoran)?></td>
		<td style="text-align:right"><?php echo rupiah($totjumkekurangan)?></td>
		<td><?php echo 'BL = '.$jbl.', L = '.$jl?></td>
	</tr>
</table>
</div>
<?php endif ?>

<?php if($this->session->userdata('sesi_status') == 'prodi'): ?>
<div style="float:right" class="noprint"><?php
	if(!$this->uri->segment(5) == 'xls'){
		echo anchor('keuangan/keubiaya/cetak_pembayaran/0/xls', 'Excel');
	}
?></div>
<b><center>DAFTAR PEMBAYARAN<br />
	<?php
		if($prodi){
			echo 'PRODI '.$this->auth->get_namaprodi($prodi);
		}
		if($angkatan){
			echo ' ANGKATAN '.$angkatan;
		}
		if($status){
			echo ' YANG '.strtoupper($status);
		}
	?>
</center></b>
<div class="table">
	<table class="custome-table" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th>Tahun Ajaran</th>
			<th>Jenis Pembayaran</th>
			<th>Jumlah Biaya</th>
			<th>Setoran</th>
			<th>Kekurangan</th>
			<th>Status</th>
		</tr>
<?php
	$i = $no+1;
	$totjumkekurangan = 0;
	$totjumsetoran = 0;
	$jl = 0;
	$jbl = 0;
	foreach($browse_pembayaran->result() as $bm):
	$nomor = $i++;
	if($nomor % 2 == 0){
		$bg = 'bg';
	}else{
		$bg = '';
	}
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $nomor.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->thajaran;?></td>
		<td class="first"><?php echo $bm->jenis;?></td>
		<td style="text-align:right"><?php echo rupiah($bm->jumbiaya);?></td>
		<td style="text-align:right">&nbsp;<?php
			$setor1 = $this->keubiaya_m->get_setoran($bm->idbiaya, 1);
				echo jika_ada(rupiah($setor1['jumsetoran']), '', '<br />');
			$setor2 = $this->keubiaya_m->get_setoran($bm->idbiaya, 2);
				echo jika_ada(rupiah($setor2['jumsetoran']), '', '<br />');
			$setor3 = $this->keubiaya_m->get_setoran($bm->idbiaya, 3);
				echo jika_ada(rupiah($setor3['jumsetoran']), '', '<br />');
		?></td>
		<td style="text-align:right">&nbsp;<?php
			$jumsetoran = $setor1['jumsetoran']+$setor2['jumsetoran']+$setor3['jumsetoran'];
			$kekurangan = $bm->jumbiaya - $jumsetoran;
			echo rupiah($kekurangan);
		?></td>
		<td><?php echo inisial($bm->status);?></td>
	</tr>
<?php
	$totjumkekurangan = $totjumkekurangan+$kekurangan;
	$totjumsetoran = $totjumsetoran+$jumsetoran;
	if($bm->status == 'Lunas'){
		$lns = 1;
		$blns = 0;
	}else{
		$lns = 0;
		$blns = 1;
	}
	$jbl = $jbl+$blns;
	$jl = $jl+$lns;
	endforeach;
?>
	<tr>
		<td colspan="6" style="text-align:right">TOTAL</td>
		<td style="text-align:right"><?php echo rupiah($totjumsetoran)?></td>
		<td style="text-align:right"><?php echo rupiah($totjumkekurangan)?></td>
		<td><?php echo 'BL = '.$jbl.', L = '.$jl?></td>
	</tr>
</table>
</div>
<?php endif ?>