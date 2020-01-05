<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Phone;
use App\Models\Report;
use App\Models\Search;
use App\Models\Setting;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;
use Mail;

class PagesController extends Controller
{
    public function home(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            preg_match('/^\d{2}/', $search, $number);
            if ($search[0] !== env('LOCAL_CODE')) {
                $number[0] === env('COUNTRY_CODE') ? $search = substr($search, 2) : '';
                $search = env('LOCAL_CODE') . $search;
            }

            $phone = Phone::query()
                          ->where('short_number', 'LIKE', "$search%")
                          ->first();

            if ($phone) {
                Search::updateOrCreate(
                    ['ip' => $request->ip(), 'phoneId' => $phone->id, 'search' => $search],
                    ['agent' => $request->header('User-Agent'), 'count' => DB::raw('count + 1')]
                );
            }

            return redirect($phone ? '/phone/' . $phone->short_number : '/report/' . $search);
        }

        if (PagesController::detect_mobile_device()) {
            $sidebar_ads = Setting::query()->where('key', 'phone ads')->first();
        } else {
            $sidebar_ads = Setting::query()->where('key', 'computer ads')->first();
        }
        $last_visits         = DataCacheHelper::lastVisited();
        $last_comments       = DataCacheHelper::lastCommented();
        $last_comments       = DataCacheHelper::selectSafeColor($last_comments);
        $last_comments_short = DataCacheHelper::lastCommentedShort($last_comments);
        $top_search          = DataCacheHelper::topSearched();
        $last_add_numbers    = DataCacheHelper::lastAddNumbers();
        $random_number       = DataCacheHelper::randomNumbers('home_page5', 'addHours', (33 - count($last_comments)));
        $google_analytics    = DataCacheHelper::getAds('google analytics');
        $population          = Lava::DataTable();
        $count               = (DataCacheHelper::redis('home_view_charts', '', 'addHours', '4', function () {
            return View::query()->select(array_merge([
                DB::raw('DATE_FORMAT(created_at, "' . [
                        'format' => '%H:%i:%s'
                    ]['format'] . '") as time'),
                DB::raw("(COUNT(*)) as total" . ', SUM(count) as sum_count')], []))
                       ->orderBy('created_at', 'DESC')
                       ->groupBy(DB::raw("" . ['format' => '%H:%i:%s', 'time' => 'DATE']['time'] . "(created_at)"), DB::raw("HOUR(created_at)"))
                       ->where('created_at', '>=', Carbon::now()->subHour(23))
                       ->get();
        }))->toArray();
        usort($count, function ($a, $b) {
            return ($a['time'] - $b['time']);
        });
        $population->addDateTimeColumn('time of day')->addNumberColumn(trans('chart.visitor'));
        Lava::AreaChart('Population', $population, [
            'title'  => trans('chart.frequency'),
            'legend' => [
                'position' => 'in'
            ],
        ]);
        foreach ($count as $item) {
            $time    = Carbon::now()->subHour(24);
            $Y       = date_parse_from_format("Y m d", $time)['year'];
            $m       = date_parse_from_format("Y m d", $time)['month'];
            $d       = date_parse_from_format("Y m d", $time)['day'];
            $a       = date_parse_from_format("H", $item['time'])['hour'];
            $rowData = [
                "$Y/$m/$d $a:00:00",
                $item['sum_count']
            ];
            $population->addRow($rowData);
        }
        $last_safe   = Phone::whereIn('id', queryForLikes(1))->withCount('likesSafe')->orderBy('likes_safe_count', 'desc')->get();
        $last_unsafe = Phone::whereIn('id', queryForLikes(-1))->withCount('likesUnsafe')->orderBy('likes_unsafe_count', 'desc')->get();
        foreach ($last_safe as $item) {
            if ($item->likes_safe_count >= 2) {
                $item->color = 'success';
            } else {
                $item->color = 'default';
            }
        }
        foreach ($last_unsafe as $item) {
            if ($item->likes_unsafe_count >= 2) {
                $item->color = 'error';
            } else {
                $item->color = 'default';
            }
        }

