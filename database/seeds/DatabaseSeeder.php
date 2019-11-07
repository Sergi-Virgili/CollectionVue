<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTable::class);
        $this->call(CategoriesTable::class);
        $this->call(CollectionsTable::class);
        $this->call(ItemSeeder::class);
        $this->call(LoveSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(ImageSeeder::class);
    }
}
