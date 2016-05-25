<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<div class="span2"></div>
<div class="span8">
	<?if($this->router->fetch_method() == "divisi_edit"){?>
		<? $url = base_url().$this->router->fetch_class()."/divisi_update/".$dafkomen[0]->id;?>
	<?}else{?>
		<? $url = base_url().$this->router->fetch_class()."/divisi_save/";}?>
	
	<form id="form_kategori" class="form-horizontal" method="post" action="<?= $url ?>">
		<div class="form-group">
			<label class="col-sm-3 control-label">Divisi</label>
			<div class="col-sm-9">
				<div class="col-sm-6" style="padding:0px;">
					<input type="text" value="<?php if(isset($dafkomen[0]->name_divisi)) echo $dafkomen[0]->name_divisi;else if(isset($data['name_divisi'])) echo $data["name_divisi"]?>" class="form-control" name="name_divisi" id="name_divisi">
				</div>
			</div>
		</div>
		
		<?if($this->uri->segment(2) != "divisi_edit"){?>
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<div class="col-sm-2" style="padding:0px;">
						<?php echo $captcha['image']; ?><br/><br/>
						<input class="form-control" type="text" id="kode" name="kode" size="8" maxlength="8">					
					</div>
				</div>
			</div>
			<div class="form-inline">
				<label class="span2">&nbsp;</label>
				<div class="span6">
					
				</div>
				<div class="clearfix"></div>
			</div>	
		<?}?>
		<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<input type="submit" class="btn btn-success" value="Simpan" style="width:100px;"> <a class="btn btn-danger" style="width:100px;" href="<?= base_url();?><?= $this->router->fetch_class();?>/divisi">Batal</a>
			</div>
		</div>

		<div class="form-inline">
			<label class="span2"></label>
			
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>