        return view('pages.home', [
            'safe'                => DataCacheHelper::getAds('tagged number safe'),
            'safe_description'    => DataCacheHelper::getAds('tagged number safe description'),
            'unsafe'              => DataCacheHelper::getAds('tagged number unsafe'),
            'unsafe_description'  => DataCacheHelper::getAds('tagged number unsafe description'),
            'image'               => Setting::where('key', 'image logo')->get()->first()->value,
            'last_safe'           => $last_safe,
            'last_unsafe'         => $last_unsafe,
            'chart'               => count($count) ? 1 : 0,
            'last_comments'       => $last_comments,
            'last_comments_short' => $last_comments_short,
            'last_visits'         => $last_visits,
            'top_search'          => $top_search,
            'last_add_numbers'    => $last_add_numbers,
            'search'              => $search,
            'random_number'       => $random_number,
            'ads'                 => $sidebar_ads,
            'google_review'       => DataCacheHelper::getAds('google review'),
            'google_analytics'    => $google_analytics
        ]);
    }

    public function detect_mobile_device()
    {
        if (stristr(@$_SERVER['HTTP_USER_AGENT'], 'windows') && !stristr(@$_SERVER['HTTP_USER_AGENT'], 'windows ce')) {
            return false;
        }

        if (preg_match('/up.browser|up. link |windows ce|iemobile|mini|mmp|symbian|midp|wap|phone|pocket|mobile|pda|psp/i',
            @$_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }

        if (isset($_SERVER['HTTP_ACCEPT']) && (stristr($_SERVER['HTTP_ACCEPT'], 'text/vnd.wap.wml') ||
                                               stristr($_SERVER['HTTP_ACCEPT'], 'application/vnd.wap.xhtml xml'))
        ) {
            return true;
        }

        if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) ||
            isset($_SERVER['X-OperaMini-Features']) || isset($_SERVER['UA-pixels'])
        ) {
            return true;
        }

        $a = array(
            'acs-',
            'alav',
            'alca',
            'amoi',
            'audi',
            'aste',
            'avan',
            'benq',
            'bird',
            'blac',
            'bla z',
            'brew',
            'cell',
            'cldc',
            'cmd-',
            'dang',
            'doco',
            'eric',
            'hipt',
            'inno',
            'ipaq',
            'java',
            'jigs',
            'kddi',
            'keji',
            'leno',
            'lg-c',
            'lg-d',
            'lg-g',
            'lge-',
            'maui',
            'maxo',
            'midp',
            'mi ts',
            'mmef',
            'mobi',
            'mot-',
            'moto',
            'mwbp',
            'nec-',
            'newt',
            'noki',
            'opwv',
            'palm',
            'pana',
            'pant',
            'pdxg',
            'phil',
            'play',
            'pluc',
            'port',
            'prox',
            'qtek',
            'qwap',
            'sage',
            'sams',
            's any',
            'sch-',
            'sec-',
            'send',
            'seri',
            'sgh-',
            'shar',
            'sie-',
            'siem',
            'smal',
            'smar',
            'sony ',
            'sph-',
            'symb',
            't-mo',
            'teli',
            'tim-',
            'tosh',
            'tsm-',
            'upg1',
            'upsi',
            'vk-v',
            'voda',
            ' w3c ',
            'wap-',
            'wapa',
            'wapi',
            'wapp',
            'wapr',
            'webc',
            'winw',
            'winw',
            'xda',
            'xda-'
        );
        if (isset($a[substr(@$_SERVER['HTTP_USER_AGENT'], 0, 4)])) {
            return true;
        }
    }

    public function phones()
    {
        return view('pages.phones', []);
    }

    public function countries()
    {
        $google_analytics = DataCacheHelper::getAds('google analytics');

        return view('pages.countries', [
            'google_analytics' => $google_analytics,
            'image'            => Setting::where('key', 'image logo')->get()->first()->value
        ]);
    }

    public function phone($number, Request $request)
    {
        $offset = $request->query('offset', 0);
        $limit  = $request->query('limit', 5);

        $phoneId = DataCacheHelper::getPhoneId($number);

        $population = Lava::DataTable();
        if (View::query()->where('phoneId', $phoneId)->get()) {
            $count = (View::query()->select(array_merge([
                DB::raw('DATE_FORMAT(created_at, "' . ['format'    => '%Y/%m/%d',
                                                       'time'      => 'DATE',
                                                       'curr_date' => ''
                    ]['format'] . '") as time'),
                DB::raw("(COUNT(*)) as total" . ', SUM(count) as sum_count')
            ], []))
                          ->orderBy('created_at', 'DESC')
                          ->where('phoneId', $phoneId)
                          ->groupBy(DB::raw("" . ['format'    => '%Y/%m/%d',
                                                  'time'      => 'DATE',
                                                  'curr_date' => ''
                              ]['time'] . "(created_at)"), DB::raw("YEAR(created_at)"))
                          ->whereRaw('created_at' . ['format'    => '%Y/%m/%d',
                                                     'time'      => 'DATE',
                                                     'curr_date' => ''
                              ]['curr_date'] . '')
                          ->paginate(10, ['*'], 'visitor'))->toArray();

            $population->addDateColumn()->addNumberColumn(trans('chart.visitor'));
            Lava::AreaChart('Population', $population, [
                'title'  => trans('chart.frequency'),
                'legend' => [
                    'position' => 'in'
                ]
            ]);
            for ($i = 0; $i < count($count['data']); $i++) {
                $rowData = [
                    $count['data'][$i]['time'],
                    $count['data'][$i]['sum_count']
                ];
                $population->addRow($rowData);
            }
        }

        if ($phoneId) {

            $comments = Comment::query()
                               ->where('phoneId', $phoneId)
                               ->orderBy('created_at', 'DESC')
                               ->skip($offset)
                               ->paginate($limit);

            $rating_query  = DataCacheHelper::getRating($phoneId, 0);
            $last_comments = DataCacheHelper::lastCommented();

            $like = DataCacheHelper::getLikes($phoneId, 0);

            $googleBots = ['google', 'googlebot', 'adsbot'];
            if (self::isGoogleBot($request->header('User-Agent'), $googleBots) === false) {
                if (strpos($request->header('referer'), 'google') !== false) {
                    View::updateOrCreate(
                        ['ip' => $request->ip(), 'phoneId' => $phoneId],
                        ['agent' => $request->header('User-Agent'), 'count' => DB::raw('count + 1')]
                    );
                }
            }

            $phone                = Phone::query()
                                         ->where('short_number', '=', $number)
                                         ->withCount('comments')
                                         ->withCount('views')
                                         ->withCount('search')
                                         ->first()
                ->format;
            $phone                = DataCacheHelper::updateAlias($phone->toArray());
            $random_numbers       = DataCacheHelper::randomNumbers($phone->id,
                env('PSEUD_RANDOM_PHONE') ? 'addYears' : 'addMinutes', 12);
            $last_visits          = DataCacheHelper::lastVisited();
            $phone->city          = DataCacheHelper::getCountry($phone->prefix);
            $phone->reports_count = Report::query()->where('phoneId', $phone->number)->count();
            $similar_number       = DataCacheHelper::getSimilarNumber($phone->short_number);
            $last_likes           = DataCacheHelper::lastLikes($phone->id);
            if (PagesController::detect_mobile_device()) {
                $sidebar_ads = Setting::query()->where('key', 'phone ads')->first();
                $top_ads     = Setting::query()->where('key', 'phone ads top')->first();
                $bottom_ads  = Setting::query()->where('key', 'phone ads bottom')->first();
                $ads_above_detailed = Setting::query()->where('key', 'phone ads above detailed')->first();
            } else {
                $sidebar_ads = Setting::query()->where('key', 'computer ads')->first();
                $top_ads     = Setting::query()->where('key', 'computer ads top')->first();
                $bottom_ads  = Setting::query()->where('key', 'computer ads bottom')->first();
                $ads_above_detailed = Setting::query()->where('key', 'computer ads above detailed')->first();
            }
            $google_analytics = DataCacheHelper::getAds('google analytics');
            debug($similar_number);
            $object = self::getLocation(isset($phone->city->location) ? $phone->city->location : '', $phone->prefix);
            $key    = 0;
            $lon    = '0';
            $lat    = '0';
            if (count($object) == 0) {
                $object = self::getLocation('', $phone->prefix);
                $key    = 1;
            }
            if ($object != null) {
                foreach ($object as $item) {
                    if ($item->type === 'city') {
                        $lon = $item->lon;
                        $lat = $item->lat;
                    }
                }
            }
            if (count($object) > 0) {
                $lon = $object[0]->lon;
                $lat = $object[0]->lat;
            }

            return view('pages.phone', [
                'safe'               => DataCacheHelper::getAds('tagged number safe'),
                'safe_description'   => DataCacheHelper::getAds('tagged number safe description'),
                'unsafe'             => DataCacheHelper::getAds('tagged number unsafe'),
                'unsafe_description' => DataCacheHelper::getAds('tagged number unsafe description'),
                'site_name'          => DataCacheHelper::getAds('site name'),
                'key'                => $key,
                'comments'           => $comments,
                'last_comments'      => $last_comments,
                'last_visits'        => $last_visits,
                'like'               => $like,
                'limit'              => $limit,
                'middle_rating'      => $rating_query['middle_rating'],
                'offset'             => $offset,
                'phone'              => $phone,
                'random_numbers'     => $random_numbers,
                'rating'             => $rating_query['rating'],
                'similar_number'     => $similar_number,
                'last_likes'         => $last_likes,
                'ads'                => $sidebar_ads,
                'top_ads'            => $top_ads,
                'ads_above_detailed' => $ads_above_detailed,
                'bottom_ads'         => $bottom_ads,
                'google_analytics'   => $google_analytics,
                'google_review'      => DataCacheHelper::getAds('google review'),
                'image'              => Setting::where('key', 'image logo')->get()->first()->value,
                'lon'                => $lon,
                'lat'                => $lat,
            ]);
        }

        return redirect('/');
    }

    public function isGoogleBot($string, $array)
    {
        for ($i = 0, $n = count($array); $i < $n; $i++) {
            if (($pos = strpos($string, $array[$i])) !== false) {
                return $pos;
            }
        }

        return false;
    }

    public function getLocation($city, $prefix)
    {
        return DataCacheHelper::redis('location_for_map_' . $prefix, '', 'addYears', '1', function () use ($city) {
            $url = 'http://nominatim.openstreetmap.org/search.php?city=' . $city . '&country=' . env('FULL_NAME_COUNTRY') . '&format=json';
            $url = str_replace(' ', '%20', $url);
            $ch  = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $output = curl_exec($ch);
            curl_close($ch);

            return json_decode($output);
        });
    }

    public function about()
    {
        $google_analytics = DataCacheHelper::getAds('google analytics');

        return view('pages.about', [
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => $google_analytics
        ]);
    }

    public function faq()
    {
        return view('pages.faq', []);
    }

    public function report($number = null)
    {
        $google_analytics = DataCacheHelper::getAds('google analytics');

        return view('pages.report', [
            'number'           => $number,
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => $google_analytics
        ]);
    }

    public function details($number)
    {
        if ($number) {
            $phone        = Phone::query()
                                 ->where('short_number', '=', $number)
                                 ->withCount('comments')
                                 ->withCount('views')
                                 ->withCount('search')
                                 ->first();
            $rating_query = DataCacheHelper::getRating($phone->id, 0);
            $phone->city  = DataCacheHelper::getCountry($phone->prefix);
            $comments     = Comment::query()
                                   ->where('phoneId', $phone->id)
                                   ->orderBy('created_at', 'DESC')
                                   ->paginate(1);
            $like         = DataCacheHelper::getLikes($phone->id, 0);

            return view('pages.phone_details', [
                'site_name'        => DataCacheHelper::getAds('site name'),
                'link_one'         => DataCacheHelper::getAds('link one'),
                'link_two'         => DataCacheHelper::getAds('link two'),
                'link_three'       => DataCacheHelper::getAds('link three'),
                'link_four'        => DataCacheHelper::getAds('link four'),
                'one'              => DataCacheHelper::getAds('details one'),
                'two'              => DataCacheHelper::getAds('details two'),
                'three'            => DataCacheHelper::getAds('details three'),
                'four'             => DataCacheHelper::getAds('details four'),
                'link_one_path'    => DataCacheHelper::getAds('link one path'),
                'link_two_path'    => DataCacheHelper::getAds('link two path'),
                'link_three_path'  => DataCacheHelper::getAds('link three path'),
                'link_four_path'   => DataCacheHelper::getAds('link four path'),
                'extra'            => DataCacheHelper::getAds('details extra four'),
                'like'             => $like,
                'phone'            => $phone,
                'middle_rating'    => $rating_query['middle_rating'],
                'rating'           => $rating_query['middle_rating'],
                'comments'         => $comments,
                'image'            => Setting::where('key', 'image logo')->get()->first()->value,
                'google_analytics' => DataCacheHelper::getAds('google analytics')
            ]);
        }

        return redirect('/');
    }

    public function getContacts()
    {
        $data['title']            = DataCacheHelper::getAds('title');
        $data['description']      = DataCacheHelper::getAds('description');
        $data['contacts']         = DataCacheHelper::getAds('contacts');
        $data['google_analytics'] = DataCacheHelper::getAds('google analytics');
        $data['image']            = Setting::where('key', 'image logo')->get()->first()->value;

        return view('pages.contact_us', $data);
    }

    public function getSafe()
    {
        ini_set('memory_limit', '-1');
        $lastId = \App\Helpers\DataCacheHelper::lastShownPhoneId();
        if (!empty($lastId)) {
            $top_safe = Like::query()->select(['*', DB::raw('count(phoneId) as safe_count')])->orderBy('id', 'DESC')
                            ->groupBy('phoneId')->where('phoneId', '<', $lastId)->with('phone')->where('value', 1)->paginate(50);
        } else {
            $top_safe = Like::query()->select(['*', DB::raw('count(phoneId) as safe_count')])->orderBy('id', 'DESC')
                            ->groupBy('phoneId')->with('phone')->where('value', 1)->paginate(50);
        }

        foreach ($top_safe as $item) {
            $item->color = ($item->safe_count >= 2) ? 'success' : 'default';
        }

        return view('pages.top_safe', [
            'top_safe'         => $top_safe,
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function getUnsafe()
    {
        ini_set('memory_limit', '-1');
        $lastId = \App\Helpers\DataCacheHelper::lastShownPhoneId();
        if (!empty($lastId)) {
            $top_unsafe = Like::query()->select(['*', DB::raw('count(phoneId) as unsafe_count')])
                              ->where('value', -1)->with('phone')->groupBy('phoneId')->where('phoneId', '<', $lastId)
                              ->orderBy('id', 'DESC')->paginate(50);
        } else {
            $top_unsafe = Like::query()->select(['*', DB::raw('count(phoneId) as unsafe_count')])
                              ->where('value', -1)->with('phone')->groupBy('phoneId')
                              ->orderBy('id', 'DESC')->paginate(50);
        }


        foreach ($top_unsafe as $item) {
            $item->color = ($item->unsafe_count >= 2) ? 'error' : 'default';
        }

        return view('pages.top_unsafe', [
            'top_unsafe'       => $top_unsafe,
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function getPrivacy()
    {
        return view('pages.privacy_policy', [
            'privacy'          => DataCacheHelper::getAds('privacy page'),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function getTerms()
    {
        return view('pages.terms', [
            'terms'            => DataCacheHelper::getAds('terms page'),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function admin_message(Request $request)
    {
        $user              = $request->all();
        $user['site_name'] = DataCacheHelper::getAds('site name')->value;
        Mail::send('emails.message', $user, function ($m) use ($user) {
            $m->from($user['email'], $user['site_name']);
            $m->to(env('EMAIL_RECEIVER'))->subject('Your Reminder!');
        });
        $data['title']            = DataCacheHelper::getAds('title');
        $data['description']      = DataCacheHelper::getAds('description');
        $data['contacts']         = DataCacheHelper::getAds('contacts');
        $data['google_analytics'] = DataCacheHelper::getAds('google analytics');
        $data['image']            = Setting::where('key', 'image logo')->get()->first()->value;

        return redirect('contact_us')->with([
            'data' => $data,
            'msg'  => 'Your message has been delivered and will be reviewed shortly.',
            'type' => 'alert-success'
        ]);
    }

}
