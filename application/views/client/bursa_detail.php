<div class="span8 dashboard-wrapper">			
	<div class="span12">
	<?if(empty($show)):?>
		<?if(count($link) != 0):?>
			<h3><?= in_array($this->router->fetch_method(), array("bursa_all", "detail")) ? "Ready Stock" : "Pre Order"?><?= in_array($this->router->fetch_method(), array("bursa_all", "preorder_all")) ? "" : ' - '.ucfirst(str_replace("pre-order-","",$this->uri->segment(1)))?></h3>
			<?if($this->router->fetch_method() == "preorder_all"):?>
				<p class="text-right">
					<span class="btn-group" role="group">
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>" class="btn btn-default" style="width:100px;">On Going PO</a>
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>?show=all" class="btn btn-default" style="width:100px;">All PO List</a>
					</span>
				</p>
			<?endif?>
			<div class="tab-content">
				<div class="tab-pane active" id="item">
					<? foreach($link as $row){?>
						<div class="widget">
							<div class="widget-body text-left" id="<?= create_title($row->name_barang)?>">
								<div class="span2" style="margin-right:10px;">
									<center><?= resize_image($row->link_gambar, $row->name_barang)?></center>
								</div>
								<div class="span7">
									<a href="<?=base_url().create_title($row->name_barang);?>"><b><?= $row->name_barang?></b></a><br/>
									<span style="width:120px;display:inline-block">Manufacture</span>:  <?= $row->name_merk?><br/>
									<span style="width:120px;display:inline-block">Harga</span>:
									<?if($this->router->fetch_method() == "bursa_all" || $this->router->fetch_method() == "detail"):?>
										<?if($row->max_price == $row->min_price):?>
											Rp. <?= number_format($row->min_price,0,',','.')?>
										<?else:?>
											Rp. <?= number_format($row->min_price,0,',','.')?> - <?= number_format($row->max_price,0,',','.')?>
										<?endif?>
									<?else:?>
										<?if($row->kurs == "IDR") echo "Rp."; elseif($row->kurs == "JPY") echo "&yen;"; else echo "$"?> <?= number_format($row->harga,0,',','.')?>
									<?endif?><br/>
									<?if(!empty($row->date_pre_order)):?>
										<span style="width:120px;display:inline-block">Tanggal Akhir PO</span>:  <?= show_tanggal($row->date_pre_order)?><br/>
										<span style="width:120px;display:inline-block">Keterangan</span>: <?= !empty($row->keterangan_barang) ? $row->keterangan_barang." - " : ""?><?= $row->keterangan_pre_order?><br/>
									<?endif?>
									<?if(!empty($row->keterangan_barang)):?>
										<span style="width:120px;display:inline-block">Keterangan Barang</span>:  <?= $row->keterangan_barang?><br/>
									<?endif?>
									<?if(!empty($row->bonus)):?>
										<span style="width:120px;display:inline-block">Bonus</span>:  <?= $row->bonus?><br/>
									<?endif?>
								</div>
								<label class='text-right mobile-text-center'>
									<a class="btn btn-success" style="min-width:106px;" href="<?=base_url().create_title($row->name_barang);?>"><?=($this->router->fetch_method() == "bursa_all" || $this->router->fetch_method() == "detail") ? "Beli" : "Order"?></a>
								</label>
								<div class="clearfix"></div>
							</div>			
						</div>
					<?}?>
					<?if(isset($links)):?>
						<div class="pagination">
							<ul>
								<?= $links ?>
							</ul>
						</div>
					<?endif?>
				</div>
			</div>
		<?else:?>
			<?if($this->router->fetch_method() == "preorder_all"):?>
				<p class="text-right">
					<span class="btn-group" role="group">
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>" class="btn btn-default" style="width:100px;">On Going PO</a>
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>?show=all" class="btn btn-default" style="width:100px;">All PO List</a>
					</span>
				</p>
			<?endif?>
			<p>
				<center>
				Maaf untuk saat ini belum ada barang <?= in_array($this->router->fetch_method(), array("preorder_all", "detail_pre_order")) ? "Pre Order" : "Ready Stock"?><?= in_array($this->router->fetch_method(), array("detail", "detail_pre_order")) ? " untuk ".ucwords(str_replace("pre-order-", "", $this->uri->segment(1))) : ""?>.<br/><a href="<?= base_url()?><? if($this->router->fetch_method() == "detail") echo "ready-stock-all-".$divisi_name;elseif($this->router->fetch_method() == "bursa_all") echo "";elseif($this->router->fetch_method() == "preorder_all") echo "";elseif($this->router->fetch_method() == "detail_pre_order") echo "preorder-all-".$divisi_name;else echo "";?>" class="btn btn-danger">Kembali</a></center>
			</p>
		<?endif?>
	<?else:?>
		<?if(count($link) != 0):?>
			<h3>Pre Order All</h3>
			<?if($this->router->fetch_method() == "preorder_all"):?>
				<p class="text-right">
					<span class="btn-group" role="group">
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>" class="btn btn-default" style="width:100px;">On Going PO</a>
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>?show=all" class="btn btn-default" style="width:100px;">All PO List</a>
					</span>
				</p>
			<?endif?>
			<?foreach($link as $row):?>
				<div class="span6" style="border-bottom:1px solid #e1e1e1;margin-bottom:10px;min-height:120px;">
					<div class="span2" style="margin-right:10px;">
						<center><?= resize_image($row->link_gambar, $row->name_barang)?></center>
					</div>
					<div class="span7">
						<div class="form-inline">
							<a href="<?=base_url()?>bursa/show_status_po/<?= $row->id?>"><?= $row->name_barang;?></a>
						</div>
						<div class="form-inline">
							<label style="min-width:70px;">Akhir PO</label>:
							<?= show_tanggal($row->date_pre_order)?>
						</div>
						<div class="form-inline">
							<label style="min-width:70px;">Status</label>:
							<?$date = new datetime($row->date_pre_order)?>
							<?$date2 = new datetime(date("Y-m-d"))?>
							<?=($date >= $date2) ? "On Going" : "Close"?>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			<?endforeach;?>
			<div class="clearfix"></div>
			<?if(isset($links)):?>
				<div class="pagination">
					<center>
						<ul>
							<?= $links ?>
						</ul>
					<center>
				</div>
			<?endif?>
		<?else:?>
			<?if($this->router->fetch_method() == "preorder_all"):?>
				<p class="text-right">
					<span class="btn-group" role="group">
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>" class="btn btn-default" style="width:100px;">On Going PO</a>
						<a href="<?= base_url()?><?= $this->uri->segment(1)?>?show=all" class="btn btn-default" style="width:100px;">All PO List</a>
					</span>
				</p>
			<?endif?>
			<p>
				<center>
				Maaf untuk saat ini belum ada barang <?= in_array($this->router->fetch_method(), array("preorder_all", "detail_pre_order")) ? "Pre Order" : "Ready Stock"?><?= in_array($this->router->fetch_method(), array("detail", "detail_pre_order")) ? " untuk ".ucwords(str_replace("pre-order-", "", $this->uri->segment(1))) : ""?>.<br/><a href="<?= base_url()?><? if($this->router->fetch_method() == "detail") echo "ready-stock-all-".$divisi_name;elseif($this->router->fetch_method() == "bursa_all") echo "";elseif($this->router->fetch_method() == "preorder_all") echo "";elseif($this->router->fetch_method() == "detail_pre_order") echo "preorder-all-".$divisi_name;else echo "";?>" class="btn btn-danger">Kembali</a></center>
			</p>
		<?endif?>
	<?endif?>
	</div>
	
</div>
<div class="span4">
	<?= another_menu() ?>
	<?= list_same_kategori_ready_stock($kategori_ready_stock, 0)?>
	<?= list_same_kategori_ready_stock($kategori_pre_order, 1)?>
</div>