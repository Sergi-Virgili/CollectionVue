<?php

use Illuminate\Database\Seeder;

class CollectionsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Collection::class, 100)->create();
    }
}
