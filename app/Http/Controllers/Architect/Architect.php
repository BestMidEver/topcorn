<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Architect extends Controller
{
	public function refreshSitemap()
    {
        $myfile = fopen("sitemap.xml", "w") or die("Unable to open file!");
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
<url> <loc>https://topcorn.xyz/recommendations</loc> <lastmod>'.substr(Carbon::now(), 0, 10).'</lastmod> <changefreq>weekly</changefreq> <priority>1</priority> </url>
<url> <loc>https://topcorn.xyz/home</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>1</priority> </url>
<url> <loc>https://topcorn.xyz/register</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.50</priority> </url>
<url> <loc>https://topcorn.xyz/login</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.50</priority> </url>
<url> <loc>https://topcorn.xyz/faq</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.80</priority> </url>
<url> <loc>https://topcorn.xyz/privacy-policy</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
<url> <loc>https://topcorn.xyz/donation</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
<url> <loc>https://topcorn.xyz/password/reset</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
';

        $movies = DB::table('movies')
        ->select(
            'movies.id',
            'movies.original_title',
            'movies.updated_at'
        )
        ->get();
        foreach ($movies as $movie) {
            $xml = $xml.'<url> <loc>https://topcorn.xyz/movie/'.$movie->id.'-'.str_replace(array(' ','/','?','#','&','<','>',"'",'"','*','%'), '-', $movie->original_title).'</loc> <lastmod>'.substr($movie->updated_at, 0, 10).'</lastmod> <changefreq>weekly</changefreq> <priority>0.80</priority> </url> 
';
        }        

        $movies = DB::table('series')
        ->select(
            'series.id',
            'series.original_name',
            'series.updated_at'
        )
        ->get();
        foreach ($movies as $movie) {
            $xml = $xml.'<url> <loc>https://topcorn.xyz/series/'.$movie->id.'-'.str_replace(array(' ','/','?','#','&','<','>',"'",'"','*','%'), '-', $movie->original_name).'</loc> <lastmod>'.substr($movie->updated_at, 0, 10).'</lastmod> <changefreq>weekly</changefreq> <priority>0.80</priority> </url> 
';
        }

        $xml = $xml . '</urlset> ';
        fwrite($myfile, $xml);
        fclose($myfile);


        return 'refreshing sitemap.';
    }
}
