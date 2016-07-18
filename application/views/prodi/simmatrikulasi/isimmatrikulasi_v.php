<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		stoploading();
		// load('prodi/simkrs/cari_matakuliah/','#txt_kodemk');
		// $("#txt_kodemk").focus().autocomplete();
		$('#txt_kodemk').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			autoFill: true,
			innerText: 'ketik kode',
			minimumSearchLength: 2
		});
		$("#txt_kodemk").val('<?php echo $this->session->userdata('sesi_kodemk'); ?>');
		$("#txt_kodemk").focus();
	});
	function searchFunction(str){
		load('prodi/simmatrikulasi/cari_matakuliah/'+str,'#nama_mk');
	}
</script>
<script language="javascript" type="text/javascript">
	function GetValueFromChild(myVal,myVal2){
		document.getElementById('id_dpa').value = myVal;
		document.getElementById('nama_dpa').value = myVal2;
	}
</script>
<div class="top-bar-adm">
	<div style="margin:5px -32px 0;float:right">
		<a href="javascript:void(0)" class='browse-button' onclick='show("prodi/simmatrikulasi/listview","#center-column")'>Browse</a>
	</div>
	<h1>Form Input Matrikulasi</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div>
<div class="select-bar"></div>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simmatrikulasi/detail_mahasiswa'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<td class="first right" width="120"><strong>NIM</strong></td>
			<td class="last">
				<input type="text" name="nim" value='<?php echo $this->session->userdata('sesi_krs_nim')?>' class="required" size="12"/>
				<input type="submit" value="ok" />
				<?php echo form_error('nim');?>
			</td>
			<td class='right'>Kelas</td>
			<td class='first'>
				<?php
					if($this->session->userdata('sesi_krs_kelas')=='2')
						echo 'Non Reguler';
					elseif($this->session->userdata('sesi_krs_kelas')=='1')
						echo 'Reguler';
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first right"><strong>Nama</strong></td>
			<td class="last"><?php echo $this->session->userdata('sesi_krs_nama');?></td>
			<td class='right'>Thn. Akademik</td><td class='first'>
				<?php echo thakademik($this->session->userdata('sesi_krs_thajaran_aktif'))?>
			</td>
		</tr>
		<tr>
			<td class="first right"><strong>PRODI</strong></td>
			<td class="last"><?php echo $this->session->userdata('sesi_krs_prodi')?></td>
			<td class='right'>Tahun Akademik</td><td class='first'><?php echo semester($this->session->userdata('sesi_krs_thajaran_aktif'))?></td>
		</tr>
		</tr>
	</table>
</div>&nbsp;
</form>
<?php
	echo '<div>';
		echo form_error('nilai').form_error('nama_mk');
	echo '</div>';
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simmatrikulasi/save'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form',	'type'=>'post'));
?>
	<input type='text' style='float:left;width: 100px' name='txt_kodemk' value='<?php echo $this->session->userdata('sesi_kodemk')?>' id='txt_kodemk'/>
	<input type='hidden' name='txt_sks' value='<?php echo $sks?>'/>
	<div id='nama_mk'><input type='text' name='nama_mk' readonly style='float:left' size='45'/></div>
	<div id='kode_mk' style='float:left'></div>
	&nbsp; &nbsp; Nilai <select name='nilai'>
		<option></option>
		<option value='A'>A</option>
		<option value='B'>B</option>
		<option value='C'>C</option>
		<option value='D'>D</option>
		<option value='E'>E</option>
	</select>
	<?php if($this->session->userdata('sesi_krs_nim')){ ?>
		<input type='submit' value='Simpan'/><br />
	<?php }else{ ?>
		<input type='submit' disabled value='Simpan'/><br />
	<?php } ?>
</form>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simkrs/simpan_tabel'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form', 'type'=>'post'));
?>
<div class='table' id='hasil'>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class='first' style='text-align:center'>No</th><th>Kode</th>
		<th>Nama Matakuliah (Yang diakui)</th>
		<th>SKS</th>
		<th>Nilai</th>
		<th class='last' style='text-align:center'> # </th>
	</tr>
	<?php
		$jumsks	= 0;
		$no		= 1;
		if($nim){
		foreach($detail_matrikulasi as $dm):
	?>
	<tr>
		<td><?php echo $no++.'.';?></td>
		<td><?php echo $dm->kodemk?></td>
		<td><div style='text-align:left'><?php echo $dm->namamk;?></div></td>
		<td><?php echo $dm->sks; ?></td>
		<td><?php echo $dm->nilai; ?></td>
		<td>
		<a href="javascript:void(0)" onclick='return tanya("<?php echo $dm->kodemk?>", "<?php echo $this->session->userdata('sesi_krs_nim')?>")'>
			<?php echo img('asset/images/design/hr.gif')?>
		</a>
		</td>
	</tr>
<?php $jumsks = $jumsks+$dm->sks; endforeach; ?>
	<tr class='bg'>
		<td colspan='3' style='text-align:right'><b>Total SKS Yang Diakui</b></td><td>
			<?php
				echo '<b>'.$jumsks.'</b>';
			?>
		</td><td colspan='2'></td>
	</tr>
	<?php } ?>
</table>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(tombolSubmit){
		document.getElementById(tombolSubmit).disabled = true;
		showloading();
	}
	function tanya(kodemk, nim){
		if(confirm('KONFIRMASI\nTekan OK untuk melanjutkan penghapusan data')){
			show("prodi/simmatrikulasi/delete/"+kodemk+"/<?php echo $this->session->userdata('sesi_krs_nim')?>","#center-column");
		}else{
			return false;
		}
	}
</script>