<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	});
</script>
<div class="top-bar-adm">
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div>
<div class="select-bar">
	<?php
		echo $this->pquery->form_remote_tag(array(
		'url'=>site_url('dosen/simdosenwali/index'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'masmahasiswa', 'type'=>'post'));
		echo "<label>".form_input("txtCari",$this->session->userdata("sesi_mhs"),'size=30')."</label>";
		echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
		echo form_close();
	?>
</div>
<div class="table">
<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first" width="5">No.</th>
		<th>NIM</th>
		<th>Nama Mahasiswa</th>
		<th>Prodi</th>
		<th>Angkatan</th>
		<th class="last">Aksi</th>
	</tr>
<?php $i=$no+1; foreach($browse_mhs->result() as $bm): ?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("dosen/simdosenwali/detail_mhs/<?php echo $bm->nim?>","#center-column")' title="Detail Mahasiswa">
				<?php echo $bm->namamhs;?></a>
			</td>
		<td>
		<?php
			if(substr($bm->nim,0,2) == '12'){
				echo 'TI';
			}elseif(substr($bm->nim,0,2) == '11'){
				echo 'SI';
			}elseif(substr($bm->nim,0,2) == '23'){
				echo 'MI';
			}elseif(substr($bm->nim,0,2) == '24'){
				echo 'TK';
			}elseif(substr($bm->nim,0,2) == '25'){
				echo 'KA';
			}
		?>
		</td>
		<td class="last"><?php echo $bm->angkatan;?></td>
		<td class="last">
			<a href="javascript:void(0)" onclick='show("dosen/simkrs/detail_mahasiswa/<?php echo $bm->nim?>","#center-column")' title="KRS">
				<?php echo img('asset/images/design/detail.gif')?>
			<a href="javascript:void(0)" onclick='show("dosen/simambilmk/pilih_khs/<?php echo $bm->nim?>","#center-column")' title="KHS">
				<?php echo img('asset/images/design/detail.gif')?>
			<a href="javascript:void(0)" onclick='show("dosen/simambilmk/pilih_transkrip/<?php echo $bm->nim?>","#center-column")' title="Transkrip Nilai">
				<?php echo img('asset/images/design/detail2.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>