<head>
	<title>Daftar Calon Mahasiswa</title>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/kartu/style.css" type="text/css" media="print"/>
	<script>
		function submitChangeStatus(){
			var selected_prodi = $('select[name=prodi]').val();
			load('admin/simcalonmhs/change_keuprodi/'+selected_prodi,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<!--<div style="float: right"></?php echo anchor('admin/simcalonmhs/cetak_absen','Print Absen',array('class'=>'print-button','target'=>'_blank'));?></div>-->
<!--<a href="javascript:void(0)" class='navi add' onclick='show("admin/masmahasiswa/add","#center-column")'> Tambah</a>-->
	<h1>Data Calon Mahasiswa <?php echo date('Y')?></h1>
	<div class="breadcrumbs"><a href="#">Yang Diterima dan Belum Registrasi (On PMB Online)</a></div>
</div><br />
<div class="select-bar">
	<select name='prodi' id='prodi' style="width: 220px !important" class='obj-right' onchange='submitChangeStatus()'>
		<option <?php if($this->session->userdata('sesi_prodicalonmhs') == '') echo 'selected'; ?> value="">Pilih PRODI</option>
		<?php foreach($browse_prodi as $bp):?>
			<option <?php if($this->session->userdata('sesi_prodicalonmhs') == $bp->prefkodeprodi) echo 'selected'; ?> value="<?php echo $bp->prefkodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach ?>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simcalonmhs/cari_bayarcalonmhs'), 'update'=>'#center-column', 'name'=>'pilih', 'id'=>'masmahasiswa',	'type'=>'post'));
	echo "<label>".form_input("txtCari", $cari, 'size=30')."</label>";
	echo "<label>".form_submit("cmdCari", "Cari", "class='search'")."</label>";
	echo form_close();
?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simcalonmhs/simpan_nim'), 'update'=>'#save', 'name'=>'pilih', 'id'=>'masmahasiswa',	'type'=>'post'));
?>
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Online</th>
			<th>No. Registrasi</th>
			<th>Nama Calon Mahasiswa</th>
			<th style="width:88px">NIM</th>
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th style="width:52px;" class="last">Kelola</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	$que = mysql_query($sql);
	while($bm = mysql_fetch_array($que)):
	$x = $i++;
?>
	<tr>
		<td class="first"><?php echo $x.'.';?></td>
		<td class="first"><?php echo $bm['no_daftar'];?></td>
		<td class="first"><?php echo 'MB'.$bm['no_registrasi'];?></td>
		<td class="first"><?php echo $bm['nama'];?></td>
		<td class="first"><?php echo $bm['nim']?></td>
		<td class="first">
			<!--<a href="javascript:void(0)" onclick='show("admin/simcalonmhs/edit/</?php echo $bm['no_daftar']?>","#center-column")'>
				</?php echo img('asset/images/design/edit-icon.gif')?>
			</a>-->
			<?php if($bm['status'] != '1'){ ?>
			<a href="javascript:void(0)" onclick='load_into_box("admin/simcalonmhs/detail/<?php echo $bm['no_daftar']?>");'>
				<?php echo img('asset/images/design/detail.gif')?>
			</a>
			<?php }else{ ?>
			<a href="javascript:void(0)" onclick='load_into_box("admin/simcalonmhs/detail/<?php echo $bm['no_daftar']?>");'>
				<?php echo img('asset/images/design/detail.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='show("admin/simcalonmhs/detail_setuju/<?php echo $bm['no_daftar']?>","#center-column");'>
				<?php echo img('asset/images/design/check.png.')?>
			</a>
			<?php } ?>
		</td>
	</tr>
<?php
	echo form_hidden('n', $x);
	endwhile;
?>
	</table>
	</form>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div><div id="save"></div>
<script language="javascript">
	function tanya(nim){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simcalonmhs/delete/"+nim,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
