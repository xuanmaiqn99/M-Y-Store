<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    private function getFormatCate($category)
    {
        foreach ($category as $key => $value) {
            $check = $value->parent_id;
            if ($check == 0) {
                $category[$key]['parent_id'] = "-";
            } else {
                foreach ($category as $key1 => $value1) {
                    if ($value1->id == $check) {
                        $category[$key]['parent_id'] = $value1->name;
                        break;
                    }
                }
            }
        }
        return $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->getFormatCate(Category::all());
        
        return view('admin.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type_category = Category::all();
        $list = array();
        foreach ($type_category as $key => $value) {
            if($value->parent_id ==0 && count($value->products) < 1){
                $list[$value->id] = $value->name;
            }
        }
        $list[0] = "Danh mục cha";
        $type_category = $list;

        return view('admin.category.add', compact('type_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->all());

        return redirect()->route('category.index')
            ->with('success', __('Thêm mới danh mục thành công!'));
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
        $category = Category::findOrFail($id);
        if ($category->parent_id != 0) {
            $type_category = Category::getParentCate();
        }
        $type_category['0'] = "Danh mục cha";

        return view('admin.category.edit', compact('category', 'type_category'));

    }

    private function getMessage()
    {
        return 'Danh mục đã bị xóa hoặc không tồn tại';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
		$category = Category::findOrFail($id);
		if ($request->parent_id == null) {
	        $request->merge([
	            'parent_id' => $category->parent_id,
	        ]);
        }
    	$category->update($request->all());

        return redirect()->route('category.index')
            ->with('success', __('Cập nhật danh mục thành công!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkChild(Request $request)
    {
        try {
        	$id = $request->id;
        	$category = Category::findOrFail($id);
    		$count = Category::getSubCategory($id)->count();
    		if ($count > 0) {
    			return response()->json(1); 
    		}
    		if (count($category->products) > 0) {
    			return response()->json(2); 
    		}

    		return response()->json(0);
        } catch (ModelNotFoundException $e) {
            return response()->json($this->getMessage(), 404, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = intval($request->id);
            $category = Category::findOrFail($id);
            if ($request->data == 0) {
                Category::destroy($id);

                return response()->json(1);
            } else if ($request->data == 1) {
                $listId = Category::getSubCategoryId($id);
                $listId[] = $id;
                $category = Category::find($listId);
                
                foreach ($category as $key => $value) {
                    $value->products()->delete();
                }
                Category::destroy($listId);

                return response()->json($listId);
            } else {
                $category->products()->delete();
                $category->delete();

                return response()->json(1);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json($this->getMessage(), 404, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function restore()
    {
        Category::withTrashed()->restore();
        Product::withTrashed()->restore();

        return redirect()->route('category.index')
            ->with('success', __('Khôi phục lại các danh mục đã xóa'));
    }
}
