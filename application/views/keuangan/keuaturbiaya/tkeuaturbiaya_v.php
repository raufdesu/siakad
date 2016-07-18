<head>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading(); this.form.submit();
		}
		function ChangeProdi(){
			showloading();
			var selected_prodi = $('select[name=kodeprodi]').val();
			load('keuangan/keuaturbiaya/prodi/'+selected_prodi,'#center-column');
		}
		/*function ChangeKategori(){
			showloading();
			var selected_kategori = $('select[name=kategori]').val();
			load('keuangan/keuaturbiaya/kategori/'+selected_kategori,'#center-column');
		}*/
		function ChangeAngkatan(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('keuangan/keuaturbiaya/angkatan/'+selected_angkatan,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<?php if($this->session->userdata('sesi_user') == 'keuangan'): ?>
	<div style="float:right;margin-right:-32px">
		<a href="javascript:void(0)" class='button' onclick='show("keuangan/keuaturbiaya/add","#center-column")'>
		Tambah</a>
		<?php echo anchor('keuangan/keuaturbiaya/cetak', 'Cetak', array('class'=>'button', 'target'=>'_blank'))?>
	</div>
	<h1>Daftar Biaya</h1>
	<div class="breadcrumbs">
		<select name='kodeprodi' style="width:290px !important;" onchange='ChangeProdi()'>
			<option <?php if($prodi == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
			<?php foreach($browse_prodi as $bp):?>
			<option <?php if($prodi == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php endif ?>
</div><br />
<div class="select-bar" style="height:22px">
	<!--<select name='kategori' style="width:150px !important;float:right;" onchange='ChangeKategori()'>
		<option </?php if($prodi == '') echo 'selected'; ?> value="">Kategori Keseluruhan</option>
		</?php for($i=0;$i<count($kategori);$i++){ ?>
		<option </?php if($namakategori == $kategori[$i]) echo 'selected'?> value="</?php echo $kategori[$i]?>"></?php echo $kategori[$i]?></option>
		</?php } ?>
	</select>-->
	<div style="float:right;">
		<b>Pilih Angkatan</b>
		<select name='angkatan' style="width:55px !important;" onchange='ChangeAngkatan()'>
			<option <?php if($prodi == '') echo 'selected'; ?> value=""></option>
			<?php foreach($browse_angkatan as $ba){ ?>
			<option <?php if($angkatan == $ba->angkatan) echo 'selected'?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Nama / Jenis Biaya</th>
			<th>Angkatan</th>
			<th>Gel</th>
			<th>Jenis</th>
			<th>Besar Biaya</th>
			<th>Kategori</th>
			<?php if($this->session->userdata('sesi_status') == 'keuangan'):?>
			<th class="last" style="width:70px"> &nbsp; Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_keuaturbiaya as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->namabiaya;?></td>
		<td><?php echo $bm->angkatan;?></td>
		<td><?php echo $bm->gelombang;?></td>
		<td class="first"><?php echo $bm->jenis;?></td>
		<td class="right"><?php echo rupiah($bm->jumbiaya);?></td>
		<td><?php
			echo $bm->kategori;
			if($bm->kategori == 'Persemester'){
				echo '<br />'.$bm->thajaran;
			}
		?></td>
		<?php if($this->session->userdata('sesi_status') == 'keuangan'){?>
		<td class="first" style="text-align:center">
			<?php if($bm->status == 'Pending'){ ?>
			<a href="javascript:void(0)" onclick='return tentukan("<?php echo $bm->idaturbiaya?>")' title="Tetapkan biaya">
				<?php echo img('asset/images/design/check.png')?>
			</a>
			<a href="javascript:void(0)" onclick='show("keuangan/keuaturbiaya/edit/<?php echo $bm->idaturbiaya?>","#center-column")' title="Ubah pengaturan biaya">
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<?php } ?>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->idaturbiaya?>)' title="Hapus pengaturan biaya">
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
		<?php } ?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(id){
		if(confirm("PERINGATAN\nPenghapusan ini juga akan menghapus pembayaran yang ditentukan permahasiswa.\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("keuangan/keuaturbiaya/delete/"+id,"#center-column");
			return true;
		}else{
			return false;
		}
	}
	function tentukan(id){
		if(confirm("KONFIRMASI\nTekan OK penentuan pengaturan pembayaran")==true){
			showloading();
			show("keuangan/keuaturbiaya/tentukan_pembayaran/"+id,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>