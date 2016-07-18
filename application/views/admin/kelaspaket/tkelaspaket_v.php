<head>
	<title>Daftar Matakuliah dan kelaspaket</title>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function ChangeProdiKelasPaket(){
			showloading();
			var selected_prodi = $('select[name=prodi]').val();
			load('admin/kelaspaket/change_prodi/'+selected_prodi, '#center-column');
		}
		function ChangeAngkatanKelasPaket(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('admin/kelaspaket/change_angkatan/'+selected_angkatan, '#center-column');
		}
		function ChangeKelasKelasPaket(){
			showloading();
			var selected_kelas = $('select[name=kelas]').val();
			load('admin/kelaspaket/change_kelas/'+selected_kelas, '#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<?php if($this->session->userdata('sesi_user') == 'admin'): ?>
		<a href="javascript:void(0)" style="margin-right:-32px;float:right" class='button' onclick='show("admin/kelaspaket/add","#center-column")'> Tambah</a>
	<?php endif ?>
	<h1>Daftar Kelas Paket</h1>
	<div class="breadcrumbs"><a href="#">Prodi, kelas dan angkatan yang menerapkan KRS Paket</a></div>
</div>
<div class="select-bar">
	<select name='kelas' style="width:100px !important" class='obj-right' onchange='ChangeKelasKelasPaket()'>
		<option <?php if($kelas == '') echo 'selected'; ?> value="">Semua Kelas</option>
		<option <?php if($kelas == '1') echo 'selected'; ?> value="1">Kelas Pagi</option>
		<option <?php if($kelas == '2') echo 'selected'; ?> value="2">Kelas Sore</option>
	</select>
	<select name='angkatan' style="width:68px !important" class='obj-right' onchange='ChangeAngkatanKelasPaket()'>
		<option <?php if($angkatan == '') echo 'selected'; ?> value="">Semua</option>
		<?php foreach($browse_angkatan as $ba):?>
		<option <?php if($angkatan == $ba->angkatan) echo 'selected'; ?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
		<?php endforeach; ?>
	</select>
	<select name='prodi' style="width:180px !important;" class='obj-right' onchange='ChangeProdiKelasPaket()'>
		<option <?php if($prodi == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($prodi == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/kelaspaket/cari_kelaspaket'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'paket', 'type'=>'post'));
	echo "<label>".form_input("txtCari", $cari,'size=30')."</label>";
	echo "<label>".form_submit("cmdCari", "Cari", "OnClick='showloading()' class='search'")."</label>";
	echo form_close();
?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Nama PRODI</th>
			<th>Kelas</th>
			<th>Angkatan</th>
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th class="last"><center>#</center></th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	foreach($browse_kelaspaket as $bm):
	$nomor = $i++;
	if($nomor % 2 == 0){
		$bg = 'bg';
	}else{
		$bg = '';
	}
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $nomor.'.';?></td>
		<td class="first"><?php echo $bm->namaprodi;?></td>
		<td class="first"><?php
			if($bm->kelas == '1'){
				echo 'Kelas Pagi';
			}else{
				echo 'Kelas Sore';
			}
		?></td>
		<td><?php echo $bm->angkatan;?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="last"><center>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->idkelaspaket?>)' title='Batalkan'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</center></td>
		<?php endif ?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging).'</div><div class="total-rows"> Total : '.$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(idkelaspaket){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/kelaspaket/delete/"+idkelaspaket, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>