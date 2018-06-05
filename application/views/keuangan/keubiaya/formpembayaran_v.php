<head>
<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		stoploading();
		document.getElementById("jumsetoran").focus();
		/*
		$('#jumsetoran').livesearch({
			searchCallback: beRupiah,
			queryDelay: 0,
			autoFill: true,
			innerText: '',
			minimumSearchLength: 0
		});
		$("#jumsetoran").keypress(function(e) {
			beRupiah();
		});
		*/
	});
	function format_number(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
	function beRupiah(){
		var nilai = format_number($('#jumsetoran').val());
		document.getElementById("jumsetoran").value = nilai;
	}
	function ChangeThajaran(){
		var selected_thajaran = $('select[name=thajaran]').val();
		load('keuangan/keubiaya/change_thajaran/'+selected_thajaran,'#form-pembayaran');
	}
	function ChangeNamaBiaya(){
		showloading();
		var selected_namabiaya = $('select[name=namabiaya]').val();
		var namabiaya = replaceMasal(selected_namabiaya );
		load('keuangan/keubiaya/change_namabiaya/'+namabiaya,'#form-pembayaran');
		/* load('keuangan/keubiaya/thajaran_bayar/'+namabiaya, '#area-thajaran'); */
	}
</script>
<style>
	.number{
		text-align:right;
	}
	.area-thajaran{
		float:right;
		margin-right:8px;
	}
</style>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('keuangan/keubiaya/save'),
	'update'=>'#form-pembayaran',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
	echo form_hidden('idbiaya', $biaya['idbiaya']);
	echo form_hidden('nim', $nim);
	/* echo form_hidden('thajaran', $thajaran); */
	echo form_hidden('petugas', $petugas);
?>
<div style="margin-right:3px;margin-top:-120px;float:right;">
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/detail_bynim/<?php echo $nim?>", "#form-pembayaran")' class="button">Detail</a>
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/atur_bynim/<?php echo $nim?>", "#form-pembayaran")' class="button">Atur Persiswa</a>
	<a href="javascript:void(0)" onclick='show("keuangan/keubiaya/laporan_nim/<?php echo $nim?>", "#center-column")' class="button">Laporan</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM PEMBAYARAN
				<select name="namabiaya" onchange="ChangeNamaBiaya()">
					<option value=""></option>
					<?php foreach($browse_namabiaya as $bn):?>
					<option <?php if($this->session->userdata('sesi_namabiaya') == $bn->namabiaya) echo 'selected'; ?> value="<?php echo $bn->namabiaya?>"><?php echo $bn->namabiaya?></option>
					<?php endforeach ?>
				</select>
				<div style="float:right"><?php echo $biaya['status']?>&nbsp;
					<?php if($this->keusetoran_m->get_lastidsetoran($biaya['idbiaya']) && $biaya['idbiaya']){ ?>
					<a href="javascript:void(0)" onclick='return batalkan_lastpembayaran("<?php echo $biaya['idbiaya']?>", "<?php echo $nim?>", "<?php echo $biaya['thajaran']?>")' title="Batalkan Pembayaran Terakhir">X</a>
					<?php } ?>
				</div>
			</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Tagihan</strong></td>
			<td class="last">
				Rp. <input type="text" class="number" style="background-color:#efefef;" readonly value="<?php echo rupiah($biaya['jumbiaya'], 1)?>" name="tagihan" size="10" />,00
				<?php echo form_error('tagihan');?>
				<?php if($biaya['kategori'] == 'Persemester'){ ?>
				<div class="area-thajaran">
					<b>Tahun Ajaran</b>:
					<?php echo $biaya['thajaran']; echo form_hidden('thajaran', $biaya['thajaran']); ?>
				</div>
				<?php
					}else{
						echo form_hidden('thajaran', $this->session->userdata('sesi_thajaranbiaya'));
					}
				?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Minimum Pengaktifan</strong></td>
			<td class="last">
				Rp. <input type="text" class="number" style="background-color:#efefef;" readonly value="<?php echo rupiah($biaya['minaktif'], 1)?>" name="tagihan" size="10" />,00
				<?php echo form_error('tagihan');?>
				<?php if($biaya['kategori'] == 'Persemester'){ ?>
				<?php
					}else{
						echo form_hidden('thajaran', $this->session->userdata('sesi_thajaranbiaya'));
					}
				?>
			</td>
		</tr>
		<tr>
			<td id="label" class="first" width="190"><strong>Sudah Dibayar</strong></td>
			<td class="last">
				Rp. <input type="text" class="number" style="background-color:#efefef;" name='jumlah' id='jumlah' readonly value="<?php echo rupiah($biaya['totalsetoran'], 1)?>" size="10" />,00
			</td>
		</tr>
		<?php if($biaya['status'] == 'Belum Lunas'){ ?>
		<tr class="bg">
			<td id="label" class="first" width="190"><strong>Kekurangan</strong></td>
			<td class="last">
				<?php
					$kekurangan = $biaya['jumbiaya'] - $biaya['totalsetoran'];
				?>
				Rp. <input type="text" class="number" style="background-color:#efefef;" readonly name="kekurangan" value="<?php echo rupiah($kekurangan, 1);?>" size="10" />,00
				<?php echo form_error('kekurangan')?>
			</td>
		</tr>
		<tr>
			<td id="label" class="first" width="190"><strong>Besar Setoran</strong></td>
			<td class="last">
				Rp. <input type="text" class="number" id="jumsetoran" onblur="beRupiah()" name="jumsetoran" value="<?php echo $this->input->post('jumsetoran');?>" size="10" />,00
				<?php echo form_error('jumsetoran')?>
				<!---<input type="text" name="tiruan" id="tiruan" value="</?php echo $this->input->post('tiruan')?>" />-->
			</td>
		</tr>
		<tr class="bg">
			<td id="label" class="first" width="190"><strong>Tanggal Setor</strong></td>
			<td class="last">
				<input type="text" name="tglsetor" value="<?php echo $this->input->post('tglsetor')?>" size="8"/>
				<input type="button" value=".." OnClick="displayDatePicker('tglsetor', false, 'dmy', '-')">
			</td>
		</tr>
		<tr>
			<td id="label" class="first" width="190"><strong>Catatan</strong></td>
			<td class="last">
				<textarea name="keterangan" cols="60" rows="1"><?php echo $this->input->post('keterangan')?></textarea>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan', 'Simpan', 'OnClick="return setujui()"');?>
				<input type="reset" value="Reset" />
			</td>
		</tr>
		<?php } ?>
	</table>
	<div><center><?php echo form_error('namabiaya');?><?php echo form_error('jumbiaya')?>
	<?php echo form_error('petugas');?></center></div>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>
<script language="javascript">
	function setujui(){
		if(document.getElementById('jumbiaya').value == false){
			alert('KONFIRMASI\nJumlah Pembayaran harus diisi');
			document.getElementById('jumbiaya').focus();
			return false;
		}else if(document.getElementById('jumbiaya').value > document.getElementById('kekurangan').value){
			alert('KONFIRMASI\nInputan Jumlah Pembayaran terlalu besar');
			document.getElementById('jumbiaya').focus();
			return false;
		}else{
			showloading();
			return true;
		}
	}
	function batalkan_lastpembayaran(idbiaya, nim, thajaran){
		if(confirm("PERINGATAN\nJika status Lunas dan nama pembayaran adalah SPP,\nmaka pengaktifan semester juga dibatalkan.\nKlik 'OK' untuk melanjutkan pembatalan pembayaran terakhir terakhir")){
			load("keuangan/keubiaya/batalkan_lastbayar/" + idbiaya + "/" + nim + "/" + thajaran, "#form-pembayaran");
			return true;
		}else{
			return false;
		}
	}
</script>