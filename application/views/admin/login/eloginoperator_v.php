<script type="text/javascript">
	$(document).ready(function(){
		stoploading();
		var kodeprodinya = "<?php echo $login->prodi?>";
		if(!kodeprodinya){
			document.getElementById("prodi").style.display = 'none';
		}
	});
	function showProdi(){
		if(document.getElementById("status").value == "prodi"){
			document.getElementById("prodi").style.display = 'block';
			$("#prodi").focus();
		}else{
			document.getElementById("prodi").style.display = 'none';
		}
	}
</script>
<?php echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/login/save_operator'),
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
			<th class="full" colspan="2">Form Input Login Operator/Administrator</th>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Username</strong></td>
			<td class="last">
				<input type="text" id="username" name="username" value="<?php echo $login->username?>" size="20" />
				<input type="hidden" name="username2" value="<?php echo $login->username?>" />
				<?php echo form_error('nama');?>
			</td>
		</tr>
		<tr class="bg">
			<td class="first" width="190"><strong>Nama</strong></td>
			<td class="last">
				<div id="nama_operator"><input type="text" name="nama" readonly value="<?php echo $login->nama?>" size="50" /></div>
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
		<tr class="bg">
			<td class="first" width="190"><strong>Status</strong></td>
			<td class="last">
				<select style="float:left" name="status" id="status" onchange="showProdi()">
					<?php for($i=0; $i<count($status); $i++):?>
					<option <?php if($login->status == $status[$i]) echo 'selected'; ?> value="<?php echo $status[$i]?>"><?php echo $status[$i]?></option>
					<?php endfor; ?>
				</select>
				<select id="prodi" style="float:left" name="kodeprodi">
					<option value=""></option>
				<?php foreach($browse_prodi as $bp):?>
					<option <?php if($login->prodi == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
				<?php endforeach; echo "</select>".form_error('kodeprodi');?>
			</td>
		</tr>
		<tr>
			<td class="first"></td>
			<td class="last">
				<?php echo form_submit('cmdSimpan','Simpan','OnClick="setujui()"');?>
				<a href="javascript:void(0)" onclick='show("admin/login/browse_admin","#center-column")'>
					&laquo;Batal
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