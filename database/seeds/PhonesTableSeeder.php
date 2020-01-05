<?php

use App\Models\Phone;
use Illuminate\Database\Seeder;

class PhonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Phone::query()->truncate();

        factory(Phone::class, 50)->create();
    }
}
