<div style="margin-right:3px;margin-top:-120px;float:right;">
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/add/", "#form-pembayaran")' class="button">Form Pembayaran</a>
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/laporan_nim/<?php echo $mhs['nim']?>", "#center-column")' class="button">Laporan</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">NO</th>
		<th>JENIS PEMBAYARAN / SETORAN</th>
		<th>JUMLAH SETORAN</th>
		<th>JUMLAH</th>
		<th>TUNGGAKAN</th>
		<th>TGL. SETOR</th>
		<th>KET</th>
		<th class="last">#</th>
	</tr>
	<?php
		$ke='A'; foreach($browse_jenis as $bj){
	?>
	<tr>
		<td><b><?php echo $ke?>.</b></td>
		<td colspan="8" class="first"><b><?php echo $bj->jenis?></b></td>
	</tr>
		<?php
			$ke = chr(ord($ke) + 1);
			$browse_nimjenis = $this->keubiaya_m->get_bynimjenis($mhs['nim'], $bj->jenis);
			$i=1; $jumlah=0; $tunggakan=0; $jumsetor1=0;$jumsetor2=0;$totjumlah=0;$jumtunggakan=0;
			foreach($browse_nimjenis as $bn){
			$no = $i++;
		?>
		<tr>
			<td rowspan="2" class="last"><?php echo $no?>.</td>
			<td rowspan="2" style="text-align:left"><?php echo $bn->namabiaya?></td>
			<td class="right"><?php
				$setor1 = $this->keubiaya_m->get_setoran($bn->idbiaya, 1); echo rupiah($setor1['jumsetoran']);
				$setor2 = $this->keubiaya_m->get_setoran($bn->idbiaya, 2);;
			?></td>
			<td rowspan="2" class="right"><?php $jumlah = $setor1['jumsetoran']+$setor2['jumsetoran']; echo rupiah($jumlah)?></td>
			<td rowspan="2" class="right"><?php $tunggakan = $bn->jumbiaya - $jumlah; echo rupiah($tunggakan)?></td>
			<td><?php echo tgl_indo($setor1['tglsetor']);?></td>
			<td rowspan="2"><?php echo inisial($bn->status)?></td>
			<td>
				<?php if($setor1['idsetoran']){ ?>
				<a href="javascript:void(0)" onclick='return tanyaBatalkan("<?php echo $setor1['idsetoran']?>", "<?php echo $bn->idbiaya?>", "<?php echo $mhs['nim']?>")'>
					<img src="<?php echo base_url()?>asset/images/design/hr.gif" />
				</a>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td class="right"><?php echo rupiah($setor2['jumsetoran'])?></td>
			<td><?php echo tgl_indo($setor2['tglsetor']);?></td>
			<td>
				<?php if($setor2['idsetoran']){ ?>
				<a href="javascript:void(0)" onclick='return tanyaBatalkan("<?php echo $setor2['idsetoran']?>", "<?php echo $bn->idbiaya?>", "<?php echo $mhs['nim']?>")'>
					<img src="<?php echo base_url()?>asset/images/design/hr.gif" />
				</a>
				<?php } ?>
			</td>
		</tr>
		<?php
			$jumsetor1 = $jumsetor1+$setor1['jumsetoran'];
			$jumsetor2 = $jumsetor2+$setor2['jumsetoran'];
			$totjumlah = $totjumlah+$jumlah;
			$jumtunggakan = $jumtunggakan+$tunggakan;
			}
		?>
		<tr>
			<td class="right" colspan="3"><b>Jumlah</b></td>
			<td class="right"><?php echo rupiah($totjumlah)?></td>
			<td class="right"><?php echo rupiah($jumtunggakan)?></td>
			<td colspan="3">&nbsp;</td>
		</tr>
	<?php } ?>
	</table>
</div>
<script>
	function tanyaBatalkan(idsetoran, idbiaya, nim){
		if(confirm('Batalkan Pembayaran')){
			load("keuangan/keubiaya/batal_setor/"+idsetoran+"/"+idbiaya+"/"+nim, "#form-pembayaran");
			return true;
		}else{
			return false;
		}
	}
</script>