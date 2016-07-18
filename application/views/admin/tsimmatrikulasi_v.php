<head>
	<title>Daftar Matrikulasi Mahasiswa</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading();
			// this.pilih.submit();
		}
		function submitChangeStatus(){
			showloading();
			var selected_status = $('select[name=statusakademik]').val();
			load('admin/masmahasiswa/status/'+selected_status,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/simmatrikulasi/input_awal","#center-column")'> Tambah</a>
	<h1>Data Matrikulasi Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
	<select name='statusakademik' class='obj-right' onchange='submitChangeStatus()'>
		<option <?php if($this->session->userdata('sesi_statusakademik') == 'Keluar') echo 'selected'; ?> value="Keluar">Tahun Ajaran</option>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simmatrikulasi/index'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'masmahasiswa', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("sesicari_mhsmatrik"),'size=30')."</label>";
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
			<th>PRODI</th>
			<th>Angkatan</th>
			<!--<th class="last">Kelola</th>-->
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_mhsmatrikulasi as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first">
			<a href="javascript:void(0)" class="link" onclick='show("admin/simmatrikulasi/detail_mahasiswa/<?php echo $bm->nim?>","#center-column")'>
				<?php echo $bm->nama; ?>
			</a>
		</td>
		<td class="first"><?php echo $bm->prodi;?></td>
		<td class="first"><?php echo $bm->angkatan;?></td>
		<!--<td class="first">-->
			<!--<a href="javascript:void(0)" onclick='show("admin/masmahasiswa/edit/</?php echo $bm->nim?>","#center-column")'>
				</?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya(</?php echo $bm->nim?>)'>
				</?php echo img('asset/images/design/hr.gif')?>
			</a>-->
		<!--</td>-->
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