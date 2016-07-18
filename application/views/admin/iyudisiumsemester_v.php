<head>
<style>
	#small-box{
		padding:10px;border:1px solid #ababab;margin:5px;
		width:2px;height:2px;float:left;
	}
	.legend{
		background-color:#efefef;clear:both;height:57px;margin-top:10px;border:1px solid #ababab;padding:5px;
	}
	.legend legend{
		padding:3px 8px 3px 8px; border:1px solid #ababab; text-align:right;
	}
</style>
<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<?php $inner = "<div class='samar'></div>"?>
<!--</?php $inner = "<div class='samar'> Masukkan kode matakuliah</div>"?>-->
<script type="text/javascript">
	function tanyahapus(kodemk){
		if(confirm('KONFIRMASI\nTekan "OK" untuk melanjutkan penghapusan data') == false){
			return false;
		}else{
			show("admin/simtranskrip/delete/"+kodemk,"#detail-mhs");
			return true;
		}
	}
</script>
<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	// load('admin/simmktawar/cari_matakuliah/','#txt_cari_mk');
	$('#txt_cari_mk').livesearch({
		searchCallback: searchFunction,
		queryDelay: 1000,
		innerText: <?php echo $inner?>,
		minimumSearchLength: 4
	});
	$("#txt_cari_mk").val('<?php echo $this->session->userdata('sesicari_matakuliah')?>');
	$("#txt_cari_mk").focus();
});
</script>
<script language='javascript'>
	var checkflag = "false";
	function check(field) {
	  if (checkflag == "false") {
		for (i = 0; i < field.length; i++) {
		  field[i].checked = true;
		}
		checkflag = "true";
		return "Uncheck All";
	  } else {
		for (i = 0; i < field.length; i++) {
		  field[i].checked = false;
		}
		checkflag = "false";
		return "Check All";
	  }
	}
</script>
</head>
<div class="select-bar">
<table width="100%">
<tr>
	<td width='30'>NIM</td><td width='80'>: <?php echo $nim?></td>
	<td width="100">&nbsp;</td><td width='30'>PRODI</td><td width='80'>:
	<?php echo $prodi; ?>
	</td>
</tr>
<tr>
	<td width='30'>Nama</td><td width='80'>: <?php echo $nama?></td>
	<td width="100">&nbsp;</td><td width='30'>Kelas</td><td width='80'>: <?php echo $kelas?></td>
</tr>
</table>
</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simtranskrip/save'), 'update'=>'#detail-mhs', 'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
?>
<div class="left-box">
<b>Daftar Matakuliah Yang Diambil</b>
<input type="text" size="41" readonly id="txt_cari_mk" value='<?php echo $this->session->userdata('sesicari_matakuliah')?>' class="text-search">
<input type='button' class='search' onclick="" value='Cari'/>
<div id="user"></div>
<table cellspacing='0' cellpadding='0'>
	<tr>
		<th><input type="checkbox" value="Check All" onClick="this.value=check(this.form.matkul)"></th>
		<th>Kode MK</th><th>Nama Matakuliah</th><th>Nilai</th>
	</tr>
	<?php $i=1; foreach($browse_ambilmk->result() as $bm): /*if($bm->nilaihuruf and $bm->nilaihuruf != 'E'){ */ $x = $i++;
		$id			= '';
		$rb			= '';
		$checked	= '';
		if($bm->status == 'mengulang'){
			$rb = 'repeat-block';
		}
		if($bm->nilaihuruf == false){
			$checked = 'disabled';
		}else{
			$id = 'matkul';
		}
		if(preg_match("/\b".$bm->kodemk."\b/i", $arkodemk)) {
			$rb = 'inserted';
		}
	?>
	<tr class='<?php echo $checked?> <?php echo $rb?>'>
		<td>
			<input <?php echo $checked?> id="<?php echo $id?>" type="checkbox" <?php if($this->input->post('matkul'.$x)) echo 'checked';?> value="<?php echo $bm->kodemk;?>" name="matkul<?php echo $x;?>">
		</td>
		<td><?php echo $bm->kodemk;?></td><td><?php echo $bm->nama_mk?></td>
		<td><input type="hidden" value="<?php echo $bm->nilaihuruf?>" name="nilai<?php echo $x?>"/><?php echo $bm->nilaihuruf;?></td>
	</tr>	
	<?php endforeach; ?>
	<input type="hidden" name="total_mk" value="<?php echo $i;?>"/>
</table>
</div>
<div class="center-box">
	<?php echo form_submit("cmdCari",">>");?>
</div>
</form>
<div class="right-box">
<b>Transkrip Nilai</b>
<input type="text" size="41" class="text-search" readonly name="txtCariMkTawar"><input type='button' onclick='submitCariMatakuliah()' class='search' value='Cari'/>
<table cellpadding='0' cellspacing='0'>
	<tr>
		<th>#</th><th>Kode MK</th><th>Nama Matakuliah</th><th>Nilai</th>
	</tr>
	<?php foreach($browse_transkrip as $bt):?>
	<tr>
		<td>
			<a href="javascript:void(0)" onclick='return tanyahapus("<?php echo $bt->kodemk?>")'><b>X</b></a>
		</td>
		<td><?php echo $bt->kodemk?></td><td><?php echo $bt->namamk?></td><td><?php echo $bt->nilai?>
	</tr>	
	<?php endforeach; ?>
</table>
	<a href="javascript:void(0)" class='navi' onclick='show("admin/simtranskrip/index_browse/<?php echo $nim;?>","#detail-mhs")'>Browse all</a>
<?php //echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<p style="clear:both;height:1px"></p>
<fieldset class="legend">
<legend>Keterangan</legend>
	<div id="small-box" style="background-color:#000;"></div>
	<p style="margin:10px;float:left;margin-left:0px;">Belum diinputkan</p>
	<div id="small-box" style="background-color:orange;"></div>
	<p style="margin:10px;float:left;margin-left:0px;">Mengulang</p>
	<div id="small-box" style="background-color:green;"></div>
	<p style="margin:10px;margin-left:0px;">Sudah diinputkan</p>
</legend>