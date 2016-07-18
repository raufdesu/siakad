<head>
<title>Daftar Matakuliah Yang Ditawarkan</title>
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
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/simmktawar/add","#center-column")'> Tambah</a>
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
	'url'=>site_url('admin/simmktawar/cari_matakuliahtawar'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'simmktawar', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("sesicari_matakuliahtawar"))."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();
?>
</div>
<table class='listing form' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<th>No.</th><th>Kode MK</th><th>Nama Matakuliah Tawaran</th><th>Qu</th><th width='15'>#</th>
	</tr>
	<?php foreach($browse_mktawar as $bm):?>
	<tr>
		<td><?php echo $x = $i++?></td>
		<td><?php echo $bm->kodemk?></td>
		<td class='first'>
		<a href="javascript:void(0)" onclick='show("admin/simmktawar/pengambilmk/<?php echo $bm->kodemk?>/<?php echo $bm->namamk?>","#center-column")'>
			<?php echo $bm->namamk?>
			<!--(</?php echo $this->simmktawar_m->count_pengambil($bm->kodemk)?>)-->
		</a>
		</td>
		<td>
		<?php echo $this->pquery->form_remote_tag(array(
			'url'=>site_url('admin/simmktawar/update_quota'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'simmktawar', 'type'=>'post'));
		?>
			<input type="hidden" value="<?php echo $this->uri->segment(4,0)?>" name="segment">
			<input type="hidden" value="<?php echo $bm->kodemk?>" name="kode" id="kode<?php echo $x?>">
			<input type="text" value="<?php echo $this->simmktawar_m->get_kuota($bm->kodemk)?>" id="quota<?php echo $x?>" name="quota" size="1"/>
			<input type="submit" value="update" onclick='showloading();'/>
		<?php echo form_close()?>
		<td class="first">
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->kodemk?>","<?php echo $bm->kodeprodi?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
<script language="javascript">
	function tanya(kodemk,kodeprodi){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simmktawar/delete2/"+kodemk+"/"+kodeprodi,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
