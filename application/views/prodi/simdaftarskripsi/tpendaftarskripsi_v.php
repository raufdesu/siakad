<head>
	<title>Daftar Mahasiswa</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading();
		}
		function changeJenisDaftar(){
			showloading();
			var selected_status = $('select[name=jenisdaftar]').val();
			load('prodi/simdaftarskripsi/change_jenisdaftar/'+selected_status,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<h1>Data Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#">
	Pendaftar KP/TA/Skripsi
	</a></div>
</div><br />
<div class="select-bar">
	<div class='obj-right'>
	<b>Jenis Pendaftaran</b>
	<select name='jenisdaftar' onchange='changeJenisDaftar()'>
		<option <?php if($this->session->userdata('sesi_jenisdaftar') == '') echo 'selected'; ?> value="">Semua</option>
		<option <?php if($this->session->userdata('sesi_jenisdaftar') == 'KP') echo 'selected'; ?> value="KP">KP</option>
		<option <?php if($this->session->userdata('sesi_jenisdaftar') == 'TA') echo 'selected'; ?> value="TA">TA</option>
		<option <?php if($this->session->userdata('sesi_jenisdaftar') == 'Skripsi') echo 'selected'; ?> value="Skripsi">Skripsi</option>
	</select>
	</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simdaftarskripsi'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'masmahasiswa', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_simdaftarskripsi"),'size=30')."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();
?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th>Angkatan</th>
			<th>Jenis Daftar</th>
			<th style="width:50px" class="last">Kelola</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_masmahasiswa as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("prodi/masmahasiswa/detail/<?php echo $bm->nim?>","#center-column")'>
				<?php echo $bm->nama; ?>
			</a>
		</td>
		<td><?php echo $this->auth->get_angkatanbynim($bm->nim);?></td>
		<td class="first"><?php echo $bm->jenisdaftar;?></td>
		<td class="first" style="text-align:center !important">
			<a href="javascript:void(0)" title="Pendaftaran KP" onclick='show("prodi/masmahasiswa/pendaftaran/<?php echo $bm->nim?>","#center-column")'>
				<?php echo img('asset/images/design/detail.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(nim){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/masmahasiswa/delete/"+nim,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>