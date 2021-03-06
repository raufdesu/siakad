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
		load('admin/simdosenampu/cari_matakuliah/'+str,'#hasil');
	}
</script>
<style>#hasil{ border:1px solid silver; padding:5px; margin:5px; margin-left:0; }</style>
</script>
<div class="top-bar-adm">
	<h1>Dosen dan Asisten Dosen Pengampu Matakuliah</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">Dosen Ampu Matakuliah Tahun Ajaran <?php echo $this->session->userdata('sesi_thajaran')?></th>
		</tr>
		<?php foreach($detail_dosen->result() as $d):?>
		<tr class="bg">
			<td class="first" width="172"><strong>NPP</strong></td>
			<td class="last"><?php echo $npp = $d->npp?></td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Nama Dosen</strong></td>
			<td class="last"><?php echo $d->nama?></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>
<?php
if($this->session->userdata('sesi_status') == 'admin'):
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simdosenampu/save'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
?>
	<input type="text" id="txt_kodemk" name="txt_kodemk"/>
	<input type="hidden" value="<?php echo $npp?>"/>
	<div id="hasil"><i>Hasil Pencarian</i></div>
	</form>
<?php
endif;
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first">No.</th><th>Kd. Matkul</th><th>Nama Matakuliah</th>
			<th>SKS</th><th>Ruang</th><th>Kelas</th><th>BAP</th><th>Mhs</th><th width="15">#</th>
		</tr>
		<?php $no=1; foreach($detail_simdosenampu->result() as $ds):?>
		<tr class="bg">
			<td><?php echo $no++?></td>
			<td><?php echo $ds->kodemk?></td>
			<td class="first"><?php echo $ds->namamk?></td>
			<td><?php echo $ds->sks?></td>
			<td><?php echo $ds->ruang?></td>
			<td><?php echo $ds->kelas?></td>
			<td>
				<?php $jumb = $this->simbap_m->count_bap($ds->id_kelas_dosen); if($jumb != 0){ ?>
					<a href='javascript:void(0)' onclick='show("admin/simbap/input/<?php echo $ds->id_kelas_dosen?>","#center-column")'><?php echo $jumb?></a>
				<?php }else{ ?>
					<a href='javascript:void(0)' onclick='show("admin/simbap/input/<?php echo $ds->id_kelas_dosen?>","#center-column")'>0</a>
				<?php } ?>
				<!--<a href='javascript:void(0)' onclick='load("admin/simbap/input/</?php echo $ds->id_kelas_dosen?>","#center-column")'>Input</a>-->
			</td>
			<td>
			<?php if($this->session->userdata('sesi_status') == 'admin'){ ?>
				<a href="javascript:void(0)" onclick="show('admin/nilai/index_inputbydosen/<?php echo $ds->id_kelas_dosen?>','#center-column');">
					<?php echo img('asset/images/design/login-icon.gif')?>
				</a>
			<?php } ?>
			</td>
			<td class="last">
			<?php if($this->session->userdata('sesi_status') == 'operator'){ ?>
				<a href="javascript:void(0)" title="Kelola BAP" onclick="show('admin/simbap/input/<?php echo $ds->id_kelas_dosen?>','#center-column');">
					<?php echo img('asset/images/design/detail_add.png')?>
				</a>
			<?php } ?>
			<?php if($this->session->userdata('sesi_status') == 'admin'): ?>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $ds->id_kelas_dosen?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
			<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
  <p>&nbsp;</p>
</div>
<script language="javascript">
	function tanya(id){
		if(confirm('KONFIRMASI\nTekan OK untuk melanjutkan penghapusan data') == false){
			return false;
		}
		show("admin/simdosenampu/delete/"+id,"#center-column");
	}
</script>