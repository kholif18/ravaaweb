<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ url('/product') }}</loc>
        <priority>0.9</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ url('/layanan') }}</loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ url('/portofolio') }}</loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ url('/software-house') }}</loc>
        <priority>0.7</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ url('/contact') }}</loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
    </url>
    @foreach($products as $product)
    <url>
        <loc>{{ route('detail-product', $product->slug) }}</loc>
        <priority>0.6</priority>
        <changefreq>weekly</changefreq>
        <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
    </url>
    @endforeach
    @foreach($services as $service)
    <url>
        <loc>{{ url('/layanan#' . $service->slug) }}</loc>
        <priority>0.5</priority>
        <changefreq>monthly</changefreq>
        <lastmod>{{ $service->updated_at->tz('UTC')->toAtomString() }}</lastmod>
    </url>
    @endforeach
    @foreach($portfolios as $portfolio)
    <url>
        <loc>{{ url('/portofolio#' . $portfolio->slug) }}</loc>
        <priority>0.5</priority>
        <changefreq>monthly</changefreq>
        <lastmod>{{ $portfolio->updated_at->tz('UTC')->toAtomString() }}</lastmod>
    </url>
    @endforeach
</urlset>
