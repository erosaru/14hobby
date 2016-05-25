<div class="row box-roomuser box-register" style>
	<form id="form_account_bank" class="form-horizontal" method="post" action="<?= base_url()."user/update/".$user->id?>">
		<div class="form-group">
			<label class="col-sm-2 control-label text-primary">Edit User</label>
			<div class="col-sm-10">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Email</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<?=$user->email?>" class="form-control" readonly>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Nama Lengkap</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<?=trim($user->first_name." ".$user->last_name)?>" class="form-control" name="first_name" readonly>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Alamat</label>
			<div class="col-sm-10">
				<div class="col-sm-10" style="padding:0px;">
					<input type="text" value="<?=$user->address?>" class="form-control" readonly>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Kota</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<?=$user->city?>" class="form-control" readonly>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Provinsi</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<select value="<? $user->province;?>" class="form-control" name="province" id="province" disabled>
						<option value="Aceh" <?if($user->province == "Aceh") echo "selected";?>>Aceh</option>
						<option value="Bali" <?if($user->province == "Bali") echo "selected";?>>Bali</option>
						<option value="Banten" <?if($user->province == "Banten") echo "selected";?>>Banten</option>
						<option value="Bengkulu" <?if($user->province == "Bengkulu") echo "selected";?>>Bengkulu</option>
						<option value="Gorontalo" <?if($user->province == "Gorontalo") echo "selected";?>>Gorontalo</option>
						<option value="Jakarta" <?if($user->province == "Jakarta") echo "selected";?>>Jakarta</option>
						<option value="Jambi" <?if($user->province == "Jambi") echo "selected";?>>Jambi</option>
						<option value="Jawa Barat" <?if($user->province == "Jawa Barat") echo "selected";?>>Jawa Barat</option>
						<option value="Jawa Tengah" <?if($user->province == "Jawa Tengah") echo "selected";?>>Jawa Tengah</option>
						<option value="Jawa Timur" <?if($user->province == "Jawa Timur") echo "selected";?>>Jawa Timur</option>
						<option value="Kalimantan Barat" <?if($user->province == "Kalimantan Barat") echo "selected";?>>Kalimantan Barat</option>
						<option value="Kalimantan Selatan" <?if($user->province == "Kalimantan Selatan") echo "selected";?>>Kalimantan Selatan</option>
						<option value="Kalimantan Tengah" <?if($user->province == "Kalimantan Tengah") echo "selected";?>>Kalimantan Tengah</option>
						<option value="Kalimantan Timur" <?if($user->province == "Kalimantan Timur") echo "selected";?>>Kalimantan Timur</option>
						<option value="Kalimantan Utara" <?if($user->province == "Kalimantan Utara") echo "selected";?>>Kalimantan Utara</option>
						<option value="Kepulauan Bangka Belitung" <?if($user->province == "Kepulauan Bangka Belitung") echo "selected";?>>Kepulauan Bangka Belitung</option>
						<option value="Kepulauan Riau" <?if($user->province == "Kepulauan Riau") echo "selected";?>>Kepulauan Riau</option>
						<option value="Lampung" <?if($user->province == "Lampung") echo "selected";?>>Lampung</option>
						<option value="Maluku" <?if($user->province == "Maluku") echo "selected";?>>Maluku</option>
						<option value="Maluku Utara" <?if($user->province == "Maluku Utara") echo "selected";?>>Maluku Utara</option>
						<option value="Nusa Tenggara Barat" <?if($user->province == "Nusa Tenggara Barat") echo "selected";?>>Nusa Tenggara Barat</option>
						<option value="Nusa Tenggara Timur" <?if($user->province == "Nusa Tenggara Timur") echo "selected";?>>Nusa Tenggara Timur</option>
						<option value="Papua" <?if($user->province == "Papua") echo "selected";?>>Papua</option>
						<option value="Papua Barat" <?if($user->province == "Papua Barat") echo "selected";?>>Papua Barat</option>
						<option value="Riau" <?if($user->province == "Riau") echo "selected";?>>Riau</option>
						<option value="Sulawesi Barat" <?if($user->province == "Sulawesi Barat") echo "selected";?>>Sulawesi Barat</option>
						<option value="Sulawesi Barat" <?if($user->province == "Sulawesi Barat") echo "selected";?>>Sulawesi Barat</option>
						<option value="Sulawesi Selatan" <?if($user->province == "Sulawesi Selatan") echo "selected";?>>Sulawesi Selatan</option>
						<option value="Sulawesi Tengah" <?if($user->province == "Sulawesi Tengah") echo "selected";?>>Sulawesi Tengah</option>
						<option value="Sulawesi Utara" <?if($user->province == "Sulawesi Utara") echo "selected";?>>Sulawesi Utara</option>
						<option value="Sumatera Barat" <?if($user->province == "Sumatera Barat") echo "selected";?>>Sumatera Barat</option>
						<option value="Sumatera Selatan" <?if($user->province == "Sumatera Selatan") echo "selected";?>>Sumatera Selatan</option>
						<option value="Sumatera Utara" <?if($user->province == "Sumatera Utara") echo "selected";?>>Sumatera Utara</option>
						<option value="Yogyakarta" <?if($user->province == "Yogyakarta") echo "selected";?>>Yogyakarta</option>						
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Telepon</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<?=$user->phone?>" class="form-control" readonly>
				</div>
			</div>
		</div>
		<div class="form-group">
				<label class="col-sm-2 control-label">Role</label>
				<div class="col-sm-10">
					<div class="col-sm-4" style="padding:0px;">
						<?= form_dropdown('role_id', $role, $user->role_id, "class='form-control' id='role_id'");?>
					</div>
				</div>
			</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
				<input type="submit" class="btn btn-success" value="Save">
				<a class="btn btn-danger" href="<?=base_url()?>user">Cancel</a>
			</div>
		</div>
	</form>
</div>