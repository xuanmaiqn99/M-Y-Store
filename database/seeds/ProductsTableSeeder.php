<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$descript = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id nulla. Donec a neque libero.</p>';
        $listProduct = array(
        	[
        		'category_id' => 1,
        		'name' => 'Áo phông',
        		'descript' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id nulla. Donec a neque libero.</p>',
        		'price' => 299000,
        		'discount' => 135000,
				// 'avatar' => 'team-img02.jpg',
				'size' => 'M',
				'color' => 'Nâu'
        	],
        	[
        		'category_id' => 1,
        		'name' => 'Sơ mi',
        		'descript' => $descript,
        		'price' => 299000,
        		'discount' => 110000,
				// 'avatar' => 'team-img02.jpg',
				'size' => 'M',
				'color' => 'Nâu'
        	],
        	[
        		'category_id' => 3,
        		'name' => 'Quần',
        		'descript' => $descript,
        		'price' => 899000,
        		// 'discount' => 1350000,
				// 'avatar' => 'team-img02.jpg',
				'size' => 'M',
				'color' => 'Nâu'
        	],
        	[
        		'category_id' => 4,
        		'name' => 'Đồng hồ',
        		'descript' => $descript,
        		'price' => 629000,
        		'discount' => 500000,
				// 'avatar' => 'team-img02.jpg',
				'size' => 'M',
				'color' => 'Nâu'
        	],
        );
        foreach ($listProduct as $key => $value) {
       		DB::table('products')->insert($value);
       	}
    }
}
