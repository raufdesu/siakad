<style>
    #konfirmasi{
        border: 1px solid red; padding: 5px;
    }
    .nama td{
        border:none !important;
        border-bottom: 1px solid #ABABAB !important;
    }
    td #label{
        color: #ABABAB;
        width: 182px !important;
        border-right: 1px solid #ABABAB !important;
    }
</style>
<div class="nama">
<table>
<tr>
    <td id="label" class="first" width="190"><strong>Nama Mahasiswa</strong></td>
    <td class="last">
        <input type="text" readonly value="<?php echo $nama?>" size="35" />
    </td>
</tr>
<tr>
    <td id="label" class="first" width="190"><strong>PRODI</strong></td>
    <td class="last">
        <input type="text" readonly value="<?php echo $prodi?>" size="60" />
    </td>
</tr>
<tr>
    <td id="label" class="first" width="190"><strong>Tagihan</strong></td>
    <td class="last">
        Rp. <input type="text" name='totalbayar' readonly value="<?php echo $totalbiaya?>" size="10" />,00
    </td>
</tr>
<?php if($status != 'Lunas'): ?>
<tr>
    <td id="label" class="first" width="190"><strong>Sudah Dibayar</strong></td>
    <td class="last">
        Rp. <input type="text" name='lastjumbayar' readonly value="<?php echo $jumbayar?>" size="10" />,00
    </td>
</tr>
<tr>
    <td id="label" class="first" width="190"><strong>Kekurangan</strong></td>
    <td class="last">
		<?php $kekurangan = $totalbiaya-$jumbayar; ?>
        Rp. <input type="text" name='kekurangan' id='kekurangan' readonly value="<?php echo $kekurangan?>" size="10" />,00
		<?php echo ' &nbsp; &nbsp; <font color="red">'.$status.'</font>'; ?>
    </td>
</tr>
<tr class="bg">
	<td class="first" width="190"><strong>Jumlah Pembayaran</strong></td>
	<td class="last">
		Rp. <input type="text" value="<?php echo $this->input->post('jumbayar')?>" id="jumbayar" name="jumbayar" size="10" />,00
		<?php echo form_error('jumbayar');?>
	</td>
</tr>
<tr class="bg">
	<td class="first" width="190"><strong>Keterangan</strong></td>
	<td class="last">
		<textarea name="keterangan" cols="55" rows="1"><?php echo $this->input->post('keterangan')?></textarea>
		<?php echo form_error('keterangan');?>
	</td>
</tr>
<?php endif ?>
</table>
<?php if($konfirmasi):?>
<div id="konfirmasi"><?php echo $konfirmasi?></div><input type="hidden" id="konfirmasi" value="<?php echo $konfirmasi?>" />
<?php endif ?>
</div>