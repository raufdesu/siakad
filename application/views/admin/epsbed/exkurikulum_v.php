<?php
	/*$file=$namafile.".xls";
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;filename=".$file );
	header('Pragma: no-cache');
	header('Expires: 0');*/
?>
<table cellspacing="0" border="1">
<tr>
	<td>THSMSTBKMK</td><td>KDPTITBKMK</td><td>KDJENTBKMK</td><td>KDPSTTBKMK</td><td>KDKMKTBKMK</td>
	<td>NAKMKTBKMK</td><td>SKSMKTBKMK</td><td>SKSTMTBKMK</td><td>SKSPRTBKMK</td><td>SKSLPTBKMK</td>
	<td>SEMESTBKMK</td><td>KDWPLTBKMK</td><td>KDKURTBKMK</td><td>KDKELTBKMK</td><td>NODOSTBKMK</td>
	<td>JENJATBKMK</td><td>PRODITBKMK</td><td>STKMKTBKMK</td><td>SLBUSTBKMK</td><td>SAPPPTBKMK</td>
	<td>BHNAJTBKMK</td><td>DIKTTTBKMK</td><td>KDUTATBKMK</td><td>KDKUGTBKMK</td><td>KDLAITBKMK</td>
	<td>KDMPATBKMK</td><td>KDMPBTBKMK</td><td>KDMPCTBKMK</td><td>KDMPDTBKMK</td><td>KDMPETBKMK</td>
	<td>KDMPFTBKMK</td><td>KDMPGTBKMK</td><td>KDMPHTBKMK</td><td>KDMPITBKMK</td><td>KDMPJTBKMK</td>
	<td>CRMKLTBKMK</td><td>PRSTDTBKMK</td><td>SMGDSTBKMK</td><td>RPSIMTBKMK</td><td>CSSTUTBKMK</td>
	<td>DISLNTBKMK</td><td>SDILNTBKMK</td><td>CODLNTBKMK</td><td>COLLNTBKMK</td><td>CTXINTBKMK</td>
	<td>PJBLNTBKMK</td><td>PBBLNTBKMK</td><td>UJTLSTBKMK</td><td>TGMKLTBKMK</td><td>TGMODTBKMK</td>
	<td>PSTSITBKMK</td><td>SIMULTBKMK</td><td>LAINNTBKMK</td><td>UJTL1TBKMK</td><td>TGMK1TBKMK</td>
	<td>TGMO1TBKMK</td><td>PSTS1TBKMK</td><td>SIMU1TBKMK</td><td>LAIN1TBKMK</td>
</tr>
<?php foreach($browse_kurikulum->result() as $bk):?>
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
	<td><?php echo $bk->kodemk?></td>
	<td><?php echo $bk->namamk?></td>
	<td><?php echo $bk->sks.',00'?></td>
</tr>
<?php endforeach; ?>
</table>