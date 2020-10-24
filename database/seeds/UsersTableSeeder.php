<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listUser = array(
            [
                'name' => 'Admin Mai',
                'email' => 'mai@gmail.com',
                'phone' => '01638161533',
                'level' => 1, 
                'password' => bcrypt('123456'),
                'remember_token' => str_random(10),
                'address_id' => 1, 
            ],
            [
                'name' => 'Le Thi Be',
                'email' => 'be@gmail.com',
                'phone' => '01638161533',
                'level' => 0, 
                'password' => bcrypt('123321'),
                'remember_token' => str_random(10),
                'address_id' => 2, 
            ],
            [
                'name' => 'Nguyen Van A',
                'email' => 'van@gmail.com',
                'phone' => '01623462563',
                'level' => 0, 
                'password' => bcrypt('123321'),
                'remember_token' => str_random(10),
                'address_id' => 3, 
            ],
            [
                'name' => 'Le Van Luyen',
                'email' => 'luyen@gmail.com',
                'phone' => '01638321489',
                'level' => 0, 
                'password' => bcrypt('123321'),
                'remember_token' => str_random(10),
                'address_id' => 4, 
            ],
        );
        foreach ($listUser as $key => $value) {
            DB::table('users')->insert($value);
        }
    }
}
