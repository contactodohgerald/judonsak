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
        //         $this->call(UsersTableSeeder::class);
        $this->call(ClientSeeder::class);
        //        $this->call(FolderSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(FrequencySeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(UserSeeder::class);
    }
}
