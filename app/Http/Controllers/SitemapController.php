<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Models\Phone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    private static $directory = 'sitemap';

    public static function index()
    {
        if (!file_exists(public_path(self::$directory))) {
            \File::makeDirectory(public_path(self::$directory));
        } else {
            $files = array_map(function ($item) {
                return public_path(self::$directory . '/' . $item);
            }, array_diff(scandir(public_path(self::$directory)), ['..', '.']));
            \File::delete($files);
        }

        $url            = env('APP_URL');
        $base_name_file = 'sitemap';
        $folder         = 'sitemap/';
        $base_url       = [];
        $limit          = 50000;
        $offset_count   = 0;
        Cache::store('redis')->forget('prefix_count');
        Cache::store('redis')->forget('last_shown_phone_id');
        $count          = DataCacheHelper::countRowPhone();
        $query_count    = ceil($count / $limit);

        for ($i = 0; $i < $query_count; $i++) {
            $posts = Phone::query()->select('short_number')->skip($offset_count)->limit($limit)->get()->toArray();

            $links = array_map(function ($item) use ($url) {
                return '/phone/' . $item['short_number'];
            }, $posts);

            $offset_count += $limit;
            $name_file    = '/' . $folder . $base_name_file . '-' . $i . '.xml';
            array_push($base_url, $name_file);

            self::generateSiteMapXML($url, $links, 'child', $name_file);
        }
        self::generateSiteMapXML($url, $base_url, 'main', 'sitemap-all.xml');
    }

    public static function generateSiteMapXML($url, $links, $type, $file_name)
    {
        if ($type === 'main') {
            $xml = new \SimpleXMLElement('<sitemapindex/>');
            $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            $link = 'sitemap';
        } else {
            $xml = new \SimpleXMLElement('<urlset/>');
            $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            $xml->addAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');
            $xml->addAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');
            $xml->addAttribute('xmlns:video', 'http://www.google.com/schemas/sitemap-video/1.1');
            $link = 'url';
        }

        foreach ($links as $item) {
            $sitemap = $xml->addChild($link);
            $sitemap->addChild('loc', $url . $item);
            $sitemap->addChild('lastmod', Carbon::now()->toDateString());
            $sitemap->addChild('changefreq', 'monthly');
            $sitemap->addChild('priority', '0.5');
        }

        Header('Content-type: text/xml');
        $xml->asXML(public_path($file_name));
    }
}
