<script type="text/javascript">
$(document).ready(function() {
	$("#form").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
<div class="select-bar">
	<h3>Tahun Akademik XXX Semester XXX</h3>
	Hubungi dosen pembimbing anda untuk menentukan matakuliah apa saja yang akan
	anda ambil pada semester ini.
</div>
<?php
	$atrform = array(
		"id" => "form",
		"name" => "form"
	);
	echo form_open("mhs/peserta/simpan",$atrform);
?>
<div class="table">
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<td class="first">Kode Matakuliah</td>
		<td class="last">
			<input type="text" name="kdmk" readonly class="required" title="Masukkan Kode Matakuliah" size="8"/>
			<?php
				$atrib = array(
					"width"	=> 625,
					"height"	=> 615,
					"screenx"=> 300,
					"screeny"=> 20
				);
				echo anchor_popup("mhs/kuliah/browse/kuliah",form_button("#","..."),$atrib);
				echo "<font color='red' size='2'> ".$this->uri->segment(4)."</font>";
			?>
		</td>
	</tr>
	<tr class="bg">
		<td class="first">Nama Matakuliah</td>
		<td class="last">
			<input type="text" readonly name="nama1" size="50"/>
		</td>
	</tr>
	<tr>
		<td class="first">SKS</td>
		<td class="last">
			<input type="text" size="1" name="sks" readonly />SKS
			<input type="hidden" name="kdkuliah">
			<input type="hidden" name="nilai" value="E">
		</td>
	</tr>
	<tr class="bg">
		<td>&nbsp;</td>
		<td class="first"><input type="submit" value="Simpan">&nbsp;<input type="reset" value="Batal"></td>
	</tr>
</table>
</div>
<?php
	echo form_close();
	echo $this->load->view("mhs/tKrs_v");
?>