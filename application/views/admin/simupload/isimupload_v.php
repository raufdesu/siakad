<script src="<?php echo base_url();?>asset/javascript/ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript">
	function ajaxFileUpload(){
		$.ajaxFileUpload
		(
			{
				url:'<?php echo base_url()?>index.php/admin/simupload/upload_file',
				secureuri:false,
				fileElementId:'myfile',
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							$("#inpo").html(data.error);
						}else{
							$("#sukses_upload").html(data.msg);
							/*show('upload/show_form_real','#form_akhir');*/
						}
					}
				},
				error: function (data, status, e)
				{
					$("#inpo").html(e);
				}
			}
		)		
		return false;
	}
</script>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi' onclick='show("admin/simupload/","#center-column")'>Browse</a>
	<h1><?php echo $title?></h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<?php echo $this->pquery->form_remote_tag(array('url'=>site_url('admin/simupload/save'),
			'update'=>'#center-column', 'name'=>'f1', 'id'=>'simupload', 'type'=>'post')); ?>
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="full" colspan="2">FORM <?php echo $title?></th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>File</strong></td>
			<td class="last">
				<div id="inpo">
				<div class="input">
					<div id="sukses_upload">
						<input id="myfile" type="file" name="myfile"/>
						<input type="hidden" name="file"/>
						<input value="Upload" type="button" onclick="ajaxFileUpload();" /><?php echo form_error('file')?>
					</div>
				</div>
				</div>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Judul/Nama File</strong></td>
			<td class="last">
				<input type="text" value="<?php echo $this->input->post('namaupload')?>" name="namaupload" size="60"/>
				<?php echo '<br />'.form_error('namaupload');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Untuk</strong></td>
			<td class="last">
				<select name="untuk">
					<option value=""></option>
					<option <?php if($this->input->post('untuk') == 'Semua') echo 'selected';?> value="Semua">Semua</option>
					<option <?php if($this->input->post('untuk') == 'Dosen') echo 'selected';?> value="Dosen">Dosen</option>
					<option <?php if($this->input->post('untuk') == 'Kaprodi') echo 'selected';?> value="Kaprodi">Kaprodi</option>
					<option <?php if($this->input->post('untuk') == 'Mahasiswa') echo 'selected';?> value="Mahasiswa">Mahasiswa</option>
				</select>
				<?php echo '<br />'.form_error('untuk');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first"><strong>Tgl. Upload</strong></td>
			<td class="last">
				<input type="text" value="<?php echo date('d-m-Y')?>" name="tglupload" class="required" size="8"/>
				<input type="button" value="..." OnClick="displayDatePicker('tglupload', false, 'dmy', '-')">
				<?php echo '<br />'.form_error('tglupload');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Keterangan</strong></td>
			<td class="last">
				<textarea cols="75" name="keterangan"><?php echo $this->input->post('keterangan')?></textarea>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan').form_reset('batal','Batal');?>
			</td>
		</tr>
	</table>
	</form>
  <p>&nbsp;</p>
</div>