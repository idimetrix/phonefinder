<?php

namespace App\Http\Middleware;

use App\Models\BotVisit;
use Closure;
use Illuminate\Support\Facades\DB;

class BlackList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $google_bots = ['Googlebot', 'AdsBot'];
//        foreach ($google_bots as $item){
//            if(substr_count($request->header('User-Agent'), $item)){
//              BotVisit::query()
//                    ->whereRaw('Date(created_at) = CURDATE()')
//                    ->updateOrCreate(['agent' => $request->header('User-Agent')],['count' => DB::raw('count + 1')]);
//            }
//        }

        $googleBots = ['google', 'googlebot', 'adsbot'];

        foreach ($googleBots as $googleBot) {
            if (strpos(strtolower($request->header('User-Agent')), $googleBot) !== false) {
                if ($this->validateGoogleBotIP($request->ip())) {
                    BotVisit::query()
                            ->whereRaw('Date(created_at) = CURDATE()')
                            ->updateOrCreate(['agent' => $request->header('User-Agent')],
                                ['count' => DB::raw('count + 1')]);
                }

                break;
            }
        }


        $black_list = [
            'BLEXBot',
            'BlackWidow',
            'Nutch',
            'Jetbot',
            'WebVac',
            'Stanford',
            'scooter',
            'naver',
            'dumbot',
            'Hatena\ Antenna',
            'grub',
            'looksmart',
            'WebZip',
            'larbin',
            'b2w/0.1',
            'Copernic',
            'psbot',
            'Python-urllib',
            'NetMechanic',
            'URL_Spider_Pro',
            'CherryPicker',
            'EmailCollector',
            'EmailSiphon',
            'WebBandit',
            'EmailWolf',
            'Email',
            'ExtractorPro',
            'CopyRightCheck',
            'Crescent',
            'SiteSnagger',
            'ProWebWalker',
            'CheeseBot',
            'LNSpiderguy',
            'ia_archiver',
            'Alexibot',
            'Teleport',
            'MIIxpc',
            'Telesoft',
            'Website\ Quester',
            'moget',
            'WebStripper',
            'WebSauger',
            'WebCopier',
            'NetAnts',
            'Mister\ PiX',
            'WebAuto',
            'TheNomad',
            'WWW-Collector-E',
            'RMA',
            'libWeb/clsHTTP',
            'asterias',
            'httplib',
            'turingos',
            'spanner',
            'Harvest',
            'InfoNaviRobot',
            'Bullseye',
            'WebBandit',
            'NICErsPRO',
            'Microsoft\ URL\ Control',
            'DittoSpyder',
            'Foobot',
            'WebmasterWorldForumBot',
            'SpankBot',
            'BotALot',
            'lwp-trivial',
            'WebmasterWorld',
            'BunnySlippers',
            'URLy\ Warning',
            'Wget',
            'LinkWalker',
            'cosmos',
            'hloader',
            'humanlinks',
            'LinkextractorPro',
            'Offline\ Explorer',
            'Mata\ Hari',
            'LexiBot',
            'Web\ Image\ Collector',
            'The\ Intraformant',
            'True_Robot',
            'BlowFish',
            'SearchEngineWorld',
            'JennyBot',
            'MIIxpc',
            'BuiltBotTough',
            'ProPowerBot',
            'BackDoorBot',
            'toCrawl/UrlDispatcher',
            'WebEnhancer',
            'suzuran',
            'WebViewer',
            'VCI',
            'Szukacz',
            'QueryN',
            'Openfind',
            'Openbot',
            'Webster',
            'EroCrawler',
            'LinkScan',
            'Keyword',
            'Kenjin',
            'Iron33',
            'Bookmark\ search\ tool',
            'GetRight',
            'FairAd\ Client',
            'Gaisbot',
            'Aqua_Products',
            'Radiation\ Retriever\ 1.1',
            'Flaming\ AttackBot',
            'Oracle\ Ultra\ Search',
            'MSIECrawler',
            'PerMan',
            'searchpreview',
            'sootle',
            'Enterprise_Search',
            'Bot\ mailto:craftbot@yahoo.com',
            'ChinaClaw',
            'Custo',
            'DISCo',
            'Download\ Demon ',
            'eCatch',
            'EirGrabber',
            'EmailSiphon',
            'EmailWolf',
            'Express\ WebPictures',
            'ExtractorPro',
            'EyeNetIE',
            'FlashGet',
            'GetRight',
            'GetWeb!',
            'Go!Zilla',
            'Go-Ahead-Got-It',
            'GrabNet',
            'Grafula',
            'HMView',
            'HTTrack',
            'Image\ Stripper',
            'Image\ Sucker',
            'Indy\ Library',
            'InterGET',
            'Internet\ Ninja',
            'JetCar',
            'JOC\ Web\ Spider',
            'larbin',
            'LeechFTP',
            'Mass\ Downloader',
            'MIDown\ tool',
            'Mister\ PiX',
            'Navroad',
            'NearSite',
            'NetAnts',
            'NetSpider',
            'Net\ Vampire',
            'NetZIP',
            'Octopus',
            'Offline\ Explorer',
            'Offline\ Navigator',
            'PageGrabber',
            'Papa\ Foto',
            'pavuk',
            'pcBrowser',
            'RealDownload',
            'ReGet',
            'SiteSnagger',
            'SmartDownload',
            'SuperBot',
            'SuperHTTP',
            'Surfbot',
            'tAkeOut',
            'Teleport\ Pro',
            'VoidEYE',
            'Web\ Image\ Collector',
            'Web\ Sucker',
            'WebAuto',
            'WebCopier',
            'WebFetch',
            'WebGo\ IS',
            'WebLeacher',
            'WebReaper',
            'WebSauger',
            'Website\ eXtractor',
            'Website\ Quester',
            'WebStripper',
            'WebWhacker',
            'WebZIP',
            'Wget',
            'Widow',
            'WWWOFFLE',
            'Xaldon\ WebSpider',
            'Zeus',
            'Semrush',
            'BecomeBot',
            'AhrefsBot',
            'MJ12bot',
            'rogerbot',
            'exabot',
            'Xenu',
            'dotbot',
            'gigabot',
            'BlekkoBot',
            'YandexBot'
        ];

        foreach ($black_list as $item) {
            if (strpos(strtolower($request->header('User-Agent')), strtolower($item)) !== false) {
                return redirect('404');
            }
        }

        return $next($request);
    }

    private function validateGoogleBotIP($ip)
    {
        return preg_match('/\.googlebot\.com$/i', gethostbyaddr($ip)); //"crawl-66-249-66-1.googlebot.com"
    }
}
