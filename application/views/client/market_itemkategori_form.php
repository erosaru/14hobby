<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<script>
	function before_save(){
		if($("#kategori").val() == ""){
			$("#kategori").focus();
			alertify.alert("Masukkan kategori dahulu");			
			return false;
		}
		<?if($this->uri->segment(2) != "itemkategori_edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}	
		<?}?>		
		
		$("#form_kategori").submit();				
	}
</script>

<div class="span2"></div>
<div class="span8">
	<?if($this->uri->segment(2) == "itemkategori_edit"){?>
		<? $url = base_url().$this->router->fetch_class()."/itemkategori_update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url().$this->router->fetch_class()."/itemkategori_save/";}?>
	
	<form id="form_kategori" class="form-horizontal" method="post" action="<?= $url ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label">Kategori</label>
			<div class="col-sm-10">
				<div class="col-sm-4">
					<input type="text" value="<?php if(isset($data[0]->name_kategori)) echo $data[0]->name_kategori;else if(isset($data['name_kategori'])) echo $data["name_kategori"]?>" class="form-control" name="kategori" id="kategori">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Picture</label>
			<div class="col-sm-10">
				<div class="col-sm-12">
					<input type="text" value="<?php if(isset($data[0]->link_gambar)) echo $data[0]->link_gambar;else if(isset($data['link_gambar'])) echo $data["link_gambar"]?>" class="form-control" name="link_gambar" id="link_gambar">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<a class="btn btn-success" href="" onclick="before_save();return false;">Save</a> <a class="btn btn-danger" href="<?= base_url();?><?= $this->router->fetch_class();?>/itemkategori">Cancel</a>
			</div>
		</div>
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>