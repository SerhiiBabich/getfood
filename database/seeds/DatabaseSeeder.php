<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('users')->truncate();

        User::create([
            'name' => 'Serhii',
            'email' => 'sergeghost+1@gmail.com',
            'password' => '123123123',
        ]);
    }
}
