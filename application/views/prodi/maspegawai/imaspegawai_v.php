<script type="text/javascript">
$(document).ready(function() {
	stoploading();
})
</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('prodi/maspegawai/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'maspegawai',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM INPUT DATA PEGAWAI</th>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NPP Pegawai</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('npp')?>" name="npp" class="required" size="20"/>
				<?php echo form_error('npp');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="172"><strong>NIP Pegawai</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nip')?>" name="nip" class="required" size="30"/>
				<?php echo form_error('nip');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nama')?>" name="nama" class="required" size="35"/>
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Pegawai</strong></td>
			<td class="last">
				<select name='statuspegawai'>
					<option value=''></option>
					<?php for($i=0;$i<count($statuspegawai);$i++){ ?>
					<option <?php if($this->input->post('statuspegawai')==$statuspegawai[$i]) echo 'selected'?> value="<?php echo $statuspegawai[$i]?>"><?php echo $statuspegawai[$i]?></option>
					<?php } ?>
				</select>
				<?php echo form_error('statuspegawai');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Alamat</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('alamat')?>" name="alamat" class="required" size="50"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('notelp')?>" name="notelp" class="required" size="20"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Status Nikah</strong></td>
			<td class="last">
				<input type="radio" name="statusnikah" class="required" value="Menikah"/>Menikah | 
				<input type="radio" name="statusnikah" class="required" value="Belum Menikah"/>Belum Menikah
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Pendidikan Terakhir</strong></td>
			<td class="last">
				<select name='pendidikanterakhir'>
					<option value=''></option>
					<option value='SD'>SD</option>
					<option value='SMP'>SMP</option>
					<option value='SMA'>SMA</option>
					<option value='D1'>D1</option>
					<option value='D3'>D3</option>
					<option value='S1'>S1</option>
					<option value='S2'>S2</option>
					<option value='S3'>S3</option>
				</select>
				<?php echo form_error('pendidikanterakhir');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>PRODI</strong></td>
			<td class="last">
				<select name="kodeprodi">
					<option value="<?php echo $this->session->userdata('sesi_prodi')?>" ><?php echo $this->auth->get_namaprodi($this->session->userdata('sesi_prodi'))?></option>
				</select>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>NIDN</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('nidn')?>" name="nidn" class="required" size="15"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Bagian</strong></td>
			<td class="last">
				<select name='bagian'>
					<option value=''></option>
					<option value='Program Studi'>Program Studi</option>
					<option value='Akademik'>Akademik</option>
					<option value='Laboratorium'>Laboratorium</option>
					<option value='Kepegawaian'>Kepegawaian</option>
					<option value='Keuangan'>Keuangan</option>
					<option value='Puskom'>Puskom</option>
					<option value='Perpustakaan'>Perpustakaan</option>
					<option value='Lainnya'>Lainnya</option>
				</select>
				<?php echo form_error('bagian');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Jabatan Akademik</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('jabatanakademik')?>" name="jabatanakademik" class="required" size="30"/>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Masuk</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('tglmasuk')?>" name="tglmasuk" class="required" size="8"/>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("prodi/maspegawai","#center-column")'>
					Batal &raquo;
				</a>
			</td>
		</tr>
	</table>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>