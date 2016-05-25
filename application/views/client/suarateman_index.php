<? if($this->session->flashdata('data')): ?>
	<?$data = $this->session->flashdata('data');?>
<?endif;?>
<script>
	function save(){
		if($("#nama").val() == ""){
			alert("Nama Harus diiisi");
			$("#nama").focus();
			return false;
		}
		/*
		if($("#alamat").val() == ""){
			alert("Alamat Harus diiisi");
			$("#alamat").focus();
			return false;
		}
		
		if($("#tlpn").val() == ""){
			alert("no. telepon Harus diiisi");
			$("#tlpn").focus();
			return false;
		}
		
		if($("#HP").val() == ""){
			alert("no. handphone Harus diiisi");
			$("#HP").focus();
			return false;
		}
		*/
		if($("#pesan").val() == ""){
			alert("Pesan Harus diiisi");
			$("#pesan").focus();
			return false;
		}
		
		if($("#kode").val() == ""){
			alert("Kode Harus diiisi");
			$("#kode").focus();
			return false;
		}
		//location.reload();
		
		$("form").submit();
		/*
		$.post('<?php echo base_url();?>suarateman/create', { nama : $('#nama').val(), pesan : $('#pesan').val(), kode : $('#kode').val(), alamat : $('#alamat').val(), email : $('#email').val() }, function(hasil){
				alert(hasil);
				if(hasil.search("Data sudah disave")>-1){
					$('#nama').val('');
					$('#alamat').val('');
					$('#email').val('');
					$('#pesan').val('');
					$('#kode').val('');
					//$('#goodtesti_content').load("content_testimoni.php");
					//location.reload();					
					window.location=('<?php echo base_url()."suarateman";?>');
				}
				else{
					$('#kode').val('');s
				}
		});	
		*/
	}	
</script>


<?if($this->session->userdata('login') == false){?>
	<? $readonly = ''?>
<?}else{?>
	<? $readonly = 'readonly';}?>
<div class="span8 dashboard-wrapper">
	<h3 style="padding-left:10px;">Testimonial </h3>
	<div class="span12 form-berikan-kesanmu" style="padding:10px;margin-bottom:20px;"> <!--style="border:1px solid black; border-radius:10px; padding-bottom:10px;margin-bottom:10px;min-height:100px;"--> 
		<form action="<?base_url()?>suarateman/create" method="post" class="form-horizontal">
			<div class="control-group">
				<label class="control-label" style="text-align:left;">Nama</label>
				<div class="controls">
					: <input type="text" id="nama" name="nama" size="27" value="<?php if(isset($data)) echo $data['nama']; else echo $this->session->userdata('nama')?>" <?= $readonly;?>>
				</div>
			</div>
			<!--
				<div class="form-inline">
				<label class="vtop">Alamat</label>
				<textarea style="resize: none;" id="alamat" name="alamat" maxlength=500></textarea>
			</div>
			-->
			<div class="control-group">
				<label class="control-label" style="text-align:left;">Email</label>
				<div class="controls">
					: <input type="text" id="email" name="email" type="email" size="27" value="<?php if(isset($data)) echo $data['email']; else echo $this->session->userdata('username')?>" <?= $readonly;?>>
				</div>
			</div>
			<div class="control-group" style="margin-bottom:0px;">
				<label class="control-label" style="text-align:left;">Pesan</label>
				<div class="controls" style="vertical-align: text-top;">
					:
				</div>
			</div>
			<div style="margin-bottom:20px;">
				<textarea rows="5" style="resize: none;width:100%;" id="pesan" name="pesan" maxlength=500><?php if(isset($data)) echo $data['pesan']?></textarea>
			</div>
			<div style="margin-bottom:20px;">
				
			</div>
			<div class="control-group text-left">
				<?php echo $captcha['image']; ?> 
				<input class="input-small" type="text" id="kode" name="kode" size="8" maxlength="8" onkeypress="runScript(event)">
				<a class="btn btn-success" onclick="save()">Save</a>
			</div>
		</form>				
	</div>
	
	<div class="span12 setting-up" style="min-height:200px;">	
		<?php $x = 0;?>
		<? if (($dafkomen > 0)):?>
			<? foreach($dafkomen as $row){ ?>
				<?if($x == 0){?>
					<div class="span6" style="min-height:180px;">
				<?}else if($x % 5 == 0){?>
					</div><div class="span6" style="min-height:180px;">
				<?}?>
				<div id="box_testi" style="text-align: left;margin-left:10px;border-bottom:1px solid #efefef;">
					<div >
						<p style="margin:0px;text-align:left;line-height:15px;font-weight:bold;text-style:italic;font-size:14px;color:#0DAED3;">
							<?= $row->pesan; ?>
						</p>
						<small>
							<b><?php echo $row->nama."</b> ".date("d-M-Y", strtotime($row->date_create));?>
						</small>  <br/>
					</div>
				</div>
			
				<?php $x++;?>
			<? };?>
			<? else: ?>
				<? echo "<div class='span12' style='padding-top:240px;'><center>Belum ada kesan dari teman</center>";?>
			<? endif ?>	
			</div>		
			<? if (($dafkomen > 0)):?>
				<div class="span12">
					<?php echo $page;?>
				</div>
			<? endif ?>
		<div class="clearfix"></div>				
	</div>	
	<div class="clearfix"></div>	
	
</div>
<div class="span4">
	<?= another_menu() ?>
</div>
