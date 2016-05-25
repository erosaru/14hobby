<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>

<h1>Side Banner</h1>
<form class="form" style="margin:0 auto; border:1px black solid; padding:10px;width:80%;" id="form_banner" class="form" method="post" action="<?= base_url();?>banner/save_sidebanner" enctype="multipart/form-data" accept-charset="utf-8">
	
	<?if(!empty($data_gambar)):?>
		<?= form_upload( array('name' => 'picture', 'id' => 'picture', 'size' => '72'))?>
		<?if(empty($data)):?>
			<?$id = ""?>
		<?else:?>
			<?$id = $data['id']?>
		<?endif?>
		<?= form_dropdown('id', $data_gambar, $id, "id='id' onchange='change_data();'");?>	
		<input id="img_alt" name="img_alt" type="text" value="<?if(isset($data)) echo $data['img_alt'];?>"><br/>
	<?else:?>
		<?= form_upload( array('name' => 'picture', 'id' => 'picture', 'size' => '72'))?>
		<input id="img_alt" name="img_alt" type="text" value="<?if(isset($data)) echo $data['img_alt'];?>"><br/>
	<?endif?><br/>
	<div class="form-inline">
		<label>Deskripsi</label>
			<div class="wysiwyg-container">
				<textarea class="ckeditor" name="deskripsi"><?php if(isset($data[0]->deskripsi)) echo $data[0]->deskripsi ; else if(isset($data)) echo $data['deskripsi']?></textarea>
			</div>
	</div>
	<center>
		<?php echo $captcha['image']; ?><br/>
		(masukkan 8 kode di atas)<br/>
		huruf besar dan kecil pengaruh<br/>				
		<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8"><br/>	
		
		<?if(!empty($dafkomen)):?>
			<a onclick="xdelete();return false;" class="btn btn-danger">Hapus</a> 
		<?endif?>
		<a onclick="save();return false;" class="btn btn-success">Save</a> 
	</center>
</form><br/>

<table class="table table-striped table-bordered">
	<thead >
		<th>Picture No</th>
		<th>Deskirpsi</th>
		<th>SEO</th>
	</thead>
	<tbody>		
		<?if(empty($picture)):?>
			<tr>
				<td colspan="3">
					<center>Belum ada gambar untuk banner</center>
				</td>
			</tr>
		<?else:?>	
			<? foreach($picture as $row){ ?>
				<tr>
					<td width="9%"><center><?= $row->id?></center></td>
					<td><?if(!empty($row->deskripsi)) echo $row->deskripsi; else echo "<center>-</center>"?></td>
					<td><?= $row->img_alt?></td>					
				</tr>
				<tr>
					<td colspan='3'><center><img width="700px" height="673" src="<?= base_url();?>asset/image/banner/<?= $row->link_picture?>"></center></td>
				</tr>
			<? }?>
		<?endif?>
	</tbody>
</table>



<script>
	tinymce.init({
		selector: "textarea",
		plugins: ["code"]
	});
	
	function xdelete(){
		if($("#id").val() == ""){
			alertify.alert("Masukkan gambar mana yang akan dihapus yang akan dihapus");			
			return false;
		}
		$("#form_banner").attr('action', "<?= base_url()?>banner/destroy");
		$("#form_banner").submit();
	}
	
	function save(){
		if($("#id").val() == "")
			if($("#picture").val() == ""){
				alertify.alert("Masukkan gambar dahulu");			
				return false;
			}
		
		if($("#img_alt").val() == ""){
			$("#img_alt").focus();
			alertify.alert("Masukkan kode gambar dahulu");			
			return false;
		}
		
		if($("#kode").val() == ""){
			$("#kode").focus();
			alertify.alert("Masukkan kode dahulu");			
			return false;
		}
		
		$("#form_banner").attr('action', "<?= base_url()?>banner/save_sidebanner");
		$("#form_banner").submit();
	}
	
	function change_data(){		
		var id = $("#id").val();
		switch(id){
		<? foreach($picture as $row){ ?>
			case "<?=$row->id?>": $("#img_alt").val("<?=$row->img_alt?>");tinyMCE.activeEditor.setContent("<?=mysql_escape_string($row->deskripsi)?>");break;
		<?}?>
			default: $("#img_alt").val("");tinyMCE.activeEditor.setContent("");;break;
		}
	}
</script>