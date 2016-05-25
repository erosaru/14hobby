<div class="col-sm-8">
    <form action="<?=base_url()?>pre-order" method="get" class="form">
	   <div class="input-group">      
		  <input type="text" class="form-control input-sm" style="height:34px" name="kata_kunci" value="<?= $this->input->get("kata_kunci")?>" placeholder="Masukkan Kata Kunci">
		  <span class="input-group-btn">
              <input type="submit" class="btn btn-default btn-success" value="Cari">
		  </span>
	   </div><!-- /input-group -->
    </form>
    <h2 class="cblack title-bar"><span style="font-size:20px;padding-right:20px;color:white;">Pre Order Terbaru</span></h2>
    <? if((count($dafkomen) > 0)): ?>
        <? foreach($dafkomen as $row):?>
            <div class="col-sm-12" style="border-bottom:1px solid #efefef;margin-bottom:10px;padding-bottom:10px;">
                <div class="col-sm-4" style="margin-bottom:10px;">
                    <center>
					   <?=resize_image_local_server("uploads/".$row->link_gambar, $row->name_barang)?>
				    </center>
				</div>
				<div class="col-sm-8 mobile-text-center" style="padding: 0 10px;">
					<div class="col-sm-12" style="min-height:20px;">
						<a href="<?=base_url().create_title($row->name_barang)?>"><?= $row->name_barang?></a><br/>
					</div>
				    <div class="col-sm-6" style="min-height:20px;">
                        
                        Harga: Rp <?= number_format($row->harga,0,',','.')?><br/>
                        <?if($row->dp_tipe == 1):?>
                            <?$jumlah_dp = $row->dp / 100 * $row->harga?>
                        <?else:?>
                            <?$jumlah_dp = $row->dp?>
                        <?endif?>
                        DP: Rp <?= number_format($jumlah_dp,0,',','.')?><br/>
						Slot: <?= $row->counter_order ? $row->counter_order : 0?> / <?= $row->slot?><br/>						
				    </div>
                    <div class="col-sm-6" style="min-height:20px;">
						Rilis: <?= date("M Y", strtotime($row->tgl_rilis))?> <br/>
                        Estimasi: <?= date("M Y", strtotime($row->tgl_tiba))?> <br/>
                        Deadline: <?= $row->tgl_deadline ? date("d-m-Y", strtotime($row->tgl_deadline)) : "PO bisa ditutup sewaktu-waktu"?><br/>
				    </div>
                    <div class="col-sm-12" style="min-height:20px;">
                        
                        <?= $row->catatan?><br/>
				    </div>
                    <div class="clearfix"></div>
				    <?if(($row->slot - $row->counter_order)  > 0):?>
						<a style="width:100px;" class="btn btn-success" href="<?=base_url()?>pre-order/detail-item/<?= create_title($row->name_barang)?>"><?=$this->session->userdata('role_id') == 3 ? "Order": "Order"?></a>
					<?else:?>
						<a style="width:100px;" class="btn btn-danger" href="">Lihat</a>
					<?endif?>
				</div>
            </div>
        <?endforeach?>
    <?else:?>
	   <center><?= $this->input->get("kata_kunci") ? "Tidak dapat menemukan barang dengan kata kunci <b>".$this->input->get("kata_kunci")."</b>" : "Tidak ada barang PO terbaru"?></center>
    <?endif?>					
</div>
<div class="col-sm-4">
	<?$this->load->view("client/sidebar")?>
</div>