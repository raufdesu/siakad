<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function setujui(){
			showloading();
		}
		function changeProdi(){
			showloading();
			var selected_prodi = $('select[name=kodeprodi]').val();
			load('keuangan/keubiaya/change_prodi/'+selected_prodi, '#center-column');
		}
		function changeStatus(){
			showloading();
			var selected_status = $('select[name=status]').val();
			load('keuangan/keubiaya/change_statuspembayaran/'+selected_status, '#center-column');
		}
		function changeAngkatan(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('keuangan/keubiaya/change_angkatanpembayaran/'+selected_angkatan, '#center-column');
		}
		function changeThajaran(){
			showloading();
			var selected_thajaran = $('select[name=thajaran]').val();
			load('keuangan/keubiaya/change_thajaranpembayaran/'+selected_thajaran, '#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<h1>Daftar Pembayaran</h1>
	<?php echo anchor('keuangan/keubiaya/cetak_pembayaran', 'Preview', array('style'=>'margin:0 -32px 0', 'class'=>'navi print-button', 'target'=>'_blank'))?>
	<?php if($this->session->userdata('sesi_user') == 'keuangan'): ?>
	<div class="breadcrumbs">
		PRODI
		<select name='kodeprodi' style="width:290px !important;" onchange='changeProdi()'>
			<option <?php if($prodi == '') echo 'selected'; ?> value="">Keseluruhan</option>
			<?php foreach($browse_prodi as $bp):?>
			<option <?php if($prodi == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php endif ?>
</div>
<div class="select-bar" style="height:25px">
	<!--<select name='kategori' style="width:150px !important;float:right;" onchange='ChangeKategori()'>
		<option </?php if($prodi == '') echo 'selected'; ?> value="">Kategori Keseluruhan</option>
		</?php for($i=0;$i<count($kategori);$i++){ ?>
		<option </?php if($namakategori == $kategori[$i]) echo 'selected'?> value="</?php echo $kategori[$i]?>"></?php echo $kategori[$i]?></option>
		</?php } ?>
	</select>-->
	<div style="float:right;">
		Angkatan
		<select name='angkatan' style="width:auto;" onchange='changeAngkatan()'>
		<option <?php if($prodi == '') echo 'selected'; ?> value="">Keseluruhan</option>
			<?php foreach($browse_angkatan as $ba){ ?>
			<option <?php if($angkatan == $ba->angkatan) echo 'selected'?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
			
			<?php } ?>
		</select>
		Thn Ajaran
		<select name='thajaran' style="width:auto;" onchange='changeThajaran()'>
			<option <?php if($prodi == '') echo 'selected'; ?> value="">Keseluruhan</option>
			<?php foreach($browse_thajaran as $bt){ ?>
			<option <?php if($thajaran == $bt->thajaran) echo 'selected'?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
			<?php } ?>
		</select>
		Status
		<select name='status' style="width:auto;" onchange='changeStatus()'>
			<option <?php if($status == 'Keseluruhan') echo 'selected'?> value="">Keseluruhan</option>
			<option <?php if($status == 'Belum Lunas') echo 'selected'?> value="Belum Lunas">Belum Lunas</option>
			<option <?php if($status == 'Lunas') echo 'selected'?> value="Lunas">Lunas</option>
		</select>
	</div>
	<?php
		echo $this->pquery->form_remote_tag(array(
		'url'=>site_url('keuangan/keubiaya/cari_mhspembayaran'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'masmahasiswa', 'type'=>'post'));
		echo "<label>".form_input("txtCari", $cari,'size=20')."</label>";
		echo "<label>".form_submit("cmdCari", "Cari", "OnClick='setujui()' class='search'")."</label>";
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
			<th>Tahun Ajaran</th>
			<th>Nama Biaya</th>
			<th>Jumlah Biaya</th>
			<th>Jumlah Setoran</th>
			<th >Tanggal Setoran</th>
			<th>Status</th>
			<!--<th>Besar Biaya</th>-->
			<?php if($this->session->userdata('sesi_status') == 'keuangan'):?>
			<th class="last">#</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	foreach($browse_pembayaran->result() as $bm):
	$nomor = $i++;
	if($nomor % 2 == 0){
		$bg = 'bg';
	}else{
		$bg = '';
	}
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $nomor.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td class="first"><?php echo $bm->thajaran;?></td>
		<td class="first"><?php echo $bm->namabiaya;?></td>
		<td style="text-align:right"><?php echo rupiah($bm->jumbiaya);?></td>
		<td class="first"><?php echo $bm->jumlahsetor;?></td>
		<td class="first"><?php echo $bm->tanggalsetor;?></td>
		<td><?php echo inisial($bm->status);?></td>
		<?php if($this->session->userdata('sesi_status') == 'keuangan'){?>
		<td class="first" style="text-align:center">
			<!--<a href="javascript:void(0)" onclick='show("keuangan/keuaturbiaya/edit/</?php echo $bm->idaturbiaya?>","#center-column")' title="Ubah pengaturan biaya">
				</?php echo img('asset/images/design/edit-icon.gif')?>
			</a>-->
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->idbiaya?>)' title="Hapus Dari Daftar">
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
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("keuangan/keubiaya/delete/" + id, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>