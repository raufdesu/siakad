<script type="text/javascript">
$(document).ready(function() {
	stoploading();
	$("#maspegawai").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
	<script language='javascript' type='text/javascript'>
	function load(page,div)
	{
		var site = "<?php echo site_url();?>";
		$.ajax({
			url: site+"/"+page,
			success: function(response){
				$(div).html(response);
			},
		dataType:"html"
		});
		return false;
	}
	function tampilkan_kabupten()
	{
		var selected_propinsi = $('select[name=propinsi]').val();
		load('admin/masmahasiswa/tampilkan_kabupaten/'+selected_propinsi,'#kabupaten');
	}
	</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/masmahasiswa/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'maspegawai',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="12" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT DATA MAHASISWA</th>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Identitas Diri Mahasiswa</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIM</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nim')?>" name="nim" class="required" size="8"/>
				<?php echo form_error('nim');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Nama Mahasiswa</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nama')?>" name="nama" class="required" size="35"/>
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jenis Kelamin</strong></td>
			<td class="last">
				<input type="radio" name="jeniskelamin" <?php if($this->input->post('jeniskelamin')=='L') echo 'checked'?> class="required" value="L"/>Laki-laki
				<input type="radio" name="jeniskelamin" <?php if($this->input->post('jeniskelamin')=='P') echo 'checked'?> class="required" value="P"/>Perempuan
				<?php echo form_error('jeniskelamin');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tempat/Tgl. Lahir</strong></td>
			<td class="last">
				<input type="text" name="tempatlahir" value="<?php echo $this->input->post('tempatlahir')?>" size="20"/>/
				<input type="text" name="tgllahir" value="<?php echo $this->input->post('tgllahir')?>" class="required" size="8"/>dd-mm-yyyy
				<?php echo form_error('tempatlahir');?>
				<?php echo form_error('tgllahir');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Agama</strong></td>
			<td class="last">
				<select name="agama">
					<option value="Islam">Islam</option>
					<option value="Kristen">Kristen</option>
					<option value="Katolik">Katolik</option>
					<option value="Hindu">Hindu</option>
					<option value="Budha">Budha</option>
					<option value="Lainnya">Lainnya</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Identitas Akademik Mahasiswa</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>PRODI</strong></td>
			<td class="last">
				<select name="kodeprodi">
					<option value=""></option>
					<?php foreach($browse_prodi as $bp):?>
					<option <?php if($this->input->post('kodeprodi')==$bp->kodeprodi) echo 'selected';?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi.' ('.$bp->jenjang.')';?></option>
					<?php endforeach; ?>
				</select>
				<?php echo form_error('kodeprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kelas/Shift</strong></td>
			<td class="last">
				<input type="radio" <?php if($this->input->post('kelas')=='1') echo 'checked'?> name="kelas" value="1"/> Kelas Pagi
				<input type="radio" <?php if($this->input->post('kelas')=='2') echo 'checked'?> name="kelas" value="2"/> Kelas Sore
				<?php echo form_error('kelas');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Angkatan</strong></td>
			<td class="last">
				<input type="text" name="angkatan" value="<?php echo $this->input->post('angkatan')?>" size="3"/>
				<?php echo form_error('angkatan');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Masuk</strong></td>
			<td class="last">
				<input type="radio" <?php if($this->input->post('statusmasuk')=='Baru') echo 'checked'?> name="statusmasuk" value="Baru"/> Baru
				<input type="radio" <?php if($this->input->post('statusmasuk')=='Pindahan') echo 'checked'?> name="statusmasuk" value="Pindahan"/> Pindahan
				<?php echo form_error('statusmasuk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Masuk</strong></td>
			<td class="last">
				<input type="text" name="tglmasuk" value="<?php if($this->input->post('tglmasuk')){ echo $this->input->post('tglmasuk'); }else{ echo date('d-m-Y'); } ?>" size="8"/>
				<?php echo form_error('tglmasuk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Akademik</strong></td>
			<td class="last">
				<select name="statusakademik">
					<option value="Belum Lulus">Belum Lulus</option>
					<!--<option value="Lulus">Lulus</option>
					<option value="Keluar">Keluar</option>-->
				</select>
				<?php echo form_error('statusakademik');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Paket KRS</strong></td>
			<td class="last">
				<select name="statuspaket">
					<option value="non paket">Non Paket</option>
					<option value="paket">Paket</option>
				</select>
				<?php echo form_error('statusakademik');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Alamat Mahasiswa</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat Asal</strong></td>
			<td class="last">
				<input type="text" name="alamatasal" value="<?php echo $this->input->post('alamatasal')?>" size="50"/>
				<?php echo form_error('alamatasal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Propinsi</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('propinsi',$propinsi,'idpropinsi','namapropinsi','onchange="tampilkan_kabupten()"');?>
				<?php echo form_error('idpropinsi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kabupaten</strong></td>
			<td class="last">
				<span id='kabupaten'></span>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kode POS</strong></td>
			<td class="last">
				<input type="text" name="kodepos" value="<?php echo $this->input->post('kodepos')?>" size="5"/>
				<?php echo form_error('kodepos');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon Mahasiswa</strong></td>
			<td class="last">
				<input type="text" name="notelpmhs" value="<?php echo $this->input->post('notelpmhs')?>" size="15"/>
				<?php echo form_error('notelpmhs');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Email</strong></td>
			<td class="last">
				<input type="text" name="email" value="<?php echo $this->input->post('email')?>" size="20"/>
				<?php echo form_error('email');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat Sekarang</strong></td>
			<td class="last">
				<input type="text" name="alamatsekarang" value="<?php echo $this->input->post('alamatsekarang')?>" size="50"/>
				<?php echo form_error('alamatsekarang');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Data Orang Tua / Wali</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Orang Tua</strong></td>
			<td class="last">
				<input type="text" name="namaortu" value="<?php echo $this->input->post('namaortu')?>" size="35"/>
				<?php echo form_error('namaortu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat Orang Tua</strong></td>
			<td class="last">
				<input type="text" name="alamatortu" value="<?php echo $this->input->post('alamatortu')?>" size="50"/>
				<?php echo form_error('alamatortu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon Orang Tua</strong></td>
			<td class="last">
				<input type="text" name="notelportu" value="<?php echo $this->input->post('notelportu')?>" size="15"/>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Data Sekolah Asal</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Sekolah Asal</strong></td>
			<td class="last">
				<input type="text" name="asalsma" value="<?php echo $this->input->post('asalsma')?>" size="35"/>
				<?php echo form_error('asalsma');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat SMA</strong></td>
			<td class="last">
				<input type="text" name="alamatsma" value="<?php echo $this->input->post('alamatsma')?>" size="50"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kode POS SMA</strong></td>
			<td class="last">
				<input type="text" name="kodepossma" value="<?php echo $this->input->post('kodepossma')?>" size="5"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jurusan di SMA</strong></td>
			<td class="last">
				<input type="text" name="jurusansma" value="<?php echo $this->input->post('jurusansma')?>" size="20"/>
				<?php echo form_error('jurusansma');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Thn. Lulus</strong></td>
			<td class="last">
				<input type="text" name="thlulus" value="<?php echo $this->input->post('thlulus')?>" size="4"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Asal Perguruan Tinggi</strong></td>
			<td class="last">
				<input type="text" name="asalpt" value="<?php echo $this->input->post('asalpt')?>" size="40"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>PRODI Asal</strong></td>
			<td class="last">
				<input type="text" name="prodiasal" value="<?php echo $this->input->post('prodiasal')?>" size="20"/>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan');?>
				<a href="javascript:void(0)" onclick='show("admin/masmahasiswa","#center-column")'>
					&laquo; Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>