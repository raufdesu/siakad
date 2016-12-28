<script>
	$(document).ready(function(){
		stoploading();
	});
</script>
<script>
	function submitGantiKelas(){
		showloading();
		var selected_kelas = $('select[name=cbkelas]').val();
		load('admin/simmktawar/gantikelas/'+selected_kelas,'#mhs-ambilmk');
	}
</script>
<script language='javascript'>
	var checkflag = "false";
	function check(field) {
	  if (checkflag == "false") {
		for (i = 0; i < field.length; i++) {
		  field[i].checked = true;
		}
		checkflag = "true";
		return "Uncheck All";
	  } else {
		for (i = 0; i < field.length; i++) {
		  field[i].checked = false;
		}
		checkflag = "false";
		return "Check All";
	  }
	}
</script>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simmktawar/pilih_kelas'), 'update'=>'#mhs-ambilmk',	'name'=>'myform',	'id'=>'maspegawai',	'type'=>'post'));
?>
<div class="headd-box">
	<div><input type='submit' onclick='setujui("simpanPilihan")' value=''id='simpanPilihan' class='simpan'/></div>
	<!--</?php echo 'Kelas : ' ?>
		<select name="cbkelas" onchange="submitGantiKelas()">
			<option </?php if($this->session->userdata('sesi_kelas') == '1') echo 'selected'; ?> value="1">Reguler</option>
			<option </?php if($this->session->userdata('sesi_kelas') == '2') echo 'selected'; ?> value="2">Malam</option>
		</select> Paralel : </?php echo $ampu->kelas?><br />-->
	<?php
		echo 'Matakuliah : <b> '.$namamatkul.'</b> ('.$ampu->kelas.')<br />';
		echo $ampu->namadosen;
		echo form_hidden('id_kelas_dosen',$id_kelas_dosen);
		echo form_hidden('kodemk',$kodemk);
		echo form_hidden('kelas',$ampu->kelas);
	?>
</div><div class='clear'></div>
<table cellspacing='0'>
	<tr>
		<th>No.</th><th>NIM</th><th>Nama Mahasiswa</th>
		<th style="width:10px;">
			<input type="checkbox" value="Check All" onClick="this.value=check(this.form.nim)">
		</th>
	</tr>
	<?php
		$i=0; $no=0; $jum=0;
		foreach($browse_mhs_sudah->result() as $ms):
		$namamhs = $this->auth->get_namamhsbynim($ms->nim);
		if($namamhs){
		$i=$no++;
	?>
	<tr>
		<td><?php echo $no?></td>
		<td><?php echo $ms->nim?></td>
		<td><?php echo $namamhs?></td>
		<td align='center'>
			<a href="javascript:void(0)" class='navi button' onclick='show("admin/simmktawar/pilih_kelas/batalpilih/<?php echo $id_kelas_dosen?>/<?php echo $ms->nim?>/<?php echo $kodemk?>","#mhs-ambilmk")'>X</a>
		</td>
	</tr>
	<?php $jum = $i;  } endforeach; ?>
	<?php
		foreach($browse_mhs->result() as $ds):
		$namamhs = $this->auth->get_namamhsbynim($ds->nim);
		if($namamhs){
		$i=$no++;
	?>
	<tr class="bg">
		<td><?php echo $no?></td>
		<td><?php echo $ds->nim?></td>
		<td><?php echo $namamhs?></td>
		<td><input type="checkbox" name="nim<?php echo $i?>" id="nim" value="<?php echo $ds->nim?>"/></td>
	</tr>
	<?php } endforeach; echo form_hidden('n', $i);?>
</table>
<?php $this->session->set_userdata('sesi_jummhs', $jum+1); ?>
</form>
<script language="javascript">
	function setujui(tombolSubmit){
		document.getElementById(tombolSubmit).disabled = true;
		showloading();
	}
</script>