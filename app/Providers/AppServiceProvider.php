<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 
use App\Category;
use Illuminate\Support\Facades\View;
use App\Product;
use Cart;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment() == 'production') {
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) 
        {
            $categoryS = Category::all();
            $product_sell = Product::getTopSell();
            $cateS = Product::getAllCate();
            $notification = Notification::getNotif();
            $total_not = Notification::getTotal();
            $view->with(compact([
                'categoryS', 
                'product_sell',
                'notification',
                'total_not',
                'cateS'
            ]));    
        });  
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
