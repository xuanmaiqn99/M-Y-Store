<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderDetail;
use App\Events\OrderEvent;
use App\Events\NotifiOrderSuccess;
use App\Events\SendMailOrder;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderSuccess;

class OrderController extends Controller
{
    private function notifiOrderSuccess($order)
    {
        $order->notify(new OrderSuccess());
        event(new NotifiOrderSuccess($order->notifications->first()));
    }

    private function sendMailOrder($id, $order)
    {
        $data = array();
        $data['user'] = Auth::user();
        $data['total'] = Cart::instance($id)->subtotal();
        $data['cart'] = Cart::instance($id)->content();
        $data['address'] = $order->address_ship;
        $data['code'] = $order->id;
        $data['email'] = Auth::user()->email;
        event(new SendMailOrder($data));
    }

    private function addCartError($id)
    {
        Cart::instance("error" . $id)->destroy();
        foreach (Cart::instance($id)->content() as $key => $value) {
            if (Product::find($value->id) == null) {
                Cart::instance("error" . $id)->add(
                    [
                        'id' => $value->id, 
                        'name' => $value->name, 
                        'qty' => 1, 
                        'price' => $value->price,
                        'options' => [
                            'avatar' => $value->options->avatar
                        ]
                    ]
                );
                Cart::instance($id)->remove($value->rowId);
            }
        }
    }

    public function add(OrderRequest $request)
    {
        $id = Auth::user()->id;
        $this->addCartError($id);
        if (Cart::instance("error" . $id)->count() > 0) {
            return redirect()->route('site.cart.view')
                ->with('message1', __('Đơn đặt hàng không thành công'));
        }
        $value = $request->all();
        $value['amount'] = Cart::instance($id)->subtotal();
        $value['user_id'] = $id;
        $order = Order::create($value);
        foreach (Cart::instance($id)->content() as $key => $value) {
            $listOrderDetail = array(
                'product_id' => $value->id,
                'quantity' => $value->qty
            );
            $order->orderDetails()->create($listOrderDetail);
        }
        $this->notifiOrderSuccess($order);
        $this->sendMailOrder($id, $order);
        Cart::instance($id)->destroy();
        Cart::instance("error" . $id)->destroy();
        session(['order_success' => 'value']);

        return redirect()->route('site.order.success');
    }

    public function checkOrder()
    {
        $count = Cart::instance(Auth::user()->id)->count();

        return response()->json($count);
    }

    public function success()
    {
        if (session()->has('order_success')) {
            session()->forget('order_success');

            return view('site.cart.success');
        }
        
        return redirect()->route('site.home.index'); 
    }
}
