<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($rows as $id=>$data)
        <sitemap>
            <loc>{{route('sitemap.path',['id'=>$id])}}</loc>
        </sitemap>
    @endforeach
</sitemapindex>
