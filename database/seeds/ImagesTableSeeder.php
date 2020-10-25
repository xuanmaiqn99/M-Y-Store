<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listImage = array(
        	[
        		'product_id' => 1,
        		'image_link' => 'anh1.jpg'
        	],
        	[
        		'product_id' => 1,
        		'image_link' => 'anh2.jpg'
        	],
        	[
        		'product_id' => 1,
        		'image_link' => 'anh3.jpg'
        	],
        	[
        		'product_id' => 2,
        		// 'image_link' => 'team-img02.jpg'
        	],
        	[
        		'product_id' => 2,
        		// 'image_link' => 'men-suits.jpg'
        	],
        	[
        		'product_id' => 3,
        		// 'image_link' => 'men-suits.jpg'
        	],
        	[
        		'product_id' => 3,
        		// 'image_link' => 'team-img02.jpg'
        	],
        	[
        		'product_id' => 4,
        		// 'image_link' => 'slide2.jpg'
        	],
        	[
        		'product_id' => 4,
        		// 'image_link' => 'slide2.jpg'
        	],
        );
        foreach ($listImage as $key => $value) {
       		DB::table('images')->insert($value);
       	}
    }
}
