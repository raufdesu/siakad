<head>
	<script>
		$(document).ready(function(){
			stoploading();
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
			var nilai = format_number($('#jumbiaya').val());
			document.getElementById("jumbiaya").value = nilai;
		}
		function showThajaran(){
			if($('select[name=kategori]').val() == 'Persemester'){
				$("#area-thajaran").show();
				$("#thajaran").focus();
			}else{
				$("#area-thajaran").hide();
			}
		}
	</script>
	<?php if($this->input->post('kategori') != 'Persemester'){ ?>
	<style>
		#area-thajaran{
			display:none;
		}
	</style>
	<?php } ?>
</head>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('keuangan/keuaturbiaya/save'),
	'update'=>'#center-column',
	'name'=>'f1',
	'id'=>'simprodi',
	'type'=>'post'));
?>
<div style="float: right; height: 25px">
	<a href="javascript:void(0)" onclick="show('keuangan/keuaturbiaya', '#center-column')" class="button">Browse</a>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM PENENTUAN BIAYA
			</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Biaya</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('namabiaya')?>" name="namabiaya" size="50" />
				<?php echo form_error('namabiaya');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Program Studi</strong></td>
			<td class="last">
				<select name='kodeprodi' style="width:290px !important;">
					<option <?php if($this->input->post('kodeprodi') == '') echo 'selected'; ?> value="">Pilih PRODI</option>
					<?php foreach($browse_prodi as $bp):?>
					<option <?php if($this->input->post('kodeprodi') == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
					<?php endforeach; ?>
				</select>
				<?php echo form_error('kodeprodi')?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Angkatan</strong></td>
			<td class="last">
				<input type="text" maxlength="4" value="<?php echo $this->input->post('angkatan')?>" name="angkatan" size="3" />
				<?php echo form_error('angkatan');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Gelombang</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('gelombang')?>" name="gelombang" size="1" />
				<?php echo form_error('gelombang');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Jenis</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('jenis')?>" name="jenis" size="30" />
				<?php echo form_error('jenis');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Besar Biaya</strong></td>
			<td class="last">
				Rp. <input style="text-align:right" type="text" value="<?php echo $this->input->post('jumbiaya')?>" id="jumbiaya" name="jumbiaya" size="10" onblur="beRupiah()" />,00
				<?php echo form_error('jumbiaya');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Kategori</strong></td>
			<td class="last">
				<select name="kategori" onchange="showThajaran()">
					<option value="">Pilih Kategori</option>
					<?php for($i=0;$i<count($kategori);$i++){ ?>
					<option <?php if($this->input->post('kategori')==$kategori[$i]) echo 'selected'?> value="<?php echo $kategori[$i]?>"><?php echo $kategori[$i]?></option>
					<?php } ?>
				</select>
				<?php echo form_error('persemester');?>
			</td>
		</tr>
		<tr class="bg" id="area-thajaran">
			<td class="first" width="190"><strong>Tahun Ajaran</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('thajaran')?>" id="thajaran" name="thajaran" maxlength="5" size="4" />
				<span style="color:#ababab">contoh : 20132</span>
				<?php echo form_error('thajaran');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="showloading()"');?>
				<input type="reset" value="Reset" />
				<!--<a href="javascript:void(0)" onclick='show("keuangan/simprodi","#center-column")'>
					<< Batal
				</a>-->
			</td>
		</tr>
	</table>
	<center><?php echo form_error('petugas');?></center>
  <p>&nbsp;</p>
</div>
<?php echo form_close();?>