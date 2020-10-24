<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
    public function index()
    {
    	$comment = Comment::getComment()->get();

    	return view('admin.comment.index', compact('comment'));
    }

    public function delete(Request $request)
    {
        try {
            $listId = $request->allVals;
            $comment = Comment::find($listId);
            foreach ($comment as $key => $value) {
                $value->replies()->delete();
            }
            Comment::destroy($listId);
            
            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('Không thể xóa', 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function deleteReply(Request $request)
    {
        try {
            Comment::destroy($request->allVals);
            
            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('Không thể xóa', 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function view(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        return view('admin.comment.reply', compact('comment'));
    }
}
