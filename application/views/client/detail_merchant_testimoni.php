<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>

<div class="col-sm-12">
	<?if(isset($testimoni)):?>
		<?foreach($testimoni as $row):?>
			<div class="list-group">
				<a class="list-group-item active">
					<h4 class="list-group-item-heading"><?= $row->testimoni?></h4>
					<p class="list-group-item-text"><?=trim($row->first_name." ".$row->last_name)?></p>
				</a>
			</div>
		<?endforeach?>
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
	<?else:?>
		<h2 class="title-bar"><span style="font-size:20px;padding-right:20px;color:black;">Belum ada testimoni untuk seller ini</span></h2>
	<?endif?>
</div>

<div class="col-sm-12">
	<?if($this->session->userdata('login') == true && $this->session->userdata("role_id") == 3):?>
		<?if(!isset($have_input)):?>
			<form class="form-horizontal" method="post" action="<?= base_url()."save_testimoni"?>">
					<div class="control-group" style="margin-bottom:0px;">
						<label class="control-label" style="text-align:left;">Pesan</label>
					</div>
					<div style="margin-bottom:20px;">
						<textarea rows="5" style="resize: none;width:100%;" id="testimoni" name="testimoni" maxlength=500><?php if(isset($data)) echo $data['testimoni']?></textarea>
						<input type="hidden" name="merchant_id" value="<?= $merchant_id?>">
						<input type="hidden" name="buyer_id" value="<?= $this->session->userdata('id')?>">
					</div>			
					<div class="form-group" style="text-align:center;">
						<div class="col-sm-12" style="padding-left:85px;padding-right:85px;">
							<?php echo $captcha['image']; ?><br/>&nbsp;<br/>&nbsp;							
							<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8" required><br/>
						</div>
					</div>
					<div class="control-group text-center">
						<input type="submit" value="Submit" class="btn btn-success">
					</div>
			</form>
		<?else:?>
			<h2 class="title-bar"><span style="font-size:20px;padding-right:20px;color:black;">Anda hanya bisa mengisi testimoni untuk seller ini satu kali</span></h2>
		<?endif?>	
	<?endif?>
</div>
