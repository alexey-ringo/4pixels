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
        $this->call(UsersTableSeeder::class);
        factory(App\Models\User::class, 15)->create();
        $this->call(SectionTableSeeder::class);
        //factory(App\Models\Section::class, 15)->create();

    }
}
