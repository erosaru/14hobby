
<script src="<?= base_url();?>asset/bootstrap/js/wysiwyg/wysihtml5-0.3.0.js"></script>
<script src="<?= base_url();?>asset/bootstrap/js/wysiwyg/bootstrap-wysihtml5.js"></script>
<link href="<?= base_url();?>asset/bootstrap/css/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet">
<link href="<?= base_url();?>asset/bootstrap/css/wysiwyg/wysiwyg-color.css" rel="stylesheet">

<style>
	.form-inline label{
		min-width:150px;
	}
</style>

<div class="col-md-6">
	<div class="form-inline">
		<label>Nama</label>
		: <?= $data[0]->first_name;?> <?= $data[0]->last_name;?>
	</div>
	<?if($this->session->userdata('role_id') == 2):?>
		<div class="form-inline">
			<label>Nama Merchant</label>
			: <?= $data[0]->name_merchant;?>
		</div>
	<?endif?>
	<div class="form-inline">
		<label>Username / Email</label>
		: <?= $data[0]->email;?>
	</div>
	<div class="form-inline">
		<label>Alamat</label>
		: <?= $data[0]->address;?>
	</div>
	<div class="form-inline">
		<label>Provinsi</label>
		: <?= $data[0]->province;?>
	</div>
	<div class="form-inline">
		<label>Negara</label>
		: Indonesia
	</div>
	<div class="form-inline">
		<label>Telepon</label>
		: <?= $data[0]->phone;?>
	</div>
	<div class="form-inline">
		<label>&nbsp;</label>
		<a href="<?= base_url()?>change_password" class="btn btn-primary btn-xs">rubah password</a>
		<a href="<?= base_url()?>change_profile" class="btn btn-primary btn-xs">rubah profile</a>
		<a href="<?= base_url()?>account-bank" class="btn btn-primary btn-xs">account bank</a>
	</div>
</div>
<div class="col-md-6">
	<?if(empty($data[0]->foto)):?>
		<center><img src="<?=base_url()?>/asset/image/profile.png"></center>
	<?else:?>
		<center><img src="<?=base_url()?>/uploads/profile/<?=$data[0]->foto?>" style="width:100%;margin-bottom:20px;"></center>
	<?endif?>
	<!--
	<div class="form-inline">
		<label>Bank Name</label>
		: <?// $data[0]->bank_name;?>
	</div>
	<div class="form-inline">
		<label>Bank Address</label>
		: <?// $data[0]->bank_address;?>
	</div>
	<div class="form-inline">
		<label>Bank Account</label>
		: <?// $data[0]->bank_account;?>
	</div>
	<div class="form-inline">
		<label>Bank Number</label>
		: <?// $data[0]->bank_account_number;?>
	</div>
	<div class="form-inline">
		<label>&nbsp;</label>
		<a href="<?= base_url()?>edit_account_bank" class="btn btn-primary btn-xs">change account bank</a>
	</div>
	-->
</div>
<div class="clearfix"></div>
