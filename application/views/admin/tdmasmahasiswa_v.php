<?php
	foreach($detail_masmahasiswa as $dm):
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="3">DETAIL DATA MAHASISWA</th>
		</tr>
		<tr>
			<td class="first" width="160"><strong>NIM</strong></td>
			<td class="last">: <?php echo $dm->nim;?></td>
			<td rowspan="12">
				<?php
					$arimg = array(
						'src' => 'asset/images/mahasiswa/'.$dm->angkatan.'/'.$dm->nim.'.jpg',
						'width' => 150, 'height' => 220
					);
					echo img($arimg);
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>nama</strong></td>
			<td class="last">: <?php echo $dm->nama;?></td>
		</tr>
		<tr>
			<td class="first"><strong>Agama</strong></td>
			<td class="last">: <?php echo $dm->agama;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Masuk</strong></td>
			<td class="last">: <?php echo $dm->tglmasuk;?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>PRODI</strong></td>
			<td class="last">: <?php echo $dm->nama_prodi;?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kelas</strong></td>
			<td class="last">:
			<?php
				if($dm->kdkelas == '2')
					echo 'Malam';
				else
					echo 'Reguler';
			?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Angkatan</strong></td>
			<td class="last">: <?php echo $dm->angkatan;?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Masuk</strong></td>
			<td class="last">: <?php echo $dm->statusmasuk; ?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Alamat Asal</strong></td>
			<td class="last">: <?php echo $dm->alamatasal; ?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Orang Tua</strong></td>
			<td class="last">: <?php echo $dm->namaortu;?></td>
		</tr>
		<tr>
			<td class="first"><strong>Asal SMA</strong></td>
			<td class="last">: <?php echo $dm->asalsma;?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Lulus SMA</strong></td>
			<td class="last">: <?php echo $dm->thlulus;?></td>
		</tr>
	</table>
<?php endforeach;?>
<div align="right"><hr />
	<a href="javascript:void(0)" onclick='show("admin/masmahasiswa","#center-column")'><< back</a>
</div>
</div>
