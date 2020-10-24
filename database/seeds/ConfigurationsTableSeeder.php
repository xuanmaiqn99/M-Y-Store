<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listConf = array(
        	[
        		'product_id' => 1,
        		'size' => 'S',
	            'color' => 'Vàng, đen',      	
	        ],
	        [
	        	'product_id' => 2,
        		'size' => 'M',
	            'color' => 'Vàng, đen',     	
	        ],
	        [
	        	'product_id' => 3,
        		'size' => 'S',
	            'color' => 'Vàng, đen',       	
	        ],
	        [
	        	'product_id' => 4,
        		'size' => 'L',
	            'color' => 'Vàng, đen',     	
	        ],
        );
        foreach ($listConf as $key => $value) {
        	DB::table('configurations')->insert($value);
        }
    }
}
