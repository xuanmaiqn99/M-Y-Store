<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function view($id)
    {
    	$product = Product::findOrFail($id);
    	$product->view += 1;
    	$product->save();
    	$product_relate = Product::getProductRe($product->category_id, $id);

    	return view('site.product.view', compact('product', 'product_relate'));
    }
}
