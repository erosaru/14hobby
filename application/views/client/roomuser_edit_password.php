<form id="form_account_bank" class="form-horizontal" method="post" action="<?= base_url()."process_change_password"?>">
		<div class="form-group">
			<label class="col-sm-3 control-label text-primary">Change Password Account</label>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Old Password</label>
			<div class="col-sm-10">
				<div class="col-sm-10" style="padding:0px;">
					<input type="password" class="form-control" name="old_password" id="old_password">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">New Password</label>
			<div class="col-sm-10">
				<div class="col-sm-10" style="padding:0px;">
					<input type="password" class="form-control" name="new_password" id="new_password">
				</div>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-sm-2 control-label">Confirm New Password</label>
			<div class="col-sm-10">
				<div class="col-sm-10" style="padding:0px;">
					<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password">
				</div>
			</div>
		</div>				
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
				<input type="submit" class="btn btn-success" value="Change Password">
				<a class="btn btn-danger" href="<?= base_url();?>profile">Cancel</a>
			</div>
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>