<script type='text/javascript' src='<?php echo base_url()?>asset/plugin/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/css/jquery.autocomplete.css" />
<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	})
</script>
<div style="float:right;height:25px">
	<?php echo anchor('dosen/simbap/cetak/'.$id_kelas_dosen, 'Cetak BAP', array('class'=>'button','target'=>'_blank')); ?>
	<a href="javascript:void(0)" class='button' onclick='show("dosen/nilai","#center-column")'>Daftar Matakuliah</a>
	<!--<a href="javascript:void(0)" class="button" onclick='show("dosen/simbap/browse","#center-column")'>Browse</a>-->
</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('dosen/simbap/save'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simbap',
	'type'=>'post'));
	echo form_hidden('kodemk', $kodemk);
	echo form_hidden('thajaran', $thajaran);
	echo form_hidden('id_kelas_dosen', $this->session->userdata('sesi_dosenampu'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT MATERI</th>
		</tr>
		<tr>
			<td class="first" width="172"><strong>Kode Matakuliah</strong></td>
			<td class="last"><?php echo $kodemk?></td>
		</tr>
		<tr>
			<td class="first" width="172"><strong>Nama Matakuliah</strong></td>
			<td class="last"><?php echo $namamatkul.' ('.$kelas.')';?></td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Materi Hari Ini</strong></td>
			<td class="last">
				<textarea name="materi" rows="2" cols="80"></textarea><?php echo form_error('materi')?>
			</td>
		</tr>
		<tr>
			<td class="first" width="172"><strong>Materi Hari Ini</strong></td>
			<td class="last">
				<input type="text" size="8" value="<?php echo tgl_indo(date('Y-m-d'));?>" name="tglkuliah" />
				<input type="button" value="..." OnClick="displayDatePicker('tglkuliah', false, 'dmy', '-')"></td>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit("cmdSimpan","Update",'OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("dosen/nilai","#center-column")'>
					<< Batal
				</a>
			</td>
		</tr>
	</table>
</div>
<?php echo form_close();?>
<table style="margin-top:10px" class="listing form" cellpadding="0" cellspacing="0">
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
	function setujui(){
		showloading();
		this.form.submit();
	}
	function tanya(idbap){
		if(confirm('KONFIRMASI\nPenghapusan ini akan menghapus presensi mahasiswa yang bersangkutan dengan BAP ini.\nTekan OK untuk melanjutkan penghapusan.')){
			show("dosen/simbap/hapus/"+idbap, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>