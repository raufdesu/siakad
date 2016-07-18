<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	$("#simkurikulum").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simkurikulum/update'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simkurikulum',
	'type'=>'post'));
	foreach($detail_simkurikulum as $dk):
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT DATA KURIKULUM</th>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Kode Matakuliah</strong></td>
			<td class="last">
				<input type="text" name="kodemk" value="<?php echo $dk->kodemk;?>" class="required" size="15"/>
				<input type="hidden" name="kodemk2" value="<?php echo $dk->kodemk;?>"/>
				<?php echo form_error('kodemk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Nama Matakuliah</strong></td>
			<td class="last">
				<input type="text" name="namamk" value="<?php echo $dk->namamk?>" size="35"/>
				<?php echo form_error('namamk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>PRODI</strong></td>
			<td class="last">
				<select name="kodeprodi">
				<?php foreach($browse_prodi as $bp):?>
					<option value="<?php echo $bp->kodeprodi;?>" <?php if($bp->kodeprodi != $this->session->userdata('sesi_prodi')) echo 'disabled'?> <?php if($dk->kodeprodi == $bp->kodeprodi) echo ' selected '?>><?php echo $bp->namaprodi?></option>
				<?php endforeach; echo "</select>".form_error('kodeprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>SKS</strong></td>
			<td class="last">
				<input type="text" name="sks" value="<?php echo $dk->sks;?>" size="2"/>
				<?php echo form_error('sks');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Teori/Praktek</strong></td>
			<td class="last">
				<input type="radio" name="teori_praktek" <?php if($dk->teori_praktek == 'Teori') echo 'checked';?> value="Teori"/>Teori
				<input type="radio" name="teori_praktek" <?php if($dk->teori_praktek == 'Praktek') echo 'checked';?> value="Praktek"/>Praktek
				<input type="radio" name="teori_praktek" <?php if($dk->teori_praktek == 'Teori Praktek') echo 'checked';?> value="Teori Praktek"/>Teori Praktek
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Wajib/Pilihan</strong></td>
			<td class="last">
				<input type="radio" name="wajib_pilihan" <?php if($dk->wajib_pilihan == 'Wajib') echo 'checked';?> value="Wajib"/>Wajib
				<input type="radio" name="wajib_pilihan" <?php if($dk->wajib_pilihan == 'Pilihan') echo 'checked';?> value="Pilihan"/>Pilihan
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Semester</strong></td>
			<td class="last">
				<input type="text" name="semester" value="<?php echo $dk->semester;?>" size="1"/>
				<?php echo form_error('semester');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Inti/Institusional</strong></td>
			<td class="last">
				<input type="radio" name="inti" <?php if($dk->inti == 'Inti') echo 'checked';?> value="Inti"/>Inti
				<input type="radio" name="inti" <?php if($dk->inti == 'Institusional') echo 'checked';?> value="Institusional"/>Institusional
				<?php echo form_error('inti');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Sifat</strong></td>
			<td class="last">
				<select name="sifat">
					<option value=""></option>
					<option value="MKB" <?php if($dk->sifat == 'MKB') echo 'selected'?>>MKB</option>
					<option value="MKK" <?php if($dk->sifat == 'MKK') echo 'selected'?>>MKK</option>
					<option value="MPK" <?php if($dk->sifat == 'MPK') echo 'selected'?>>MPK</option>
					<option value="MPB" <?php if($dk->sifat == 'MPB') echo 'selected'?>>MPB</option>
					<option value="MBB" <?php if($dk->sifat == 'MBB') echo 'selected'?>>MBB</option>
				</select>
				<?php echo form_error('sifat');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Prasyarat</strong></td>
			<td class="last">
				<input type="text" name="prasyarat" value="<?php echo $dk->prasyarat;?>" size="10"/>
				<?php echo form_error('prasyarat');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Thn. Kurikulum</strong></td>
			<td class="last">
				<input type="text" name="thnkur" value="<?php echo $dk->thnkur;?>" size="4"/>
				<?php echo form_error('thnkur');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("prodi/simkurikulum","#center-column")'>&laquo; Batal</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php endforeach; echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
	}
</script>