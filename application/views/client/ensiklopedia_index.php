<div class="col-sm-9" id="bursa_index">	<h2><?=$title?></h2>	<div class="col-sm-12">		<?if(!empty($link)):?>				<? foreach($link as $row){?>				<div class="col-sm-6" style="margin-bottom:10px;padding:0px 10px;">					<a href="<?=base_url()."ensiklopedia-".create_title($row->name_kategori);?>" class="btn btn-primary btn-block">						<?=ucwords($row->name_kategori)?>					</a>				</div>							<?}?>		<?endif?>	</div>	<div class="col-sm-12">		<form style="padding:2px 10px;border:1px solid grey;border-radius:10px;" id="form_kategori" class="form-horizontal" method="get" action="<?= base_url()?><?=$this->uri->segment(1)?>-search">			<h2>Pencarian Barang</h2>			<div class="form-group">				<label class="col-sm-2 control-label">Merk</label>				<div class="col-sm-10">					<div class="col-sm-4" style="padding:0px;">						<?= form_dropdown('id_merk', $merk, "", "class='form-control' id='id_merk'");?>						</div>				</div>			</div>			<div class="form-group">				<label class="col-sm-2 control-label">Kategori</label>				<div class="col-sm-10">					<div class="col-sm-4" style="padding:0px;">						<?= form_dropdown('id_kategori', $tipe, "", "class='form-control' id='id_kategori'");?>					</div>				</div>			</div>						<div class="form-group">				<label class="col-sm-2 control-label">Kata Kunci</label>				<div class="col-sm-10">					<div class="col-sm-4" style="padding:0px;">						<input type="text" value="" class="form-control" name="kata_kunci" id="kata_kunci">					</div>				</div>			</div>			<div class="form-group">				<label class="col-sm-2 control-label"></label>				<div class="col-sm-10">					<input type="submit" class="btn btn-success" value="Cari">				</div>			</div>					</form>	</div>	<?if(count($new_item)>0):?>		<div class="col-sm-12">			<h2 class="title-bar c1" style="text-align:center;color:white;font-size:24px;">Last Item</h2>			<ul>				<? foreach($new_item as $row):?>					<li>						<a class="title" href="<?= base_url()?><?=create_title($row->name_barang)?>"><?= $row->name_barang?></a>					</li>				<?endforeach?>			</ul>		</div>	<?endif?></div><div class="col-sm-3">	<?$this->load->view("client/sidebar")?></div>