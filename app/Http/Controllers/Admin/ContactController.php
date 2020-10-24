<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;

class ContactController extends Controller
{
    public function index()
    {
    	$contact = Contact::all();

    	return view('admin.contact.index', compact('contact'));
    }

   	public function delete(Request $request)
    {
        try {
            Contact::destroy($request->id);

            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('Không thể xóa', 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function delMulCon(Request $request)
    {
        try {
            Contact::destroy($request->allVals);

            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('Không thể xóa', 500, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
