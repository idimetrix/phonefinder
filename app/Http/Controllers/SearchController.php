<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Models\Search;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $top_search = DataCacheHelper::redis('last_search_10', '', 'addMinutes', '10', function () {
            return Search::query()
                         ->groupBy('phoneId')
                         ->with('phone')
                         ->orderBy('id', 'DESC')
                         ->select(['*', DB::raw('sum(count) as search_count')])
                         ->take(50)
                         ->get();
        });

        foreach ($top_search as $item) {
            if ($item->search_count > 2) {
                $item->color = 'warning';
            } else {
                $item->color = 'default';
            }
        }

        return view('pages.top_search', [
            'top_search'       => $top_search,
            'image'            => Setting::where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
