<div class="col-sm-12">
	<!--
	<?if(!empty($name_merchant['img'])):?>
		<center><img src="<?= base_url()?>uploads/profile/<?= $name_merchant['img']?>"></center>
	<?else:?>
		<h1><?= $name_merchant['header']?></h1>
	<?endif?>
	-->
	<ul class="nav nav-tabs" id="myTab" >
		<li class="<?if(in_array($this->router->fetch_method(), array("index", "show"))) echo "active";?>"><a href="<?= base_url()?>detail-merchant/<?=$name_merchant['title']?>">Item</a></li>
		<li class="<?if(in_array($this->router->fetch_method(), array("profile"))) echo "active";?>"><a href="<?= base_url()?>detail-merchant/<?=$name_merchant['title']?>/profile">Profile</a></li>
		<li class="<?if(in_array($this->router->fetch_method(), array("testimoni"))) echo "active";?>"><a href="<?= base_url()?>detail-merchant/<?=$name_merchant['title']?>/testimoni">Testimoni</a></li>
		<li style="float:right;padding-top:16px;"><?=$name_merchant['title']?></li>
	</ul>
	<div class="row box-roomuser box-min-height">
		<?php $this->load->view("client/".$content2) ?>
	</div>
</div>
