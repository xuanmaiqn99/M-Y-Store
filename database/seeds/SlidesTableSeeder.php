<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SlidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listSlide = array(
        	[
	            'name' => str_random(4),
	            'image_link' => 'slide1.jpg', 
        	],
        ); 
       	foreach ($listSlide as $key => $value) {
       		DB::table('slides')->insert($value);
       	}
    }
}
