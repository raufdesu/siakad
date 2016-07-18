<script type="text/javascript">
$(document).ready(function() {
	stoploading();
})
</script>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2"><?php echo $title?></th>
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
			<?php echo $this->pquery->form_remote_tag(array( 'url'=>site_url('admin/importold/krs'),
				'update'=>'#center-column','name'=>'f1','id'=>'importold','type'=>'post'));
				if($cek_krsmhs) $disabled = '';
				else $disabled = 'disabled = false';
			?>
				<div align='center' style='margin:10px'>
					<input type='submit' name='cmdImportKRS' <?php echo $disabled;?> value='Import Data KRS SIMAK Lama Ke SIMAK Baru' onclick='setujui("cmdKRS")' id='cmdKRS'/>
				</div>
			</form>
			</td>
		</tr>
		<?php if($cek_mastermk == true) $kondisi = ''; else $kondisi = 'disabled'; ?>
		<tr>
			<td class="last" colspan='2'>
			<?php echo $this->pquery->form_remote_tag(array( 'url'=>site_url('admin/importold/matakuliah'),
				'update'=>'#center-column','name'=>'f1','id'=>'importold','type'=>'post')); ?>
				<div align='center' style='margin:10px'>
					<input type='submit' name='cmdImportMatkul' <?php echo $kondisi?> value='Import Data Matakuliah SIMAK Lama Ke SIMAK Baru' onclick='setujui("cmdMatkul")' id='cmdMatkul'/>
				</div>
			</form>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<script language="javascript">
	function setujui(tombolSubmit){
		document.getElementById(tombolSubmit).disabled = true;
		showloading();
	}
</script>