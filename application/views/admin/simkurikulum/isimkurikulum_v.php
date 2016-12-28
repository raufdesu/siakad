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
});
function submitChangeKurikulum(){
	var selected_kurikulum = $('select[name=thkurikulum]').val();
	load('admin/simkurikulum/add/'+selected_kurikulum,'#center-column');
}

</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simkurikulum/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simkurikulum',
	'type'=>'post'));
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
				<input type="text" name="kodemk" value="<?php echo $this->input->post('kodemk')?>" size="15"/>
				<?php echo form_error('kodemk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Nama Matakuliah</strong></td>
			<td class="last">
				<input type="text" name="namamk" value="<?php echo $this->input->post('namamk')?>" size="35"/>
				<?php echo form_error('namamk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>PRODI</strong></td>
			<td class="last">
				<select name="kodeprodi">
					<option value=""></option>
				<?php foreach($browse_prodi as $bp):?>
					<option value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
				<?php endforeach; echo "</select>".form_error('kodeprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>SKS</strong></td>
			<td class="last">
				<input type="text" name="sks" size="1"/>
				<?php echo form_error('sks');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Teori/Praktek</strong></td>
			<td class="last">
				<input type="radio" name="teori_praktek" value="Teori"/>Teori
				<input type="radio" name="teori_praktek" value="Praktek"/>Praktek
				<input type="radio" name="teori_praktek" value="Teori Praktek"/>Teori Praktek
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Wajib/Pilihan</strong></td>
			<td class="last">
				<input type="radio" name="wajib_pilihan" value="Wajib"/>Wajib
				<input type="radio" name="wajib_pilihan" value="Pilihan"/>Pilihan
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Semester</strong></td>
			<td class="last">
				<input type="text" name="semester" size="1"/>
				<?php echo form_error('semester');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Inti/Institusional</strong></td>
			<td class="last">
				<input type="radio" name="inti" value="inti"/>Inti
				<input type="radio" name="inti" value="Institusional"/>Institusional
				<?php echo form_error('inti');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Sifat</strong></td>
			<td class="last">
				<select name="sifat">
					<option value=""></option>
					<option value="MKB">MKB</option>
					<option value="MKK">MKK</option>
					<option value="MPK">MPK</option>
					<option value="MPB">MPB</option>
					<option value="MBB">MBB</option>
					<option value="MPB">MKDU</option>
					<option value="MBB">MKDK</option>
				</select>
				<?php echo form_error('sifat');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Prasyarat</strong></td>
			<td class="last">
				<input type="text" name="prasyarat" size="10"/>
				<?php echo form_error('prasyarat');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Thn. Kurikulum</strong></td>
			<td class="last">
				<input type="text" name="thnkur" size="4"/>
				<?php echo form_error('thnkur');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/simkurikulum","#center-column")'>
					Batal &raquo; 
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>