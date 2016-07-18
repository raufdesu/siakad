<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simaktifsemester/save_move'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simaktifsemester',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM EXPORT MAHASISWA TO AKTIF SEMESTER</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190" colspan='2'>
				<div class='notice'>
					Proses ini akan membutuhkan waktu yang cukup lama. Untuk itu, harap bersabar menunggu proses selesai. Pada saat
					proses berlangsung, harap jangan melakukan aktifitas apapun dalam sistem ini. Terimakasih
				</div>
			</td>
		</tr>
		<tr>
			<td class="last" colspan='2'>
				<div align='center' style='margin:10px'>
					<input type='submit' name='cmdSimpan' value='Export Data Mahasiswa To Aktif Semester' id='cmdsimpan'/>
				</div>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		document.getElementById('cmdsimpan').disabled = true;
		showloading();
	}
</script>