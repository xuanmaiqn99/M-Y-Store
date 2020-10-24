<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use App\Product;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Address;

class CartController extends Controller
{
    private function getInfo()
    {
        $addresses = Address::seft();
        $cart = Cart::instance(Auth::user()->id)->content();
        $product_segest = array();
        $listId = array();
        foreach ($cart as $key => $value) {
            $listId[] = $value->id;
        }
        $product = Product::find($listId);
        $listCategoryId = array();
        foreach ($product as $key => $value) {
            $listCategoryId[] = $value->category->id;
        }
        $product_segest = Product::getProductSeg($listCategoryId);
        $total = Cart::instance(Auth::user()->id)->subtotal();

        return array($addresses, $cart, $total, $product_segest);
    }

    public function index(Request $request)
    {
        list($addresses, $cart, $total, $product_segest) = $this->getInfo();

        return view('site.cart.view', compact('cart', 'product_segest', 'total', 'addresses'));
    }
    public function checkOut(){
       
        list($addresses, $cart, $total, $product_segest) = $this->getInfo(); 

        return view('site.cart.checkout', compact(
            'cart', 'product_segest', 'total', 'addresses'
        ));
    }

    public function delete(Request $request)
    {
        $rowId = $request->rowId;
        Cart::instance(Auth::user()->id)->remove($rowId);

        return response()->json('ok');
    }

    public function update(Request $request)
    {
        $qty = $request->qty;
        $cart = Cart::instance(Auth::user()->id)->content();
        $i = 0;
        foreach ($cart as $key => $value) {
            Cart::instance(Auth::user()->id)->update($value->rowId, intval($qty[$i]));
            $i++;
        }

        return redirect()->route('site.cart.view');
    }

    private function checkLogIn()
    {
        return Auth::check();
    }

    public function addToCart(Request $request)
    {
        if ($this->checkLogIn()) {
            $id = $request->id;
            $product = Product::find($id);
            if ($product == null){
                return response()->json("error");
            }
            if ($product->discount > 0)
                $price = $product->price - $product->discount;
            else
                $price = $product->price;
            Cart::instance(Auth::user()->id)->add(
                [
                    'id' => $id, 
                    'name' => $product->name, 
                    'qty' => 1, 
                    'price' => $price,
                    'options' => [
                        'avatar' => $product->avatar
                    ]
                ]
            );
            return response()->json('ok');
        } else {
            return response()->json(null);
        }
    }

    public function add(Request $request)
    {
        if ($this->checkLogIn()) {
            $id = $request->id;
            $value = intval($request->value); 
            $product = Product::find($id);
            if ($product == null)
                return response()->json("error"); 
            if ($product->discount > 0)
                $price = $product->price - $product->discount;
            else
                $price = $product->price;
            Cart::instance(Auth::user()->id)->add(
                [
                    'id' => $id, 
                    'name' => $product->name, 
                    'qty' => $value, 
                    'price' => $price,
                    'options' => [
                        'avatar' => $product->avatar
                    ]
                ]
            );
            $cart = Cart::instance(Auth::user()->id)->content();
            foreach ($cart as $row) {
                $data[] = array(
                    'rowId' => $row->rowId,
                    'id' => $row->id, 
                    'name' => $row->name, 
                    'qty' => $row->qty,
                    'price' => number_format($row->price, null, null, '.'),
                    'avatar' => url(config('app.imageUrl')) . '/' . $row->options->avatar,
                    'subtotal' => $row->subtotal,
                    'link' => route('product.view', ['id' => $row->id]),
                );
            }
            return response()->json(array($data, count($cart), Cart::subtotal()));
        }else {
            return response()->json(null);
        }
    }

    private function checkFullCompare()
    {
        return Cart::instance('compare')->count() > 1;
    }

    private function checkExistCompare($id)
    {
        foreach (Cart::instance('compare')->content() as $key => $value) {
            if ($value->id == $id) 
                return true;
        }

        return false;
    }

    public function addToCompare(Request $request)
    {
        $id = intval($request->value);
        $product = Product::find($id);
        if ($product == null)
            return response()->json("error");
        if ($this->checkFullCompare()) {
            return response()->json("full");
        }else if($this->checkExistCompare($id)) {
            return response()->json("exist");
        }else{
            if ($product->discount > 0)
                $price = $product->price - $product->discount;
            else
                $price = $product->price;
            Cart::instance('compare')->add(
                [
                    'id' => $id, 
                    'name' => $product->name, 
                    'qty' => 1, 
                    'price' => $price,
                    'options' => [
                        'avatar' => $product->avatar,
                        'configuration' => $product->configuration->toArray()
                    ]
                ]
            );
            return response()->json(Cart::instance('compare')->count());
        }
    }

    public function viewToCompare()
    {
        $compare = Cart::instance('compare')->content();
        if (count($compare ) == 0) {
            return redirect()->route('site.home.index');
        }

        return view('site.cart.compare', compact('compare'));
    }

    public function deleteProductCompare(Request $request)
    {
        $id = $request->id;
        foreach (Cart::instance('compare')->content() as $key => $value) {
            if ($value->id == $id) {
                Cart::instance('compare')->remove($value->rowId);
                break;
            }
        }

        return response()->json(Cart::instance('compare')->count());
    }

    private function checkExistWishList($id)
    {
        foreach (Cart::instance('wishlist_'.Auth::user()->id)->content() as $key => $value) {
            if ($value->id == $id) {
                return true;
            }
        }

        return false;
    }

    public function addToWishList(Request $request)
    {
        if ($this->checkLogIn()) 
        {
            $id = intval($request->value);
            $product = Product::find($id);
            if ($product == null) 
                return response()->json('error');
            if ($this->checkExistWishList($id)) {
                return response()->json('exist');
            }
            if ($product->discount > 0)
                $price = $product->price - $product->discount;
            else
                $price = $product->price;
            Cart::instance('wishlist_'.Auth::user()->id)->add(
                [
                    'id' => $id, 
                    'name' => $product->name, 
                    'qty' => 1, 
                    'price' => $price,
                    'options' => [
                        'avatar' => $product->avatar
                    ]
                ]
            );

            return response()->json(Cart::instance('wishlist_'.Auth::user()->id)->count());
        }

        return response()->json("fail");
    }

    public function removeWishList(Request $request)
    {
        $rowId = $request->id;
        $wishList = Cart::instance('wishlist_'.Auth::user()->id)->remove($rowId);

        return response()->json('ok');
    }

    public function viewWishList(Request $request)
    {
        if ($this->checkLogIn()) {
            $wishList = Cart::instance('wishlist_'.Auth::user()->id)->content();
            if (count($wishList) > 0)
                return view('site.cart.wishlist', compact('wishList'));

            return redirect()->route('site.home.index');
        } 

        return redirect()->route('site.customer.login')
            ->with('message', 'Vui lòng đăng nhập để thực hiện chức năng này');
    }
}
