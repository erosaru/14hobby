<div class="col-sm-12">
	<ul class="nav nav-tabs" id="myTab" style="margin-bottom:0px;">
		<li class="<?if($this->router->fetch_class() == "dashboard") echo "active";?>"><a href="<?= base_url()?>dashboard">Dashboard</a></li>
		<li class="<?if((in_array($this->router->fetch_method(), array("index", "change_password", "change_profile", "account_bank_form")) && $this->router->fetch_class() == "roomuser")) echo "active";?>"><a href="<?= base_url()?>roomuser">Profile</a></li>
		<?if($this->session->userdata('role_id') == 2):?>		
			<li class="<?if((in_array($this->router->fetch_method(), array("item_list", "ensiklopedia_terkait", "item_form", 'edit_item_form', "item_show")) && $this->router->fetch_class() == "roomuser") || (in_array($this->router->fetch_method(), array("edit", "show")) && $this->router->fetch_class() == "item")) echo "active";?>"><a href="<?= base_url()?>list-item">Item</a></li>
			<li class="<?if(in_array($this->router->fetch_method(), array("view_order", "order_list", "order_form", 'invoice_view', 'invoice_calculate', 'invoice_form'))) echo "active";?>"><a href="<?= base_url()?>list-order">Order</a></li>
		<?endif?>
		<?if($this->session->userdata('role_id') == 3):?>
			<li class="<?if(in_array($this->router->fetch_method(), array("view_order", "order_list", "order_form", 'invoice_view', 'invoice_calculate', 'invoice_form'))) echo "active";?>"><a href="<?= base_url()?>list-order">Order</a></li>
		<?endif?>		
		<?if($this->session->userdata('role_id') == 1):?>
			<li class="<?if(in_array($this->router->fetch_method(), array('needapprove'))) echo "active";?>"><a href="<?= base_url()?>user/needapprove">User</a></li>
			<li class="<?if((in_array($this->router->fetch_method(), array("item_need_approve")) && $this->router->fetch_class() == "roomuser") || (in_array($this->router->fetch_method(), array("edit", "show")) && $this->router->fetch_class() == "item")) echo "active";?>"><a href="<?= base_url()?>roomuser/item_need_approve">Item</a></li>
			<li class="<?if(in_array($this->router->fetch_method(), array("show_event_validation"))) echo "active";?>"><a href="<?= base_url()?>event-for-check">Event</a></li>
			<!--<li class="<?if(in_array($this->router->fetch_method(), array("payment_list", "payment_view")) && $this->router->fetch_class()=="roomuser") echo "active";?>"><a href="<?= base_url()?>payment-list">Payment</a></li>-->
		<?endif?>
	</ul>
	<div class="box-roomuser box-min-height">	
		<?php $this->load->view("client/".$content) ?>
	</div>
</div>