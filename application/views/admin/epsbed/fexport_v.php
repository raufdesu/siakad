<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#txt_thajar').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			autoFill: true,
			innerText: '<?php echo $tahun?>',
			minimumSearchLength: 4
		});
		$("#txt_thajar").val('<?php echo $tahun?>');
		$('select[name=semester]').val('<?php echo $semester?>');
		$("#semester").focus();
	});
	function searchFunction(str){
		var selected_semester = str+$('select[name=semester]').val();
		load('admin/epsbed/changethajaran/'+selected_semester);
	}
	function submitChangeSemester(){
		var input_tahun = $("#txt_thajar").val();
		var selected_semester = $('select[name=semester]').val();
		load('admin/epsbed/changethajaran/'+input_tahun+selected_semester,'#detail-mhs');
	}
</script>
<div class="top-bar-adm">
	<h1><?php echo $title?></h1>
<div style="float:right">
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simtranskrip/cari_mhs'), 'update'=>'#detail-mhs', 'name'=>'cari', 'id'=>'maspegawai',	'type'=>'post'));
?>
	<b>Tahun Ajaran</b>
	<input type="text" id="txt_thajar" maxlength="4" name="thajaran" size="5" />
	<select name="semester" id="semester" onchange="submitChangeSemester()">
		<option selected value="1">Gasal</option>
		<option value="2">Genap</option>
	</select>
</form>
</div>
	<div class="breadcrumbs"><a href="#">Export Data Simak Ke Format PDPT/Epsbed</a></div>
</div>
<div class="table">
	<div class='webnail'>
	<a href="<?php echo base_url().'index.php/admin/epsbed/export_mhs';?>" target="_blank">
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/siswa.png' title='Data KRS'/>
		<b>Export MSMHS</b><br />
		Export Pendataan Master Mahasiswa
	</a>
	</div>
	<div class='webnail'>
	<!--<a href="</?php echo base_url().'index.php/admin/epsbed/export_kurikulum/';?>" target="_blank">-->
	<a href="javascript:void()" onclick='alert("KONFIRMASI\nUnder Construction")'>
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/kurikulum.png' title='Data KRS'/>
		<b>Export TBKMK</b><br />
		Export Pendataan Tabel Kurikulum
	</a>
	</div>
	<div class='webnail'>
	<a href="<?php echo base_url().'index.php/admin/epsbed/export_krs';?>" >
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/krs.png' title='Data KRS'/>
		<b>Export TRKRS - OK</b><br />
		Export data KRS kedalam format PDPT
	</a>
	</div>
	<div class='webnail'>
	<!--<a href="</?php echo base_url().'index.php/admin/epsbed/export_kuliahmhs';?>" >-->
	<a href="javascript:void(0)" onclick='alert("KONFIRMASI\nUnder Construction")' >
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/aktifitas.png' title='Data KRS'/>
		<b>Export TRAKM</b><br />
		Transaksi Aktifitas Kuliah Mahasiswa
	</a>
	</div>
	<div class='webnail'>
	<a href="<?php echo base_url().'index.php/admin/epsbed/export_nilai/';?>">
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/nilai.png' title='Data KRS'/>
		<b>Export TRNLM - OK</b><br />
		Transaksi Nilai Semester Mahasiswa
	</a>
	</div>
	<div class='webnail'>
	<!--<a href="javascript:void(0)" onclick='show("admin/simaktifsemester/akumulasi","#center-column")'>-->
	<a href="javascript:void(0)" onclick='alert("KONFIRMASI\nUnder Construction")'>
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/wisuda.png' title='Status Mahasiswa'/>
		<b>Export TRLSM</b><br />
		Transaksi Lulus, Cuti, Non Aktif, Keluar, DO
	</a>
	</div>
	<div class='webnail'>
	<!--<a href="javascript:void(0)" onclick='show("admin/simaktifsemester/akumulasi","#center-column")'>-->
	<a href="javascript:void(0)" onclick='alert("KONFIRMASI\nUnder Construction")'>
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/nilaipindahan.png' title='Data KRS'/>
		<b>Export TRNLP </b><br />
		Transaksi Nilai Mahasiswa Pindahan
	</a>
	</div>
	<div class='webnail'>
	<!--<a href="javascript:void(0)" onclick='show("admin/simaktifsemester/akumulasi","#center-column")'>-->
	<a href="javascript:void(0)" onclick='alert("KONFIRMASI\nUnder Construction")'>
		<img alt='Welcome' src='<?php echo base_url()?>asset/images/design/dosen.png' title='Data KRS'/>
		<b>Export TRAKD </b><br />
		Transaksi Aktifitas Mengajar Dosen
	</a>
	</div>
</div>