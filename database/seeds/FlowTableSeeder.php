<?php

use Illuminate\Database\Seeder;

class FlowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\VisitFlow::class, 50)->create();
    }
}
