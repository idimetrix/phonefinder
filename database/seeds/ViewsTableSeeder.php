<?php

use Illuminate\Database\Seeder;
use App\Models\View;

class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        View::query()->truncate();

        factory(View::class, 40000)->create();
    }
}
