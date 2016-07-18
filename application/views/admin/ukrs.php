<img src="<?php echo base_url();?>asset/images/design/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="<?php echo base_url();?>asset/images/design/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class='first' style='text-align:center'>No</th><th>Kode</th>
		<th>Nama Matakuliah</th><th>SKS</th><th class='last' style='text-align:center'>Del</th>
	</tr>
	
<?php $i=1; $no=1; foreach($this->cart->contents() as $items): ?>
	<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
	<tr>
	  <td><?php echo $no++.'.';?></td>
	  <td><?php echo $items['id']?></td>
	  <td class='first'><?php echo $items['name']; ?></td>
	  <td><?php echo $items['qty']; ?></td>
	  <td>
		<a href="javascript:void(0)" onclick='show("admin/simkrs/delete/<?php echo $items['rowid']?>","#center-column")'>
			<?php echo img('asset/images/design/hr.gif')?>
		</a>
		</td>
	</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>
<div class='panel'>
	<input type='button' value='Copy ke'/>
	<input type='button' value='KHS'/>
	<input type='button' value='Hapus'/>
	<input type='button' value='Copy ke'/>
	&nbsp; &nbsp; <strong> &nbsp; Nama DPA</strong> <input type='text' value='Momon Muzakkar, S.T' readonly size='42'/>
	<input type='button' value='Cetak'/>
</div>