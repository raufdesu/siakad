<table id="kartu_header" style="margin-bottom:-10px" width="100%">
	<tr>
		<td width="50">
			<img src="<?php echo base_url()?>asset/images/design/logo-laporan.png" />
		</td>
		<td class="header" align="center">
			<div style="font-size:17px;font-family:'Times New Roman';font-weight:bold;padding-left:0px;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br />
			UNIVERSITAS MUHAMMADIYAH MATARAM<br />
			FAKULTAS <?php echo strtoupper($namafakultas)?></div>
			<?php if($this->uri->segment(3) != 'cetakpresensi'){ ?>SK KEMENDIKNAS RI. NOMOR 84/D/O//2001<br /><?php } ?>
			<i>Mataram, Nusa Tenggara Barat</i>
		</td>
	</tr>
	<tr>
		<th style="height:1px;border-top:5px double #000" colspan="2"></th>
	</tr>
</table>