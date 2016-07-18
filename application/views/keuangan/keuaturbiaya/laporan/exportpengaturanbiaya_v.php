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
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading(); this.form.submit();
		}
		function ChangeProdi(){
			showloading();
			var selected_prodi = $('select[name=kodeprodi]').val();
			load('keuangan/keuaturbiaya/prodi/'+selected_prodi,'#center-column');
		}
		/*function ChangeKategori(){
			showloading();
			var selected_kategori = $('select[name=kategori]').val();
			load('keuangan/keuaturbiaya/kategori/'+selected_kategori,'#center-column');
		}*/
		function ChangeAngkatan(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('keuangan/keuaturbiaya/angkatan/'+selected_angkatan,'#center-column');
		}
	</script>
</head>
<cetak>
	<a href="javascript:void(0)" onclick="window.print()" style="float:right" class="noprint">Print</a>
	<?php if($this->session->userdata('sesi_user') == 'keuangan'): ?>
	<h2>Daftar Biaya
		<?php
			if($prodi){
				echo ' Prodi '.$this->auth->get_namaprodi($prodi);
			}
			if($angkatan){
				echo ' Angkatan '.$angkatan;
			}
		?>
	</h2>
	<?php endif ?>
<div class="table">
	<table class="custome-table" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Jenis Biaya</th>
			<th>Angkatan</th>
			<th>Gel</th>
			<th>Jenis</th>
			<th>Besar Biaya</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_keuaturbiaya as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->namabiaya;?></td>
		<td align="center"><?php echo $bm->angkatan;?></td>
		<td align="center"><?php echo $bm->gelombang;?></td>
		<td class="first"><?php echo $bm->jenis;?></td>
		<td align="right"><?php echo rupiah($bm->jumbiaya);?></td>
	</tr>
<?php endforeach;?>
	</table>
</div>