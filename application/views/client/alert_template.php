<?if($this->session->flashdata('success')):?>
	<div class='alert alert-success'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<?=$this->session->flashdata('success');?>
	</div>	
	<div class="clearfix"></div>
<?endif?>
				
<?if($this->session->flashdata('warning')):?>
	<div class='alert alert-danger'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<?=$this->session->flashdata('warning');?>
	</div>
	<div class="clearfix"></div>
<?endif?>