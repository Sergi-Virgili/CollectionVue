<?php

use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            'name' => 'Spiderman',
            'user_id' => 1,
            'url' => 'https://cloud10.todocoleccion.online/comics-forum/tc/2012/01/10/29974877.jpg',
        ]);
    }
}
