<script>
function submitChangeThajaran(){
	var selected_thajaran = $('select[name=thajaran]').val();
	load('admin/simmktawar/change_thajaran/'+selected_thajaran,'#center-column');
}
function submitChangeProdi(){
	var selected_prodi = $('select[name=prodi]').val();
	load('admin/simmktawar/change_prodi/'+selected_prodi,'#center-column');
}
function submitChangeSemester(){
	var selected_semester = $('select[name=semester]').val();
	load('admin/simmktawar/change_semester/'+selected_semester,'#center-column');
}
function submitCariMatakuliah(){
	var teks_cari_mktawar = $('input:textbox').val()
	load('admin/simmktawar/cari_matakuliahtawar/'+teks_cari_mktawar,'#center-column');
}
</script>
<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<!--</?php $inner = "<div class='samar'> Masukkan kode matakuliah</div>"?>-->
<script type="text/javascript">
$(document).ready(function() {
	// load('admin/simmktawar/cari_matakuliah/','#txt_cari_mk');
	$('#txt_cari_mk').livesearch({
		searchCallback: searchFunction,
		queryDelay: 1000,
		innerText: '',
		minimumSearchLength: 4
	});
	$("#txt_cari_mk").val('<?php echo $this->session->userdata('sesicari_matakuliah')?>');
	$("#txt_cari_mk").focus();
});
function searchFunction(str){
	load('admin/simmktawar/cari_matakuliah/'+str,'#center-column');
}
</script>
<div class="top-bar-adm">
	<h1>Input Matakuliah Tawaran</h1>
	<select name="prodi" id="prodi" class="obj-right" OnChange="submitChangeProdi()">
		<option value=""> Pilih Prodi </option>
		<?php foreach($browse_prodi as $bp): ?>
		<option <?php if($this->session->userdata('sesi_prodi') == $bp->kodeprodi) echo 'selected';?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select><strong class="obj-right">Program Studi &nbsp;</strong>
</div>
<div class="select-bar">
</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simmktawar/save'), 'update'=>'#center-column', 'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
?>
<div class="left-box">
<b>Daftar Matakuliah Semester</b>
<select name="semester" id="semester" onchange="submitChangeSemester()">
	<!--<option </?php if($this->session->userdata('sesi_semester')=="") echo 'selected';?> value="">All</option>-->
	<option <?php if($this->session->userdata('sesi_semester') % 2 <> 0) echo 'selected';?> value="1">Gasal</option>
	<option <?php if($this->session->userdata('sesi_semester') % 2 == 0) echo 'selected';?> value="2">Genap</option>
</select>
<input type="text" size="41" id="txt_cari_mk" value='<?php echo $this->session->userdata('sesicari_matakuliah')?>' class="text-search">
<input type='button' class='search' onclick="" value='Cari'/>
<div id="user"></div>
<table cellspacing='0' cellpadding='0'>
	<tr>
		<th>#</th><th>Kode MK</th><th>Nama Matakuliah</th><th>Qu</th>
	</tr>
	<?php $i=1; foreach($browse_mk as $bm): $x = $i++; ?>
	<tr>
		<td><input type="checkbox" <?php if($this->input->post('matkul'.$x)) echo 'checked';?> value="<?php echo $bm->kodemk;?>" name="matkul<?php echo $x;?>"></td>
		<td><?php echo $bm->kodemk;?></td><td><?php echo $bm->nama_mk?></td><td><input type="text" value="<?php echo $this->input->post('kuota'.$x);?>" class="kuota" name="<?php echo 'kuota'.$x;?>"/></td>
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
<b>Daftar Matakuliah Tawaran Th Ajaran</b>
<select name='thajaran' id='thajaran' OnChange='submitChangeThajaran()'>
	<option value=''>Pilih</option>
	<?php foreach($browse_thn_ajaran as $btk):?>
	<option <?php if($this->session->userdata('sesi_thajaran') == $btk->thajaran) echo 'selected';?> value='<?php echo $btk->thajaran?>'><?php echo $btk->thajaran?></option>
	<?php endforeach; ?>
</select>
<input type="text" size="41" class="text-search" readonly name="txtCariMkTawar"><input type='button' onclick='submitCariMatakuliah()' class='search' value='Cari'/>
<table cellpadding='0' cellspacing='0'>
	<tr>
		<th>#</th><th>Kode MK</th><th>Nama Matakuliah</th><th>Qu</th>
	</tr>
	<?php foreach($browse_mktawar as $bm):?>
	<tr>
		<td>
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->kodemk;?>","<?php echo $bm->kodeprodi;?>")'><b>X</b></a>
		</td>
		<td><?php echo $bm->kodemk?></td><td><?php echo $bm->namamk?></td><td><?php echo $bm->kuota?>
	</tr>	
	<?php endforeach; ?>
</table>
	<a href="javascript:void(0)" class='navi' onclick='show("admin/simmktawar/listview","#center-column")'>Browse all</a>
<?php //echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(kodemk,kodeprodi){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simmktawar/delete/"+kodemk+"/"+kodeprodi,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>