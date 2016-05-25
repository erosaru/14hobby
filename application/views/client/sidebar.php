<style>
	.divsignin img{
		background: #ffffff url("<?=base_url()?>asset/image/sign_bg.gif") no-repeat;
		height: 284px;
		border-radius: 10px;
		margin: 0 0 10px 0;
		overflow: hidden;
	}
</style>
<?if($this->session->userdata("login") == false):?>
	<!--<div class="col-sm-12" style="margin-bottom:10px;"><a href="<?= base_url()?>how-to-be-seller" class="btn btn-warning btn-block">Signup sebagai seller</a></div>-->
	<div class="col-sm-12" style="margin-bottom:10px;"><a href="<?= base_url()?>signup" class="btn btn-primary btn-block">Signup sebagai member</a></div><br/>
	<a href="<?= base_url()?>login">
		<div class="divsignin">
			<center><img  src="<?= base_url()?>asset/image/sign_en.png" ></center>
		</div>
	</a>
<?endif?>
<?if($this->router->fetch_method() == "show" && $this->router->fetch_class() == "artikel"):?>
	<?= kategori_artikel_lainnya($kategori_artikel_lain) ?>
<?endif?>
<?if($this->router->fetch_method() == "show" && $this->router->fetch_class() == "ensiklopedia" && $this->router->fetch_class() != "item"):?>
	<?= list_same_kategori_and_merk($related_ensiklopedia) ?>
	<?if(!empty($barang_semanufacture)):?>
		<?= barang_semanufacture($barang_semanufacture) ?>
	<?endif?>
<?endif?>
<?if($this->router->fetch_method() == "detail_ensiklopedia" && $this->router->fetch_class() == "ensiklopedia"):?>
	<?= ensiklopedia_kategori_lainnya($kategori_lainnya) ?>
<?endif?>


<?if($this->router->fetch_method() == "index" && $this->router->fetch_class() == "page"):?>
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Community and Store</h3>
			</div>
			<div class="panel-body">
				<center>						
					<a href="<?=base_url()?>list-komunitas"><img src="<?=base_url()?>asset/image/kategori/logo-your-hobby-community.gif"></a>
					<a href="<?=base_url()?>list-toko"><img src="<?=base_url()?>asset/image/kategori/logo-your-supply-hobby.gif"></a>
				</center>				
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><center>ENCYCLOPEDIA</center></h3>
			</div>
			<div class="panel-body">
				<center>
					<a class="toyspedia" href="<?= base_url()?>toy-pedia">New (<?= $ensiklopedia_baru[0]["jumlah"]?>)</a>
					<!--<a class="toyspedia" href="<?= base_url()?>ensiklopedia-toys">New (<?= $ensiklopedia_baru[0]["jumlah"]?>)</a>-->
					<!--<a class="toyspedia cardpedia" href="<?= base_url()?>ensiklopedia-cards">New (<?= $ensiklopedia_baru[0]["jumlah"]?>)</a>-->
				</center>
			</div>
		</div>
	</div>
	<!--
		<div class="col-sm-12 side-menu">
			<h2>Payment</h2>
			<center>
				<img alt="bank bca" src="<?= base_url()?>asset/image/bca.jpg">							
			</center>	  
		</div>
	-->
	<?/*
	<div class="col-sm-12 side-menu">
		<h2>Kurs BCA</h2>
		<div class="col-sm-12">
			<?if(count($kurs)>0):?>
				<table class="table table-bordered">
					<tr>
						<th style="text-align:center">Kurs</th>
						<th style="text-align:center">Jual</th>
						<th style="text-align:center">Beli</th>
					</tr>
					<?foreach($kurs as $row):?>
						<tr>
							<td style="text-align:center"><?= $row->kurs?></td>
							<td style="text-align:right"><?= round($row->jual)?></td>
							<td style="text-align:right"><?= round($row->beli)?></td>
						</tr>
					<?endforeach?>
				</table>
			<?endif?>
		</div>
	</div>
	*/?>
<?endif?>
<center><a href="https://www.facebook.com/14hobby"><img src="<?= base_url()?>asset/image/facebook-banner.png"></a></center>