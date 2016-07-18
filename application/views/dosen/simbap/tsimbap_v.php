<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	});
</script>
<div class="top-bar-adm">
	<div style="margin-right:-30px;float:right">
		<a href="javascript:void(0)" class='button' onclick='show("dosen/nilai","#center-column")'>Daftar Matakuliah</a>
		<?php echo anchor('dosen/simbap/cetak/'.$id_kelas_dosen, 'Cetak BAP', array('class'=>'button','target'=>'_blank')); ?>
	</div>
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div>
<div class="table">
<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first" width="5">No.</th>
		<th style="width:140px">Tgl. Kuliah</th>
		<th>Materi</th>
		<th style="width:80px" class="last">Kelola</th>
	</tr>
<?php $i=1; foreach($browse_bap->result() as $bm): ?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo tgl_indo($bm->tglkuliah, 1);?></td>
		<td class="first"><?php echo $bm->materi;?></td>
		<td>
			<a href="javascript:void(0)" onclick='show("dosen/simbap/input_presensi/<?php echo $bm->idbap?>","#center-column")' title='Presensi Mahasiswa'>
				<?php echo img('asset/images/design/detail_add.png')?>
			</a>
			<a href="javascript:void(0)" onclick='show("dosen/simbap/edit/<?php echo $bm->idbap?>","#center-column")' title='Edit Materi'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->idbap?>")' title='Hapus BAP beserta Presensi Mahasiswa Didalamnya'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
</table>
<script>
	function tanya(idbap){
		if(confirm('KONFIRMASI\nPenghapusan ini akan menghapus presensi mahasiswa yang bersangkutan dengan BAP ini.\nTekan OK untuk melanjutkan penghapusan.')){
			show("dosen/simbap/hapus/"+idbap, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>