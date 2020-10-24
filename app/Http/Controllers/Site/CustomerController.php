<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\SignInRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use App\Order;
use Session;

class CustomerController extends Controller
{
    public function logIn()
    {
        return view('site.customer.login');
    }

    public function postLogIn(SignInRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->remember == null ? false : true;
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('site.home.index');
        }

        return back()->with('message', __('Đăng nhập không thành công'))->withInput();
    }

    public function logOut()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->route('site.home.index');
    }

    public function regester()
    {
        $addresses = Address::seft();
        return view('site.customer.regester', compact('addresses'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $addresses = Address::seft();

        return view('site.customer.regester', compact('addresses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $password = $request->password;
        $request->merge([
            'level' => 0,
        ]);
        $user = User::create($request->all());
        $credentials = array('email' => $user->email, 'password' => $password);
        if (Auth::attempt($credentials)) {
            return redirect()->route('site.home.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        $addresses = Address::seft();

        return view('site.customer.edit', compact('customer', 'addresses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
        $customer = User::findOrFail($id);
        if($request->password == '') {
            $request->merge([
                'password' => $customer->password,
            ]);
        }
        $customer->update($request->all());

        return redirect()->route('site.customer.edit', ['customer' => $id])
            ->with('success', __('Cập nhật thông tin thành công!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkLogIn()
    {
        if (Auth::check()) {
            return response()->json("true");
        }

        return response()->json(null);
    }

    public function review(Request $request)
    {
        request()->validate(['rate' => 'required']);
        $product = Product::findOrFail($request->id);
        $product_id = $request->id;
        $user_id = Auth::user()->id;
        $item = array(
            'user_id' => $user_id,
            'rateable_id' => $product_id,
        );
        $rate = \willvincent\Rateable\Rating::firstOrNew($item);
        $rate->rating = $request->rate;
        $rate->user_id = $user_id;
        $product->ratings()->save($rate);

        return back()->with('success', __('Cám ơn bạn đã đánh giá sản phẩm, chúng tôi sẽ ghi nhận đánh giá cuối cùng của bạn'));
    }

    public function history()
    {
        if (Auth::check()) {
            $history = User::find(Auth::id())->orders;

            return view('site.customer.history', compact('history'));
        }

        return redirect()->route('site.customer.login')
            ->with('message', __('Vui lòng đăng nhập để thực hiện chức năng này'));
    }

    public function historyDetail(Request $request)
    {
        $order = Order::find($request->id);
        if ($order == null) {
            return response()->json(null);
        }
        $orderDetails = $order->orderDetails;
        $listId = array();
        foreach ($orderDetails as $key => $value) {
            $listId[] = $value->product_id;
        }
        $product = Product::withTrashed()->find($listId);
        $view = view("site.customer.history_detail", compact('orderDetails', 'product'))
            ->render();

        return response()->json(['html' => $view]);
    }
}
