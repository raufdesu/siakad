<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
		// load('admin/simkrs/cari_matakuliah/','#txt_kodemk');
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
		load('admin/simkrs/cari_matakuliah/'+str,'#nama_mk');
	}
</script>
<script language="javascript" type="text/javascript">
	function GetValueFromChild(myVal,myVal2){
		document.getElementById('id_dpa').value = myVal;
		document.getElementById('nama_dpa').value = myVal2;
	}
</script>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi browse' onclick='show("admin/simkrs/listview","#center-column")'>
		<?php echo img('design').'&nbsp;Browse'?>
	</a>
	<?php if($this->session->userdata('sesi_krs_nim')){ ?>
	<!--<div style="margin-top:0px;float:right"></?php echo anchor('admin/simkrs/cetak_krs','Print preview','class="print-button"');?></div>-->
	<?php } ?>
	<h1>Detail KRS Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simkrs/detail_mahasiswa'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<td class="first right" width="120"><strong>NIM</strong></td>
			<td class="last"><?php echo $this->session->userdata('sesi_krs_nim')?></td>
			<td class='right'>Kelas</td>
			<td class='first'>
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
			<td class="last"><?php echo $this->session->userdata('sesi_krs_nama');?></td>
			<td class='right'>Thn. Akademik</td><td class='first'>
				<?php echo $this->session->userdata('sesi_krs_thajaran_aktif')?>
			</td>
		</tr>
		<tr>
			<td class="first right"><strong>Jurusan</strong></td>
			<td class="last"><?php echo $this->session->userdata('sesi_krs_prodi')?></td>
			<td class='right'>Jumlah SKS</td><td class='first'><?php echo $this->session->userdata('sesi_jumgab')?> SKS</td>
		</tr>
		</tr>
	</table>
</div>&nbsp;
</form>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simkrs/simpan_tabel'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form', 'type'=>'post'));
?>
<div class='table' id='hasil'>
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class='first' style='text-align:center'>No</th><th>Kode</th>
		<th>Nama Matakuliah</th><th class='last'>SKS</th>
	</tr>
	<?php
	$no=1; $fix_sks=0;
	if($this->session->userdata('sesi_krs_nim')){
		foreach($browse_krs->result() as $bk){?>
		<tr class='bg'>
			<td><?php echo $no++?></td><td><?php echo $bk->kodemk?></td>
			<td class='first'><?php echo $bk->nama_mk?></td><td><?php echo $bk->sks?></td>
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
		</td>
	</tr>
</table>
<div class='panel'>
	<strong> &nbsp; Nama DPA : </strong><?php echo $nama_dpa?></div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(tombolSubmit){
		document.getElementById(tombolSubmit).disabled = true;
		showloading();
	}
</script>