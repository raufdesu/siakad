<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){ stoploading(); });
	$(document).ready(function() {
		// load('admin/simmktawar/cari_matakuliah/','#txt_cari_mk');
		$('#txt_thajar').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			innerText: '',
			minimumSearchLength: 4
		});
		$("#txt_thajar").val('<?php echo $sesi_thajar?>');
		$("#txt_thajar").focus();
	});
	function searchFunction(str){
		var selected_semester = $('select[name=semester]').val();
		load('admin/simtranskrip/change_thajaran/'+str+selected_semester,'#detail-mhs');
	}
	function submitChangeSemester(){
		var input_tahun = $("#txt_thajar").val();
		var selected_semester = $('select[name=semester]').val();
		load('admin/simtranskrip/change_semester/'+input_tahun+selected_semester,'#detail-mhs');
	}
	function ChangeProdi(){
		showloading();
		var selected_prodi = $('select[name=prodi]').val();
		load('admin/simtranskrip/change_prodi/'+selected_prodi,'#center-column');
	}
</script>
<script type='text/javascript' src='<?php echo base_url()?>asset/plugin/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/css/jquery.autocomplete.css" />
<script type="text/javascript">
var cities = [
	<?php echo $records;?>
];
	$().ready(function() {
		/*function log(event, data, formatted) {
			$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
		}*/
		$("#nim").autocomplete(cities, {
			matchContains: true,
			minChars: 0
		});
		
		/* UNTUK HASIL DIBAWAHNYA */
		/*$(":text, textarea").result(log).next().click(function() {
			$(this).prev().search();
		});*/
		/* SELESAI */
	});
</script>
<div class="top-bar-adm">
	<div style="float:right;margin-right:-32px">
	<b>Pilih PRODI&nbsp;</b>
	<select name='prodi' style="width:175px !important;" class='obj-right' onchange='ChangeProdi()'>
		<option <?php if($this->session->userdata('sesi_transprodi') == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($this->session->userdata('sesi_transprodi') == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>
	</div>
	<h1>Yudisium Semester</h1>
</div>
	<div class="select-bar">
		<div class='obj-right'>
			<b>Tahun Ajaran</b>
			<input type="text" id="txt_thajar" maxlength="4" name="thajaran" size="2" value="<?php echo $sesi_thajar?>"/>
			<select name="semester" style="width:65px;" id="semester" onchange="submitChangeSemester()">
				<option <?php if($sesi_semester == "1") echo 'selected';?> value="1">Gasal</option>
				<option <?php if($sesi_semester == "2") echo 'selected';?> value="2">Genap</option>
			</select>
		</div>
		<div>
			<?php
				echo $this->pquery->form_remote_tag(array(
				'url'=>site_url('admin/simtranskrip/cari_mhs'), 'update'=>'#detail-mhs', 'name'=>'cari', 'id'=>'maspegawai',	'type'=>'post'));
			?>
			<b>NIM Mahasiswa</b>
			<input type="text" id="nim" size="9" name="txtNimMhs" />
			<input type="submit" value="OK" />
			</form>
		</div>
	</div>
<div id="detail-mhs">
<center>
	<h3 style="padding: 10px; margin: 10px; border: 1px dotted #ABABAB;">Masukkan NIM Untuk Melakukan Pengelolaan Yudisium</h3>
</center>
</div>