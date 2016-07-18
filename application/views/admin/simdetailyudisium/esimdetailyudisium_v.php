<script type="text/javascript">
$(document).ready(function() {
	stoploading();
})
</script>
<?php
	//echo form_open('admin/simdetailyudisium/save',array('target' => '_blank', 'name' => 'frmyudisium'));
?>
<?php echo $this->pquery->form_remote_tag(array('url'=>site_url('admin/simdetailyudisium/save'), 							
	'update'=>'#center-column', 'name'=>'f1', 'id'=>'maspegawai', 'type'=>'post')); ?>
<div class="table" style="margin:0 10px 10px 10px;">
	<h2><?php echo $title?></h2>
	<table class="form" width="250" cellpadding="0" cellspacing="0">
		<tr class="bg">
			<td class="first"><strong>No.&nbsp;Yudisium</strong></td>
			<td class="last">
				<select name="idyudisium">
				<?php foreach($browse_ny as $bn){ ?>
				<option <?php if($yud->idyudisium == $bn->idyudisium) echo 'selected';?> value="<?php echo $bn->idyudisium?>"><?php echo $bn->noyudisium.'('.$bn->idyudisium?></option>
				<?php } ?>
				</select>
				<?php echo form_error('idyudisium');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>NIM</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $yud->iddetailyudisium?>" name="iddetailyudisium" />
				<input type="text" name="nim" value="<?php echo $this->session->userdata('sesi_nimmhs')?>" class="required" readonly size="10"/>
				<?php echo form_error('nim');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Judul TA/Skripsi</strong></td>
			<td class="last">
				<textarea name="judulskripsi" class="required" rows="2" cols="40"><?php echo $yud->judulskripsi?></textarea>
				<?php echo form_error('judulskripsi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Total SKS</strong></td>
			<td class="last">
				<input type="text" name="totalsks" value="<?php echo $jum_sks?>" class="required" size="1"/>
				<?php echo form_error('totalsks');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>IPK</strong></td>
			<td class="last">
				<input type="text" name="ipk" class="required" value="<?php echo number_format($jum_ipk,2)?>" size="2"/>
				<?php echo form_error('ipk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Ijazah</strong></td>
			<td class="last">
				<input type="text" name="noijazah" value="<?php echo $yud->noijazah?>" class="required" size="25"/>
				<?php echo form_error('noijazah');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Trnskrip</strong></td>
			<td class="last">
				<input type="text" name="notranskrip" value="<?php echo $yud->notranskrip?>" class="required" size="25"/>
				<?php echo form_error('notranskrip');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Kelulusan</strong></td>
			<td class="last">
				<input type="text" name="tglijazah" value="<?php echo tgl_indo($yud->tglijazah)?>" class="required" size="8"/>
				<?php echo form_error('tglijazah');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<hr />
				<?php echo form_submit('cmdSimpan','Simpan dan Cetak','OnClick="return Validasi()"');?>
				<input type="button" onclick='jQuery.facebox.close();' value="Tutup">
			</td>
		</tr>
	</table>
</div>
<?php echo form_close();?>
<script>
	function Validasi(){
		var a = document.frmyudisium;
		if(a.notranskrip.value == false){
			alert('No Transkrip Masih Kosong');
			a.notranskrip.focus();
			return false;
		}else if(a.noijazah.value == false){
			alert('No Ijazah Masih Kosong');
			a.noijazah.focus();
			return false;
		}else if(a.ipk.value == false){
			alert('IPK Masih Kosong');
			a.ipk.focus();
			return false;
		}else if(a.totalsks.value == false){
			alert('Total SKS Masih Kosong');
			a.totalsks.focus();
			return false;
		}else if(a.judulskripsi.value == false){
			alert('Judul Skripsi/TA Masih Kosong');
			a.judulskripsi.focus();
			return false;
		}else{
			jQuery.facebox.close();
		}
	}
</script>