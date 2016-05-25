<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url();?></loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
	
	<url>
        <loc><?= base_url();?>suarateman</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	
		<url>
        <loc><?= base_url();?>ready-stock-all-toy</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url();?>preorder-all-toy</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url();?>ready-stock-all-card-game</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url();?>preorder-all-toy-card-game</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	
 	<url>
        <loc><?= base_url();?>turnamen</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	
	<url>
        <loc><?= base_url();?>event</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url();?>artikel</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url();?>ensiklopedia</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url();?>list-komunitas</loc> 
		<lastmod><?= date("Y-m-d")?></lastmod>
		<changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>

	<?if($item->num_rows() > 0):?>
		<?foreach($item->result() as $row){?>
			<url>
				<loc><?= base_url();?><?= create_title($row->name_barang);?></loc> 
				<lastmod><?= date("Y-m-d")?></lastmod>
				<changefreq>daily</changefreq>
				<priority>0.5</priority>
			</url>
		<?}?>
	<?endif?>
	
	<?if($artikel->num_rows() > 0):?>
		<?foreach($artikel->result() as $row){?>
			<url>
				<loc><?= base_url();?><?= create_title($row->title);?></loc> 
				<lastmod><?= date("Y-m-d")?></lastmod>
				<changefreq>daily</changefreq>
				<priority>0.5</priority>
			</url>
		<?}?>
	<?endif?>
</urlset> 