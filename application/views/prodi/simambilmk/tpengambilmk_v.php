<script>
	$(document).ready(function(){ stoploading(); });
	function setujui(){ showloading(); }
	function submitGantiKelas(){
		showloading();
		var selected_kelas = $('select[name=cbkelas]').val();
		load('admin/simmktawar/ganti_kelas/'+selected_kelas,'#center-column');
	}
	/*function submitChangeThajaran2(){
		showloading();
		var selected_thajaran = $('select[name=thajaran]').val();
		load('admin/simmktawar/change_thajaran2/'+selected_thajaran,'#center-column');
	}*/
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
		  field[i].checked = false;
		for (i = 0; i < field.length; i++) {
		}
		checkflag = "false";
		return "Check All";
	  }
	}
</script>
<?php echo anchor('admin/simmktawar/export_pengambilmk', 'Export to Excel', 'class="navi button"') ?>
<div class="top-bar-adm">
	<h1>Pengambil Matakuliah</h1>
	<div class="breadcrumbs"><a href="#"><?php echo $this->session->userdata('sesi_namamatkul').
		'('.$this->session->userdata('sesi_kodematkul').')';?></a>
	</div>
	<select style="float:right;margin-right:-32px" name="cbkelas" onchange="submitGantiKelas()">
		<option <?php if($this->session->userdata('sesi_kelas') == '1') echo 'selected'; ?> value="1">Reguler</option>
		<option <?php if($this->session->userdata('sesi_kelas') == '2') echo 'selected'; ?> value="2">Non Reguler</option>
	</select><b style="float:right">Kelas&nbsp;</b>
</div><br />
<div class='clear'></div>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th>No.</th><th>NIM</th><th>Nama Mahasiswa</th>
	</tr>
	<?php
		$i=0; $no=0; foreach($browse_mhs_sudah->result() as $ms): 
		if($ms->namamhs){
		$i=$no++;
	?>
	<tr>
		<td><?php echo $no?></td>
		<td><?php echo $ms->nim?></td>
		<td align="left"><div style="text-align:left";><?php echo $ms->namamhs?></div></td>
	</tr>
	<?php } endforeach; echo form_hidden('n', $i);?>
</table>
<script language="javascript">
	function setujui(tombolSubmit){
		document.getElementById(tombolSubmit).disabled = true;
		showloading();
	}
</script>