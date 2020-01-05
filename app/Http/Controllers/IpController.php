<?php

namespace App\Http\Controllers;

use App\Helpers\DataCacheHelper;
use App\Http\Requests\IpRequest;
use App\Jobs\FakeSafeUnsafeJob;
use App\Models\Ip;
use App\Models\Setting;

class IpController extends Controller
{
    public function index()
    {
        return view('pages.admin_ip', [
            'ips'                   => Ip::query()->orderBy('id', 'desc')->paginate(15),
            'setting_for_fake_safe' => (int)Setting::query()->where('key', 'button generate fake like')->first()->value,
            'image'                 => Setting::query()->where('key', 'image logo')->get()->first()->value,
            'google_analytics'      => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function create()
    {
        return view('pages.admin_ip_create', [
            'image'            => Setting::query()->where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function store(IpRequest $request)
    {
        Ip::create($request->all());

        return redirect('admin/ips');
    }

    public function edit(Ip $ip)
    {
        return view('pages.admin_ip_edit', [
            'ip'               => $ip,
            'image'            => Setting::query()->where('key', 'image logo')->get()->first()->value,
            'google_analytics' => DataCacheHelper::getAds('google analytics')
        ]);
    }

    public function update(IpRequest $request, Ip $ip)
    {
        $ip->update($request->all());

        return redirect('admin/ips');
    }

    public function destroy(Ip $ip)
    {
        $ip->delete();

        return redirect('admin/ips');
    }

    public function fakeSafeUnsafe()
    {
        if (Ip::query()->count() !== 0) {
            Setting::query()->where('key', 'button generate fake like')->update(['value' => 1]);
        }

        return redirect()->back();
    }
}
