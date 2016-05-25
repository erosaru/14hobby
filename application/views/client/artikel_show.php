<style>
	tbody tr:hover{
		background-color: white;
	}
	
	tbody.tablex tr td{
		border-bottom:1px solid black;
		padding:6px 0px;
	}
</style>

<div class="col-sm-9">
	<h2>Artikel dan Berita</h2>
	<form id="form_kategori" method="get" action="<?= base_url() ?>artikel" class="form-horizontal" style="border:1px solid #e1e1e1; padding:10px;">
		<div class="form-group">
			<label class="col-sm-3 control-label">Kategori Artikel</label>
			<div class="col-sm-9">
				<div class="col-sm-6" style="padding:0px;">
					<?= form_dropdown('id_kategori_artikel', $card_game_name, $this->input->get('id_kategori_artikel'), "class='form-control' id='id_kategori_artikel' onchange='ganti_merk($(this));''");?>	
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Judul Artikel</label>
			<div class="col-sm-9">
				<div class="col-sm-6" style="padding:0px;">
					<input type="text" name="nama_artikel" id="nama_artikel" class="form-control">	
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Nama Penulis</label>
			<div class="col-sm-9">
				<div class="col-sm-6" style="padding:0px;">
					<input type="text" name="nama_penulis" id="nama_penulis" class="form-control">	
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<input type="hidden" name="cari" value="cari">
				<input type="submit" value="Cari" class="btn btn-success">
			</div>
		</div>
	</form>
		<?if(!empty($dafkomen)):?>
			<p>
				<table width="100%">
					<tbody class="tablex">
						<? foreach($dafkomen as $row){?>
							<tr>
								<td>
									<a href="<?= base_url()?>artikel-<?= $row->url_title?>"><b><?= $row->title?></b></a><br/>
									<small>By: <?= $row->pengarang?>; Tentang: <?= $row->kategori?></small>
								</td>
								<td><span class="pull-right"><?= date("d M Y", strtotime($row->created_date))?></span><br/></td>
							</tr>
						<?}?>
					</tbody>
				</table>
			</p>
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
			<p>
				<center>
					Tidak ada artikel.<br/>
					<?if($this->input->get('cari') == 'cari'):?>
						<a href="<?= base_url()?>artikel" class="btn btn-danger">Refresh</a>
					<?else:?>
						<a href="<?= base_url()?>" class="btn btn-danger">Kembali</a>
					<?endif?>
				</center>
			</p>
		<?endif?>						
			
</div>
<div class="col-sm-3">	
	<? $this->load->view("client/sidebar")?>
</div>