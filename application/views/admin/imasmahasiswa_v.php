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
				<input type="text" value="<?php echo $this->input->post('nim')?>" name="nim" class="required" size="12"/>
				<?php echo form_error('nim');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIK</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nik')?>" name="nik" class="required" size="35"/>
				<?php echo form_error('nik');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NISN</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nisn')?>" name="nisn" class="required" size="35"/>
				<?php echo form_error('nisn');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NPWP</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('npwp')?>" name="npwp" class="required" size="35"/>
				<?php echo form_error('npwp');?>
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
				<input type="radio" name="jeniskelamin" <?php if($this->input->post('jeniskelamin')=='1') echo 'checked'?> class="required" value="1, L"/>Laki-laki
				<input type="radio" name="jeniskelamin" <?php if($this->input->post('jeniskelamin')=='0') echo 'checked'?> class="required" value="0, P"/>Perempuan
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
					<option value="Islam,1">Islam</option>
					<option value="Kristen,2">Kristen</option>
					<option value="Katolik,3">Katolik</option>
					<option value="Hindu,4">Hindu</option>
					<option value="Budha,5">Budha</option>
					<option value="Konghuchu,6">Konghuchu</option>
					<option value="Lainnya,99">Lainnya</option>
				</select>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Penerima KPS ? </strong></td>
			<td class="last">
				<input type="radio" <?php if($this->input->post('a_terima_kps')=='0') echo 'checked'?> name="a_terima_kps" value="0"/> Tidak
				<input type="radio" <?php if($this->input->post('a_terima_kps')=='1') echo 'checked'?> name="a_terima_kps" value="1"/> Ya
				<?php echo form_error('a_terima_kps');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>No KPS</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('no_kps')?>" name="no_kps" class="required" size="35"/>
				<?php echo form_error('no_kps');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kewarganegaraan</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('wilayah',$wilayah,'id_negara','nm_wil');?>
			<span id='wilayah'></span>
				<?php echo form_error('wilayah');?>
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
				<?php echo form_error('angkatan'); $mulai_smt = str_pad('angkatan', 5, '1', STR_PAD_RIGHT);?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Masuk</strong></td>
			<td class="last">
				<input type="radio" <?php if($this->input->post('statusmasuk')=='Baru') echo 'checked'?> name="statusmasuk" value="Baru,1"/> Baru
				<input type="radio" <?php if($this->input->post('statusmasuk')=='Pindahan') echo 'checked'?> name="statusmasuk" value="Pindahan,2"/> Pindahan
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
			<td class="first"><strong>Dusun</strong></td>
			<td class="last">
				<input type="text" name="nm_dsn" value="<?php echo $this->input->post('nm_dsn')?>" size="50"/>
				<?php echo form_error('nm_dsn');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Desa/Kelurahan</strong></td>
			<td class="last">
				<input type="text" name="ds_kel" value="<?php echo $this->input->post('ds_kel')?>" size="50"/>
				<?php echo form_error('ds_kel');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>RT</strong></td>
			<td class="last">
				<input type="text" name="rt" value="<?php echo $this->input->post('rt')?>" size="5"/>
				<?php echo form_error('rt');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>RW</strong></td>
			<td class="last">
				<input type="text" name="rw" value="<?php echo $this->input->post('rw')?>" size="5"/>
				<?php echo form_error('rw');?>
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
		<tr class="bg">
			<td class="first"><strong>Jenis Tinggal</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('jenis_tinggal',$jenis_tinggal,'id_jns_tinggal','nm_jns_tinggal');?>
			<span id='jenis_tinggal'></span>
				<?php echo form_error('jenis_tinggal');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alat Transportasi</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('alat_transport',$alat_transport,'id_alat_transport','nm_alat_transport');?>
			<span id='alat_transport'></span>
				<?php echo form_error('alat_transport');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last"><font color='blue'><b>Data Orang Tua / Wali</b></font></td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIK Ayah</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nik_ayah')?>" name="nik_ayah" class="required" size="35"/>
				<?php echo form_error('nik_ayah');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Ayah</strong></td>
			<td class="last">
				<input type="text" name="nm_ayah" value="<?php echo $this->input->post('nm_ayah')?>" size="35"/>
				<?php echo form_error('nm_ayah');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tempat/Tgl. Lahir Ayah</strong></td>
			<td class="last">
				<input type="text" name="tempatlahir_ayah" value="<?php echo $this->input->post('tempatlahir_ayah')?>" size="20"/>/
				<input type="text" name="tgl_lahir_ayah" value="<?php echo $this->input->post('tgl_lahir_ayah')?>" class="required" size="8"/>dd-mm-yyyy
				<?php echo form_error('tempatlahir_ayah');?>
				<?php echo form_error('tgl_lahir_ayah');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pendidikan Ayah</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_jenjang_pendidikan_ayah',$pendidikan,'id_jenj_didik','nm_jenj_didik');?>
			<span id='id_jenjang_pendidikan_ayah'></span>
				<?php echo form_error('id_jenjang_pendidikan_ayah');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pekerjaan Ayah</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_pekerjaan_ayah',$pekerjaan,'id_pekerjaan','nm_pekerjaan');?>
			<span id='id_pekerjaan_ayah'></span>
				<?php echo form_error('id_pekerjaan_ayah');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>penghasilan Ayah</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_penghasilan_ayah',$penghasilan,'id_penghasilan','nm_penghasilan');?>
			<span id='id_penghasilan_ayah'></span>
				<?php echo form_error('id_penghasilan_ayah');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIK Ibu</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nik_ibu')?>" name="nik_ibu" class="required" size="35"/>
				<?php echo form_error('nik_ibu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Ibu</strong></td>
			<td class="last">
				<input type="text" name="nm_ibu_kandung" value="<?php echo $this->input->post('nm_ibu_kandung')?>" size="35"/>
				<?php echo form_error('nm_ibu_kandung');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tempat/Tgl. Lahir Ibu</strong></td>
			<td class="last">
				<input type="text" name="tempatlahir_ibu" value="<?php echo $this->input->post('tempatlahir_ibu')?>" size="20"/>/
				<input type="text" name="tgl_lahir_ibu" value="<?php echo $this->input->post('tgl_lahir_ibu')?>" class="required" size="8"/>dd-mm-yyyy
				<?php echo form_error('tempatlahir_ibu');?>
				<?php echo form_error('tgl_lahir_ibu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pendidikan Ibu</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_jenjang_pendidikan_ibu',$pendidikan,'id_jenj_didik','nm_jenj_didik');?>
			<span id='id_jenjang_pendidikan_ibu'></span>
				<?php echo form_error('id_jenjang_pendidikan_ibu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pekerjaan Ibu</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_pekerjaan_ibu',$pekerjaan,'id_pekerjaan','nm_pekerjaan');?>
			<span id='id_pekerjaan_ibu'></span>
				<?php echo form_error('id_pekerjaan_ibu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>penghasilan Ibu</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_penghasilan_ibu',$penghasilan,'id_penghasilan','nm_penghasilan');?>
			<span id='id_penghasilan_ibu'></span>
				<?php echo form_error('id_penghasilan_ibu');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Wali</strong></td>
			<td class="last">
				<input type="text" name="nm_wali" value="<?php echo $this->input->post('nm_wali')?>" size="35"/>
				<?php echo form_error('nm_wali');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tempat/Tgl. Lahir Wali</strong></td>
			<td class="last">
				<input type="text" name="tempatlahir_wali" value="<?php echo $this->input->post('tempatlahir_wali')?>" size="20"/>/
				<input type="text" name="tgl_lahir_wali" value="<?php echo $this->input->post('tgl_lahir_wali')?>" class="required" size="8"/>dd-mm-yyyy
				<?php echo form_error('tempatlahir_wali');?>
				<?php echo form_error('tgl_lahir_wali');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pendidikan Wali</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_jenjang_pendidikan_wali',$pendidikan,'id_jenj_didik','nm_jenj_didik');?>
			<span id='id_jenjang_pendidikan_wali'></span>
				<?php echo form_error('id_jenjang_pendidikan_wali');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pekerjaan Wali</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_pekerjaan_wali',$pekerjaan,'id_pekerjaan','nm_pekerjaan');?>
			<span id='id_pekerjaan_wali'></span>
				<?php echo form_error('id_pekerjaan_wali');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>penghasilan Wali</strong></td>
			<td class="last">
			<?php echo $this->fungsi->create_combobox('id_penghasilan_wali',$penghasilan,'id_penghasilan','nm_penghasilan');?>
			<span id='id_penghasilan_wali'></span>
				<?php echo form_error('id_penghasilan_wali');?>
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

<script type="text/javascript">

$(document).ready(function() {


$('.up_feeder').on('click', function() {

  if ($('#isi_drop_up').is(":visible")){
    $("#isi_drop_up").hide();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  } else {
    $("#isi_drop_up").show();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  }


});

   $.ajax({
     url: '<?=base_admin();?>modul/mahasiswa/create_json.php?jurusan='+<?=$id_jur;?>,
      });

$('.cmdSimpan').on('click', function() {

//$("#loadnya").show();
//$(".text-wait-up").show();
$("#isi_drop_up").hide();
 
window.finished = false;
        $.getJSON('<?=base_admin();?>modul/mahasiswa/push_mhs.php?sem='+<?=$mulai_smt;?>+"&jurusan="+$("#kodeprodi").val(),
            function(data){
             //   console.log("ALL DONE", data);
                clearInterval(window.progressInterval);
                window.finished = true;
                if(typeof data.error == 'undefined' || data.error === true){
                    displayError(data);
                } else {
                    checkProgress();
                    $('.tertiary-status').remove();
                    if(!$('#script-progress').hasClass('hidden')){
                        $('#script-progress').fadeOut(200,function(){$('#script-progress').addClass('hidden');});
                    }
                    alert('Upload Data Selesai');
                    $("#loadnya").hide();
                   $(".text-wait-up").hide();
                    $("#isi_drop_up").hide();
                    $("#progress_nya").hide();
                    $("#isi_informasi").html(data.message);
                    $('#informasi').modal('show');
                    
                   // window.location.reload();
                }
            }
        ).error(function(data){
            window.hasError = true;
            console.log("ERROR", data);
            displayError(data);
        });
        window.progressInterval = setInterval(checkProgress, window.updatePeriod);


});


});


</script>  