<script src="<?php echo base_url()?>asset/plugin/livesearch/jquery.livesearch.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		stoploading();
		$('#nim').livesearch({
			searchCallback: searchFunction,
			queryDelay: 0,
			autoFill: true,
			innerText: 'ketik nim',
			minimumSearchLength: 4
		});
		$("#nim").val('<?php echo $this->input->post('nim'); ?>');
		$("#nim").focus();
	});
	function searchFunction(str){
		load('admin/loginmhs/namamhs/'+str,'#nama_mahasiswa');
	}
</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/loginmhs/savemhs'),
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
			<th class="full" colspan="2">Form Input Password Mahasiswa</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>NIM</strong></td>
			<td class="last">
				<input type="text" name="nim" id="nim" value="<?php echo $this->input->post('nim')?>" size="8" />
				<?php echo form_error('nim');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama Mahasiswa</strong></td>
			<td class="last">
				<div id="nama_mahasiswa">
				<input type="text" name="nama" readonly value="<?php echo $this->input->post('nama')?>" size="50" />
				</div>
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Password</strong></td>
			<td class="last">
				<input type="text" name="password" value="<?php echo $this->input->post('password')?>" size="18" />
				<?php echo form_error('password');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/login/index_browse","#center-column")'>
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