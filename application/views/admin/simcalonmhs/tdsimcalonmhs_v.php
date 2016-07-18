<head>
<script>
	$(document).ready(function(){
		stoploading();
		document.getElementById('nim').focus();
	})
	function cek(){
		if(document.getElementById('nim').value == false){
			alert('Masukkan NIM');
			document.getElementById('nim').focus();
			return false;
		}else{
			jQuery.facebox.close();
		}
	}
	function BiayaDaftar(){
		var selected_namabiaya = $('select[name=namabiaya]').val();
		load('admin/simcalonmhs/biaya_daftar/'+selected_namabiaya,'#biayadaftar');
	}
	function cekbayarkosong(){
		if(document.getElementById('namabiaya').value == false){
			alert('Nama Biaya Kosong');
			document.getElementById('namabiaya').focus();
			return false;
		}else if(document.getElementById('biaya').value == false){
			alert('Besar Biaya Kosong');
			document.getElementById('biaya').focus();
			return false;
		}
	}
</script>
</head>
<?php
	$que = mysql_query($sql);
	while($dm = mysql_fetch_assoc($que)):
?>
<div class="table">
	<fieldset class="area" style="margin-top: 10px">
	<legend><b>DAFTAR ULANG DAN PEMBERIAN NIM</b></legend>
	<div id="kelola-area">
	<div id="input">
	<?php echo $this->pquery->form_remote_tag(array(
		'url'=>site_url('admin/simcalonmhs/save_biayadaftar'), 'update'=>'#hasil', 'name'=>'f1',
		'id'=>'pendaftaran', 'type'=>'post'));
		echo form_hidden('nodaft', $dm['no_daftar']);
	?>
		<select name="namabiaya" id="namabiaya" onchange="BiayaDaftar()">
			<option value="">Pilih Biaya</option>
			<?php foreach($browse_namabiaya as $bn):?>
			<option value="<?php echo $bn->idbiayadaftar?>"><?php echo $bn->namabiaya?></option>
			<?php endforeach ?>
		</select>
		<span id="biayadaftar" style="clear:both">
			Rp.<input type="text" style="width:100px;text-align:right" readonly value="<?php echo $this->input->post('biaya')?>" />,00
			&nbsp; <input type="button" value="Bayar" />
		</span>
	</form>
	</div>
	<div id="hasil">
		<?php $this->load->view('admin/simcalonmhs/tbiayaby_nodaft_v')?>
	</div>
	</div>
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">DETAIL DATA CALON MAHASISWA</th>
		</tr>
		<tr>
			<td class="first" width="160"><strong>No. Pendaftaran</strong></td>
			<td class="last">: <?php echo $dm['no_daftar']?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Mahasiswa</strong></td>
			<td class="last">: <?php echo $dm['nama'];?></td>
		</tr>
		<tr>
			<td class="first"><strong>PRODI Pilihan</strong></td>
			<td class="last">: <?php echo $dm['pil_jurusan']?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Gelombang</strong></td>
			<td class="last">: <?php echo $dm['gelombang'];?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Agama</strong></td>
			<td class="last">: <?php echo $dm['agama'];?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Masuk</strong></td>
			<td class="last">: <?php echo $dm['status_baru']; ?>
			</td>
		</tr>
		<tr>
			<td class="first"><strong>Alamat Asal</strong></td>
			<td class="last">: <?php echo $dm['alamat_rumah']; ?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon</strong></td>
			<td class="last">: <?php echo $dm['no_telepon'];?></td>
		</tr>
		<tr>
			<td class="first"><strong>Asal SMA</strong></td>
			<td class="last">: <?php echo $dm['nama_sekolah'];?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jurusan</strong></td>
			<td class="last">: <?php echo $dm['jurusan'];?></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tahun Lulus SMA</strong></td>
			<td class="last">: <?php echo $dm['thn_lulus'];?></td>
		</tr>
	</table>
<?php endwhile;?>
<div align="right"><hr />
	<a href="javascript:void(0)" class='button navi' onclick='jQuery.facebox.close()'>Tutup</a>
</div>
	</fieldset>
</div>
