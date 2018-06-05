<head>
	<title>Daftar Mahasiswa</title>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function setujui(){
			showloading();
		}
		function ChangeStatusTugas(){
			showloading();
			var selected_status = $('select[name=status]').val();
			load('admin/simaktifsemester/change_status/'+selected_status,'#center-column');
		}
		function submitChangeStatus(){
			showloading()
			var selected_status = $('select[name=status]').val();
			load('admin/simaktifsemester/change_status/'+selected_status,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<div style="float:right;margin-right:-32px">
		<a href="javascript:void(0)" class='button' onclick='show("admin/simaktifsemester/input","#center-column")'>Input</a>
		<a href="javascript:void(0)" class='button' onclick='show("admin/simaktifsemester/akumulasi","#center-column")'>Rekapitulasi</a>
	</div>
	<h1>Mahasiswa Aktif Semester</h1>
	<div class="breadcrumbs"><a href="javascript:void(0)">Penstatusan Mahasiswa Tahun Ajaran <?php echo $thajaran;?></a></div>
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
			<th width='65'>Angkatan</th>
			<?php if($this->session->userdata('sesi_user') == 'admin' || $this->session->userdata('sesi_status') == 'keuangan'){ ?>
			<!--<th width="85">Tugas</th>-->
			<th width='110'>Status</th>
			<th class="last" width='35'><center>#</center></th>
			<?php } ?>
		</tr>
<?php
	$i = $no+1;
	foreach($browse_masmahasiswa as $bm):
	$nomor = $i++;
	if($nomor % 2 == 0){
		$bg = 'bg';
	}else{
		$bg = '';
	}
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $nomor.'. ';?></td>
		<td><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->nama;?></td>
		<td><?php echo $bm->angkatan;?></td>
		<?php if($this->session->userdata('sesi_user') == 'admin' || $this->session->userdata('sesi_status') == 'keuangan'){ ?>
		<td>
			<?php
				if($bm->status == 'Aktif') $aktif = 'active'; else $aktif = '';
				if($bm->status == 'Cuti') $cuti = 'active'; else $cuti = '';
				if($bm->status == 'Non Aktif') $non_aktif = 'active'; else $non_aktif = '';
				if($bm->status == 'Keluar') $keluar = 'active'; else $keluar = '';
				if($bm->status == '-') $normal = 'active'; else $normal = '';
			?>
			<a href="javascript:void(0)" class='ring <?php echo $aktif?>' <?php if(!$aktif == 'active'){ ?> onclick='tanya("<?php echo $bm->nim?>","Aktif")' <?php } ?>>A</a>
			<a href="javascript:void(0)" class='ring <?php echo $cuti?>' <?php if(!$cuti == 'active'){ ?> onclick='tanya("<?php echo $bm->nim?>","Cuti")' <?php } ?>>C</a>
			<a href="javascript:void(0)" class='ring <?php echo $non_aktif?>' <?php if(!$non_aktif == 'active'){ ?> onclick='tanya("<?php echo $bm->nim?>","Non Aktif")' <?php } ?>>N</a>
			<a href="javascript:void(0)" class='ring <?php echo $keluar?>' <?php if(!$keluar == 'active'){ ?> onclick='tanya("<?php echo $bm->nim?>","Keluar")' <?php } ?>>K</a>
			<a href="javascript:void(0)" class='ring <?php echo $normal?>' <?php if(!$normal == 'active'){ ?> onclick='tanya("<?php echo $bm->nim?>","-")' <?php } ?>>-</a>
		</td>
		<td class="last" style="text-align:center">
			<a href="javascript:void(0)" onclick='return tanyahapus("<?php echo $bm->nim?>", "<?php echo $bm->thajaran?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
		<?php } ?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(nim, status){
		if(confirm("KONFIRMASI\nTekan OK Untuk Menjadikan Status "+status+" Untuk Bagi "+nim)==true){
			show("admin/simaktifsemester/status/"+nim+"/"+status,"#center-column");
			return true;
		}else{
			return false;
		}
	}
	function tanyahapus(nim, thajaran){
		if(confirm("KONFIRMASI\nTekan OK untuk penghapusan data\nmahasiswa dengan NIM : "+nim)==true){
			show("admin/simaktifsemester/hapus/"+nim+"/"+thajaran, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>