<style>
	td,tr{
		padding:0 10px 0 10px;
	}
</style>
<b>Daftar Nilai Matakuliah <?php echo $namamatkul.' ('.$kodemk.')';?></b>
<table border="1">
	<tr>
		<th class="first">No.</th><th>NIM</th><th>Nama Mahasiswa</th>
		<th width="41" class="last">Nilai Akhir</th>
	</tr>
	<?php
		$bg = '';
		$no=1;
		foreach($browse_mahasiswaambilmk->result() as $ds):
		$i = $no++;
		if($i % 2 == 0){
			$bg = 'bg';
		}else{
			$bg = '';
		}
	?>
	<tr class="<?php echo $bg?>">
		<td><?php echo $i?></td>
		<td><?php echo $ds->nim?></td>
		<td><?php echo $this->auth->get_namamhsbynim($ds->nim)?></td>
		<td><?php echo $ds->nilaihuruf?></td>
	</tr>
	<?php $n=$i; endforeach ?>
</table>