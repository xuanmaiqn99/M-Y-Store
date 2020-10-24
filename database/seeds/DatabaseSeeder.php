<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AddressesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SlidesTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
        
    }
}
