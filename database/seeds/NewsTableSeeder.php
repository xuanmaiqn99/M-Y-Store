<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id nulla. Donec a neque libero. Pellentesque aliquet, sem eget laoreet ultrices, ipsum metus feugiat sem, quis fermentum turpis eros eget velit. Donec ac tempus ante. Fusce ultricies massa massa. Fusce aliquam, purus eget sagittis vulputate, sapien libero hendrerit est, sed commodo augue nisi non neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat vestibulum, metus nisi posuere nisl, in accumsan elit odio quis mi. Cras neque metus, consequat et blandit et, luctus a nunc. Etiam gravida vehicula tellus, in imperdiet ligula euismod eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam erat mi, rutrum at sollicitudin rhoncus, ultricies posuere erat. Duis convallis, arcu nec aliquam consequat, purus felis vehicula felis, a dapibus enim lorem nec augue.<br><br>Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis 
            vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis 
            in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend 
            laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla 
            luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent 
            per conubia nostra, per inceptos himenaeos. Integer enim purus, posuere at 
            ultricies eu, placerat a felis. Suspendisse aliquet urna pretium eros 
            convallis interdum. Quisque in arcu id dui vulputate mollis eget non arcu. Aenean 
            et nulla purus. Mauris vel tellus non nunc mattis lobortis.';
        $listNews = array(
            [
                'title' => 'Thời trang nam',
                'content' => $content, 
                'avatar' => 'slide2.jpg'
            ],
            [
                'title' => 'Mẫu hàng mới sắp ra mắt',
                'content' => $content, 
                'avatar' => 'slide2.jpg'
            ],
            [
                'title' => 'Mặc đẹp theo sao',
                'content' => $content, 
                'avatar' => 'slide2.jpg'
            ]
        ); 
        foreach ($listNews as $key => $value) {
            DB::table('news')->insert($value);
        }
    }
}
