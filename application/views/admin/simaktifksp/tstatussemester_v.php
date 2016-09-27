<head>
	<title>Daftar Mahasiswa</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading();
			// this.pilih.submit();
		}
		function submitChangeStatus(){
			showloading()
			var selected_status = $('select[name=status]').val();
			load('admin/simaktifsemester/change_status/'+selected_status,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<div style="float:right;margin:5px -32px 0 0">
	<a href="javascript:void(0)" class='button' onclick='show("admin/simaktifsemester/akumulasi","#center-column")'>
		Rekapitulasi</a>
	</div>
	<h1>Data Mahasiswa Aktif Semester</h1>
	<div class="breadcrumbs"><a href="javascript:void(0)">Data Mahasiswa Tahun Ajaran <?php echo $thajaran;?></a></div>
</div><br />
<div class="select-bar">
	<select name='status' id='status' class='obj-right' onchange='submitChangeStatus()'>
		<option <?php if($this->session->userdata('sesi_statussem') == '') echo 'selected'; ?> value="">Pilih Status</option>
		<option <?php if($this->session->userdata('sesi_statussem') == 'Aktif') echo 'selected'; ?> value="Aktif">Aktif</option>
		<option <?php if($this->session->userdata('sesi_statussem') == 'Cuti') echo 'selected'; ?> value="Cuti">Cuti</option>
		<option <?php if($this->session->userdata('sesi_statussem') == 'Non Aktif') echo 'selected'; ?> value="Non Aktif">Non Aktif</option>
		<option <?php if($this->session->userdata('sesi_statussem') == 'Keluar') echo 'selected'; ?> value="Keluar">Keluar</option>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simaktifsemester/cari'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'simaktifsemester', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("cari_simaktifsemester"),'size=30')."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();
?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th width='90'>NIM</th>
			<th>Nama Mahasiswa</th>
			<th width='75'>PRODI</th>
			<!--<th>Status</th>-->
			<?php if($this->session->userdata('sesi_user') == 'admin'): ?>
			<th class="last" width='110'>Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_statusmhs as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td><?php echo inisial($bm->nama_prodi);?></td>
		<!--<td class="first"></?php echo $bm->status;?></td>-->
		<?php if($this->session->userdata('sesi_user') == 'admin'): ?>
		<td class="last">
			<?php
				if($bm->status == 'Aktif') $aktif = 'active'; else $aktif = '';
				if($bm->status == 'Cuti') $cuti = 'active'; else $cuti = '';
				if($bm->status == 'Non Aktif') $non_aktif = 'active'; else $non_aktif = '';
				if($bm->status == 'Keluar') $keluar = 'active'; else $keluar = '';
			?>
			<a href="javascript:void(0)" class='ring <?php echo $aktif?>' onclick='tanya("<?php echo $bm->nim?>","Aktif")'>A</a>
			<a href="javascript:void(0)" class='ring <?php echo $cuti?>' onclick='tanya("<?php echo $bm->nim?>","Cuti")'>C</a>
			<a href="javascript:void(0)" class='ring <?php echo $non_aktif?>' onclick='tanya("<?php echo $bm->nim?>","Non Aktif")'>N</a>
			<a href="javascript:void(0)" class='ring <?php echo $keluar?>' onclick='tanya("<?php echo $bm->nim?>","Keluar")'>K</a>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(nim,status){
		if(confirm("KONFIRMASI\nTekan OK Untuk Menjadikan Status "+status+" Untuk Bagi "+nim)==true){
			show("admin/simaktifsemester/status/"+nim+"/"+status,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
