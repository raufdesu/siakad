<head>
<title>Pengelolaan Kelas Mahasiswa</title>
<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<?php
	$i = $this->uri->segment(4,0)+1; $n=$i+10;
?><script>
	$(document).ready(function(){ stoploading(); });
	function setujui(){ showloading(); }
	function submitChangemktawar(){
		var selected_mktawar = $('select[name=thmktawar]').val();
		load('admin/simmktawar/thn_mktawar/'+selected_mktawar,'#center-column');
	}
	function submitChangeThajaran2(){
		showloading();
		var selected_thajaran = $('select[name=thajaran]').val();
		load('admin/simmktawar/change_thajaran2/'+selected_thajaran,'#center-column');
	}
</script>
</head>
<div class="top-bar-adm">
	<!--<a href="javascript:void(0)" class='navi add' onclick='show("admin/simmktawar/add","#center-column")'>
		</?php echo 'Tambah'?>
	</a>-->
	<h1><?php echo $title;?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
	<select name='thajaran' class='obj-right' id='thajaran' OnChange='submitChangeThajaran2()'>
		<option value=''>Pilih</option>
		<?php foreach($browse_thn_ajaran as $btk):?>
		<option <?php if($this->session->userdata('sesi_thajaran') == $btk->thajaran) echo 'selected';?> value='<?php echo $btk->thajaran?>'><?php echo $btk->thajaran?></option>
		<?php endforeach; ?>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simmktawar/presensi'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'simmktawar', 'type'=>'post'));
	$arr_option = array(
		''=>'Pilih kategori',
		'kodemk' => 'Kode matakuliah',
		'namamk' => 'Nama matakuliah',
		'namadosen' => 'Nama dosen'
	);
	echo form_dropdown('cbKategori', $arr_option);
	echo form_input("txtCari",$this->session->userdata("sesicari_matakuliahtawar"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();
?>
</div>
<div class="left-box2">
<div class="head-box">
	<b>Daftar Matakuliah</b>
</div>
<table cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<th>Kode MK</th><th>Matakuliah</th><th>Pengampu</th>
	</tr>
	<?php foreach($browse_mkdosenampu->result() as $bm):?>
	<tr>
		<td><?php echo $bm->kodemk?></td>
		<td>
			<a href="javascript:void(0)" onclick='show("admin/simmktawar/mhsambilmk/<?php echo $bm->id_kelas_dosen?>/awal","#mhs-ambilmk")'>
			<?php
				echo $bm->namamk;
			?>
			</a><?php echo '<small> ('.$bm->kelas.')</small>';?>
		</td>
		<td>
			<?php echo $bm->namadosen?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<div class="right-box2" id="mhs-ambilmk">
<div class="head-box">
	<b>Daftar Mahasiswa</b>
</div>
<table>
	<tr><th>Belum Ada Matakuliah Yang Dipilih</th></tr>
</table>
</div>
<div style="clear:both;"></div>
<div class="bottom-navi">
	<?php echo anchor('admin/simmktawar/cetak_coverpresensi', 'Preview Cover', array("class"=>"button","target"=>"_blank"));?>
	<?php echo anchor('admin/simmktawar/cetakpresensi', 'Preview Presensi', array( "class"=>"button","target"=>"_blank"));?>
	<?php echo anchor('admin/simmktawar/export', 'Excel', array("class"=>"button"));?>
</div>