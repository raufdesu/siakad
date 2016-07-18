<head>
	<title>Detail Pembayaran Mahasiswa</title>
</head>
<?php
	if($cek_bayar == 0){
		echo "<div class='alert' style='border:1px solid brown;color:brown;padding:20px;margin-top:30px;'>";
			echo "<b>KONFIRMASI - </b>Data tidak ditemukan";
		echo "</div>";
	}
	foreach($browse_detail as $dp):
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">DETAIL PEMBAYARAN <?php echo $dp->jenisbayar?>
			<div style="float:right"><?php echo $dp->status?></div>
			</th>
		</tr>
		<?php
		$sql = "SELECT * FROM keudetbayar WHERE idbayar = ".$dp->idbayar;
		$que = mysql_query($sql);
		$no = 1;
		$tot = 0;
		while($d = mysql_fetch_array($que)):
		$i = $no++;
		if($i % 2 == 0){
			$bg = 'bg';
		}else{
			$bg = '';
		}
		?>
		<tr class="<?php echo $bg?>">
			<td class="first" width="200"><strong>Jumlah Pembayaran <?php echo $i?></strong></td>
			<td class="last">
				<a style="float:right;" href="javascript:void(0)" onclick='show("admin/keubayar/cetak_kwitansione/<?php echo $d['iddetbayar'];?>", "#center-column")'>
					<?php
						$arimg = array(
							'src'	=> 'asset/images/design/print.gif', 'style'	=> 'margin-right:10px; border:none;'
						);
						echo img($arimg);
					?>
				</a>
					<?php
						$arimg2 = array(
							'src'	=> 'asset/images/design/salah.png', 'style'	=> 'margin-right:5px; border:none;'
						);
					?>
				<a style="float:right;" href="javascript:void(0)" onclick='return tanya("<?php echo $d['iddetbayar'];?>","<?php echo $d['idbayar'];?>")'><?php echo img($arimg2)?></a>
				<?php echo rupiah($d['jumbayar']);?>
			</td>
		</tr>
		<tr class="<?php echo $bg?>">
			<td class="first"><strong>Tgl. Bayar</strong></td>
			<td class="last"><?php echo tgl_indo($d['tglbayar'],1);?></td>
		</tr>
		<tr class="<?php echo $bg?>">
			<td class="first" width="200"><strong>Petugas</strong></td>
			<td class="last"><?php echo $d['petugas'];?></td>
		</tr>
		<tr class="<?php echo $bg?>">
			<td class="first" width="200"><strong>Keterangan</strong></td>
			<td class="last"><?php echo $d['keterangan'];?></td>
		</tr>
		<?php
			$tot = $tot + $d['jumbayar'];
			endwhile;
		?>
		<tr>
			<td>Total Pembayaran <?php echo $dp->jenisbayar?></td>
			<td class="first"><?php echo rupiah($tot)?></td>
		</tr>
	</table><br />
</div>
<?php endforeach;?>
<script>
	function tanya(id, id2){
		if(confirm('KONFIRMASI\nTekan tombol OK untuk melanjutkan penghapusan data terpilih') == true){
			show("admin/keubayar/hapus/"+id+"/"+id2, "#detail-transkrip");
		}else{
			return false;
		}
	}
</script>