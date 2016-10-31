<?php

use Illuminate\Database\Seeder;

class CorporationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\tecai\Models\Organization\Corporation::class, 10)->create();
    }
}
