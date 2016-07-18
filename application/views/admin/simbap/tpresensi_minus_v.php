<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	});
</script>
<div class="top-bar-adm">
	<div style="margin-right:-32px;float:right" >
		<input type="checkbox" value="minus" name="tujupuluh" title="Hanya mencetak yang kurang dari 75%" />-75%
		<a href="javascript:void(0)" onclick='window.print()' class="button">Cetak</a>
	</div>
	<h1>Rekap Presensi Matakuliah</h1>
	Dosen : <?php echo $this->auth->get_namauser($this->session->userdata('sesi_user'));?>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div>
<div class="print-only" style="font-size:15px; border-bottom:4px double #ababab;"><b>Rekap Presensi Matakuliah</b><br />
Dosen : <?php echo $this->auth->get_namauser($this->session->userdata('sesi_user'));?></div>
<div class="table">
<?php foreach($browse_matakuliah->result() as $bm): ?>
<table>
	<tr>
		<td>Kode Matakuliah</td><td>: <?php echo $bm->kodemk; ?></td>
	</tr>
	<tr>
		<td>Nama Matakuliah</td><td>: <?php echo $bm->namamk.'('.$bm->kelas.')'; ?></td>
	</tr>
	<tr>
		<td>Total Pertemuan</td><td>:
			<?php
				$hadir_dosen = $bm->jumhadir;
				echo $hadir_dosen;
			?>
		</td>
	</tr>
</table>
<table class="listing form" style="margin-bottom:10px;" cellpadding="0" cellspacing="0">
	<tr>
		<td>NIM</td><td>Nama</td><td>Jumlah Hadir</td>
	</tr>
	<?php
		$browse_mhs = $this->simbap_m->getmhs_byidkelas($bm->id_kelas_dosen);
		foreach($browse_mhs as $mhs):
		$hadir_mhs = $mhs->jumhadir;
		$min_hadir = (75/100) * $hadir_dosen;
		
		if($hadir_mhs < $min_hadir){
			$color = 'color:red !important';
		}else{
			$color = '';
		}
	?>
	<tr>
		<td style="<?php echo $color?>"><?php echo $mhs->nim?></td>
		<td class="first" style="<?php echo $color?>">
		<?php
			echo $mhs->namamhs;
		?></td>
		<td style="<?php echo $color?>"><?php echo $hadir_mhs?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php endforeach;?>