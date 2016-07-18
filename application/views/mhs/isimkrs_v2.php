<head>
<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
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
		showloading();
		load('mhs/simkrs/cari_matakuliah/'+str,'#nama_mk');
		stoploading();
	}
</script>
<script language="javascript" type="text/javascript">
	function GetValueFromChild(myVal,myVal2){
		document.getElementById('id_dpa').value = myVal;
		document.getElementById('nama_dpa').value = myVal2;
	}
</script>
</head>
<div style='float:right;'><?php echo anchor_popup('mhs/simmktawar/download','Download Matakuliah Tawaran',array('class'=>'download-button'));?></div>
<div class="top-bar-adm">
	<h2>Form Input KRS Mahasiswa</h2>
	<!--<div class="breadcrumbs"><a href="#">tes&nbsp;</a></div>-->
</div>
<div class="select-bar">
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/simkrs/detail_mahasiswa'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<div style="text-align:left;">
	<table class="" cellpadding="0" cellspacing="0">
		<tr>
			<td class="right"><strong>NIM</strong></td>
			<td class="last" width='350'>: <?php echo $this->session->userdata('sesi_krs_nim')?></td>
			<td class='right'><strong>Kelas</strong></td>
			<td class='first'>:
				<?php
					if($this->session->userdata('sesi_krs_kelas')=='2')
						echo 'Malam';
					elseif($this->session->userdata('sesi_krs_kelas')=='1')
						echo 'Reguler';
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first right"><strong>Nama</strong></td>
			<td class="last">: <?php echo $this->session->userdata('sesi_krs_nama');?></td>
			<td class='right'><strong>Thn. Akademik</strong></td><td class='first'>:
				<?php echo $this->session->userdata('sesi_krs_thajaran_aktif')?>
			</td>
		</tr>
		<tr>
			<td class="first right"><strong>Jurusan</strong></td>
			<td class="last">: <?php echo $this->session->userdata('sesi_krs_prodi')?></td>
			<td class='right'><strong>Jumlah SKS</strong></td><td class='first'>: <?php echo $this->session->userdata('sesi_jumgab')?> SKS</td>
		</tr>
		</tr>
	</table>
</div>
</form>
</div>
<?php
if($sudah_krs){
?>
	<div style="text-align:center;border:1px solid red;padding:10px;margin:10px;">
		<a href="javascript:void(0)" onclick='show("mhs/simkrs/cetak_krs","#center-column")'
			style="background:silver;width:130px;display:block;padding:5px;margin:5px auto;font-weight:bold;">Print Preview KRS</a>
	</div>
<?php
}else{
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/simkrs/simpan'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form', 'type'=>'post'));
?>
	<input type='text' style='float:left;' name='txt_kodemk' value='<?php echo $this->session->userdata('sesi_kodemk')?>' id='txt_kodemk' size='8'/>
	<input type='hidden' name='txt_sks' value='<?php echo $sks?>'/>
	<div id='nama_mk'><input type='text' readonly style='float:left' size='45'/></div>
	<div id='kode_mk' style='float:left'></div>
	<input type='submit' value='Tambah'/><br />
	<input type='radio' name='status' checked value='baru'> Baru |
	<input type='radio' name='status' value='mengulang'> Mengulang
</form>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('mhs/simkrs/simpan_tabel'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form', 'type'=>'post'));
?>
<div class='table' id='hasil'>
<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class='first' style='text-align:center'>No</th><th>Kode</th>
		<th>Nama Matakuliah</th><th>SKS</th><th class='last' style='text-align:center'>Del</th>
	</tr>
	
<?php $i=1; $jum = 0; $no=1; foreach($this->cart->contents() as $items): ?>
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
		<a href="javascript:void(0)" onclick='show("mhs/simkrs/delete/<?php echo $items['rowid']?>","#center-column")'>
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
		<td colspan='3' style='text-align:right'><b>Total SKS</b></td><td><?php echo '<b>'.$jum.'</b>';?></td><td></td>
	</tr>
</table>
<div class='panel'>
	<strong> &nbsp; Nama DPA</strong>
		<input type='text' id='nama_dpa' name='nama_dpa' value='<?php echo $nama_dpa?>' readonly size='42'/>
		<input type='hidden' value='<?php echo $id_dpa?>' id='id_dpa' name='id_dpa'/>
	<?php
		if($nama_dpa == false){
			$atrpop = array(
				'width'=>650,'height'=>450,'screenx'=>200,'screeny'=>50				
			);
			echo anchor_popup('mhs/simkrs/browse_dpa','[..]',$atrpop);
		}
		if($this->cart->contents() == true){
	?>
			<input type='hidden' value='<?php echo $jum?>' name='jum_sks_input'/>
			<input type='submit' value='Simpan dan Lanjutkan' onclick='setujui()' id='cmdSimpanKRS'/>
	<?php
		}else{
			echo '<input type="button" disabled value="Simpan dan Lanjutkan"/>';
		}
	?>
</div>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		/*document.getElementById(tombolSubmit).disabled = true;*/
		showloading();
	}
</script>
<?php } ?>