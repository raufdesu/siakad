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
	foreach($detail_masmahasiswa as $dm):
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM UPDATE DATA MAHASISWA</th>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Identitas Diri Mahasiswa</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIM</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->nim;?>" name="nim" class="required" size="12"/>
				<input type="hidden" value="<?php echo $dm->nim;?>" name="nim2"/>
				<?php echo form_error('nim');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIK</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->nik;?>" name="nik" class="required" size="35"/>
				<?php echo form_error('nik');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>Nama Mahasiswa</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $dm->nama;?>" name="nama" class="required" size="35"/>
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jenis Kelamin</strong></td>
			<td class="last">
				<input type="radio" <?php if($dm->jeniskelamin=='L') echo 'checked';?> name="jeniskelamin" class="required" value="L"/>Laki-laki
				<input type="radio" <?php if($dm->jeniskelamin=='P') echo 'checked';?> name="jeniskelamin" class="required" value="P"/>Perempuan
				<?php echo form_error('jeniskelamin');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tempat/Tgl. Lahir</strong></td>
			<td class="last">
				<input type="text" name="tempatlahir" value="<?php echo $dm->tempatlahir;?>" size="20"/>/
				<input type='text' name='tgllahir' value='<?php echo tgl_indo($dm->tgllahir)?>' size='8'/>
				<input type='button' value='..' class='date' OnClick="displayDatePicker('tgllahir', false, 'dmy', '-')"/>
				<?php echo form_error('tempatlahir');?>
				<?php echo form_error('tgllahir');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Agama</strong></td>
			<td class="last">
				<select name="agama">
					<option <?php if($dm->agama='Islam') echo 'selected';?> value="<?php echo $dm->agama?>" >Islam</option>
					<option value="Kristen,2">Kristen</option>
					<option value="Katolik,3">Katolik</option>
					<option value="Hindu,4">Hindu</option>
					<option value="Budha,5">Budha</option>
					<option value="Konghuchu,6">Konghuchu</option>
					<option value="Lainnya,99">Lainnya</option>
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
					<option <?php if($dm->kodeprodi == $bp->kodeprodi) echo 'selected';?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi.' ('.$bp->jenjang.')';?></option>
					<?php endforeach; ?>
				</select>
				<?php echo form_error('kodeprodi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kelas</strong></td>
			<td class="last">
				<select name="kdkelas">
					<option value=""></option>
					<option <?php if($dm->kdkelas == '1') echo 'selected';?> value="1">Kelas Pagi</option>
					<option <?php if($dm->kdkelas == '2') echo 'selected';?> value="2">Kelas Sore</option>
				</select>
				<?php echo form_error('kdkelas'); ?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Angkatan</strong></td>
			<td class="last">
				<input type="text" name="angkatan" value="<?php echo $dm->angkatan?>" size="3"/>
				<?php echo form_error('angkatan');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Masuk</strong></td>
			<td class="last">
				<input type="radio" <?php if($dm->statusmasuk == 'Baru') echo 'checked';?> name="statusmasuk" value="Baru, 1"/> Baru
				<input type="radio" <?php if($dm->statusmasuk == 'Pindahan') echo 'checked';?> name="statusmasuk" value="Pindahan, 2"/> Pindahan
				<?php echo form_error('statusmasuk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Masuk</strong></td>
			<td class="last">
				<input type="text" name="tglmasuk" value="<?php echo tgl_indo($dm->tglmasuk)?>" size="8"/>
				<?php echo form_error('tglmasuk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Akademik</strong></td>
			<td class="last">
				<select name="statusakademik">
					<option <?php if($dm->statusakademik == 'Belum Lulus') echo 'selected';?> value="Belum Lulus">Belum Lulus</option>
					<option <?php if($dm->statusakademik == 'Lulus') echo 'selected';?> value="Lulus">Lulus</option>
					<option <?php if($dm->statusakademik == 'Keluar') echo 'selected';?> value="Keluar">Keluar</option>
					<option <?php if($dm->statusakademik == 'DO') echo 'selected';?> value="DO">DO</option>
				</select>
				<?php echo form_error('statusakademik');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Paket KRS</strong></td>
			<td class="last">
				<select name="statuspaket">
					<option <?php if($dm->statuspaket== 'non paket') echo 'selected';?> value="non paket">Non Paket</option>
					<option <?php if($dm->statuspaket == 'paket') echo 'selected';?> value="Paket">Paket</option>
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
				<input type="text" name="alamatasal" value="<?php echo $dm->alamatasal?>" size="50"/>
				<?php echo form_error('alamatasal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>RT</strong></td>
			<td class="last">
				<input type="text" name="rt" value="<?php echo $dm->rt?>" size="5"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>RW</strong></td>
			<td class="last">
				<input type="text" name="rw" value="<?php echo $dm->rw?>" size="5"/>
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
				<input type="text" name="kabupaten"  value="<?php echo $dm->idkabupaten?>" class="required" size="30"/>
				<?php echo form_error('idkabupaten');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kode POS</strong></td>
			<td class="last">
				<input type="text" name="kodepos" value="<?php echo $dm->kodepos?>" size="5"/>
				<?php echo form_error('kodepos');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon Mahasiswa</strong></td>
			<td class="last">
				<input type="text" name="notelpmhs" value="<?php echo $dm->notelpmhs?>" size="15"/>
				<?php echo form_error('notelpmhs');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Email</strong></td>
			<td class="last">
				<input type="text" name="email" value="<?php echo $dm->email?>" size="20"/>
				<?php echo form_error('email');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat Sekarang</strong></td>
			<td class="last">
				<input type="text" name="alamatsekarang" value="<?php echo $dm->alamatsekarang?>" size="50"/>
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
				<input type="text" name="namaortu" value="<?php echo $dm->namaortu?>" size="35"/>
				<?php echo form_error('namaortu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat Orang Tua</strong></td>
			<td class="last">
				<input type="text" name="alamatortu" value="<?php echo $dm->alamatortu?>" size="50"/>
				<?php echo form_error('alamatortu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon Orang Tua</strong></td>
			<td class="last">
				<input type="text" name="notelportu" value="<?php echo $dm->notelportu?>" size="15"/>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Data Sekolah Asal</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Sekolah Asal</strong></td>
			<td class="last">
				<input type="text" name="asalsma" value="<?php echo $dm->asalsma?>" size="35"/>
				<?php echo form_error('asalsma');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat SMA</strong></td>
			<td class="last">
				<input type="text" name="alamatsma" value="<?php echo $dm->alamatsma?>" size="50"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kode POS SMA</strong></td>
			<td class="last">
				<input type="text" name="kodepossma" value="<?php echo $dm->kodepossma?>" size="5"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jurusan di SMA</strong></td>
			<td class="last">
				<input type="text" name="jurusansma" value="<?php echo $dm->jurusansma?>" size="20"/>
				<?php echo form_error('jurusansma');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Thn. Lulus</strong></td>
			<td class="last">
				<input type="text" name="thlulus" value="<?php echo $dm->thlulus?>" size="4"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Asal Perguruan Tinggi</strong></td>
			<td class="last">
				<input type="text" name="asalpt" value="<?php echo $dm->asalpt?>" size="40"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>PRODI Asal</strong></td>
			<td class="last">
				<input type="text" name="prodiasal" value="<?php echo $dm->prodiasal?>" size="20"/>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Update','OnClick="showloading()"');?>
				<a href="javascript:void(0)" onclick='show("admin/masmahasiswa","#center-column")'>
					&laquo; Batal
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php endforeach; echo form_close();?>