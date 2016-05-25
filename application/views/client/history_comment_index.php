<h1>History Comment</h1>
<table class="table table-striped table-bordered" align="center">
	<thead>
		<tr>
			<th><center>CommentID</center></th>
			<th><center>Link</center></th>
			<th><center>Waktu</center></th>
			<th><center>Status</center></th>
		</tr>
	</thead>
	<tbody>
		<? if (($dafkomen->num_rows > 0)){ ?>
			<? foreach($dafkomen->result() as $row){?>
			<tr>
				<td><?= $row->id_comment_fb?></td>
				<td><?= $row->link?></td>
				<td><?= show_tanggal($row->tanggal)?> <?= $row->waktu?></td>
				<td><?= $row->status?></td>
			</tr>
			<?}?>
		<?}else{?>
			<tr>
				<td  colspan="4"><center>Belum ada data history comment</center></td>
			</tr>
		<?}?>
	</tbody>
</table>
