<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		// load('admin/simmktawar/cari_matakuliah/','#txt_cari_mk');
		$('#txtcari').livesearch({
			searchCallback: searchFunction,
			queryDelay: 500,
			innerText: '',
			minimumSearchLength: 3
		});
		$("#txtcari").val('<?php echo $this->session->userdata('cari_inputmhspa')?>');
		$("#txtcari").focus();
	});
	function searchFunction(str){
		load('admin/simdosenwali/cari_inputmhspa/'+str,'#popup-column');
	}
	function dipilih(){
		load('admin/simdosenwali/add/','#popup-column');
		jQuery.facebox.close();
	}
</script>
<div id="popup-column" style="min-width:500px !important">
<div class="top-bar-adm2">
	<strong class="obj-right"><a href='javascript:void(0)' onclick='jQuery.facebox.close()'>X&nbsp;</a></strong></br>
	<h3 style="margin:0px 0px 2px 5px;">Penentuan Penasehat Akademik</h3>
</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simdosenwali/save'), 'update'=>'#center-column', 'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo form_hidden('npp', $npp);
?>
<div class="select-bar" style="margin:0 5px -2px 5px;">
	<b>Nama Mahasiswa</b>
	<input type="text" style="width:205px;" id="txtcari" onfocus="this.selectionStart = this.selectionEnd = this.value.length;" value='<?php echo $this->session->userdata('cari_inputmhspa')?>' class="text-search">
	<input type='button' class='search' onclick="" value='Cari'/>
</div>
<div class="full-box" style="margin:5px;max-height:400px;overflow:auto;width:500px">
<!--<div id="user"></div>-->
<table cellspacing='0' class='listing' cellpadding='0' style="width:100%">
	<tr>
		<th>No.</th><th>NIM</th><th>Nama Mahasiswa</th><th>Angkatan</th><th>#</th>
	</tr>
	<?php
		$i=1;
		foreach($mahasiswa_nodpa->result() as $bm){
			$x = $i++;
			if($x % 2 == 0){
				$bg = '';
			}else{
				$bg = 'bg';
			}

	?>
	<tr class="<?php echo $bg?>">
		<td><?php echo $x;?></td>
		<td><?php echo $bm->nim;?></td>
		<td class='first'><?php echo $bm->nama?></td>
		<td><?php echo $bm->angkatan?></td>
		<td><input type="checkbox" <?php if($this->input->post('nim'.$x)) echo 'checked';?> value="<?php echo $bm->nim;?>" name="nim<?php echo $x;?>"></td>
	</tr>	
	<?php } ?>
	<input type="hidden" name="n" value="<?php echo $i;?>"/>
</table>
</div>
<input type="submit" value="Tambah" style="float:right;margin:5px;" onclick='dipilih()' name="cmdCari" />
<!--<input type="submit" value="Tambah" style="float:right;margin:5px;" onclick="disetujui()" name="cmdCari" />-->
</form>
</div>