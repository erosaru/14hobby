<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<div class="row box-roomuser box-register" style>
	<form id="form_account_bank" class="form-horizontal" method="post" action="<?= base_url()."signup/create_seller"?>">
		<div class="form-group">
			<label class="col-sm-3 control-label text-primary">Formulir Pendaftaran Seller</label>
			<div class="col-sm-9">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Email</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['email'];?>" class="form-control" name="email" id="email">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Nama Depan</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['first_name'];?>" class="form-control" name="first_name" id="first_name">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Nama Belakang</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['last_name'];?>" class="form-control" name="last_name" id="last_name">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Nama Toko</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['name_merchant'];?>" class="form-control" name="name_merchant" id="name_merchant">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Alamat Toko</label>
			<div class="col-sm-10">
				<div class="col-sm-10" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['address'];?>" class="form-control" name="address" id="address">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Kota</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['city'];?>" class="form-control" name="city" id="city">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Provinsi</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<select value="<? if(isset($data)) echo $data['province'];?>" class="form-control" name="province" id="province">
						<option value="Aceh" <?if(isset($data) && $data['province'] == "Aceh") echo "selected";?>>Aceh</option>
						<option value="Bali" <?if(isset($data) && $data['province'] == "Bali") echo "selected";?>>Bali</option>
						<option value="Banten" <?if(isset($data) && $data['province'] == "Banten") echo "selected";?>>Banten</option>
						<option value="Bengkulu" <?if(isset($data) && $data['province'] == "Bengkulu") echo "selected";?>>Bengkulu</option>
						<option value="Gorontalo" <?if(isset($data) && $data['province'] == "Gorontalo") echo "selected";?>>Gorontalo</option>
						<option value="Jakarta" <?if(isset($data) && $data['province'] == "Jakarta") echo "selected";?>>Jakarta</option>
						<option value="Jambi" <?if(isset($data) && $data['province'] == "Jambi") echo "selected";?>>Jambi</option>
						<option value="Jawa Barat" <?if(isset($data) && $data['province'] == "Jawa Barat") echo "selected";?>>Jawa Barat</option>
						<option value="Jawa Tengah" <?if(isset($data) && $data['province'] == "Jawa Tengah") echo "selected";?>>Jawa Tengah</option>
						<option value="Jawa Timur" <?if(isset($data) && $data['province'] == "Jawa Timur") echo "selected";?>>Jawa Timur</option>
						<option value="Kalimantan Barat" <?if(isset($data) && $data['province'] == "Kalimantan Barat") echo "selected";?>>Kalimantan Barat</option>
						<option value="Kalimantan Selatan" <?if(isset($data) && $data['province'] == "Kalimantan Selatan") echo "selected";?>>Kalimantan Selatan</option>
						<option value="Kalimantan Tengah" <?if(isset($data) && $data['province'] == "Kalimantan Tengah") echo "selected";?>>Kalimantan Tengah</option>
						<option value="Kalimantan Timur" <?if(isset($data) && $data['province'] == "Kalimantan Timur") echo "selected";?>>Kalimantan Timur</option>
						<option value="Kalimantan Utara" <?if(isset($data) && $data['province'] == "Kalimantan Utara") echo "selected";?>>Kalimantan Utara</option>
						<option value="Kepulauan Bangka Belitung" <?if(isset($data) && $data['province'] == "Kepulauan Bangka Belitung") echo "selected";?>>Kepulauan Bangka Belitung</option>
						<option value="Kepulauan Riau" <?if(isset($data) && $data['province'] == "Kepulauan Riau") echo "selected";?>>Kepulauan Riau</option>
						<option value="Lampung" <?if(isset($data) && $data['province'] == "Lampung") echo "selected";?>>Lampung</option>
						<option value="Maluku" <?if(isset($data) && $data['province'] == "Maluku") echo "selected";?>>Maluku</option>
						<option value="Maluku Utara" <?if(isset($data) && $data['province'] == "Maluku Utara") echo "selected";?>>Maluku Utara</option>
						<option value="Nusa Tenggara Barat" <?if(isset($data) && $data['province'] == "Nusa Tenggara Barat") echo "selected";?>>Nusa Tenggara Barat</option>
						<option value="Nusa Tenggara Timur" <?if(isset($data) && $data['province'] == "Nusa Tenggara Timur") echo "selected";?>>Nusa Tenggara Timur</option>
						<option value="Papua" <?if(isset($data) && $data['province'] == "Papua") echo "selected";?>>Papua</option>
						<option value="Papua Barat" <?if(isset($data) && $data['province'] == "Papua Barat") echo "selected";?>>Papua Barat</option>
						<option value="Riau" <?if(isset($data) && $data['province'] == "Riau") echo "selected";?>>Riau</option>
						<option value="Sulawesi Barat" <?if(isset($data) && $data['province'] == "Sulawesi Barat") echo "selected";?>>Sulawesi Barat</option>
						<option value="Sulawesi Barat" <?if(isset($data) && $data['province'] == "Sulawesi Barat") echo "selected";?>>Sulawesi Barat</option>
						<option value="Sulawesi Selatan" <?if(isset($data) && $data['province'] == "Sulawesi Selatan") echo "selected";?>>Sulawesi Selatan</option>
						<option value="Sulawesi Tengah" <?if(isset($data) && $data['province'] == "Sulawesi Tengah") echo "selected";?>>Sulawesi Tengah</option>
						<option value="Sulawesi Utara" <?if(isset($data) && $data['province'] == "Sulawesi Utara") echo "selected";?>>Sulawesi Utara</option>
						<option value="Sumatera Barat" <?if(isset($data) && $data['province'] == "Sumatera Barat") echo "selected";?>>Sumatera Barat</option>
						<option value="Sumatera Selatan" <?if(isset($data) && $data['province'] == "Sumatera Selatan") echo "selected";?>>Sumatera Selatan</option>
						<option value="Sumatera Utara" <?if(isset($data) && $data['province'] == "Sumatera Utara") echo "selected";?>>Sumatera Utara</option>
						<option value="Yogyakarta" <?if(isset($data) && $data['province'] == "Yogyakarta") echo "selected";?>>Yogyakarta</option>						
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*Telepon</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['phone'];?>" class="form-control" name="phone" id="phone">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Deskripsi</label>
			<div class="col-sm-10 wysiwyg-container">
				<textarea id="wysiwyg" name="deskripsi" id="deskripsi" class="input-block-level" placeholder="Sample: Toko saya menjual barang-barang seperti bla-bla-bla" style="height: 200px;width:90%;"><? if(isset($data)) echo $data['deskripsi'];?></textarea>
			</div>
		</div>
		<div class="form-group" style="text-align:center;">
			<div class="col-sm-12" style="padding-left:85px;padding-right:85px;">
				<?php echo $captcha['image']; ?><br/>&nbsp;<br/>&nbsp;
				
				<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8" required><br/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
				<input type="submit" class="btn btn-success" value="Submit"><br/>
				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-12 control-label text-danger" style="text-align:left;padding-left:85px;">* Must be fill</label>
		</div>
	</form>
</div>