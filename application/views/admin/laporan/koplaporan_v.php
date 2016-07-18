<table id="kartu_header" style="margin-bottom:-10px" width="100%">
	<tr>
		<td style="width:auto">
			<img src="<?php echo base_url()?>asset/images/design/logo-laporan.png" style="width:105px;height:auto;" />
		</td>
		<td class="header" align="center">
			<div style="font-size:18px;font-family:'Times New Roman';font-weight:bold;padding-left:0px;">
			UNIVERSITAS MUHAMMADIYAH MATARAM<br />
			FAKULTAS <?php echo strtoupper($namafakultas)?></div>
			<?php if($this->uri->segment(3) != 'cetakpresensi'){ ?>
			<b style="font-size:12px">Kampus I : Jln. KH. Ahmad Dahlan No. 1 Telp. (0370)633723 Fax. (0370)641906 Mataram<br />
			Kampus II : Jl. Raya Praya - Mantang KM 5,5 Telp. (0370)6610120, Penaban Praya
			<?php } ?>
			<i><br />Website : http://www.ummat.ac.id, e-mail : um_mataram@ummat.ac.id,</i><br />Mataram, Nusa Tenggara Barat</b>
		</td>
	</tr>
	<tr>
		<th style="height:1px;border-top:5px double #000" colspan="2"></th>
	</tr>
</table>