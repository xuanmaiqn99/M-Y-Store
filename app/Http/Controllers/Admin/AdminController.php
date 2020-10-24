<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Address;
use Session;

class AdminController extends Controller
{

    public function index()
    {
        $admin = User::role(1)->get();

        return view('admin.admin.index', compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        $addresses = Address::seft();

        return view('admin.admin.edit', compact('admin', 'addresses'));
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        $admin = User::findOrFail($id);
        if ($request->password == '') {
            $request->merge([
                'password' => $admin->password,
            ]);
        }
        $admin->update($request->all());

        return redirect('admin/admin/index')
            ->with('success', __('Cập nhật thông tin Admin thành công!'));
    }

    public function getLogin()
    {
        if(Auth::user() && Auth::user()->level == 1)
			return redirect()->intended('admin/home/index');
        
        return view('admin.login');
    }

    public function postLogin(SignInRequest $request)
    {
    	$credentials = $request->only('email', 'password');
    	$credentials['level'] = 1;
        $remember = $request->remember == null ? false : true;
        if(Auth::attempt($credentials, $remember)){
            return redirect()->intended('admin/home/index');
        }

        return back()->with('message', trans('common.error.login'))->withInput();
    }
    
    public function getLogout()
    {
       	if (Auth::user() && Auth::user()->level == 1) {
            Auth::logout();
        }

        return redirect('admin/login');
    }
}
