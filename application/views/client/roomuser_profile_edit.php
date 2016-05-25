<script>	
	tinymce.init({
		selector: "textarea",
		plugins: ["code", "image"]
	});
</script>

<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<div>
	<form id="form_account_bank" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?= base_url()."process_change_profile"?>">
		<?if($this->session->userdata('role_id') == 2):?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama Merchant</label>
				<div class="col-sm-5 wysiwyg-container">
					<input name="name_merchant" type="text" class="form-control" value="<? if(isset($data)) echo $data['name_merchant'];?>">
				</div>
			</div>
		<?endif?>		
		<div class="form-group">
			<label class="col-sm-2 control-label">Foto</label>
			<div class="col-sm-10 wysiwyg-container">
				<input name="profile_picture" type="file" class="form-control">
			</div>
		</div>
		<?if($this->session->userdata('role_id') == 2):?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Deskripsi</label>
				<div class="col-sm-10 wysiwyg-container">
					<textarea id="wysiwyg" name="deskripsi" id="deskripsi" class="input-block-level" placeholder="Enter text ..." style="height: 200px"><? if(isset($data)) echo $data['deskripsi'];?></textarea>
				</div>
			</div>
		<?endif?>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
				<input type="submit" class="btn btn-success" value="Update">
				<a class="btn btn-primary" href="<?=base_url()?>profile">Back</a>
			</div>
		</div>
	</form>
</div>