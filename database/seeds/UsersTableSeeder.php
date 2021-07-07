<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Krshna Teja',
            'username'=>'krishnateja',
            'email' => 'packetcode@gmail.com',
            'password' => Hash::make('kastur1g'),
            'client_slug'=>'gradable',
            'role'=>2,
            'status'=>'0'
        ]);
    }
}
