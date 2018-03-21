<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'slug' => 'administrator',
            '_lft' => '1',
            '_rgt' => '2',
            'parent_id' => null,
        ]);
    }
}
