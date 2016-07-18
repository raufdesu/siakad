<div style="margin:10px">
	<?php echo $this->pquery->form_remote_tag(array(
		'url'=>site_url('admin/simcalonmhs/save_spp'), 'update'=>'#center-column', 'name'=>'f1',
		'id'=>'simcalonmhs', 'type'=>'post'));
		echo form_hidden('nodaftar', $nodaftar);
	?>
	<h2 style="border-bottom:1px solid #ababab;width:380px;">Form Input SPP (mahasiswa baru)</h2>
	<div style="float:right" >
		<b>Tahun Ajaran</b>
		<input type="text" id="thajaran" name="thajaran" size="3" maxlength="5" value="<?php echo $this->session->userdata('sesi_newthajaran')?>" />
	</div>
	<table>
	<tr>
		<td><b>NIM</b></td><td>: <input type="text" name="nim" readonly size="10" value="<?php echo $nim?>" /></td>
	</tr>
	<tr>
		<td><b>Tagihan</b></td>
		<td>: Rp.<input type="text" id="tagihan" value="<?php echo $tagihan?>" name="tagihan" size="8" readonly />,00</td>
	</tr>
	<tr>
		<td><b>Jumlah Bayar</b></td>
		<td>: Rp.<input type="text" name="jumbayar" id="jumbayar" size="8" />,00</td>
	</tr>
	<tr>
		<td><b>Keterangan</b></td>
		<td>: <input type="text" name="keterangan" size="30" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><hr />
			<input type="submit" value="Simpan" onclick="return valid()" />
			<a href="javascript:void(0)" style="text-decoration:underline" onclick='jQuery.facebox.close()'>Tutup</a>
		</td>
	</tr>
	</table>
	</form>
</div>
<script>
	function valid(){
		if(document.getElementById('thajaran').value == false){
			alert('KONFIRMASI\nTahun Ajaran Harus Diisi');
			document.getElementById('thajaran').focus();
			return false;
		}else if(document.getElementById('tagihan').value == false){
			alert('KONFIRMASI\nTagihan Masih Kosong. Harap Tentukan Tagihan Pada Tahun Angkatan\ndan PRODI Yang Bersangkutan');
			document.getElementById('tagihan').focus();
			return false;
		}else if(document.getElementById('jumbayar').value == false){
			alert('KONFIRMASI\nJumlah Pembayaran Harus Diisi');
			document.getElementById('jumbayar').focus();
			return false;
		}else{
			jQuery.facebox.close();
			return true;
		}
	}
</script>