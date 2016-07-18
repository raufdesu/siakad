<head>
	<title>Daftar Dosen Pengampu Matakuliah</title>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function changeAngkatan(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('admin/simdosenwali/change_angkatan/'+selected_angkatan, '#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<div style='float:right;margin:3px -32px 0'>
		<a href='javascript:void(0)' class='button' onclick='load_into_box("admin/simdosenwali/add")'>Tambah</a>
		<a href='javascript:void(0)' class='button' onclick='show("admin/simdosenwali", "#center-column")'>&laquo; Back</a>
	</div>
	<h1><?php echo $dosen['nama'].'('.$dosen['npp'].')'; ?></h1>
	<div class="breadcrumbs"><a href="#">Daftar Mahasiswa - Penasehat Akademik</a></div>
</div>
<div class="select-bar">
	<div style="float:right;">
	Angkatan <select name="angkatan" style="width:60px" onchange='changeAngkatan()'>
		<?php foreach($browse_angkatan as $ba){ ?>
		<option <?php if($angkatan == $ba->angkatan) echo 'selected'?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
		<?php } ?>
	</select>
	</div>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simdosenwali/cari_mhspa'), 'update'=>'#center-column',	'name'=>'cari',	'id'=>'maspegawai',	'type'=>'post'));
	echo "<label>".form_input("txtCari", $this->session->userdata("sesi_carimhspa"))."</label>";
	echo "<label>".form_submit("cmdCari", "Cari", "OnClick='showloading()' class='search'")."</label>";
	echo form_close();?>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>NIM</th>
			<th>Nama Mahasiswa</th>
			<th>Angkatan</th>
			<th style="width:22px;" class="last">#</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_mahasiswa->result() as $bm):
	$x = $i++;
	if($x % 2 == 0){
		$bg = '';
	}else{
		$bg = 'bg';
	}
?>
	<tr class="<?php echo $bg?>">
		<td class="first"><?php echo $x.'.';?></td>
		<td class="first"><?php echo $bm->nim;?></td>
		<td class="first"><?php echo $bm->namamhs; ?></td>
		<td class="first"><?php echo $bm->angkatan;?></td>
		<td class="last">
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->nim?>", "<?php echo $bm->thajaran?>")'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(nim, thajaran){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih") == true){
			show("admin/simdosenwali/delete/"+nim+"/"+thajaran, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
