<div class="span12">
	<span><?= date('d-m-Y H:i:s')?></span><br/>
	<span><?= $_SERVER['HTTP_USER_AGENT']?></span>
	<div class="col-sm-12">
		<div class="col-sm-4">
			<h3>Counting Board</h3>
			<table class="table table-bordered">
				<tr>
					<th>Nama Menu</th>
					<th>Jumlah Kunjungan</th>
				</tr>
				<?if(count($counting_board)>0):?>
					<?foreach($counting_board as $row){?>
						<tr>
							<td><?= $row->controller_name?></td>
							<td><?= $row->jumlah?></td>
						</tr>
					<?}?>		
				<?else:?>
					<tr>
						<td colspan="2"><center>Tidak ada kunjungan</center></td>
					</tr>
				<?endif?>
			</table>
		</div>
		<div class="col-sm-4">
			<h3>Counting Board Kemarin</h3>
			<table class="table table-bordered">
				<tr>
					<th>Nama Menu</th>
					<th>Jumlah Kunjungan</th>
				</tr>
				<?if(count($counting_board_yesterday)>0):?>
					<?foreach($counting_board_yesterday as $row){?>
						<tr>
							<td><?= $row->controller_name?></td>
							<td><?= $row->jumlah?></td>
						</tr>
					<?}?>		
				<?else:?>
					<tr>
						<td colspan="2"><center>Tidak ada kunjungan kemarin</center></td>
					</tr>
				<?endif?>
			</table>
		</div>
		<div class="col-sm-4">
			<h3>Counting Board Hari Ini</h3>
			<table class="table table-bordered">
				<tr>
					<th>Nama Menu</th>
					<th>Jumlah Kunjungan</th>
				</tr>
				<?if(count($counting_board_today)>0):?>
					<?foreach($counting_board_today as $row){?>
						<tr>
							<td><?= $row->controller_name?></td>
							<td><?= $row->jumlah?></td>
						</tr>
					<?}?>		
				<?else:?>
					<tr>
						<td colspan="2"><center>Tidak ada kunjungan hari ini</center></td>
					</tr>
				<?endif?>
			</table>
		</div>
	</div>
	<div style="clearfix"></div>
	<div class="col-sm-12">
		<div class="col-sm-12">
			<h3>Log Browser</h3>
			<table class="table table-bordered">
				<tr>
					<th width="70%">Browser</th>
					<th width="30%">Jam Akses</th>
				</tr>
				<?if(count($browser_log->num_rows)>0):?>
					<?foreach($browser_log->result() as $row){?>
						<tr>
							<td><?= $row->browser?></td>
							<td><?= show_tanggal($row->tanggal)?> <?= $row->waktu?></td>
						</tr>
					<?}?>		
				<?else:?>
					<tr>
						<td colspan="2"><center>Tidak ada log</center></td>
					</tr>
				<?endif?>
			</table>
            <?if(isset($links)):?>
                <center>
                    <nav>
                        <ul class="pagination">
                            <?= $links ?>
                        </ul>
                    </nav>
                </center>
            <?endif?>
		</div>
		<div class="col-sm-12">
			<h3>Count Browser</h3>
			<table class="table table-bordered">
				<tr>
					<th width="70%">Browser</th>
					<th width="30%">Jumlah Log</th>
				</tr>
				<?if(count($browser_log_count)>0):?>
					<?foreach($browser_log_count as $row){?>
						<tr>
							<td><?= $row->browser?></td>
							<td><?= $row->jumlah?></td>
						</tr>
					<?}?>		
				<?else:?>
					<tr>
						<td colspan="2"><center>Tidak ada log</center></td>
					</tr>
				<?endif?>
			</table>
		</div>
	</div>
</div>
<div class="clearfix"></div>