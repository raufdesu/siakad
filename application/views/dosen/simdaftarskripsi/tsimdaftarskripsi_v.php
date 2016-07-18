<script>
	$(document).ready(function(){
		stoploading();
	});
</script>
<script>
	function ChangeJenisDaftar(){
		showloading();
		var jenis = $('select[name=jenisdaftar]').val();
		load('dosen/simdaftarskripsi/change_jenisdaftar/'+jenis,'#center-column');
	}
</script>
<div class="top-bar-adm">
	<h1>Daftar Mahasiswa Bimbingan
		<select name="jenisdaftar" onchange="ChangeJenisDaftar()">
			<option <?php if($this->session->userdata('sesi_jenisdaftar') == '') echo 'selected'; ?> value="">All</option>
			<option <?php if($this->session->userdata('sesi_jenisdaftar') == 'Skripsi') echo 'selected'; ?> value="Skripsi">Skripsi</option>
			<option <?php if($this->session->userdata('sesi_jenisdaftar') == 'TA') echo 'selected'; ?> value="TA">TA</option>
			<option <?php if($this->session->userdata('sesi_jenisdaftar') == 'KP') echo 'selected'; ?> value="KP">KP</option>
		</select>
	</h1>
	<div class="breadcrumbs"><a href="javascript:void(0)"></a></div>
</div>
<div class="table">
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">No.</th><th>NIM</th><th>Nama Mahasiswa</th><th>PRODI</th><th width="41" class="last">Aksi</th>
	</tr>
	<?php $no=1; foreach($mhsdaftarskripsi->result() as $ds){ if($ds->nim){ ?>
	<tr class="bg">
		<td><?php echo $i = $no++;?></td>
		<td><?php echo $ds->nim?><input type='hidden' name='nim_<?php echo $i?>' value='<?php echo $ds->nim?>'/></td>
		<td class="first"><?php echo $ds->namamhs?></td>
		<td class="first"><?php echo $this->auth->get_prodibynim($ds->nim)->namaprodi?></td>
		<td class="last">
			<a href="javascript:void(0)" onclick='show("dosen/simdaftarskripsi/detail/<?php echo $ds->iddaftarskripsi?>","#center-column")' title='Lihat Detail'>
				<?php echo img('asset/images/design/login-icon.gif')?>
			</a>
		</td>
	</tr>
	<?php } } ?>
</table>
<?php
	$tot = $mhsdaftarskripsi->result();
	echo '<div style="padding:5px; float:right"> Total : '.count($tot).' Mahasiswa</div>';
?>
</div>