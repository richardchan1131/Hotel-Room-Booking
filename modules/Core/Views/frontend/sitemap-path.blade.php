<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($rows as $url)
        <url>
            <loc>{{$url['loc']}}</loc>
            <lastmod>{{$url['lastmod'] ?? ''}}</lastmod>
        </url>
    @endforeach
</urlset>
