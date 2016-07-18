<head>
	<title>Daftar Matakuliah dan Kurikulum</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){ showloading(); }
		function submitChangeKurikulum(){
			var selected_kurikulum = $('select[name=thkurikulum]').val();
			load('admin/simkurikulum/thn_kurikulum/'+selected_kurikulum,'#center-column');
		}
	</script>
</head>
<div class="table" style="margin-top:5px">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing" style="width:723px;" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first"><center>Kode MK</center></th>
			<th>Nama Matakuliah</th>
			<th>SKS</th>
			<th style="width:10px !important" class="last">Pilih</th>
		</tr>
<?php
	foreach($browse_matkul->result() as $bm):
?>
	<tr>
		<td class="first">&nbsp;<?php echo $bm->kodemk;?></td>
		<td class="first"><?php echo $bm->namamk?></td>
		<td class="center"><?php echo $bm->sks;?></td>
		<td>
			<a href="javascript:void(0)" onclick='show("admin/nilai/pilih_matakuliah/<?php echo $bm->kodemk?>","#center-column")'>
			<?php echo img_check();?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
</div>
<script language="javascript">
	function tanya(kodemk){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simkurikulum/delete/"+kodemk,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
