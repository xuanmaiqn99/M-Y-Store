<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\News;
use App\OrderDetail;
use App\Slide;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private function getInfo()
    {
        $product_view = Product::getProductView()->first();
        $news = News::getNews()->get();
        $slide = Slide::getSlide()->get();
        $priceS = array(
            1 => 'Dưới 100,000',
            2 => 'Từ 100,000-300,000',
            3 => 'Từ 300,000-500,000',
            4 => 'Trên 500,000'
        );
        $orderS = array(
            "desc" => 'Giá cao đến thấp',
            "asc" => 'Giá thấp đến cao'
        );

        return array($priceS, $orderS, $news, $slide, $product_view);
    }

    public function index()
    {
    	$product_new = Product::getProductNew()->get();
    	$product_disc = Product::getProductDis()->get();
        list($priceS, $orderS, $news, $slide, $product_view) = $this->getInfo();
    	return view('site.home.index', compact(
    		[
	    		'product_new', 
	    		'product_disc', 
	    		'news',
	    		'product_view',
                'slide',
                'priceS',
                'orderS'
    		]
    	));
    }

    public function search(Request $request)
    {
        $key = $request->key;
        if ($key == "") {
            return back();
        }
        try {
            $product = Product::whereCate(intval($request->category_id))->search($key)->get();
        } catch (\Illuminate\Database\QueryException $e) {
            return view('site.404');
        }
        list($priceS, $orderS, $news, $slide, $product_view) = $this->getInfo();
        return view('site.home.search', compact(
                'news', 
                'product', 
                'product_view', 
                'slide',
                'orderS',
                'priceS'
            )
        );
    }

    public function searchMul(Request $request)
    {
        try {
            $product = Product::searchMul(
                intval($request->category_id), 
                intval($request->price), 
                $request->order
            )->get();
        } catch (\Illuminate\Database\QueryException $e) {
            return view('site.404');
        }
        list($priceS, $orderS, $news, $slide, $product_view) = $this->getInfo();

        return  view('site.home.search', compact(
                    'news', 
                    'product', 
                    'product_view', 
                    'slide',
                    'priceS',
                    'orderS'
                )
            );
    }

    public function seggest(Request $request)
    {
        $product = Product::seggest($request->key, intval($request->id))->get();
        $result = array();
        foreach ($product as $key => $value) {
            $result[] = array(
                'name' => $value->name,
                'id' => $value->id,
                'avatar' => $value->avatar,
                'price' => $value->FormatPrice
            );
        }

        return response()->json($result);
    }
}
