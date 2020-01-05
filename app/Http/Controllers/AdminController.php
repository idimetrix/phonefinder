<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Models\BotVisit;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Phone;
use App\Models\Report;
use App\Models\Search;
use App\Models\Setting;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $d           = $request->type ?: 0;
        $date        = [
            ['format' => '%d/%m/%Y', 'time' => 'DAY', 'curr_date' => '>= curdate()'],
            ['format' => '%d/%m/%Y', 'time' => 'DATE', 'curr_date' => ''],
            ['format' => '%m/%Y', 'time' => 'MONTH', 'curr_date' => ''],
            ['format' => '%Y', 'time' => 'YEAR', 'curr_date' => '']
        ];
        $safe        = [
            DB::raw('count(case when value=1 then 1 else null end) as safe'),
            DB::raw('count(case when value=-1 then 1 else null end) as unsafe')
        ];

        return view('pages.admin', [
            'count'            => Setting::where('key', 'number of first phones shown')->get()->first()->value,
            'safe'             => self::getAnalytics(Like::query(), $date, $d, 'safe', false, $safe),
            'visitors'         => self::getAnalytics(View::query(), $date, $d, 'visitor', true, []),
            'comments'         => self::getAnalytics(Comment::query(), $date, $d, 'comment', false, []),
            'ratings'          => self::getAnalytics(Like::query(), $date, $d, 'rating', false, []),
            'google_bots'      => self::getAnalytics(BotVisit::query(), $date, $d, 'google_bot', true, []),
            'google_analytics' => DataCacheHelper::getAds('google analytics'),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'select'           => $d
        ]);
    }

    /**
     * Get Analytics
     * @param \Illuminate\Database\Query\Builder $table_name
     * @param $date
     * @param $d
     * @param $page_name
     * @param $sum
     * @param $safe
     *
     * @return mixed
     */
    public function getAnalytics($builder, $date, $d, $page_name, $sum, $safe)
    {
        $sum_count = '';
        if ($sum) {
            $sum_count = ', SUM(count) as sum_count';
        }

        return $builder->select(array_merge([
            DB::raw('DATE_FORMAT(created_at, "' . $date[$d]['format'] . '") as time'),
            DB::raw("(COUNT(*)) as total" . $sum_count)
        ], $safe))->orderBy('created_at', 'DESC')
                  ->groupBy(DB::raw("" . $date[$d]['time'] . "(created_at)"), DB::raw("YEAR(created_at)"))
                  ->whereRaw('created_at' . $date[$d]['curr_date'] . '')
                  ->paginate(10, ['*'], $page_name);
    }

    public function create()
    {
        return view('pages.admin_create_phone', [
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function store(Request $request)
    {
        $country_code = '+' . env('COUNTRY_CODE');
        $local_code   = env('LOCAL_CODE');
        $number       = ActionsController::getNumber(substr($country_code, 1), $request);
        $short_number = self::getShortNumber($local_code, substr($country_code, 1), $request);
        $prefix       = $request->input('prefix');
        $aliases      = DataCacheHelper::generateAliases($request->input('number'), $prefix, $country_code,
            $local_code);
        if (Phone::where('number', $number)->exists()) {
            return redirect('admin/phone')->with(['msg' => 'This phone already exists!', 'type' => 'alert-danger']);
        }
        Phone::create([
            'prefix'       => $prefix,
            'number'       => $number,
            'country'      => env('COUNTRY'),
            'aliases'      => $aliases,
            'short_number' => $short_number,
            'area_number'  => substr(substr($number, strlen($prefix) + strlen($country_code) - 1), 0, -4)
        ]);

        return redirect('admin/phone')->with(['msg' => 'Phone in review!', 'type' => 'alert-success']);
    }

    public function getShortNumber($local_code, $country_code, $request)
    {
        preg_match('/^\d/', $request->input('number'), $first);
        preg_match('/^\d{' . strlen($country_code) . '}/', $request->input('number'), $two);
        $number = $local_code . $request->input('number');
        if ($first[0] === $local_code) {
            $number = $request->input('number');
        }
//        elseif($two[0] === $country_code){
//            $number = $local_code . substr($request->input('number'), strlen($country_code));
//        }
        return $number;
    }

    public function showSettings()
    {
        return view('pages.admin_setting', [
            'ads'              => Setting::where('key', '!=', 'button generate fake like')->orWhereNull('key')->get(),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function editSettings($id)
    {
        return view('pages.admin_edit_setting', [
            'ads'              => Setting::whereId($id)->get()->first(),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function updateSettings(Request $request, $id)
    {
        if ($request->file) {
            $image = Setting::find($id);
            $image->value == '' ?: File::delete(storage_path() . '/app/public/images/' . $image->value);
            $img = $request->file->store('public/images');
            Setting::find($id)->update(['value' => str_replace('public/images/', '', $img)]);
            Cache::store('redis')->forget(Setting::whereId($id)->get()->first()->key);

            return redirect('admin/settings');
        }
        $setting = Setting::find($id);
        $setting->update($request->all());
        Cache::store('redis')->forget($setting->key);
        Cache::store('redis')->forget(str_replace(' ', '_', $setting->key));
        if ($setting->key == 'number of first phones shown') {
            exec('php '. base_path() .'/artisan sitemap:generate > /dev/null &');
        }

        return redirect('admin/settings');
    }

    public function report()
    {
        return view('pages.admin_report', [
            'reports'          => Report::query()->orderBy('id', 'DESC')->paginate(10),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function destroyReport(Request $request, $id)
    {
        Report::destroy($id);

        return redirect('admin/report');
    }

    function deleteNumber(Request $request, int $id)
    {
        Phone::query()->where('id', $id)->delete();
        View::query()->where('phoneId', $id)->delete();
        Search::query()->where('phoneId', $id)->delete();
        Report::query()->where('phoneId', $id)->delete();
        Comment::query()->where('phoneId', $id)->delete();

        return self::showDelete($request);
    }

    public function showDelete(Request $request)
    {
        $search           = $request->query('search');
        $last_add_numbers = Phone::query()
                                 ->withCount('comments')
                                 ->withCount('views')
                                 ->withCount('likes')
                                 ->orderBy('created_at', 'DESC')
                                 ->take(20)
                                 ->get();
        if ($search) {
            preg_match('/^\d{2}/', $search, $number);
            if ($search[0] !== env('LOCAL_CODE')) {
                $number[0] === env('COUNTRY_CODE') ? $search = substr($search, 2) : '';
                $search = env('LOCAL_CODE') . $search;
            }
            $last_add_numbers = Phone::query()
                                     ->withCount('comments')
                                     ->withCount('views')
                                     ->withCount('likes')
                                     ->where('short_number', 'LIKE', "$search%")
                                     ->take('20')
                                     ->get();

            return view('pages.admin_delete', [
                'search'           => $search,
                'image'            => Setting::where('key', 'image logo')->get()->first()->value,
                'last_add_numbers' => $last_add_numbers,
            ]);
        }

        return view('pages.admin_delete', [
            'search'           => $search,
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'last_add_numbers' => $last_add_numbers,
        ]);
    }

    function viewsDiagram()
    {
        $population = Lava::DataTable();
        $count      = (self::getAnalytics(View::query(),
            [['format' => '%Y/%m/%d', 'time' => 'DATE', 'curr_date' => '']], 0, 'visitor', true, []))->toArray();
        $population->addDateColumn()->addNumberColumn('Number of visitors');
        Lava::AreaChart('Population', $population, [
            'title'  => 'Frequency of visits',
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

        return view('pages.view_diagram', ['image' => Setting::where('key', 'image logo')->get()->first()->value]);
    }

    public function indexTranslate()
    {
        $data['files'] = array_slice(scandir(resource_path() . '/lang/' . env('LOCALE')), 2);
        $data['image'] = Setting::where('key', 'image logo')->get()->first()->value;

        return view('pages.admin_translate', $data);
    }

    public function showTranslate($name)
    {
        $value = File::get(resource_path() . '/lang/' . env('LOCALE') . '/' . $name . '.php');
        $image = Setting::where('key', 'image logo')->get()->first()->value;

        return view('pages.admin_translate_edit', compact(['name', 'value', 'image']));
    }

    public function updateTranslate(Request $request, $name)
    {
        File::put(resource_path() . '/lang/' . env('LOCALE') . '/' . $name . '.php', $request->value);

        return redirect('admin/translation');
    }
}
