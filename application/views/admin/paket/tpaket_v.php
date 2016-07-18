<head>
	<script>
		$(document).ready(function(){
			stoploading();
		});
		function setujui(){
			showloading();
		}
		function ChangeProdi(){
			showloading();
			var selected_prodi = $('select[name=prodi]').val();
			load('admin/paket/change_prodi/'+selected_prodi,'#center-column');
		}
		function ChangeAngkatan(){
			showloading();
			var selected_angkatan = $('select[name=angkatan]').val();
			load('admin/paket/change_angkatan/'+selected_angkatan,'#center-column');
		}
		function ChangeKelas(){
			showloading();
			var selected_kelas = $('select[name=kelas]').val();
			load('admin/paket/change_kelas/'+selected_kelas,'#center-column');
		}
		function ChangeThAjaran(){
			showloading()
			var selected_thajaran = $('select[name=thajaran]').val();
			load('admin/paket/change_thajaran/'+selected_thajaran,'#center-column');
		}
	</script>
</head>
<div class="top-bar-adm">
	<div style="float:right;margin:5px -32px 0">
	<?php if($this->session->userdata('sesi_user') == 'admin'):?>
	<a href="javascript:void(0)" class='button' onclick='show("admin/paket/add","#center-column")'> Tambah</a>
	<?php endif?>
	<!--</?php echo anchor('admin/paket/cetak', 'Excel', array('class'=>'button'))?>-->
	</div>
	<h1>Data Matakuliah Paket</h1>
	<div class="breadcrumbs">Penentuan matakuliah paket
	<!--<select name='statusakademik' onchange='submitChangeStatus()'>
		<option </?php if($this->session->userdata('sesi_statusakademik') == '') echo 'selected'; ?> value="">Semua</option>
		<option </?php if($this->session->userdata('sesi_statusakademik') == 'Belum Lulus') echo 'selected'; ?> value="Belum Lulus">Belum Lulus</option>
		<option </?php if($this->session->userdata('sesi_statusakademik') == 'Lulus') echo 'selected'; ?> value="Lulus">Lulus</option>
		<option </?php if($this->session->userdata('sesi_statusakademik') == 'Keluar') echo 'selected'; ?> value="Keluar">Keluar</option>
	</select>-->
	<a href="#">
	<?php //echo $this->auth->get_namaprodi($this->session->userdata('sesi_prodipaket'))?>
	</a></div>
</div>
<div class="select-bar">
	<select name='thajaran' style="width:auto !important" class='obj-right' onchange='ChangeThAjaran()'>
		<option <?php if($this->session->userdata('sesi_thajaranpaket') == '') echo 'selected'; ?> value="">Thajaran</option>
		<?php foreach($browse_thajaran as $ta){ ?>
		<option <?php if($this->session->userdata('sesi_thajaranpaket') == $ta->thajaran) echo 'selected'; ?> value="<?php echo $ta->thajaran?>"><?php echo $ta->thajaran?></option>
		<?php } ?>
	</select>
	<select name='kelas' style="width:100px !important" class='obj-right' onchange='ChangeKelas()'>
		<option <?php if($this->session->userdata('sesi_kelaspaket') == '') echo 'selected'; ?> value="">Semua Kelas</option>
		<option <?php if($this->session->userdata('sesi_kelaspaket') == '1') echo 'selected'; ?> value="1">Kelas Pagi</option>
		<option <?php if($this->session->userdata('sesi_kelaspaket') == '2') echo 'selected'; ?> value="2">Kelas Sore</option>
	</select>
	<select name='angkatan' style="width:68px !important" class='obj-right' onchange='ChangeAngkatan()'>
		<option <?php if($this->session->userdata('sesi_angkatanpaket') == '') echo 'selected'; ?> value="">Semua</option>
		<?php foreach($browse_angkatan as $ba):?>
		<option <?php if($this->session->userdata('sesi_angkatanpaket') == $ba->angkatan) echo 'selected'; ?> value="<?php echo $ba->angkatan?>"><?php echo $ba->angkatan?></option>
		<?php endforeach; ?>
	</select>
	<select name='prodi' style="width:180px !important;" class='obj-right' onchange='ChangeProdi()'>
		<option <?php if($this->session->userdata('sesi_prodipaket') == '') echo 'selected'; ?> value="">Prodi Keseluruhan</option>
		<?php foreach($browse_prodi as $bp):?>
		<option <?php if($this->session->userdata('sesi_prodipaket') == $bp->kodeprodi) echo 'selected'; ?> value="<?php echo $bp->kodeprodi?>"><?php echo $bp->namaprodi?></option>
		<?php endforeach; ?>
	</select>
<?php
	echo $this->pquery->form_remote_tag(array(
	'url'=>site_url('admin/paket/cari_paket'), 'update'=>'#center-column', 'name'=>'cari', 'id'=>'paket', 'type'=>'post'));
	echo "<label>".form_input("txtCari",$this->session->userdata("sesi_caripaket"),'size=30')."</label>";
	echo "<label>".form_submit("cmdCari","Cari","OnClick='setujui()' class='search'")."</label>";
	echo form_close();
?>
</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Kode MK</th>
			<th>Kode Matakuliah</th>
			<th>SKS</th>
			<th>PRODI</th>
			<th>Angkatan</th>
			<?php if($this->session->userdata('sesi_status') == 'admin'):?>
			<th class="last" style="width:15px">#</th>
			<?php endif ?>
		</tr>
<?php
	$i = $no+1;
	foreach($browse_paket as $bm):
?>
	<tr>
		<td class="first"><?php echo $i++.'.';?></td>
		<td class="first"><?php echo $bm->kodemk;?></td>
		<td class="first">
			<a href="javascript:void(0)" onclick='load_into_box("admin/simkurikulum/popdetail/<?php echo $bm->kodemk?>")'>
			<?php echo $bm->namamk?></a>
		</td>
		<td><?php echo $bm->sks;?></td>
		<td class="first"><?php echo $bm->namaprodi;?></td>
		<td><?php echo $bm->angkatan;?></td>
		<?php if($this->session->userdata('sesi_status') == 'admin'):?>
		<td class="first">
			<a href="javascript:void(0)" onclick='return tanya("<?php echo $bm->idpaket?>", "<?php echo $bm->iddetpaket?>")'>
				<?php echo img('asset/images/design/hr.gif')?></a>
		</td>
		<?php endif ?>
	</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".($paging)."</div><div class='total-rows'> Total : ".$total_page."</div>";?>
</div>
<script language="javascript">
	function tanya(idpaket, iddetpaket){
		if(confirm("KONFIRMASI\nTekan OK Untuk Melanjutkan Penghapusan Data Terpilih")){
			show("admin/paket/delete/"+idpaket+"/"+iddetpaket, "#center-column");
			return true;
		}else{
			return false;
		}
	}
</script>