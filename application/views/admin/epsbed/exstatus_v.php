<?php
	$file=$namafile.".xls";
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;filename=".$file );
	header('Pragma: no-cache');
	header('Expires: 0');
?>
<table cellspacing="0" border="1">
<tr>
	<td>THSMSTRLSM</td><td>KDPTITRLSM</td><td>KDJENTRLSM</td><td>KDPSTTRLSM</td><td>NIMHSTRLSM</td>
	<td>STMHSTRLSM</td><td>TGLLSTRLSM</td><td>SKSTTTRLSM</td><td>NLIPKTRLSM</td><td>NOSKRTRLSM</td>
	<td>TGLRETRLSM</td><td>NOIJATRLSM</td><td>STLLSTRLSM</td><td>JNLLSTRLSM</td><td>BLAWLTRLSM</td>
	<td>BLAKHTRLSM</td><td>NODS1TRLSM</td><td>NODS2TRLSM</td><td>NODS3TRLSM</td><td>NODS4TRLSM</td><td>NODS5TRLSM</td>
</tr>
<?php foreach($browse_krs->result() as $bk):?>
<tr>
	<td><?php echo str_replace('-', '',substr($bk->tglkrs,0,10))?></td>
	<td><?php echo substr($bk->tglkrs,10,9)?></td>
	<td><?php echo str_replace('-', '',substr($bk->tglkrs,0,10))?></td>
	<td><?php echo substr($bk->tglkrs,10,9)?></td>
	<td><?php echo $bk->thajaran?></td>
	<td><?php echo '053025'?></td>
	<td>
		<?php
			if(substr($bk->nim, 0, 1) == '1'){
				echo 'C';
			}elseif(substr($bk->nim, 0, 1) == '2'){
				echo 'E';
			}
		?>
	</td>
	<td>
		<?php
			if(substr($bk->nim, 0, 2) == '11'){
				echo '57201';
			}elseif(substr($bk->nim, 0, 2) == '12'){
				echo '55201';
			}elseif(substr($bk->nim, 0, 2) == '23'){
				echo '61201';
			}elseif(substr($bk->nim, 0, 2) == '24'){
				echo '56401';
			}elseif(substr($bk->nim, 0, 2) == '25'){
				echo '57402';
			}
		?>
	</td>
	<td><?php echo $bk->nim?></td>
	<td><?php echo $bk->kodemk?></td>
	<td><?php echo "'01";?></td>
</tr>
<?php endforeach; ?>
</table>