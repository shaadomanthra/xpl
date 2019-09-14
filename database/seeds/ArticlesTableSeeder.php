<?php

use Illuminate\Database\Seeder;
use PacketPrep\Models\Content\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 3; $i++) { 
	    	Article::create([
	            'name' => str_random(8),
	            'slug' => str_random(12),
		        'description' => str_random(200),
		        'details' => str_random(300),
		        'keywords'=>'',
		        'related'=>'',
		        'math'=>1,
		        'status'=>1
			        ]);
    	}
    }
}
