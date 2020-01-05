<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Http\Requests\AreaRequest;
use App\Models\AreaCode;
use App\Models\Country;
use App\Models\Phone;
use App\Models\Setting;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            return view('pages.admin_city', [
                'city'             => Country::query()->orderBy('id', 'desc')->where('prefix', 'LIKE',
                    "$search%")->paginate(15),
                'image'            => Setting::where('key', 'image logo')->get()->first()->value,
                'google_analytics' => DataCacheHelper::getAds('google analytics')
            ]);
        }

        return view('pages.admin_city', [
            'search'           => $search,
            'city'             => Country::query()->orderBy('id', 'desc')->paginate(15),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function create()
    {
        return view('pages.admin_city_create', [
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function store(AreaRequest $request)
    {
        Country::create($request->all());

        return redirect('admin/area');
    }

    public function edit(Country $area)
    {
        return view('pages.admin_city_edit', [
            'city'             => $area,
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function update(AreaRequest $request, Country $area)
    {
        $area->update($request->all());

        return redirect('admin/area');
    }

    public function destroy(Country $area)
    {
        $area->delete();

        return redirect('admin/area');
    }

    public function areaCode(Request $request)
    {
        return view('pages.prefix', [
            'prefix'           => DataCacheHelper::prefixNumbers(),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function areaCodeNumbers(Request $request, $prefix)
    {
        return view('pages.full_prefix', [
            'prefix'           => $prefix,
            'city'             => DataCacheHelper::getCountry($prefix),
            'google_analytics' => DataCacheHelper::getAds('google analytics'),
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'full_prefix'      => AreaCode::where('prefix', $prefix)->paginate(500)
        ]);
    }

    public function suitedNumbers(Request $request, $prefix, $code)
    {
        return view('pages.suited_numbers', [
                'prefix'           => $prefix,
                'code'             => $code,
                'google_analytics' => DataCacheHelper::getAds('google analytics'),
                'image'            => Setting::where('key', 'image logo')->get()->first()->value,
                'numbers'          => Phone::query()->where('prefix', $prefix)->where('area_number',
                    $code)->paginate(20)
            ]
        );
    }
}
