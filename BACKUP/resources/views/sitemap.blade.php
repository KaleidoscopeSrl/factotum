<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($listData as $arrayIndex => $arrayData)
        @foreach($arrayData as $index => $data)
            <url>
                <loc>{{ $data->abs_url }}</loc>
                <lastmod>{{ gmdate(DateTime::W3C, strtotime($data->updated_at)) }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.9</priority>
            </url>
        @endforeach
    @endforeach
</urlset>