<ul id="top-navigation" class="tabs">
	<li class=""><span><span>
		<a href="javascript:void(0)" onclick='show("admin/main/home","#center-column")'>Home</a>
	</span></span></li>
	<?php
		if($this->session->userdata('sesi_status') == 'admin' || $this->session->userdata('sesi_status') == 'dosen' || $this->session->userdata('sesi_status') == 'keuangan'){
			foreach($menu as $mn){
	?>
	<li class=""><span><span>
		<a href="javascript:void(0)" onclick='show("admin/<?php echo $mn->alamat?>","#center-column")'><?php echo $mn->nama?></a>
	</span></span></li>
	<?php
			}
		}elseif($this->session->userdata('sesi_status') == 'prodi'){
	?>
	<li class="">
		<span><span>
			<a href="javascript:void(0)" onclick='show("prodi/maspegawai","#center-column")'>Dosen dan Pegawai</a>
		</span></span>
	</li>
	<li class="">
		<span><span>
			<a href="javascript:void(0)" onclick='show("prodi/simkurikulum","#center-column")'>Kurikulum</a>
		</span></span>
	</li>
	<li class="">
		<span><span>
			<a href="javascript:void(0)" onclick='show("prodi/masmahasiswa","#center-column")'>Mahasiswa</a>
		</span></span>
	</li>
	<li class="">
		<span><span>
			<a href="javascript:void(0)" onclick='show("prodi/simprodi","#center-column")'>Prodi</a>
		</span></span>
	</li>
	<?php
		}
	?>
</ul>
<div id="loading"></div>
