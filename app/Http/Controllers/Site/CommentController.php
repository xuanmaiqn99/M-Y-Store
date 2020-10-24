<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private function checkLogIn()
    {
    	return Auth::check();
    }

    public function store(Request $request)
    {
    	if ($this->checkLogIn()) {
    		$comment = new Comment;
	        $comment->content = $request->message;
	        $comment->parent_id = 0;
	        $comment->user()->associate($request->user());
	        $product = Product::find($request->product_id);
	        if ($product == null) {
	        	return response()->json("error");
	        }
	        $product->comments()->save($comment);
	        $result = array(
	            'comment_id' => $comment->id,
	            'name' => Auth::user()->name,
	            'level' => Auth::user()->level,
	            'message' => $request->message,
	            'product_id' => $request->product_id,
	            'date' => $comment->created_at->diffForHumans(),
	            'total' => $product->comments()->count(),
	        );

	        return response()->json($result);
    	}

    	return response()->json(null);
    }

    public function replyStore(Request $request)
    {
    	if ($this->checkLogIn()) {
	        $reply = new Comment();
	        $reply->content = $request->message;
	        $reply->user()->associate($request->user());
	        $reply->parent_id = $request->comment_id;
	        $product = Product::find($request->product_id);
	        if ($product == null) {
	        	return response()->json("error");
	        }
	        $product->comments()->save($reply);
	        $result = array(
	            'name' => Auth::user()->name, 
	            'message' => $reply->content,
	            'level' => Auth::user()->level,
	            'date' => $reply->created_at->diffForHumans(),
	            'total' => $product->comments()->count(),
	        );

	        return response()->json($result);
    	}

    	return response()->json(null);
    }
}
