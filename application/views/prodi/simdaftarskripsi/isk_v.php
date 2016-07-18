<div class="top-bar-adm">
	<a href="javascript:void(0)" style="margin-right:-32px" class='navi button' onclick='show("prodi/simdaftarskripsi/browse_sk","#center-column");'>Browse</a>
	<h2>Form Input SK</h2>
	<!--<div class="breadcrumbs"><a href="#">tes&nbsp;</a></div>-->
</div>
<div class="select-bar">
</div>
<?php
	echo $this->pquery->form_remote_tag(array('url'=>site_url('prodi/simdaftarskripsi/simpan'), 'update'=>'#center-column',
	'name'=>'f1', 'id'=>'simdaftarskripsi','type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT SK</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Jenis Pendaftaran</strong></td>
			<td class="last">
				<select name="jenisdaftar">
					<option value=""></option>
					<option value="KP">KP</option>
					<option value="TA">TA</option>
					<option value="Skripsi">Skripsi</option>
				</select>
				<?php echo '<br />'.form_error('jenisdaftar');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>No. SK</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nosk')?>" name="nosk" size="30"/>
				<?php echo '<br />'.form_error('nosk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tgl. SK</strong></td>
			<td class="last">
				<input type='text' name='tglsk' value='<?php echo $this->input->post('tglsk')?>' size='8'/>
				<input type='button' value='..' class='date' OnClick="displayDatePicker('tglsk', false, 'dmy', '-')"/>
				<?php echo '<br />'.form_error('tglsk');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Mahasiswa</strong></td>
			<td class="last">
				<a href="#" onclick='browse_mhs()'>Browse</a>
				<div id="browse_pengambil"></div>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan').form_reset('batal','Batal');?>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script>
	function browse_mhs(){
		var jns = $('select[name=jenisdaftar]').val();
		if(jns){
			load_into_box("prodi/simdaftarskripsi/browse_pendaftar/"+jns);
		}else{
			alert('KONFIRMASI\nPilih jenis pendaftaran terlebih dahulu');
		}
	}
</script>