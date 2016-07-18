<?php
	$file=$namafile.".xls";
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;filename=".$file );
	header('Pragma: no-cache');
	header('Expires: 0');
?>
<table cellspacing="0" border="1">
<tr>
	<td>THSMSTRNLM</td><td>KDPTITRNLM</td><td>KDJENTRNLM</td><td>KDPSTTRNLM</td><td>NIMHSTRNLM</td>
	<td>KDKMKTRNLM</td><td>NLAKHTRNLM</td><td>BOBOTTRNLM</td><td>KELASTRNLM</td>
</tr>
<?php foreach($browse_nilai->result() as $bk):?>
<tr>
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
	<td><?php echo $bk->nilaihuruf?></td>
	<td>
		<?php
			if($bk->nilaihuruf == "A"){
				echo "'4,00";
			}elseif($bk->nilaihuruf == "B"){
				echo "'3,00";
			}elseif($bk->nilaihuruf == "C"){
				echo "'2,00";
			}elseif($bk->nilaihuruf == "D"){
				echo "'1,00";
			}else{
				echo "'0,00";
			}
		?>
	</td>
	<td><?php echo "'01";?></td>
</tr>
<?php endforeach; ?>
</table>