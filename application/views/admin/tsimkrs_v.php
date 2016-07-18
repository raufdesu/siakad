<head>
	<title>Daftar Mahasiswa</title>
	<script>
		$(document).ready(function(){ stoploading(); });
		function setujui(){
			showloading();
			// this.pilih.submit();
		}
		function submitChangeProdi(){
			showloading();
			var selected_prodi = $('select[name=prodi]').val();
			load('admin/simkrs/pilih_prodi/'+selected_prodi,'#center-column');
		}
	</script>
</head>
	<!--<a href="javascript:void(0)" class='navi button' onclick='show("admin/simaktifsemester/akumulasi","#center-column")'>
		Rekapitulasi
	</a>-->
<div class="top-bar-adm">
	<h1>Daftar Mahasiswa KRS</h1>
	<div class="breadcrumbs"><a href="javascript:void(0)">
	<?php echo 'Tahun Ajaran '.thakademik($thajaran) ?>
	<?php echo 'Semester '.semester($thajaran);?></a></div>
</div><br />
<div class="select-bar">
	<select name='prodi' id='prodi' style='float:right; width:180px;' onchange='submitChangeProdi()'>
		<option <?php if($this->session->userdata('sesi_prodi') == '') echo 'selected'; ?> value="">
			Pilih PRODI
		</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($this->session->userdata('sesi_prodi') == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/simkrs/index_listview'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'simaktifsemester', 'type'=>'post'));
	echo "<label>".form_input("cari_mhs",$this->session->userdata("sesi_carimhs"),'size=30')."</label>";
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
			<th>Angkatan</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_mhskrs->result() as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td><?php echo $bm->nim;?></td>
		<td class="first">
		<a href="javascript:void(0)" onclick='show("admin/simkrs/detail_krs/<?php echo $bm->nim?>","#center-column")'>
		<?php echo $bm->nama;?></a>
		</td>
		<td><?php echo $bm->angkatan?></td>
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
