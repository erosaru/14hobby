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
	
	tinymce.init({
		selector: "textarea",
		plugins: ["code", "image"]
	});
</script>

<style>
	.form-inline label{
		min-width:150px;
	}
</style>

<div class="col-sm-3 text-center">
			<img src="<?= base_url();?>asset/image/profile.png" alt="300x200" style="width:80px;">
			
			<br/>Level<br/>
			Join Date
</div>
<div class="col-sm-9">
	<div class="form-inline">
		<label>Nama</label>
		: <?= trim($data[0]->first_name." ".$data[0]->last_name);?>
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
		<label>Telepon / Handphone</label>
		: <?= $data[0]->phone;?>
	</div>
	<form action='<?= base_url();?>roomuser/update_room_user' method='post' id='form_change_password' class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">Biodata</label>
			<div class="col-sm-10">
				<textarea id="wysiwyg" name="deskripsi" class="input-block-level" placeholder="Enter text ..." style="height: 200px"><?if(isset($data[0]->deskripsi)) echo $data[0]->deskripsi?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Password Lama</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="password" name='passlama' id='passlama' class="form-control" required="required">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Password Baru</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="password" name='passbaru' id='passbaru' class="form-control" required="required">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Confirm Password Baru</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="password" name='cpassbaru' id='cpassbaru' class="form-control" required="required">
					<br/><small>*Password bila tidak akan dirubah dikosongkan saja.</small>		
				</div>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<a class='btn btn-success' onclick="before_save();">Simpan</a>
			</div>
		</div>	
	</form>
</div>
<div class="clearfix"></div>