<?php
	/*$file=$namafile.".xls";
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;filename=".$file );
	header('Pragma: no-cache');
	header('Expires: 0');*/
?>
<table cellspacing="0" border="1">
<tr>
	<td>KDPTIMSMHS</td><td>KDJENMSMHS</td><td>KDPSTMSMHS</td><td>NIMHSMSMHS</td><td>NMMHSMSMHS</td>
	<td>SHIFTMSMHS</td><td>TPLHRMSMHS</td><td>TGLHRMSMHS</td><td>KDJEKMSMHS</td><td>TAHUNMSMHS</td>
	<td>SMAWLMSMHS</td><td>BTSTUMSMHS</td><td>ASSMAMSMHS</td><td>TGMSKMSMHS</td><td>TGLLSMSMHS</td>
	<td>STMHSMSMHS</td><td>STPIDMSMHS</td><td>SKSDIMSMHS</td><td>ASNIMMSMHS</td><td>ASPTIMSMHS</td>
	<td>ASJENMSMHS</td><td>ASPSTMSMHS</td><td>BISTUMSMHS</td><td>PEKSBMSMHS</td><td>NMPEKMSMHS</td>
	<td>PTPEKMSMHS</td><td>PSPEKMSMHS</td><td>NOPRMMSMHS</td><td>NOKP1MSMHS</td><td>NOKP2MSMHS</td>
	<td>NOKP3MSMHS</td><td>NOKP4MSMHS</td><td>USIAMMSMHS</td><td>MLSEMMSMHS</td><td>SMAW1MSMHS</td>
	<td>TGMS1MSMHS</td><td>NIMANMSMHS</td><td>NILUNMSMHS</td>
</tr>
<?php foreach($browse_krs as $bk):?>
<tr>
	<td>053025</td>
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
	<td><?php echo $bk->nama?></td>
	<td><?php echo 'R';?></td>
	<td><?php echo $bk->tempatlahir;?></td>
	<td><?php echo str_replace('-', '',substr($bk->tgllahir,0,10))?></td>
	<td><?php
		if($bk->jeniskelamin == '1'){
			echo 'L';
		}else{
			echo 'P';
		}
	?></td>
	<td><?php echo $bk->angkatan;?></td>
	<td><?php echo $bk->thajaranawal;?></td>
	<td><?php echo $bk->thajaranakhir?></td>
	<td><?php echo $bk->propinsisma?></td>
	<td><?php echo str_replace('-', '',substr($bk->tglmasuk,0,10))?></td>
	<td><?php echo str_replace('-', '',substr($bk->thlulusmhs,0,10))?></td>
	<td>
		<?php
			echo substr($bk->statusakademik,0,1);
			echo substr($bk->status,0,1);
			echo '<br />STMHSMSMHS adalah status mahasiswa(C=Cuti, K=Keluar, D=Dropout, L=Lulus, A=Aktif) Status ada di 2 tabel kepiye kie...';?></td>
	<td><?php if($bk->statusmasuk == 'Baru'){ echo 'B'; }else{ echo 'P'; } ?></td>
	<td><?php echo $bk->sksdiakui;?></td>
	<td><?php echo 'ASNIMMSMHS = NIM asal'; ?></td>
	<td><?php echo 'ASPTIMSMHS = KODE PRODI Asal?'; ?></td>
	<td>
		<?php
			/*if(substr($bk->nim, 0, 1) == '1'){
				echo 'C';
			}elseif(substr($bk->nim, 0, 1) == '2'){
				echo 'E';
			} */
		?>
</td>
	<td><?php echo 'ASPSTMSMHS = KODE Perguruan Tinggi Asal?'; ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo $bk->usiamhs?></td>
	<td>MLSEMMSMHS</td>
	<td>SMAW1MSMHS</td>
	<td>TGMS1MSMHS</td>
	<td>NIMANMSMHS</td>
	<td>NILUNMSMHS</td>
</tr>
<?php endforeach; ?>
</table>