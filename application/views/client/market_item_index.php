<div class="span2"></div>
<div class="span8">
	<div class="span12">
		<ul class="nav nav-tabs" id="myTab" >
			<li class="<?if(in_array($this->router->fetch_method(), array("index", "create","edit"))) echo "active";?>"><a href="<?= base_url()?>market_item">Item</a></li>
			<li class="<?if(in_array($this->router->fetch_method(), array("itemkategori", "itemkategori_create","itemkategori_edit"))) echo "active";?>"><a href="<?= base_url()?>market_item/itemkategori">Kategori</a></li>
		</ul>
		<div class="row box-roomuser" style="padding:10px;">
			<?php $this->load->view("client/".$content) ?>
		</div>
	</div>
</div>
<div class="span2"></div>