<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	/*$(document).ready(function() {
		$('#txt_namamk').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			autoFill: true,
			innerText: 'ketik nama matakuliah',
			minimumSearchLength: 2
		});
		$("#txt_namamk").val('</?php echo $this->session->userdata('sesi_namamk'); ?>');
		$("#txt_namamk").focus();
	});
	function searchFunction(str){
		load('admin/nilai/cari_matkul/'+str,'#result-namamk');
	}*/
	function submitChangeStatus(){
		var selected_status = $('select[name=cbthajaran]').val();
		load('admin/nilai/ubah_thajaran/'+selected_status,'#center-column');
	}
</script>
<style>#hasil{ border:1px solid silver; padding:5px; margin:5px; margin-left:0; }</style>
</script>
<div class="top-bar-adm">
	<h1>Input Nilai Matakuliah
		<!--<select name='cbthajaran' id='cbthajaran' onchange='submitChangeStatus()'>
			<option value='</?php echo $sesi_thajaran?>'></?php echo $sesi_thajaran?></option>
			<option </?php if($sesi_thajaran == '20111') echo 'selected'?> value='20111'>20111</option>
			<option </?php if($sesi_thajaran == '20112') echo 'selected'?> value='20102'>20102</option>
			<option value='20101'>20101</option>
			<option value='20092'>20092</option>
			<option value='20091'>20091</option>
		</select>-->
	</h1>
	<div class="breadcrumbs"><a href="#">Tahun Ajaran</a>
	<select name="cbthajaran" id="cbthajaran" onchange="submitChangeStatus()">
		<?php foreach($thajaran as $thajar){ ?>
		<option <?php if($this->session->userdata('sesi_cbthajarannilai') == $thajar->thajaran) echo 'selected';?> value="<?php echo $thajar->thajaran?>"><?php echo $thajar->thajaran?></option>
		<?php } ?>
		<!--<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20081') echo 'selected';?> value="20081">20081</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20082') echo 'selected';?> value="20082">20082</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20091') echo 'selected';?> value="20091">20091</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20092') echo 'selected';?> value="20092">20092</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20101') echo 'selected';?> value="20101">20101</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20102') echo 'selected';?> value="20102">20102</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20111') echo 'selected';?> value="20111">20111</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20112') echo 'selected';?> value="20112">20112</option>
		<option </?php if($this->session->userdata('sesi_cbthajarannilai') == '20121') echo 'selected';?> value="20121">20121</option>-->
	</select>
	</div>
</div><br />
<fieldset>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/nilai/cari_matkul'),
	'update'=>'#result-namamk',
	'name'=>'f1',
	'id'=>'nilai',
	'type'=>'post'));
?>
<legend>
	<input type="radio" name="matkul" value="kode"/>Kode Matakuliah &nbsp; |
	<input type="radio" checked name="matkul" value="nama"/>Nama Matakuliah
</legend>
<b>Masukkan Matakuliah </b><input type="text" id="txt_namamk" size="40" name="txt_namamk"/>
<input type="submit" value="Cari" onclick="return cek_kosong()" />
</form>
<div id="result-namamk"><p>Hasil Belum Ditampilkan, <b>Masukkan Kode Atau Nama Matakuliah</b></p></div>
</fieldset>
<script>
	function cek_kosong(){
		if(document.getElementById('txt_namamk').value == false){
			alert('PERINGATAN\nMatakuliah belum ditentukan!');
			document.getElementById('txt_namamk').focus();
			return false;
		}else{
			return true;
		}
	}
</script>