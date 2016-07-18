<head>
	<title>Daftar Mahasiswa</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading();
			// this.pilih.submit();
		}
		function ChangeAngkatan(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('admin/masmahasiswa/angkatan/'+selected_angkatan,'#center-column');
		}
		function ChangeShift(){
			showloading();
			var selected_shift = $('select[name=shift]').val();
			load('admin/masmahasiswa/shift/'+selected_shift,'#center-column');
		}
		function ChangeProdi(){
			showloading();
			var selected_prodi = $('select[name=prodi]').val();
			load('admin/masmahasiswa/prodi/'+selected_prodi,'#center-column');
		}
		function submitChangeStatus(){
			showloading()
			var selected_status = $('select[name=statusakademik]').val();
			load('admin/masmahasiswa/status/'+selected_status,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<div style="float:right;margin:5px -32px 0">
	<?php if($this->session->userdata('sesi_user') == 'admin'):?>
	<a href="javascript:void(0)" class='button' onclick='show("admin/masmahasiswa/add","#center-column")'> Tambah</a>
	<?php endif?>
	<?php echo anchor('admin/masmahasiswa/cetak', 'Excel', array('class'=>'button'))?>
	</div>
	<h1>Data Mahasiswa</h1>
	<div class="breadcrumbs">
	<select name='statusakademik' onchange='submitChangeStatus()'>
		<option <?php if($this->session->userdata('sesi_statusakademik') == '') echo 'selected'; ?> value="">Semua</option>
		<option <?php if($this->session->userdata('sesi_statusakademik') == 'Belum Lulus') echo 'selected'; ?> value="Belum Lulus">Belum Lulus</option>
		<option <?php if($this->session->userdata('sesi_statusakademik') == 'Lulus') echo 'selected'; ?> value="Lulus">Lulus</option>
		<option <?php if($this->session->userdata('sesi_statusakademik') == 'Keluar') echo 'selected'; ?> value="Keluar">Keluar</option>
	</select>
	<a href="#">
	<?php echo $this->auth->get_namaprodi($this->session->userdata('sesi_prodi'))?>
	</a></div>
</div><br />
<div class="select-bar">
	<select name='shift' style="width:100px !important" class='obj-right' onchange='ChangeShift()'>
		<option <?php if($this->session->userdata('sesi_shiftmhs') == '') echo 'selected'; ?> value="">Semua Kelas</option>
		<option <?php if($this->session->userdata('sesi_shiftmhs') == '1') echo 'selected'; ?> value="1">Kelas Pagi</option>
		<option <?php if($this->session->userdata('sesi_shiftmhs') == '2') echo 'selected'; ?> value="2">Kelas Sore</option>
	</select>
	<select name='angkatan' style="width:68px !important" class='obj-right' onchange='ChangeAngkatan()'>
		<option <?php if($this->session->userdata('sesi_angkatanmhs') == '') echo 'selected'; ?> value="">Semua</option>
		<?php foreach($browse_angkatan as $ba):?>
		<option <?php if($this->session->userdata('sesi_angkatanmhs') == $ba->angkatan) echo 'selected'; ?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
		<?php endforeach; ?>
	</select>
	<select name='prodi' style="width:180px !important;" class='obj-right' onchange='ChangeProdi()'>
		<option <?php if($this->session->userdata('sesi_prodimhs') == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($this->session->userdata('sesi_prodimhs') == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/masmahasiswa/index'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'masmahasiswa', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_masmahasiswa"),'size=30')."</label>";
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
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th class="last">Kelola</th>
			<?php endif ?>
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
			<a href="javascript:void(0)" onclick='show("admin/masmahasiswa/detail/<?php echo $bm->nim?>","#center-column")'>
				<?php echo $bm->nama; ?>
			</a>
		</td>
		<td class="first"><?php echo $bm->nama_prodi;?></td>
		<td class="first"><?php echo $bm->angkatan;?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/masmahasiswa/edit/<?php echo $bm->nim?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->nim?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
		<?php endif ?>
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