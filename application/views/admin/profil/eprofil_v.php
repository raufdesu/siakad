<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	})
	function tampilkan_kabupten(){
		var selected_propinsi = $('select[name=propinsi]').val();
		load_no_loading('admin/profil/tampilkan_kabupaten/'+selected_propinsi,'#kabupaten');
	}
</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/profil/save'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
?>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM UPDATE PROFIL</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Kampus</strong></td>
			<td class="last">
				<input type="text" name="nama" value="<?php echo $dp->nama?>" size="50" />
				<input type="hidden" value="<?php echo $dp->idprofil?>" name="idprofil" />
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Alamat</strong></td>
			<td class="last">
				<textarea name="alamat" cols="50"><?php echo $dp->alamat?></textarea>
				<?php echo form_error('alamat');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Propinsi</strong></td>
			<td class="last">
				<select name="propinsi" id="select" onchange="tampilkan_kabupten()">
					<option value=""></option>
					<?php foreach($propinsi->result() as $pro):?>
					<option <?php if(substr($dp->idkabupaten,0,2) == $pro->idpropinsi) echo 'selected';?> value="<?php echo $pro->idpropinsi?>"><?php echo $pro->namapropinsi?></option>
					<?php endforeach; ?>
				</select>
				<?php echo form_error('propinsi');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Kabupaten</strong></td>
			<td class="last" id="kabupaten">
				<?php $kabupaten = $this->kabupaten_m->get_all(substr($dp->idkabupaten,0,2));?>
				<select name="idkabupaten">
					<option value=""></option>
					<?php foreach($kabupaten as $kab):?>
					<option <?php if($dp->idkabupaten == $kab->idkabupaten) echo 'selected';?> value="<?php echo $kab->idkabupaten?>"><?php echo $kab->namakabupaten?></option>
					<?php endforeach; ?>
				</select>
				<?php echo form_error('idkabupaten')?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>No. Telepon</strong></td>
			<td class="last">
				<input type="text" name="notelp" value="<?php echo $dp->notelp?>" size="25"/>
				<?php echo form_error('notelp');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>eMail</strong></td>
			<td class="last">
				<input type="text" name="email" value="<?php echo $dp->email?>" size="30"/>
				<?php echo form_error('email');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Website</strong></td>
			<td class="last">
				<input type="text" name="website" value="<?php echo $dp->website?>" size="30"/>
				<?php echo form_error('website');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Nama Rektor</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $dp->npp?>" name="npp"/>
				<input type="text" readonly value="<?php echo $dp->namadekan?>" name="namadosen" style="width:300px"/>
				<a href="javascript:void(0)" onclick='load_into_box("admin/maspegawai/browse_dosen");'>..</a>
				<?php echo '<br />'.form_error('npp');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Update','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/simsetting","#center-column")'>
					<< Batal
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
	}
</script>