<div class="col-sm-12">
		<div class="col-sm-6"><span style="font-weight:bold;font-size:20px;">List Seller</span></div>
		<form class="form-inline col-sm-6 text-right" id="form_province" action="<?= base_url()?>list-seller">
		  <div class="form-group">
			<?$data['province'] = $this->input->get('province');?>
			<select value="<? if(isset($data)) echo $data['province'];?>" class="form-control" name="search" onchange="$('#form_province').submit();">
				<option value="" <?if(isset($data) && $data['province'] == "") echo "selected";?>>All</option>
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
		  <!--<button type="submit" class="btn btn-success">Cari</button>-->
		</form>
	</div>
	<div class="clearfix"></div>
	<?if($merchant->num_rows() > 0):?>
		<?foreach($merchant->result() as $row):?>
			<div class="col-sm-6">				
				<div class="col-sm-12" style="min-height:150px;max-height:150px;background-color:none;">					
					<center>
						<?if(!empty($row->foto)):?>
							<?= resize_image_local_server('uploads/profile/'.$row->foto, $row->name_merchant ? $row->name_merchant : $row->first_name.' '.$row->last_name)?>
						<?else:?>
							<?= resize_image_local_server('asset/image/profile.png', 'market 14hobby')?>
						<?endif?>
					</center>
				</div>
				<div class="col-sm-12" style="min-height:60px;max-height:60px;">
					<center><a href="<?=base_url()?>detail-merchant/<?= !empty($row->name_merchant) ? create_title($row->name_merchant) : create_title(trim($row->first_name.' '.$row->last_name))?>"><?= !empty($row->name_merchant) ? $row->name_merchant : $row->first_name.' '.$row->last_name?></a></center>
				</div>
			</div>
		<?endforeach?>
	<?else:?>
		<h2 class="title-bar"><span style="font-size:20px;padding-right:20px;color:black;">Belum ada seller untuk provinsi yang anda cari</span></h2>
	<?endif?>
	<?if(isset($links)):?>
		<div class="col-sm-12">
			<center>
				<nav>
					<ul class="pagination">
						<?= $links ?>
					</ul>
				</nav>
			</center>
		</div>
	<?endif?>