<?php

namespace App\Console\Commands;

use App\Models\Ip;
use App\Models\Like;
use App\Models\Phone;
use App\Models\Setting;
use Campo\UserAgent;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FakeSafeUnsafe extends Command
{
    protected $signature = 'command:fake_safe_unsafe';
    protected $description = 'Command description';

    public function handle()
    {
        if (Setting::query()->where('key', 'button generate fake like')->where('value', 1)->exists()) {
            $lastNumber = (int)Setting::query()->where('key', 'number of first phones shown')->first()->value;
            $lastPhoneId = (int)Phone::query()->withoutGlobalScopes()->take(1)->offset($lastNumber)->first()->id;
            \Schema::dropIfExists('fake_like');
            DB::select('create table fake_like like phone');
            DB::select('insert into fake_like (id,number) 
              select id,number from phone where id not in 
                (select phoneId from likes WHERE phoneId < ' . $lastPhoneId . ' 
                    group by phoneId) AND id < ' . $lastPhoneId);
            $offset     = 0;
            $likes      = (int)round($lastNumber * 0.5, 0);
            $ips        = Ip::query()->get();
            $time_start = time();
            if ($ips->count() > 0) {
                while ($offset < $likes) {
                    $phones = DB::table('fake_like')->take(10)->get();
                    $this->createFakeSafeUnsafe($phones, $ips);
                    DB::table('fake_like')->whereIn('id', $phones->pluck('id')->toArray())->delete();
                    $offset += 10;
                }
                $time_end = time();
                $this->info('Done.');
                $this->info(gmdate("H:i:s", $time_end - $time_start));
            } else {
                $this->info('No data for command');
            }
            \Schema::drop('fake_like');
            Setting::query()->where('key', 'button generate fake like')->update(['value' => 0]);
        }
    }

    /**
     * @param Collection $phones
     * @param Collection $ips
     */
    private function createFakeSafeUnsafe($phones, $ips)
    {
        $data = [];
        $i = 0;
        foreach ($phones as $value) {
            if ($i < 4) {
                array_push($data, $this->createFakeLike($value->id, -1, $ips));
                $i++;
            } else {
                array_push($data, $this->createFakeLike($value->id, 1, $ips));
                continue;
            }
            if ($i % 10 == 0) {
                $i=0;
            }
        }

        Like::query()->insert($data);
    }

    private function createFakeLike($phone_id, $value, $ips)
    {
        $ip      = $this->generateIp($ips);
        $u_agent = UserAgent::random([
            'os_type'     => ['Android', 'iOS', 'Xbox', 'Linux', 'OS X'],
            'device_type' => ['Mobile', 'Tablet', 'Desktop', 'Console']
        ]);
        $time    = date("Y-m-d H:i:s", rand(strtotime('2017-02-01 00:00:00'), time()));
        $data    = [
            'phoneId'    => $phone_id,
            'value'      => $value,
            'ip'         => $ip,
            'agent'      => $u_agent,
            'created_at' => $time,
            'updated_at' => $time,
        ];

        return $data;
    }

    /**
     * Generate random ip from mask
     *
     * @param Collection $ips
     *
     * @return string
     */
    private function generateIp($ips)
    {
        $ip = $ips->random();
        $ex = explode(".", $ip->value);

        return $ex[0] . '.' . $ex[1] . '.' . rand(1, 255) . '.' . rand(1, 255);
    }
}
