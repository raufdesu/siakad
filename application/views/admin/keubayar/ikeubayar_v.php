<head>
<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		stoploading();
		$('#nim').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			autoFill: true,
			innerText: '',
			minimumSearchLength: 5
		});
		$("#nim").val('<?php echo $this->input->post('nim'); ?>');
		$("#nim").focus();
	});
	function searchFunction(str){
		load('admin/keubayar/cari_nim/'+str,'#nama_mhs');
	}
	function ChangeThajaran(){
		var selected_thajaran = $('select[name=thajaran]').val();
		load('admin/keubayar/change_thajaran/'+selected_thajaran,'#center-column');
	}
	function ChangeJenisbayar(){
		var selected_jenisbayar = $('select[name=jenisbayar]').val();
		load('admin/keubayar/change_jenisbayar/'+selected_jenisbayar,'#center-column');
	}
</script>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/keubayar/save'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
?>
<div style="float: right; height: 25px">
	<a href="javascript:void(0)" onclick='show("admin/keubayar/cari_mhs", "#center-column")' class="button">Browse</a>
	<a href="javascript:void(0)" onclick='show("admin/keubayar/laporan", "#center-column")' class="button">Laporan</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM PEMBAYARAN
				<select name="jenisbayar" onchange="ChangeJenisbayar()">
					<option value=""></option>
					<?php foreach($browse_jenisbayar as $bj):?>
					<option <?php if($this->session->userdata('sesi_jenisbayar') == $bj->jenisbayar) echo 'selected'; ?> value="<?php echo $bj->jenisbayar?>"><?php echo $bj->jenisbayar?></option>
					<?php endforeach ?>
				</select>
				<div style="float: right">
					<b>Tahun Ajaran</b>
					<select name="thajaran" onchange="ChangeThajaran()">
					<?php foreach($browse_thajaran as $bt):?>
						<option <?php if($thajaran == $bt->thajaran) echo 'selected'; ?> value="<?php echo $bt->thajaran?>"><?php echo $bt->thajaran?></option>
					<?php endforeach; ?>
					</select>
				</div>
			</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>NIM</strong></td>
			<td class="last">
				<input type="hidden" value="<?php echo $petugas?>" name="petugas" />
				<input type="text" value="<?php echo $this->input->post('nim')?>" id="nim" name="nim" size="8" />
				<?php echo form_error('nim');?>
			</td>
		</tr>
		<tr>
			<td colspan="2" id="nama_mhs">
				<table>
					<tr>
						<td id="label" class="first" width="190"><strong>Nama Mahasiswa</strong></td>
						<td class="last">
							<input type="text" readonly value="<?php echo $this->input->post('nama');?>" size="35" />
						</td>
					</tr>
					<tr>
						<td id="label" class="first" width="190"><strong>PRODI</strong></td>
						<td class="last">
							<input type="text" readonly value="<?php echo $this->input->post('prodi')?>" size="60" />
						</td>
					</tr>
					<tr>
						<td id="label" class="first" width="190"><strong>Tagihan</strong></td>
						<td class="last">
							Rp. <input type="text" name='totalbayar' id='totalbayar' readonly value="<?php echo $this->input->post('totalbayar')?>" size="10" />,00
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="return setujui()"');?>
				<input type="reset" value="Reset" />
				<!--<a href="javascript:void(0)" onclick='show("admin/simprodi","#center-column")'>
					<< Batal
				</a>-->
			</td>
		</tr>
	</table>
	<div><center><?php echo form_error('jenisbayar');?><?php echo form_error('jumbayar')?>
	<?php echo form_error('petugas');?></center></div>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		if(document.getElementById('jumbayar').value == false){
			alert('KONFIRMASI\nJumlah Pembayaran harus diisi');
			document.getElementById('jumbayar').focus();
			return false;
		}else if(document.getElementById('jumbayar').value > document.getElementById('kekurangan').value){
			alert('KONFIRMASI\nInputan Jumlah Pembayaran terlalu besar');
			document.getElementById('jumbayar').focus();
			return false;
		}else{
			showloading();
			return true;
		}
	}
</script>