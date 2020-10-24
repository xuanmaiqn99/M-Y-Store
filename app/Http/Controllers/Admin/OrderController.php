<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;
use App\Category;
use Excel;

class OrderController extends Controller
{
    public function index()
    {
    	$order = Order::all();

    	return view('admin.order.index', compact('order'));
    }

    public function detail(Request $request)
    {
    	$order = Order::findOrFail($request->id);
    	$user = User::withTrashed()->find($order->user_id);
    	$orderDetails = $order->orderDetails; 
    	$listId = array();
    	foreach ($orderDetails as $key => $value) {
    		$listId[] = $value->product_id;
    	}
    	$product = Product::withTrashed()->find($listId);

    	return view('admin.order.detail', compact('order', 'orderDetails', 'user', 'product'));
    }

    public function delete(Request $request)
    {
    	try {
            $order = Order::whereIn('id', $request->allVals);
            $order->update([
                'status' => 'Hủy bỏ'
            ]);

            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('Không thể xóa', 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function confirmOrder(Request $request)
    {
    	$order = Order::findOrFail($request->id_order);
    	$order->update(array('status' => "Thành công"));

    	return redirect()->route('order.index')->with('success', __('Xác nhận đơn hàng thành công'));
    }

    public function exportToExcel()
    {
    	$orders = Order::all();
    	if (count($orders) > 0){
    		$orderArray = []; 
	        $orderArray[] = [
	        	'Tên khách hàng',
	        	'Số điện thoại',
	        	'Email',
	        	'Địa chỉ',
	            'Mã số đơn hàng', 
	            'Trạng thái',
	            'Số tiền',
	            'Ngày đặt hàng'
	        ];
	        foreach ($orders as $order) {
                $user = $order->user;
	            $temp = array(
	                $user->name,
	                $user->phone,
	                $user->email,
	                $user->address->address,
	                $order->id,
	                $order->status,
	                number_format($order->amount) . ' đ',
	                $order->created_at,
	            );
	            $orderArray[] = $temp;
	        }
	        $myFile = Excel::create('orders', function($excel) use ($orderArray) {
	            $excel->setTitle('Orders');
	            $excel->setCreator('Admin')->setCompany('Framgia Inc.');
	            $excel->setDescription('Order file');
	            $excel->sheet('sheet1', function($sheet) use ($orderArray) {
	            $sheet->fromArray($orderArray, null, 'A1', false, false);
	            });

	        });//->download('xlsx');
	        $myFile = $myFile->string('xlsx');
	        $response =  array(
	            'name' => "Orders",
	            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . 
                base64_encode($myFile)
	        );
	        return response()->json($response);
    	}

    	return response()->json(null);
    }
}
