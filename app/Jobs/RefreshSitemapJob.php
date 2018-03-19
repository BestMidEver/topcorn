<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RefreshSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $myfile = fopen("sitemap.xml", "w") or die("Unable to open file!");
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
<url> <loc>https://topcorn.io/recommendations</loc> <lastmod>'.substr(Carbon::now(), 0, 10).'</lastmod> <changefreq>weekly</changefreq> <priority>1</priority> </url>
<url> <loc>https://topcorn.io/home</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>1</priority> </url>
<url> <loc>https://topcorn.io/register</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.50</priority> </url>
<url> <loc>https://topcorn.io/login</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.50</priority> </url>
<url> <loc>https://topcorn.io/faq</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.80</priority> </url>
<url> <loc>https://topcorn.io/privacy-policy</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
<url> <loc>https://topcorn.io/donation</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
<url> <loc>https://topcorn.io/password/reset</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
';

        $movies = DB::table('movies')
        ->select(
            'movies.id',
            'movies.original_title',
            'movies.updated_at'
        )
        ->get();
        foreach ($movies as $movie) {
            $xml = $xml.'<url> <loc>https://topcorn.io/movie/'.$movie->id.'-'.str_replace(array(' ','/','?','#'), '-', $movie->original_title).'</loc> <lastmod>'.substr($movie->updated_at, 0, 10).'</lastmod> <changefreq>weekly</changefreq> <priority>0.80</priority> </url> 
';
        }

        $xml = $xml . '</urlset> ';
        fwrite($myfile, $xml);
        fclose($myfile);
    }
}
