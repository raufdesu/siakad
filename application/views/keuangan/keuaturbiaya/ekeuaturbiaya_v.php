<head>
	<script>
		$(document).ready(function(){ stoploading(); });
	</script>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('keuangan/keuaturbiaya/save'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
?>
<div style="float: right; height: 25px">
	<a href="javascript:void(0)" onclick="show('keuangan/keuaturbiaya', '#center-column')" class="button">Browse</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM PERUBAHAN PENENTUAN BIAYA
			</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Biaya</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $biaya->namabiaya?>" name="namabiaya" size="50" />
				<input type="hidden" value="<?php echo $biaya->idaturbiaya?>" name="idaturbiaya" />
				<?php echo form_error('namabiaya');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Program Studi</strong></td>
			<td class="last">
				<select name='kodeprodi' style="width:290px !important;">
					<option <?php if($biaya->kodeprodi == '') echo 'selected'; ?> value="">Pilih PRODI</option>
					<?php foreach($browse_prodi as $bp):?>
					<option <?php if($biaya->kodeprodi == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
					<?php endforeach; ?>
				</select>
				<?php echo form_error('kodeprodi')?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Angkatan</strong></td>
			<td class="last">
				<input type="text" maxlength="4" value="<?php echo $biaya->angkatan?>" name="angkatan" size="3" />
				<?php echo form_error('angkatan');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Gelombang</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $biaya->gelombang?>" name="gelombang" size="1" />
				<?php echo form_error('gelombang');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Jenis</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $biaya->jenis?>" name="jenis" size="30" />
				<?php echo form_error('jenis');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Besar Biaya</strong></td>
			<td class="last">
				Rp. <input style="text-align:right" type="text" value="<?php echo rupiah($biaya->jumbiaya, 1)?>" name="jumbiaya" size="10" />,00
				<?php echo form_error('jumbiaya');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Kategori</strong></td>
			<td class="last">
				<select name="kategori">
					<option value="">Pilih Kategori</option>
					<?php for($i=0;$i<count($kategori);$i++){ ?>
					<option <?php if($biaya->kategori==$kategori[$i]) echo 'selected'?> value="<?php echo $kategori[$i]?>"><?php echo $kategori[$i]?></option>
					<?php } ?>
				</select>
				<?php echo form_error('persemester');?>
			</td>
		</tr>		
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Update','OnClick="setujui()"');?>
				<input type="reset" value="Reset" />
				<!--<a href="javascript:void(0)" onclick='show("keuangan/simprodi","#center-column")'>
					<< Batal
				</a>-->
			</td>
		</tr>
	</table>
	<center><?php echo form_error('petugas');?></center>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
	}
</script>