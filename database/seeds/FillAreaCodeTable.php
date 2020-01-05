<?php

use Illuminate\Database\Seeder;

class FillAreaCodeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefix = \App\Models\Phone::query()->withoutGlobalScopes()->select('prefix')->groupBy('prefix')->get();
        foreach ($prefix as $item) {
            $area_codes = \App\Models\Phone::query()->withoutGlobalScopes()->select('prefix', 'area_number')->where('prefix',
                $item->prefix)->groupBy('area_number')->get();
            foreach ($area_codes as $area_code) {
                \App\Models\AreaCode::create(['value' => $area_code->area_number, 'prefix' => $area_code->prefix]);
            }
        }
    }
}
