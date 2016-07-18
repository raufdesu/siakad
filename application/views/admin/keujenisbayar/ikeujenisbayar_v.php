<head>
	<script>
		$(document).ready(function(){ stoploading(); });
	</script>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/keujenisbayar/save'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
?>
<div style="float: right; height: 25px">
	<a href="javascript:void(0)" onclick="show('admin/keujenisbayar', '#center-column')" class="button">Browse</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM PENENTUAN PEMBAYARAN
			</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Jenis Pembayaran</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('jenisbayar')?>" name="jenisbayar" size="25" />
				<?php echo form_error('jenisbayar');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Program Studi</strong></td>
			<td class="last">
				<select name='kodeprodi' style="width:290px !important;">
					<option <?php if($this->input->post('kodeprodi') == '') echo 'selected'; ?> value="">Pilih PRODI</option>
					<?php foreach($browse_prodi as $bp):?>
					<option <?php if($this->input->post('kodeprodi') == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
					<?php endforeach; ?>
				</select>
				<?php echo form_error('kodeprodi')?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Angkatan</strong></td>
			<td class="last">
				<input type="text" maxlength="4" value="<?php echo $this->input->post('angkatan')?>" name="angkatan" size="2" />
				<?php echo form_error('angkatan');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Gelombang</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('gelombang')?>" name="gelombang" size="1" />
				<?php echo form_error('gelombang');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Total Biaya</strong></td>
			<td class="last">
				Rp. <input style="text-align:right" type="text" value="<?php echo $this->input->post('totalbiaya')?>" name="totalbiaya" size="10" />,00
				<?php echo form_error('totalbiaya');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<input type="reset" value="Reset" />
				<!--<a href="javascript:void(0)" onclick='show("admin/simprodi","#center-column")'>
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