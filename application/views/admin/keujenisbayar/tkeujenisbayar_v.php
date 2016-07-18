<head>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){ showloading(); this.form.submit();
		}
		function ChangeProdi(){
			showloading();
			var selected_prodi = $('select[name=kodeprodi]').val();
			load('admin/keujenisbayar/prodi/'+selected_prodi,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<?php if($this->session->userdata('sesi_user') == 'keuangan'): ?>
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/keujenisbayar/add","#center-column")'>
		Tambah
	</a>
	<?php endif ?>
	<h1>Daftar Penentuan Pembayaran</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar" style="height:22px">
	<?php echo form_error('kodeprodi')?>
	<select name='kodeprodi' style="width:290px !important;float:right;" onchange='ChangeProdi()'>
		<option <?php if($prodi == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($prodi == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Jenis Pembayaran</th>
			<th>Angkatan</th>
			<th>Gelombang</th>
			<th>Total Biaya</th>
			<?php if($this->session->userdata('sesi_status') == 'keuangan'):?>
			<th class="last">Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_keujenisbayar as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->jenisbayar;?></td>
		<td><?php echo $bm->angkatan;?></td>
		<td><?php echo $bm->gelombang;?></td>
		<td class="right"><?php echo rupiah($bm->totalbiaya);?></td>
		<?php if($this->session->userdata('sesi_status') == 'keuangan'){?>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/keujenisbayar/edit/<?php echo $bm->idjenisbayar?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->idjenisbayar?>)'>
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
			show("admin/keujenisbayar/delete/"+id,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
