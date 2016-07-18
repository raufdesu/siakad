<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
	</script>
	<style>
		.in-kolom td{
			border:none !important;
			border-bottom:1px solid #ababab !important;
		}
		td.row{
			vertical-align:top;
			border-bottom:1px solid #ababab !important;
			border-right:1px solid #ababab !important;
		}
	</style>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/design.css" type="text/css"/>
</head>
<div id='noprint' style="margin-bottom:10px; float:right;"><a href='#' id="noprint" class='print-button' onclick='print()'>cetak</a></div>
<h3>Jadwal Perkuliahan</h3>
<div class="top-bar">
</div>
<div class="select-bar">
</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th>Hari</th><th>
				<table width="100%">
					<th style="width:180px;border:none;">Matakuliah</th>
					<th class="bg" style="border:none;">Ruang</th>
					<th class="bg" style="border:none;">Jam</th>
					<th style="border:none;">Pengampu</th>
				</table>
			</th>
		</tr>
		<?php
			for($i=1; $i<7; $i++):
				if($i == 1){
					$hari = 'Senin';
				}elseif($i == 2){
					$hari = 'Selasa';
				}elseif($i == 3){
					$hari = 'Rabu';
				}elseif($i == 4){
					$hari = 'Kamis';
				}elseif($i == 5){
					$hari = 'Jumat';
				}elseif($i == 6){
					$hari = 'Sabtu';
				}
				$detail_jadwal = $this->simambilmk_m->get_kelasdosen($nim, $thajaran, $hari);
		?>
		<tr>
			<td class="first row"><b><?php echo $hari?></b></td>
			<td class="row">
				<table class="in-kolom" cellspacing="0" width="100%">
					<?php foreach($detail_jadwal as $dj): ?>
					<tr style="text-align:center;">
						<td style="vertical-align:top;text-align:center;width:180px" class="last"><?php echo $dj->namamk.'<br />('.$dj->kodemk.')';?></td>
						<td style="vertical-align:top;text-align:center"><?php echo $dj->ruang;?></td>
						<td style="vertical-align:top;text-align:centerwidth:60px"><?php echo $dj->jamawal.'<br /><small>s/d</small><br />'.$dj->jamselesai?></td>
						<td style="vertical-align:top;text-align:center" class="last"><?php echo $dj->namadosen;?></td>
					</tr>
					<?php endforeach ?>
				</table>
			</td>
		</tr>
		<?php endfor; ?>
	</table>
</div>