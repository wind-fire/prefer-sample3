<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Tests\Seeds\UserTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();
            $this->call(UserTableSeeder::class);
        Model::guard();
    }
}
