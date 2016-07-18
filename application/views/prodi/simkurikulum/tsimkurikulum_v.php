<head>
	<title>Daftar Matakuliah dan Kurikulum</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){ showloading(); }
		function submitChangeKurikulum(){
			var selected_kurikulum = $('select[name=thkurikulum]').val();
			load('prodi/simkurikulum/thn_kurikulum/'+selected_kurikulum,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi add' onclick='show("prodi/simkurikulum/add","#center-column")'>
		Tambah
	</a>
	<h1>Data Matakuliah Kurukulum</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simkurikulum/index'),
	'update'=>'#center-column','name'=>'th',
	'id'=>'maspegawai',	'type'=>'post'));
?>
	<select name='thkurikulum' class='obj-right' id='th_kurikulum' OnChange='submitChangeKurikulum()'>
		<option value=''>Semua Tahun</option>
		<?php foreach($browse_thn_kurikulum as $btk):?>
		<option <?php if($this->session->userdata('sesi_thnkurikulum') == $btk->thkurikulum) echo 'selected';?> value='<?php echo $btk->thkurikulum?>'><?php echo $btk->thkurikulum?></option>
		<?php endforeach; ?>
	</select>
<?php
	echo form_close();
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/simkurikulum/index'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_simkurikulum"))."</label>";
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
			<th>Kode MK</th>
			<th>Nama Matakuliah</th>
			<th>SKS</th>
			<th>PRODI</th>
			<th>Semester</th>
			<th style="width:48px" class="last">Kelola</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_simkurikulum as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->kodemk;?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("prodi/simkurikulum/detail/<?php echo $bm->kodemk?>","#center-column")'>
				<?php echo $bm->namamk; ?>
			</a>
		</td>
		<td class="center"><?php echo $bm->sks;?></td>
		<td class="first"><?php echo $bm->namaprodi;?></td>
		<td class="first">
			<?php
				if($bm->semester % 2 == 0){
					echo 'Genap';
				}elseif($bm->semester % 2 != 0){
					echo 'Gasal';
				}else{
					echo 'Gasal dan Genap';
				}
			?>
		</td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("prodi/simkurikulum/edit/<?php echo $bm->kodemk?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->kodemk;?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging).'</div><div class="total-rows"> Total : '.$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(kodemk){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("prodi/simkurikulum/delete/"+kodemk,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
