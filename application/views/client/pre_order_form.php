<script>
    $(document).ready(function () {
        $('#dp1').datepicker();
        $('#dp2').datepicker();
        $('#dp3').datepicker();
    });
    
	var gambar=new Array();
	tinymce.init({
		selector: "textarea",
		plugins: ["code", "image"]
	});
	function validate_number_integer_only(evt) {
		  var theEvent = evt || window.event;
		  var key = theEvent.keyCode || theEvent.which;
		  key = String.fromCharCode( key );
		  var regex = /[0-9]|[\b]|\t/;
		  if (key.keyCode != 8)
			  if( !regex.test(key)) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			  }
	}		
</script>

<div class="col-sm-1"></div>
<div class="col-sm-10">
	<? if($this->session->flashdata('data')): ?>
		<?$data = $this->session->flashdata('data');?>
	<?endif;?>

	<?if($this->router->fetch_method() == "edit_item_form"){?>
		<? $url = base_url()."pre_order/update/".$dafkomen[0]->id;?>
	<?}else{?>
		<? $url = base_url()."pre_order/save";}?>
	<form id="form_kategori" class="form-horizontal" method="post" action="<?= $url ?>" enctype='multipart/form-data'>
		<div class="form-group">
			<label class="col-sm-2 control-label text-primary"><?if($this->router->fetch_method() == "edit") echo "Update"; else echo "New"?> PO</label>
			<div class="col-sm-10 text-right">
				<a class="btn btn-primary" href="<?=base_url()?>pre_order/ensiklopedia_terkait<?if($this->router->fetch_method() == "edit_item_form") echo "?id=".$dafkomen[0]->id;?>">Pilih Barang</a>
			</div>
		</div>
		<?$link_ensiklopedia = $this->session->userdata("link_ensiklopedia");?>
		<?if(count($link_ensiklopedia) > 0 && !empty($link_ensiklopedia[0]['id'])):?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Item PO</label>
				<div class="col-sm-10" style="vertical-align:top;">
					
					<div class="col-sm-12 text-left">
						<a  target="_blank" href="<?=base_url()?><?=create_title($link_ensiklopedia[0]['name_barang'])?>"><?= $link_ensiklopedia[0]['name_merk']?> - <?= $link_ensiklopedia[0]['name_barang']?></a><br/>
						<?=resize_image_local_server($link_ensiklopedia[0]['link_gambar'], $link_ensiklopedia[0]['name_barang'])?><br/>	&nbsp;<br/>			
						<a  class="btn btn-danger btn-xs" href="<?=base_url()?>pre_order/delete_link_ensiklopedia<?if($this->router->fetch_method() == "edit_item_form") echo "?id=".$dafkomen[0]->id;?>">Hapus Link</a>
					</div>
					
				</div>
			</div>
		<?endif?>
		<div class="form-group">
            <label class="col-sm-2 control-label">Tanggal Rilis</label>
			<div class="col-sm-10">
                <div id="dp1" class="dp1 input-append date" data-date="" data-date-format="dd-mm-yyyy">
				    <input type="text" id="tgl_rilis" name="tgl_rilis" class="form-control" readonly size="16" style="width:100px" value= "<?if(isset($data)) echo show_tanggal($data['tgl_rilis']); else echo date('d-m-Y');?>">
                    <span class="add-on">
                        <i class="icon-th"></i>
                    </span>				
				</div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Tanggal Tiba</label>
			<div class="col-sm-10">
                <div id="dp2" class="dp2 input-append date" data-date="" data-date-format="dd-mm-yyyy">
				    <input type="text" id="tgl_tiba" name="tgl_tiba" class="form-control" readonly size="16" style="width:100px" value= "<?if(isset($data)) echo show_tanggal($data['tgl_tiba']); else echo date('d-m-Y');?>">
                    <span class="add-on">
                        <i class="icon-th"></i>
                    </span>				
				</div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Deadline</label>
			<div class="col-sm-10">
                <div id="dp3" class="dp3 input-append date" data-date="" data-date-format="dd-mm-yyyy">
				    <input type="text" id="tgl_deadline" name="tgl_deadline" class="form-control" readonly size="16" style="width:100px" value= "<?if(isset($data)) echo show_tanggal($data['tgl_deadline']);?>">
                    <span class="add-on">
                        <i class="icon-th"></i>
                    </span>				
				</div>
            </div>
        </div>
        <div class="form-group">
			<label class="col-sm-2 control-label">Harga</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['harga'];else if(isset($dafkomen)) echo $dafkomen[0]->harga?>" class="form-control" name="harga" id="harga" onkeypress="validate_number_integer_only(event)">
				</div>
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-2 control-label">DP</label>
			<div class="col-sm-10">
                <div class="col-sm-4" style="padding:0px;">
                    <select name="dp_tipe" class="form-control">
                        <option value="1" <? if(isset($data)) if($data['dp_tipe'] == 1) echo "selected";?> >Persen</option>
                        <option value="2" <? if(isset($data)) if($data['dp_tipe'] == 2) echo "selected";?>>Rupiah</option>
                    </select>
				</div>
                <div class="col-sm-1"></div>
				<div class="col-sm-4" style="padding:0px;">                    
					<input type="text" value="<? if(isset($data)) echo $data['dp'];else if(isset($dafkomen)) echo $dafkomen[0]->dp?>" class="form-control" name="dp" id="dp" onkeypress="validate_number_integer_only(event)">
				</div>
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-2 control-label">Slot</label>
			<div class="col-sm-10">
				<div class="col-sm-4" style="padding:0px;">
					<input type="text" value="<? if(isset($data)) echo $data['slot'];else if(isset($dafkomen)) echo $dafkomen[0]->stock?>" class="form-control" name="slot" id="slot" onkeypress="validate_number_integer_only(event)">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Catatan</label>
			<div class="col-sm-10 wysiwyg-container">
				<textarea class="ckeditor" name="catatan"><?php if(isset($data)) echo $data['catatan'] ; else if(isset($dafkomen)) echo $dafkomen[0]->catatan?></textarea>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
				<input class="btn btn-success" type="submit" value="<?if($this->router->fetch_method() != "edit_item_form") echo "Save"; else echo "Update"?>">
				<a href="<?= base_url()?>pre_order" class="btn btn-danger">Cancel</a>
			</div>
		</div>
	</form>
</div>
<div class="col-sm-1"></div>