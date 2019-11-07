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
        DB::table('collections')->insert([
            'name' => 'Amazing Spiderman',
            'description' => 'comics antiguos de Amazing Spiderman, primera tirada cada uno',
            'user_id' => 1,
            'img_url'=>'https://cloud10.todocoleccion.online/comics-forum/tc/2012/01/10/29974877.jpg',
            'category_id' => 7,

        ]);
        factory(App\Collection::class, 100)->create();
    }
}
