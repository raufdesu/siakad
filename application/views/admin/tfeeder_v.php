<head>
	<title>Daftar Mahasiswa</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading();
			// this.pilih.submit();
		}
	</script>
</head>

<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Username</th>
			<th>URL</th>
			<th>Port</th>
			<th>ID Perguruan Tinggi</th>
			<th>Live</th>
			<th>Status</th>
			<th>Edit</th>
		</tr>
<?php
	foreach($browse_user as $bm):
?>
	<tr>
		<td class="first"><?php echo $bm->id;?></td>
		<td class="first"><?php echo $bm->username;?></td>
		<td class="first"><?php echo $bm->url;?></td>
		<td class="first"><?php echo $bm->port;?></td>
		<td class="first"><?php echo $bm->id_sp;?></td>
		<td class="first"><?php echo $bm->live;?></td>
		<td class="first"><?php echo $bm->status_connected;?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/feeder/edit/<?php echo $bm->id?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
		</td>
		<?php endif ?>
	</tr>
<?php endforeach;?>
	</table>
</div>
