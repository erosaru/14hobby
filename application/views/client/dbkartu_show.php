<script>
	function before_save(){
		if($("#pokemon_name").val() == ""){
			$("#pokemon_name").focus();
			alertify.alert("Masukkan Nama Pokemon dahulu");			
			return false;
		}
		
		if($("#boosterset").val() == ""){
			$("#boosterset").focus();
			alertify.alert("Masukkan Booster Set dahulu");			
			return false;
		}
		
		<?if($this->uri->segment(2) != "pokemon_edit"){?>
			if($("#kode").val() == ""){
				$("#kode").focus();
				alertify.alert("Masukkan kode dahulu");			
				return false;
			}		
		<?}?>
		
		$("#form_subkategori").submit();				
	}
	

</script>

<div class="span2"></div>
<div class="span8">
	<?if($this->uri->segment(2) == "pokemon_edit"){?>
		<? $url = base_url()."dbkartu/pokemon_update/".$data[0]->id;?>
	<?}else{?>
		<? $url = base_url()."dbkartu/pokemon_save/";}?>
	
	<form id="form_subkategori" class="form" method="post" action="<?= $url ?>" enctype="multipart/form-data" accept-charset="utf-8">
		<div class="form-inline">
			<label>Nama Pokemon</label>
			: <?php if(isset($data[0]->name_card)) echo $data[0]->name_card;?>
		</div>		
		<div class="form-inline">
			<label>Card Game Name</label>
			: <?php if(isset($data[0]->name_sub_kategori)) echo $data[0]->name_sub_kategori;?>
		</div>	
		<div class="form-inline">
			<label>Booster Set</label>
			: <?php if(isset($data[0]->booster_set)) echo $data[0]->booster_set;?>
		</div>	
		<?if($this->uri->segment(2) == "show" && !empty($data[0]->picture)){?>
			<div class="form-inline">
				<img src="<?= base_url();?><?= $data[0]->picture?>" style="width:150px;">
			</div>
		<?}?>
		<div class="form-inline">
			<a class="btn btn-danger" href="<?= base_url();?>dbkartu/delete/<?= $data[0]->id;?>" onclick="return(confirm('anda yakin akan menghapus data kartu ini?'))">Hapus</a> 
			<a class="btn btn-primary" href="<?= base_url();?>dbkartu">Kembali</a>
		</div>	
	</form>
</div>
<div class="span2"></div>
<div class="clearfix"></div>