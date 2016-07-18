<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		stoploading();
		$('#nimmhs').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			autoFill: true,
			innerText: '',
			minimumSearchLength: 4
		});
		/* $("#nimmhs").val('</?php echo $this->session->userdata('sesi_nimbiaya'); ?>'); */
		/* $("#nim").focus(); */
	});
	function getNamaOnBlur(){
		var str = document.getElementById("nimmhs").value;
		load('keuangan/keubiaya/namamhs_bynim/'+str,'#namamhs');
	}
	function searchFunction(str){
		load('keuangan/keubiaya/namamhs_bynim/'+str,'#namamhs');
	}
</script>
<script>
	function get_bythajaran(){
		var selected_thajaran = $('select[name=thajaran]').val();
		load('keuangan/nilai/change_thajarankhs/'+selected_thajaran,'#form-pembayaran');
	}
	function ChangeThajaran(){
		var selected_thajaran = $('select[name=thajaran]').val();
		load('keuangan/keubiaya/change_thajaran3/'+selected_thajaran,'#form-pembayaran');
	}
</script>
<div id="noprint">
<div class="top-bar-adm">
	<h1>Pembayaran</h1>
	<div class="breadcrumbs"><a href="#"><?php echo $title?></a></div>
</div>
<div class="select-bar">
	<?php
		echo $this->pquery->form_remote_tag(array(
		'url'=>site_url('keuangan/keubiaya/pilih_mahasiswa'), 'update'=>'#form-pembayaran', 'name'=>'cari', 'id'=>'maspegawai', 'type'=>'post'));
	?>
	<table width="100%">
		<tr>
			<td><b>NIM Mahasiswa</b></td>
			<td><input type="text" name="txtNim" onblur="return getNamaOnBlur()" id="nimmhs" size="12" /></td>
			<td style="width:20px;">&nbsp;</td>
			<td><!--<b>Tahun Ajaran</b>--></td>
			<td>
				<!--<select name="thajaran" style="width:60px;" onchange="ChangeThajaran()">
				</?php foreach($browse_thajaran as $bt):?>
					<option </?php if($thajaran == $bt->thajaran) echo 'selected'; ?> value="</?php echo $bt->thajaran?>"></?php echo $bt->thajaran?></option>
				</?php endforeach; ?>
				</select>-->
			</td>
			<td rowspan="2" valign="bottom" align="right"><input type="submit" value="OK" onclick="return go()" style="padding:8px;font-weight:bold;" /></td>
		</tr>
		<tr>
			<td><b>Nama</b></td><td><div id="namamhs"><input type="text" size="35" /></div></td>
			<td>&nbsp;</td>
			<td><b>Jenis</b></td>
			<td>
				<select name="jenis">
					<option value=""></option>
					<?php foreach($browse_jenis as $bj){ ?>
					<option value="<?php echo $bj->jenis?>"><?php echo $bj->jenis?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
	</table>
<?php echo form_close()?>
</div>
</div>
<div id="form-pembayaran"><center>
<h3 style="padding: 10px; margin: 10px; border: 1px dotted #ABABAB;">Masukkan NIM, tahun ajaran dan jenis untuk menginputkan setoran biaya</h3></center></div>
<script>
	function go(){
		if(document.getElementById('nimmhs').value == false){
			alert('PERINGATAN\nNIM masih kosong, Harap mengisi NIM terlebih dahulu');
			document.getElementById('nimmhs').focus();
			return false;
		}else{
			showloading();
		}
	}
</script>