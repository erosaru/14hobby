
<script src="<?= base_url();?>asset/bootstrap/js/wysiwyg/wysihtml5-0.3.0.js"></script>
<script src="<?= base_url();?>asset/bootstrap/js/wysiwyg/bootstrap-wysihtml5.js"></script>
<link href="<?= base_url();?>asset/bootstrap/css/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet">
<link href="<?= base_url();?>asset/bootstrap/css/wysiwyg/wysiwyg-color.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/bootstrap/css/jquery.raty.css" media="screen">
<script src="<?php echo base_url() ?>asset/bootstrap/js/jquery.raty.js"></script>
<script src="<?php echo base_url() ?>asset/bootstrap/js/labs.js"></script>

<style>
	.form-inline label{
		min-width:150px;
	}
</style>

<div class="col-md-8">
	<div class="form-inline">
		<label class="control-label text-primary">Profile Seller</label>
	</div>
	<div class="form-inline">
		<label>Seller</label>
		: <?= !empty($data[0]->name_merchant) ? $data[0]->name_merchant : trim($data[0]->first_name." ".$data[0]->last_name)?>
	</div>
	<div class="form-inline">
		<label>Alamat</label>
		: <?= $data[0]->address;?>
	</div>
	<div class="form-inline">
		<label>Kota</label>
		: <?= $data[0]->city;?>
	</div>
	<div class="form-inline">
		<label>Provinsi</label>
		: <?= $data[0]->province;?>
	</div>
	<div class="form-inline">
		<label>Telepon</label>
		: <?= $data[0]->phone;?>
	</div>
	<div class="form-inline">
		<label>Keterangan</label>
		: <?= $data[0]->deskripsi;?>
	</div>
	<div class="form-inline">
		<label class="control-label text-primary">Status Penjualan Seller</label>
	</div>
	<div class="form-inline">
		<label>Jumlah Order</label>
		: <?= $all_order;?>
	</div>
	<div class="form-inline">
		<label>Order Berhasil</label>
		: <?= $success_order;?>
	</div>
	<div class="form-inline">
		<label>Kepercayaan</label>
		: <span id="rating"></span>
		<!--
		<?if($all_order == 0):?>
			(100 %)
		<?else:?>
			(<?= $success_order / $all_order * 100?> %)
		<?endif?>
		-->
	</div>
	<?if(count($payment_bank) > 0):?>
		<div class="form-inline">
			<label class="control-label text-primary">Pembayaran melalui:</label>
		</div>
		<div class="form-inline">
			<table class="table table-bordered">
				<tr >
					<th>Bank</th>
					<th>No Rekening</th>
					<th>Nama</th>
				</tr>
				<?foreach($payment_bank as $row):?>
					<tr >
						<td class="text-center"><img src="<?=base_url()?>uploads/bank/<?= $row->picture?>" alt="<?= $row->bank_name?>"></td>
						<td class="text-center" style="vertical-align:middle;"><?= $row->bank_account_number?></td>
						<td class="text-center" style="vertical-align:middle;"><?= $row->bank_account?></td>
					</tr>
				<?endforeach?>
			</table>
		</div>
	<?endif?>
</div>
<div class="col-md-4">
	<?if(empty($data[0]->foto)):?>
		<center><img src="<?=base_url()?>/asset/image/profile.png"></center>
	<?else:?>
		<center><img src="<?=base_url()?>/uploads/profile/<?=$data[0]->foto?>" style="width:100%;margin-bottom:20px;"></center>
	<?endif?>
</div>
<script>
	$(document).ready(function () {
		$('#rating').raty({ readOnly: true, score: <?= ($all_order == 0) ? 5 : $success_order / $all_order * 5?> });
		$('#rating img').each(function() {
			src = $(this).attr("src");
			$(this).attr("src", "<?=base_url()?>asset/image/rating/"+src);
		});
	});
	
</script>