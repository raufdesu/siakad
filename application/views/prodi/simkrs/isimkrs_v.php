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
		load('prodi/simkrs/cari_matakuliah/'+str,'#nama_mk');
	}
</script>
<script language="javascript" type="text/javascript">
	function GetValueFromChild(myVal,myVal2){
		document.getElementById('id_dpa').value = myVal;
		document.getElementById('nama_dpa').value = myVal2;
	}
</script>
<div class="top-bar-adm">
	<div style="margin:0px -32px 0px; float:right">
	<a href="javascript:void(0)" class='browse-button' onclick='show("prodi/simkrs/listview","#center-column")'> Browse</a>
	<?php if($this->session->userdata('sesi_krs_nim')){ ?>
	<a href="javascript:void(0)" class='print-button' onclick='show("prodi/simkrs/cetak_krs","#center-column")'> preview</a>
	<?php } ?>
	</div>
	<h1>Form Input KRS Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simkrs/detail_mahasiswa'),
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
				<input type="submit" onclick="showloading()" value="ok" />
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
				<?php echo $this->session->userdata('sesi_krs_thajaran_aktif')?>
				<!--<select name='thajaran'>
					</?php foreach($browse_thajaran as $bt):?>
					<option </?php if($this->session->userdata('sesi_krs_thajaran')==$bt->thajaran) echo 'selected'; ?> value='</?php echo $bt->thajaran?>'></?php echo $bt->thajaran?></option>
					</?php endforeach ?>
				</select>-->
			</td>
		</tr>
		<tr>
			<td class="first right"><strong>PRODI</strong></td>
			<td class="last"><?php echo $this->session->userdata('sesi_krs_prodi')?></td>
			<td class='right'>Jumlah SKS Maksimal</td><td class='first'><?php echo $this->session->userdata('sesi_jumgab')?> SKS</td>
		</tr>
		</tr>
	</table>
</div>&nbsp;
</form>
</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simkrs/simpan'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form',	'type'=>'post'));
?>
	--<input type='text' style='float:left;' name='txt_kodemk' value='<?php echo $this->session->userdata('sesi_kodemk')?>' id='txt_kodemk' size='8'/>
	<input type='hidden' name='txt_sks' value='<?php echo $sks?>'/>
	<div id='nama_mk'><input type='text' readonly style='float:left' size='45'/></div>
	<div id='kode_mk' style='float:left'></div>
	<input type='submit' value='Tambah'/><br />
	<input type='radio' name='status' checked value='baru'> Baru |
	<input type='radio' name='status' value='mengulang'> Mengulang
</form>-
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simkrs/simpan_tabel'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form', 'type'=>'post'));
?>
<div class='table' id='hasil'>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class='first' style='text-align:center'>No</th><th>Kode</th>
		<th>Nama Matakuliah</th><th>SKS</th><th class='last' style='text-align:center'>Del</th>
	</tr>
	<?php
	$no=1; $fix_sks=0;
	if($this->session->userdata('sesi_krs_nim')){
		foreach($browse_krs->result() as $bk){?>
		<tr class='bg'>
			<td><?php echo $no++?></td><td><?php echo $bk->kodemk?></td>
			<td class='first'><?php echo $bk->nama_mk?></td><td><?php echo $bk->sks?></td>
			<td>
				<a href="javascript:void(0)" onclick='show("prodi/simkrs/delete2/<?php echo $bk->idkrs.'/'.$bk->kodemk?>","#center-column")'>
					<?php echo img('asset/images/design/hr.gif')?>
				</a>
			</td>
		</tr>
	<?php
		$fix_sks = $fix_sks+$bk->sks;
		}
	}
	?>
	<?php $i=1; $jum = 0; foreach($this->cart->contents() as $items): ?>
	<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
	<tr>
		<td><?php echo $no++.'.';?></td>
		<td><?php echo $items['id']?></td>
		<td class='first'><?php
			echo $items['name'].
			'<div class="status">'.$items['options']['status'].'</div>';
		?></td>
		<td><?php echo $items['qty']; ?></td>
		<td>
		<a href="javascript:void(0)" onclick='show("prodi/simkrs/delete/<?php echo $items['rowid']?>","#center-column")'>
			<?php echo img('asset/images/design/hr.gif')?>
		</a>
		</td>
	</tr>
<?php
	$jum = $jum + $items['qty'];
	$i++;
?>
<?php endforeach; ?>
	<tr class='bg'>
		<td colspan='3' style='text-align:right'><b>Total SKS</b></td><td>
			<?php
				$jumfix = $fix_sks + $jum; echo '<b>'.$jumfix.'</b>';
			?>
		</td><td></td>
	</tr>
</table>
<div class='panel'>
	<strong>Nama Dosen Wali</strong>
		<input type='text' id='nama_dpa' name='nama_dpa' value='<?php echo $nama_dpa?>' readonly style='width: 330px'/>
		<input type='hidden' id='id_dpa' name='id_dpa'/>
	<?php
		{
			$atrpop = array(
				'width'=>520,'height'=>450,'screenx'=>200,'screeny'=>50				
			);
			echo anchor_popup('prodi/simkrs/browse_dpa','[..]',$atrpop);
		}
		if($this->cart->contents() == true){
	?>
			<input type='hidden' value='<?php echo $jumfix?>' name='jum_sks_input'/>
			<input type='submit' value='Simpan dan Lanjutkan' onclick='setujui("cmdSimpanKRS")' id='cmdSimpanKRS'/>
	<?php
		}else{
	?>
			<input type='submit' value='Simpan dan Lanjutkan' onclick='setujui()' id='cmdSimpanKRS'/>
	<?php
		}
	?>
</div>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		/*document.getElementById(tombolSubmit).disabled = true; */
		showloading();
	}
</script>