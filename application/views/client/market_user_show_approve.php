<script src="<?= base_url();?>asset/bootstrap/js/wysiwyg/wysihtml5-0.3.0.js"></script>
<script src="<?= base_url();?>asset/bootstrap/js/wysiwyg/bootstrap-wysihtml5.js"></script>
<link href="<?= base_url();?>asset/bootstrap/css/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet">
<link href="<?= base_url();?>asset/bootstrap/css/wysiwyg/wysiwyg-color.css" rel="stylesheet">

<script>
	function before_save(){
			if ($("#passlama").val() != ""){
				if ($("#passbaru").val() == ""){
				alertify.alert("Anda belum mengisikan password baru apabila anda ingin mengubah password");
				$("#passbaru").focus();
				return false;
			}
			
			if ($("#cpassbaru").val() == ""){
				alertify.alert("Anda belum mengisikan confirm password baru apabila anda ingin mengubah password");
				$("#cpassbaru").focus();
				return false;
			}
			
			if ($("#cpassbaru").val() != $("#passbaru").val()){
				alertify.alert("Password baru dan confirm password tidak sama. Mohon diisi dengan value yang sama");
				$("#passbaru").val('');
				$("#cpassbaru").val('');			
				$("#passbaru").focus();
				return false;
			}
		}				
		$("#form_change_password").submit();
	}
	
	$(function () {
		$('#wysiwyg').wysihtml5();
	});
</script>

<style>
	.form-inline label{
		min-width:150px;
	}
</style>

<div class="col-md-4 text-center" style="padding-top:20px;">
			<img src="<?= base_url();?>asset/image/profile.png" alt="300x200" style="width:80px;"><br/>
			Level<br/>
			Join Date
</div>
<div class="col-md-8">
	<div class="form-inline">
		<label>Role</label>
		: <?= $dafkomen[0]->role_name;?>
	</div>
	<div class="form-inline">
		<label>Email</label>
		: <?= $dafkomen[0]->email;?>
	</div>
	<div class="form-inline">
		<label>Name</label>
		: <?= $dafkomen[0]->first_name;?> <?= $dafkomen[0]->last_name;?>
	</div>
	<?if($dafkomen[0]->role_id == 3):?>
		<div class="form-inline">
			<label>Alamat</label>
			: <?= $dafkomen[0]->address;?>
		</div>
	<?else:?>
		<div class="form-inline">
			<label>Nama Toko</label>
			: <?= $dafkomen[0]->name_merchant;?>
		</div>
		<div class="form-inline">
			<label>Alamat Toko</label>
			: <?= $dafkomen[0]->address;?>
		</div>
	<?endif?>
	<div class="form-inline">
		<label>City</label>
		: <?= $dafkomen[0]->city;?>
	</div>
	<div class="form-inline">
		<label>Province</label>
		: <?= $dafkomen[0]->province;?>
	</div>
	<div class="form-inline">
		<label>Phone</label>
		: <?= $dafkomen[0]->phone;?>
	</div>	
	<?if($dafkomen[0]->role_id == 2):?>
		<div class="form-inline">
			<label>Deskripsi</label>
			: <?= $dafkomen[0]->deskripsi;?>
		</div>
	<?endif?>
	<div class="form-inline">
		<a class='btn btn-success' href="<?=base_url()?>user/approved/<?= $dafkomen[0]->id.($this->router->fetch_method() == "rshowapprove" ? "?menu=rshowapprove" : "")?>" onclick="before_save();" style="width:74px;">Approve</a>
		<a class='btn btn-danger'  href="<?=base_url()?>user/declined/<?= $dafkomen[0]->id.($this->router->fetch_method() == "rshowapprove" ? "?menu=rshowapprove" : "")?>" onclick="before_save();" style="width:74px;">Decline</a>
		<a class='btn btn-primary' href="<?=base_url()?>user/<?=($this->router->fetch_method() == "rshowapprove" ? "rneedapprove" : "needapprove")?>" style="width:74px;">Back</a>
	</div>
</div>