<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
		// load('admin/simkrs/cari_matakuliah/','#txt_kodemk');
		$('#txt_kodemk').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			innerText: 'ketik kode',
			minimumSearchLength: 2
		});
		//$("#txt_kodemk").val('<?php echo $this->session->userdata('sesi_kodemk'); ?>');
		$("#txt_kodemk").focus();
	});
	function searchFunction(str){
		// showloading();
		//load('admin/simkrs/cari_matakuliah/'+str,'#hasil');
		$.ajax({
            type: "POST",
            url: "<?php echo base_url()?>getmk.php",
            data: "&act=getmk&wh="+str,
            success: function(msg){
				alert(msg);
			}
		})
	}
</script>
<div class="top-bar-adm">
	<h1>Form Input KRS Mahasiswa</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simkrs/detail_mahasiswa'), 							
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'form',
	'type'=>'post'));
?>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<td class="first right" width="120"><strong>NIM</strong></td>
			<td class="last">
				<input type="text" name="nim" value='<?php echo $this->session->userdata('sesi_krs_nim')?>' class="required" size="8"/>
				<input type="submit" value="ok" />
				<?php echo form_error('nim');?>
			</td>
			<td class='right'>Kelas</td>
			<td class='first'>
				<?php
					if($this->session->userdata('sesi_krs_kelas')=='2')
						echo 'Malam';
					elseif($this->session->userdata('sesi_krs_kelas')=='1')
						echo 'Reguler';
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first right"><strong>Nama</strong></td>
			<td class="last"><?php echo $this->session->userdata('sesi_krs_nama');?></td>
			<td class='right'>Thn. Akademik</td><td class='first'>
				<?php echo $this->session->userdata('sesi_krs_thajaran_aktif')?>
				<!--<select name='thajaran'>
					</?php foreach($browse_thajaran as $bt):?>
					<option </?php if($this->session->userdata('sesi_krs_thajaran')==$bt->thajaran) echo 'selected'; ?> value='</?php echo $bt->thajaran?>'></?php echo $bt->thajaran?></option>
					</?php endforeach ?>
				</select>-->
			</td>
		</tr>
		<tr>
			<td class="first right"><strong>Jurusan</strong></td>
			<td class="last"><?php echo $this->session->userdata('sesi_krs_prodi')?></td>
			<td class='right'>Jumlah SKS</td><td class='first'>: 22 SKS</td>
		</tr>
		</tr>
	</table>
</div>&nbsp;
</form>
</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simkrs/simpan'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'form',	'type'=>'post'));
?>
	<input type='text' name='txt_kodemk'  id='txt_kodemk' size='8'/>
	<input type='hidden' name='sks' value='<?php echo $sks?>' />
	<input type='text' name='nama_matkul' value='<?php echo $nama_matkul?>' size='45'/><input type='submit' value='Tambah'/>
</form>
<div class='table' id='hasil'>
<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class='first' style='text-align:center'>No</th><th>Kode</th>
		<th>Nama Matakuliah</th><th>SKS</th><th class='last' style='text-align:center'>Del</th>
	</tr>
	
<?php $i=1; $no=1; foreach($this->cart->contents() as $items): ?>
	<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
	<tr>
	  <td><?php echo $no++.'.';?></td>
	  <td><?php echo $items['id']?></td>
	  <td class='first'><?php echo $items['name']; ?></td>
	  <td><?php echo $items['qty']; ?></td>
	  <td>
		<a href="javascript:void(0)" onclick='show("admin/simkrs/delete/<?php echo $items['rowid']?>","#center-column")'>
			<?php echo img('asset/images/design/hr.gif')?>
		</a>
		</td>
	</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>
<div class='panel'>
	<input type='button' value='Copy ke'/>
	<input type='button' value='KHS'/>
	<input type='button' value='Hapus'/>
	<input type='button' value='Copy ke'/>
	&nbsp; &nbsp; <strong> &nbsp; Nama DPA</strong> <input type='text' value='Momon Muzakkar, S.T' readonly size='42'/>
	<input type='button' value='Cetak'/>
</div>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		showloading();
		this.form.submit();
	}
</script>