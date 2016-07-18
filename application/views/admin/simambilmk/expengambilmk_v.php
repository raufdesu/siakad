<?php
	$namafile = $this->session->userdata('sesi_kodematkul').'-'.
	str_replace(' ', '_',$this->session->userdata('sesi_namamatkul'));
	header("Content-type: application/msexcel");
	header("Content-disposition: attachment; filename=".$namafile);
?>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/report.css" type="text/css" media="all"/>
<div class="top-bar-adm">
	<?php
		echo '<b>Kelas';
		if($this->session->userdata('sesi_kelas') == 1){
			echo 'Reguler';
		}elseif($this->session->userdata('sesi_kelas') == 2){
			echo 'Malam';
		}else{
			echo 'Reguler';
		}
		echo '</b><br />';
	?>
	<b>Pengambil Matakuliah <?php echo $this->session->userdata('sesi_namamatkul').
		'('.$this->session->userdata('sesi_kodematkul').')';?></b>
</div><br />
<div class='clear'></div>
<table class="list" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<th>No.</th><th>NIM</th><th>Nama Mahasiswa</th>
	</tr>
	<?php
		$i=0; $no=0; foreach($browse_mhs_sudah->result() as $ms): 
		$namamhs = $this->auth->get_namamhsbynim($ms->nim);
		if($namamhs){
		$i=$no++;
	?>
	<tr>
		<td><?php echo $no?></td>
		<td><?php echo $ms->nim?></td>
		<td align="left"><div style="text-align:left";><?php echo $namamhs?></div></td>
	</tr>
	<?php } endforeach; echo form_hidden('n', $i);?>
</table>