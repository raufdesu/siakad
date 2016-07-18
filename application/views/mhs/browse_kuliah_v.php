<script langauge="javascript">
	function post_value(val,val2,val3,val4){
		opener.document.form.kdkuliah.value = val4;
		opener.document.form.sks.value = val3;
		opener.document.form.kdmk.value = val2;
		opener.document.form.nama1.value = val;
		self.close();
	}
</script>
<style>
	*{
		font-size:13px;
	}
</style>
<form name="frm" method=post action=''>
<style media="all" type="text/css">@import "<?php echo base_url();?>	css/design.css";</style>
<div class="top-bar">
	<h1>Daftar Matakuliah</h1>
	<div class="breadcrumbs">
		<?php echo form_open("kuliah/browse");?>
			<input type="text" value="<?php echo $this->session->userdata("sesi_kuliah");?>" name="txtCari" size="30"><?php echo form_submit("cmdCari","Cari");?>
</form>
	</div>
</div><br />
<div class="table">
	<img src="<?php echo base_url();?>images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
	<img src="<?php echo base_url();?>images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
	<table class="listing form" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first" width="5">No.</th>
			<th>Kode Matakuliah</th>
			<th>Nama Matakuliah</th>
			<th class="last" width="20">Pilih</th>
		</tr>
<?php
	$i = $no+1;
	foreach($browse_kuliah as $bm):
?>
		<tr>
			<td class="first"><?php echo $i++;?></td>
			<td class="first"><?php echo $bm->kdkmk;?></td>
			<td class="first"><?php echo $bm->nama1;?></td>
			<td class="first">
				<input type="hidden" value="<?php echo $bm->kdkmk;?>" name="c_id<?php echo $i-1;?>">
				<input type="hidden" value="<?php echo $bm->nama1;?>" name="c_name<?php echo $i-1;?>">
				<input type="hidden" value="<?php echo $bm->sks;?>" name="c_sks<?php echo $i-1;?>">
				<input type="hidden" value="<?php echo $bm->kdkuliah;?>" name="c_kdkuliah<?php echo $i-1;?>">
				<?php
					$x = $i-1;
					$atribut = array(
						"width"	=> "15",
						"height"	=> "15",
						"OnClick"=> "post_value(document.frm.c_name$x.value,document.frm.c_id$x.value,document.frm.c_sks$x.value,document.frm.c_kdkuliah$x.value)"
					);
					echo anchor("#",img("images/design/check.png"),$atribut);
				?>
				<!--<input type="button" value='Submit'
					onclick="post_value(document.frm.c_name</?php echo $i-1;?>.value,document.frm.c_id</?php echo $i-1;?>.value);">-->
			</td>
		</tr>
<?php endforeach;?>
	</table>
<?php echo "<div class='pagination'>".$this->pagination->create_links()." Total Record : <b>".$total_rows."</b></div>";?>
</div>
</form>