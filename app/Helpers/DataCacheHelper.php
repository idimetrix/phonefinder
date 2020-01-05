<?php

namespace App\Helpers;

use App\Models\Comment;
use App\Models\Country;
use App\Models\Like;
use App\Models\Phone;
use App\Models\Search;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class DataCacheHelper
{
    public static function lastVisited()
    {
        return self::redis('last_visit_121', '', 'addMinutes', '15', function () {
            return Phone::whereIn('id', queryForViews())->get();
        });
    }

    public static function redis($key, $id, $time_type, $time, $fn)
    {
        $key_generate = $key . $id;
        $expire       = Carbon::now()->$time_type($time);
        if (Cache::store('redis')->has($key_generate)) {
            error_log('get');

            return Cache::store('redis')->get($key_generate);
        } else {
            error_log('save and get');
            Cache::store('redis')->put($key_generate, $fn(), $expire);

            return Cache::store('redis')->get($key_generate);
        }
    }

    public static function getPhoneId($number)
    {
        return Phone::query()->where('short_number', '=', $number)->value('id');
    }

    public static function lastCommented()
    {
        $query = DB::select(
            'SELECT
                  comment_count,
                  comments.message,
                  phone.number,
                  phone.short_number,
                  AVG(likes.value) AS likes_avg
                FROM (
                       SELECT
                         COUNT(*)  AS comment_count,
                         (SELECT id
                          FROM comments
                          WHERE phoneId = cc.phoneId
                          ORDER BY created_at DESC
                          LIMIT 1) AS last_id
                       FROM comments cc
                       GROUP BY phoneId
                     ) id_table LEFT JOIN comments ON id_table.last_id = comments.id
                  , phone LEFT JOIN likes ON  likes.phoneId = phone.id
                WHERE comments.phoneId = phone.id and comments.phoneId < ' . self::lastShownPhoneId() .' 
                GROUP BY comments.phoneId
                ORDER BY comments.created_at DESC
                LIMIT 30'
        );

        foreach ($query as $item) {
            !isset($item->likes_avg) ? $item->likes_avg = 0 : '';
        }

        return $query;
    }

    public static function selectSafeColor($data)
    {
        foreach ($data as $item) {
            if ($item->likes_avg == 0) {
                $item->color = 'default';
            } elseif ($item->likes_avg > 0) {
                $item->color = 'success';
            } else {
                $item->color = 'danger';
            }
        }

        return $data;
    }

    public static function topSearched()
    {
        return Search::query()->select(['*', DB::raw('count(phoneId) as search_count')])
                              ->groupBy('phoneId', 'id')->with('phone')->orderBy('id', 'DESC')
                              ->orderBy('search_count', 'DESC')->take(50)->get();
    }

    public static function randomNumbers($phone_id, $period, $count)
    {
        $keys  = [];
        $start = Phone::first()->id;
        $end   = Phone::orderBy('id', 'DESC')->first()->id;

        for ($i = 0; $i < 400; $i++) {
            $key_id = rand($start, $end);
            array_push($keys, $key_id);
        }

        return array_map(function ($item) {
            return $item ['short_number'];
        }, Phone::query()->whereIn('id', $keys)->take($count)->get()->toArray());
    }

    public static function countRowPhone()
    {
        return self::redis('prefix_count', '', 'addYears', '1', function () {
            return Phone::query()->count();
        });
    }

    public static function prefixNumbers()
    {
        return self::redis('all_prefix_numbers', '', 'addMonths', '1', function () {
            return Phone::query()->select('prefix')->groupBy('prefix')->get();
        });
    }

    public static function numberOfFirstPhonesShown()
    {
        return self::redis('number_of_first_phones_shown', '', 'addMonths', '1', function () {
            return (int)Setting::query()->where('key', 'number of first phones shown')->first()->value;
        });
    }

    public static function lastShownPhoneId()
    {
        return self::redis('last_shown_phone_id', '', 'addMonths', '1', function () {
            return (int)Phone::query()->withoutGlobalScopes()->take(1)
                                 ->offset(self::numberOfFirstPhonesShown())->first()->id;
        });
    }

    public static function fullPrefixNumbers($prefix)
    {
        return self::redis('full_prefix_numbers' . $prefix, '', 'addMonths', '6', function () use ($prefix) {
            return Phone::query()->select('prefix', 'area_number')->where('prefix',
                $prefix)->groupBy('area_number')->get();
        });
    }

    public static function lastAddNumbers()
    {
        return Phone::query()->orderBy('id', 'DESC')->take(10)->get();
    }

    public static function getCountry($prefix)
    {
        return self::redis('country_', $prefix, 'addYears', '1', function () use ($prefix) {
            return Country::select('location')->where('prefix', $prefix)->get()->first();
        });
    }

    public static function getAds($key)
    {
        return self::redis($key, '', 'addYears', '1', function () use ($key) {
            return Setting::query()->where('key', $key)->first();
        });
    }

    public static function getLikes($phoneId, $request)
    {
        if ($request) {
            error_log('test ');
            Like::updateOrCreate(
                ['ip' => $request->ip(), 'phoneId' => $phoneId],
                ['agent' => $request->header('User-Agent'), 'value' => $request->input('value')]
            );
        }
        $likes = Like::query()->where('phoneId', $phoneId)->select([
             '*',
             DB::raw("count( ( CASE WHEN value = 1 THEN value END ) ) as positive"),
             DB::raw("count( ( CASE WHEN value = -1 THEN value END ) ) as negative"),
             DB::raw("count( ( CASE WHEN value = 0 THEN value END ) ) as neutral"),
         ])
         ->first();

        return $likes;
    }

    public static function getSimilarNumber($number)
    {
        $number = substr($number, 0, (strlen($number) - 3));
        debug($number);

        return self::updateAliases(Phone::query()->where('short_number', 'LIKE',
            $number . '%')->limit(15)->get()->toArray());
    }

    public static function updateAliases($phones)
    {
        return array_map(function ($item) {
            return self::updateAlias((object)$item);
        }, $phones);
    }

    public static function updateAlias($item)
    {
        $item          = (object)$item;
        $item->aliases = preg_replace('/\|[1-9].*\|0/', '|0', $item->aliases);
        $item->aliases = preg_replace('/tel:/', '', $item->aliases);
        $item->aliases = preg_replace('/\|/', ', ', $item->aliases);

        return $item;
    }

    public static function getRating($phoneId, $request)
    {
        if ($request) {
            error_log('test ');
            Comment::create(array_merge([
                'phoneId' => $phoneId,
                'active'  => 0,
                'ip'      => $request->ip(),
                'agent'   => $request->header('User-Agent'),
                'rating'  => $request->input('rating', 0)
            ], $request->only(['name', 'type', 'message'])));
        }
        $rating_query = Comment::query()->select('rating', DB::raw('count(rating) as rating_count'))
                        ->where('phoneId', $phoneId)->groupBy('rating')->orderBy('rating', 'DESC')->get();
        list($rating, $rating_request, $middle_rating, $sum_rating, $count_rating) = [[], [], 0, 0, 0];

        foreach ($rating_query as $item) {
            $rating[$item->rating] = $item->rating_count;
        }

        for ($i = 5; $i > 0; $i--) {
            if (isset($rating[$i])) {
                $sum_rating   += $rating[$i] * $i;
                $count_rating += $rating[$i];
            }
        }

        if ($count_rating > 0) {
            $middle_rating = round($sum_rating / $count_rating, 1);
        }

        $rating_request['rating']        = $rating;
        $rating_request['middle_rating'] = [
            'middle' => $middle_rating,
            'color'  => DataCacheHelper::selectRatingColor($middle_rating)
        ];

        return $rating_request;
    }

    public static function selectRatingColor($item)
    {
        if ($item == 0) {
            $color = 'default';
        } elseif ($item <= 2.5) {
            $color = 'danger';
        } elseif ($item <= 3.5) {
            $color = 'warning';
        } else {
            $color = 'success';
        }

        return $color;
    }

    public static function lastCommentedShort($last_comments)
    {
        $last_comments_short = [];
        if (count($last_comments) >= 12) {
            foreach ($last_comments as $item) {
                array_push($last_comments_short, $item);
            }
        } else {
            $last_comments_short = $last_comments;
        }

        return $last_comments_short;
    }

    public static function lastLikes($id)
    {
        $likes = Like::query()->where('phoneId', $id)->latest('id')->limit(5)->get();

        foreach ($likes as $item) {
            $geo = file_get_contents('http://api.sypexgeo.net/json/' . $item->ip);
            $geo = json_decode($geo);
            if ($geo->city || $geo->country) {
                $item->agent = $geo->city->name_en;
                $item->time  = $geo->country->name_en;
            } else {
                $item->agent = 'Columbus';
                $item->time  = 'United States';
            }
            $item->ip = preg_replace('/\.\d/', '.#', $item->ip);
        }

        return $likes;
    }

    public static function determinePrefixes($number)
    {
        $number = substr($number, 1);
        for ($i = 4; $i > 1; $i--) {
            $prefix = Phone::query()->select('prefix')->where('prefix', 'LIKE',
                substr($number, 0, $i) . '%')->groupBy('prefix')->get()->toArray();
            if (count($prefix) > 0) {
                return $prefix[0]['prefix'];
            }
        }

        return '';
    }

    // return format string +447554002044|+44 7554 002044|07554 002044|07554002044|+44-7554-002044
    public static function generateAliases($number, $prefix, $country_code, $local_code)
    {
        $number = substr($number, 1);
        $number_cat_prefix = ($prefix) ? substr($number, strlen($prefix)) : $number;

        return $country_code . $number . '|' . $country_code . ' ' . $prefix . ' ' . $number_cat_prefix . '|' . $local_code . $prefix . ' ' . $number_cat_prefix . '|' . $local_code . $number . '|' . $country_code . '-' . $prefix . '-' . $number_cat_prefix;
    }
}
