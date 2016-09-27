<head>
	<title>Setting SIAKAD</title>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function setujui(){
			showloading();
			this.form.submit();
		}
	</script>
</head>
<div class="top-bar-adm">
	<h1>Setting SIAKAD</h1>
	<div class="breadcrumbs"><a href="#">&nbsp;</a></div>
</div><br />
<div class="select-bar">
</div>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi edit' onclick='show("admin/profil/edit","#center-column")'>&nbsp;Edit</a>
	<h3>Profil Kampus</h3>
</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th style="text-align:left;width: 200px;">Nama Perguruan Tinggi</th>
			<td class="first"><?php echo $pt->nama?></td>
		</tr>
		<tr>
			<th style="text-align:left;width: 200px;">Alamat</th>
			<td class="first"><?php echo $pt->alamat?></td>
		</tr>
		<tr>
			<th style="text-align:left;width: 200px;">No. Telepon</th>
			<td class="first"><?php echo $pt->notelp?></td>
		</tr>
		<tr>
			<th style="text-align:left;width: 200px;">Email</th>
			<td class="first"><?php echo $pt->email?></td>
		</tr>
		<tr>
			<th style="text-align:left;width: 200px;">Website</th>
			<td class="first"><?php echo $pt->website?></td>
		</tr>
		<tr>
			<td style="text-align:left;" colspan="2"><a>Data Dekan</a></td>
		</tr>
		<tr>
			<th style="text-align:left;width: 200px;">NPP/NIM</th>
			<td class="first"><?php
				if(!$pt->nip){
					echo $pt->npp;
				}else{
					echo $pt->nip;
				}
			?></td>
		</tr>
		<tr>
			<th style="text-align:left;">Nama Rektor</th>
			<td class="first">
				<?php echo $pt->namadekan?>
			</td>
		</tr>
	</table>
</div>
<div class="top-bar-adm">
	<a href="javascript:void(0)" class='navi add' onclick='show("admin/simsetting/add","#center-column")'> Tambah</a>
	<h3>Tahun Ajaran</h3>
</div>
<div class="table">
	<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Th. Ajaran</th>
			<th>Aktif</th>
			<th>Tgl. KRS Awal</th>
			<th>Tgl. KRS Akhir</th>
			<th>Tgl. PKRS Awal</th>
			<th>Tgl. PKRS Akhir</th>
			<th>Tgl. KSP Awal</th>
			<th>Tgl. KSP Akhir</th>
			<th class="last">Kelola</th>
		</tr>
<?php
	$i = $no+1;
	$atrib = array(
		"width" => "619", "height" => "435", "screenx" => "340", "screeny" => "30"
	);
	foreach($browse_simsetting as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td><?php echo $bm->thajaran;?></td>
		<td>
			<?php
				if($bm->aktif == 'Aktif'){
					$funct = 'nonactive_all';
				}else{
					$funct = 'active_one/'.$bm->thajaran;
				}
			?>
			<a href="javascript:void(0)" class='sim-active' onclick='show("admin/simsetting/<?php echo $funct;?>","#center-column")'
				title='<?php if($bm->aktif == 'Aktif'){ echo 'Klik Untuk Me-Non Aktifkan'; }else{ echo 'Klik Untuk Meng-Aktifkan'; } ?>'>
				<?php
					if($bm->aktif == 'Aktif'){
						echo img_check();
					}else{
						echo img_off();
					}
				?>
			</a>
		</td>
		<td class="first"><?php echo tgl_indo($bm->tglkrsawal);?></td>
		<td class="first"><?php echo tgl_indo($bm->tglkrsakhir);?></td>
		<td class="first"><?php echo tgl_indo($bm->tglperubahankrsawal);?></td>
		<td class="first"><?php echo tgl_indo($bm->tglperubahankrsakhir);?></td>
		<td class="first"><?php echo tgl_indo($bm->tglkspawal);?></td>
		<td class="first"><?php echo tgl_indo($bm->tglkspakhir);?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='show("admin/simsetting/edit/<?php echo $bm->thajaran?>","#center-column")'>
				<?php echo img('asset/images/design/edit-icon.gif')?>
			</a>
			<a href="javascript:void(0)" onclick='return tanya(<?php echo $bm->thajaran?>)'>
				<?php echo img('asset/images/design/hr.gif')?>
			</a>
		</td>
	</tr>
<?php endforeach;?>
	</table>
<!--</?php echo "<div class='pagination'>".($paging).' Total : '.$total_page."</div>";?>-->
	<!--<div class="top-bar-adm">
		<a href="javascript:void(0)" class='navi add' onclick='show("admin/simsetting/add_tambahan","#center-column")'> Tambah</a>
		<h3>Daftar Tahun Kurikulum</h3>
	</div>-->
	<!--<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Tahun Kurikulum</th>
			<th class="last" width="10">Kelola</th>
		</tr>
		</?php $i=1; foreach($browse_tambahan as $bt):?>
		<tr>
			<td></?php echo $i++;?></td>
			<td></?php echo $bt->thkurikulum?></td>
			<td>
				<a href="javascript:void(0)" onclick='return tanya2(</?php echo $bt->thkurikulum?>)'>
					</?php echo img('asset/images/design/hr.gif')?>
				</a>
			</td>
		</tr>
		</?php endforeach; ?>
	</table>-->
</div>
<script language="javascript">
	function tanya(kodesetting){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simsetting/delete/"+kodesetting,"#center-column");
			return true;
		}else{
			return false;
		}
	}
	function tanya2(thnkurikulum){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")==true){
			show("admin/simsetting/delete_thkurikulum/"+thnkurikulum,"#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>
