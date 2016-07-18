<head>
	<title>Rekapitulasi Aktif Semester</title>
	<script type="text/javascript">
	$(document).ready(function() {
		stoploading();
	})
	</script>
</head>
<a href="javascript:void(0)" class='navi button' onclick='show("admin/simaktifsemester/akumulasi","#center-column")'>
	Refresh
</a>
<div class="top-bar-adm">
	<h1>Rekapitulasi Status Akademik Mahasiswa Per-PRODI</h1>
	<div class="breadcrumbs"><a href="#">Tahun Ajaran <?php echo $this->session->userdata('sesi_thajaran')?></a></div>
</div><br />
<div class="select-bar">
</div>
<div class="table">
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th>PRODI</th>
			<th>Aktif</th>
			<th>Non Aktif</th>
			<th>Cuti</th>
			<th>Keluar</th>
		</tr>
		<tr>
			<?php foreach($browse_prodi as $bp){ ?>
				<tr>
					<th class="right"><?php echo $bp->namaprodi?></th>
					<td>
						<a href="javascript:void(0)" class='jum-status' onclick='show("admin/simaktifsemester/index_statussemester/<?php echo $bp->kodeprodi?>/Aktif","#center-column")'>
							<?php echo $this->simaktifsemester_m->get_jumstatus($bp->kodeprodi, $thajaran, 'Aktif');?></a>
						</td>
					<td>
						<a href="javascript:void(0)" class='jum-status' onclick='show("admin/simaktifsemester/index_statussemester/<?php echo $bp->kodeprodi?>/Non aktif","#center-column")'>
							<?php echo $this->simaktifsemester_m->get_jumstatus($bp->kodeprodi, $thajaran, 'Non Aktif');?></a>
						</td>
					</td>
					<td>
						<a href="javascript:void(0)" class='jum-status' onclick='show("admin/simaktifsemester/index_statussemester/<?php echo $bp->kodeprodi?>/Cuti","#center-column")'>
							<?php echo $this->simaktifsemester_m->get_jumstatus($bp->kodeprodi, $thajaran, 'Cuti');?></a>
						</td>
					</td>
					<td>
						<a href="javascript:void(0)" class='jum-status' onclick='show("admin/simaktifsemester/index_statussemester/<?php echo $bp->kodeprodi?>/Keluar","#center-column")'>
							<?php echo $this->simaktifsemester_m->get_jumstatus($bp->kodeprodi, $thajaran, 'Keluar');?></a>
						</td>
					</td>
				</tr>
			<?php } ?>
		</tr>
	</table>
</div>