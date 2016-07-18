<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	$("#simruang").validate({
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
<div style=""><a href="javascript:void(0)" class='navi button' onclick='show("admin/simruang","#center-column")'> Browse</a></div>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simruang/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simruang',
	'type'=>'post'));
	foreach($detail_simruang as $dr):
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM UPDATE RUANGAN</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Ruangan</strong></td>
			<td class="last">
				<input type="text" name="nama" value="<?php echo $dr->nama?>" size="55"/>
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Lantai</strong></td>
			<td class="last">
				<input type="hidden" name="id_ruang" value="<?php echo $dr->id_ruang?>" />
				<input type="text" name="lantai" value="<?php echo $dr->lantai?>" size="1"/>
				<?php echo form_error('lantai');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nomor</strong></td>
			<td class="last">
				<input type="text" name="nomor" value="<?php echo $dr->nomor?>" size="5"/>
				<?php echo form_error('nomor');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kapasitas</strong></td>
			<td class="last">
				<input type="text" name="kapasitas" value="<?php echo $dr->kapasitas?>" size="3"/>
				<?php echo form_error('kapasitas');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jenis Ruang</strong></td>
			<td class="last">
				<select name="jenisruang">
					<option <?php if($dr->jenisruang == 'Teori') echo 'selected'; ?> value="Teori">Teori</option>
					<option <?php if($dr->jenisruang == 'Lab') echo 'selected'; ?> value="Lab">Lab</option>
					<option <?php if($dr->jenisruang == 'Serbaguna') echo 'selected'; ?> value="Serbaguna">Serbaguna</option>
				</select>
				<?php echo form_error('jenisruang');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Update','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/simruang","#center-column")'>
					<< Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php endforeach; echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>