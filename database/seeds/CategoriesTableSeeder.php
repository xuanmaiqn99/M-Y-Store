<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listCategory = array(
        	[
	            'name' => 'Áo',
	            'parent_id' => 0, 
			],
			[
	            'name' => 'Áo phông',
	            'parent_id' => 1, 
        	],
        	[
	            'name' => 'Sơ mi',
	            'parent_id' => 1, 
        	],
        	[
	            'name' => 'Quần',
	            'parent_id' => 4, 
        	],
        	[
	            'name' => 'Đồng hồ',
	            'parent_id' => 5, 
			],
			[
	            'name' => 'Giày',
	            'parent_id' => 6, 
			],
        ); 
       	foreach ($listCategory as $key => $value) {
       		DB::table('categories')->insert($value);
       	}
    }
}
