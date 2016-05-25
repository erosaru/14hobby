<?php
	if(isset($gambar)){
		$i=0;
		foreach($gambar as $row){
			if($row->set_gambar ==1){
				list($width, $height) = getimagesize(FCPATH."uploads/".$row->link_gambar);
				$dst_width2 = 200;
				$dst_height2 = ($dst_width2/$width)*$height;
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				if (preg_match('/Firefox/i', $user_agent)) { 
					if($dst_height2 < 290)
						$h = 300+10;
					else
						$h = $dst_height2+10;
				} else if (preg_match('/Chrome/i', $user_agent)) {
					$h = 300+10;
				} 
				$gambar_utama = "<a href='".base_url()."uploads/".$row->link_gambar."' data-lightbox='example-set' title='My caption'><img id='fuu2' width='$dst_width2' height='$dst_height2' class='resize' src='".base_url()."uploads/".$row->link_gambar."'  /></a>";
			}else{
				$gambar_lain[$i] = $row->link_gambar;
				$i++;
			}				
		}
	}
			
?>
<style>
	img.resize{
		max-width:100%; 
		max-height:100%;
		margin:auto;
		display:block;
	}
	
	#fuu {
		background-color: #FFFFFF;
		border: 1px solid #0066B3;
		border-radius: 4px 4px 4px 4px;
		float: left;
		margin: 3px 5px 3px 0;
		padding: 2px;
	}
	
	#fuu2{
		background-color: #FFFFFF;
		border: 1px solid #0066B3;
		border-radius: 4px 4px 4px 4px;
		margin: auto auto;
		padding: 2px;
	}

	#content-detail #kananx table{
		font: 15px/160% 'Adobe Garamond Pro';
		margin:0px;
		font-weight:bold;

	}
	
	#content-detail #kirix table{
		font: 15px/160% 'Adobe Garamond Pro';
		margin:0px;
	}
	
	#content-detail .kirix{
		height: <?php echo $h;?>;
		background-color: transparant;
		padding:0px;
	}
	
	#content-detail #kananx{
		width:70%;
		height: auto;
		float:left;
		background-color: transparant;
	}
	
	#content-detail #kananx #dalam{
		width:95%;
		height: auto;
		margin: 5px auto;
		margin-top: 20px;
		background-color: transparant;
		font-size:20px;
	}
	
	#content-detail #bawahx{
		width:100%;
		height: auto;
		float:left;
		background-color: transparant;
	}
</style>

<div class='span8'>
	<div id='content-detail'>
			<div class='span4 kirix'>
				<table background='white' border="0" width="100%" height="200px">
				<tr>
					<td valign=center><?php if(empty($gambar_utama))echo "<a href='".base_url()."asset/image/kategori/no_picture.png' data-lightbox='example-set' title='My caption'><img id='fuu2' width='100px' class='resize' src='".base_url()."asset/image/kategori/no_picture.png'  /></a>"; else echo $gambar_utama;?></td>
				</tr>
				</table>
			</div>
			<div class='span8'>
				<div id="dalam">
					<center>
					<ul style="margin:0;padding:0px 0px 0px 0px;">
					<table width="100%" style="border-top: 1px solid black;border-bottom: 1px solid black;">
							<tr>
								<td height="20px">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td height="15px"><li>Nama Barang</li></td>
								<td>: <?php echo $data[0]->name_barang?></td>
							</tr>
							<tr>
								<td height="15px"><li>Harga</li></td>
								<td>: <?php 
											echo "Rp. ".number_format($data[0]->harga,0,',','.');
											if ($data[0]->diskon > 0){
												$nilai_diskon = $data[0]->harga * $data[0]->diskon / 100;
												$harga_diskon = $data[0]->harga - $nilai_diskon;
												echo " - Rp. ".number_format($nilai_diskon,0,',','.')."(".$data[0]->diskon."%) = Rp. ".number_format($harga_diskon,0,',','.');
											}											
								      ?>
								</td>
							</tr>
							<tr>
								<td height="15px"><li>Manufacture</li></td>
								<td height="15px">: <?= $data[0]->name_sub_kategori?></td>
							</tr>
							<tr>
								<td height="15px"><li>Berat</li></td>
								<td>: <?php echo $data[0]->berat?> kg</td>
							</tr>
							<tr>
								<td height="20px">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
					</table>
					<table width="100%" style="border-bottom: 1px solid black;">
	 						<tr>
								<td height="15px" ><center>Deskripsi</center></td>
							</tr>
							<tr>
								<td height="15px" style="font-weight:none; font:12px/160% Arial;" align="justify"><?php echo $data[0]->deskripsi;?></td>
							</tr>
							<tr>
								<td height="20px">&nbsp;</td>
							</tr>
					</table>
					</ul>
					</center>
				</div>
				<div id="bawahx">
					<center>
					<?php			
						if(isset($gambar_lain)){
							echo "<table><caption>Galeri Barang</caption><tr>";
							$col = 4;
							$cnt = 0;
							foreach($gambar_lain as $row){
								if ($cnt >= $col) {
									echo "</tr><tr>";
									$cnt = 0;
								}
								$cnt++;
								$link = FCPATH."uploads/".$row;								
								list($width, $height) = getimagesize($link);
								$dst_width2 = 100;
								$dst_height2 = ($dst_width2/$width)*$height;
								$link = base_url()."uploads/".$row;
								echo "<td align=center valign=top><br /><a class='example-image-link' href='$link' data-lightbox='example-set' title='My caption'><img id='fuu' width='$dst_width2' height='$dst_height2' class='resize' src='$link'  /></a></td>";
							}
							echo "</tr></table>";
						}
					?>
					</center>
				</div>	
			</div>
			
	</div>
</div>
<div class="span4">
</div>