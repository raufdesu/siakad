<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi button' onclick='show("prodi/simdaftarskripsi/browse_sk","#center-column");'>Browse</a>
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
					<option value='<?php echo $sk->jenisdaftar?>'><?php echo $sk->jenisdaftar?></option>
					<!--</?php for($i=0;$i<count($jd);$i++){ ?>
					<option </?php if($sk->jenisdaftar==$jd[$i]) echo 'selected'?> value="</?php echo $jd[$i]?>"></?php echo $jd[$i]?></option>
					</?php } ?>-->
				</select>
				<?php echo '<br />'.form_error('jenisdaftar');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>No. SK</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $sk->nosk?>" name="nosk" size="30"/>
				<input type="hidden" value="<?php echo $sk->iddaftarskripsi?>" name="iddaftarskripsi" />
				<?php echo '<br />'.form_error('nosk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tgl. SK</strong></td>
			<td class="last">
				<input type='text' name='tglsk' value='<?php echo tgl_indo($sk->tglsk)?>' size='8'/>
				<input type='button' value='..' class='date' OnClick="displayDatePicker('tglsk', false, 'dmy', '-')"/>
				<?php echo '<br />'.form_error('tglsk');?>
			</td>
		</tr>
		<tr>
			<td class="first" width="190"><strong>Mahasiswa</strong></td>
			<td class="last">
				<a href="#" onclick='browse_mhs("<?php echo force_segment($sk->nosk)?>")'>Browse</a>
				<div id="browse_pengambil">
					<?php
						$tmp = explode(',', $pengambil);
						$n = count($tmp);
						for($i=0;$i<$n;$i++){
							echo '<div class="mini-list">'.$tmp[$i].'-'.$this->auth->get_namamhsbynim($tmp[$i]).'<div>';
						}
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan')?>
				<input type="button" onclick='show("prodi/simdaftarskripsi/browse_sk", "#center-column")' value='Batal'/>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script>
	function browse_mhs(nosk){
		var jns = $('select[name=jenisdaftar]').val();
		if(jns){
			load_into_box("prodi/simdaftarskripsi/browse_pendaftar/"+jns+"/"+nosk);
		}else{
			alert('KONFIRMASI\nPilih jenis pendaftaran terlebih dahulu');
		}
	}
</script>