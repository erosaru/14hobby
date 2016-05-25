<div class="col-sm-8">
	<div class="col-md-4 text-center">
		<?if(!empty($item->link_gambar)):?>
			<center><?=resize_image_local_server("uploads/".$item->link_gambar, $item->name_barang, 200, 200)?></center>
		<?else:?>
			<?= resize_image_local_server("asset/image/profile.png", "blank_picture", 250, 200)?>
		<?endif?>
		<br/>&nbsp;		
		<?if($this->session->userdata('role_id') == 100 /*&& $item->counter_stock > 0 && $this->session->userdata("login") == true*/):?>
			<form action="<?= base_url()?>pre-order/add-to-cart" method="post">
				<div class="col-sm-12">
					<div class="col-sm-4"></div>
						<div class="col-sm-4" style="padding:0px;">
							<center>
								<input type="text" name="qty" value="1" required="required" class="form-control">
								<input type="hidden" value="<?= $item->id?>" name="id">
							</center>
						</div>
					<div class="col-sm-4"></div>
				</div><br/>&nbsp;
				<input type="submit" class="btn btn-block btn-success" value="Masukkan ke keranjang">
			</form>
			<!--<a class="btn btn-block btn-danger" href="<?=base_url()?>ecatalog/kategori/<?= create_title($dafkomen[0]->name_kategori)?>">Kembali</a>-->
		<?endif?>		
		<a class="btn btn-block btn-danger" href="<?=base_url()?>pre-order">Kembali</a>
	</div>
	<div class="col-md-8 ">
		<article>
			<h3 class="mobile-text-center"><a href="<?=base_url().create_title($item->name_barang)?>"><?=$item->name_barang?></a></h3>
			<div class="form-inline">
				<label>Harga</label>
				: Rp <?= number_format($item->harga,0,',','.')?>
			</div>
			<?if($item->dp_tipe == 1):?>
				<?$jumlah_dp = $item->dp / 100 * $item->harga?>
			<?else:?>
				<?$jumlah_dp = $item->dp?>
			<?endif?>
			<div class="form-inline">
				<label>DP</label>
				: Rp <?= number_format($jumlah_dp,0,',','.')?>
			</div>
			<div class="form-inline">
				<label>Rilis</label>
				: <?= date("M Y", strtotime($item->tgl_rilis))?>
			</div>
			<div class="form-inline">
				<label>ETA</label>
				: <?= date("M Y", strtotime($item->tgl_tiba))?>
			</div>
			<div class="form-inline">
				<label>Deadline</label>
				: <?= $item->tgl_deadline ? date("d-m-Y", strtotime($item->tgl_deadline)) : "PO bisa ditutup sewaktu-waktu"?>
			</div>
		</article>
		<?/*
		<article>
			<table class="table table-bordered">
				<tr>
					<th>Nama Customer</th>
					<th>Jumlah PO</th>
				</tr>
				<?if($customer_po->num_rows() > 0):?>
				
				<?else:?>
					<tr>
						<td colspan="2"><center>Belum ada customer yang order untuk barang ini</center></td>
					</tr>
				<?endif?>
			</table>
		</article>
		*/?>
		<article>
			<h3 class="mobile-text-center">Peraturan Pre Order</h3>
			<ul>
				<li>Kami hanya menerima order dari teman-teman sampai tanggal yang sudah ditentukan.</li>
				<li>Teman-teman yang melakukan order harap membayarkan uang muka dahulu sesuai jumlah uang DP yang tertulis. Tidak membayar uang muka maka proses pre order tidak dilanjutkan</li>
				<!--<li>Harga sudah fix saat mendaftar tidak ada perubahan dari kami</li>-->
				<li>Harga barang disesuaikan dengan kurs dan kondisi lainnya. Harap maklum apabila terjadi kenaikan harga. Kami akan memberikan harga terbaik untuk anda</li>
				<li>Batal pre order dari pihak teman-teman maka uang DP yang sudah dibayarkan hangus</li>
				<li>Apabila ada pembatalan dari pihak kami, maka uang DP akan dikembalikan utuh kepada teman-teman</li>
				<li>Kami menganggap anda sudah membaca peraturan dan menyetujui semua aturan PO di 14hobby.com apabila anda melakukan order</li>
			</ul>
			
			Bagi yang berminat untuk memesan barang bisa menghubungi Ferry Lugiman dengan contact 085320066604 (SMS, WA, Line untuk fast response harap telepon atau SMS) Thanks
		</article>
	</div>
</div>
<div class="col-sm-4">
		<?$this->load->view("client/sidebar")?>	
</div>
