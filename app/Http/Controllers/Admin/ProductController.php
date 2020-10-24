<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\Traits\Upload;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    use Upload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return view('admin.product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list = Product::getAllCate();

        return view('admin.product.add', compact('list'));
    }

    private function getPath()
    {
        return 'app.imageUrl';
    }

    private function getInfo($request)
    {
        $prod = $request->except(
            'image_id',
            'avatar',
        );
        $conf = $request->only(
            'size',
            'color',
        );

        return array($prod, $conf);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $path = $this->getPath();
        list($prod, $conf) = $this->getInfo($request);
        $prod['avatar'] = $this->addImage($request->file('avatar'), $path);
        $product = Product::create($prod);
        $product->configuration()->create($conf);
        if ($request->hasFile('image_id')) {
            $file = $request->file('image_id');
            foreach ($file as $key => $value) {
                $listImage[]['image_link'] = $this->addImage($value, $path);
            }
            foreach ($listImage as $key => $value) {
               $product->images()->create($value);
            }
            
        }

        return redirect()->route('product.index')
            ->with('success', __('Thêm mới sản phẩm thành công!'));
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
        $product = Product::findOrFail($id);
        $list = Product::getAllCate();
      
        return view('admin.product.edit', compact('product', 'list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        list($prod, $conf) = $this->getInfo($request);
        $path = $this->getPath();
            
        $img_old = $product->avatar;
        if ($request->hasFile('avatar')) {
            $this->removeImage($img_old, $path);
            $prod['avatar'] = $this->addImage($request->file('avatar'), $path);
        } else {
           $prod['avatar'] = $img_old;
        }
        $product->update($prod);
        $product->configuration->update($conf);   
        if ($request->hasFile('image_id')) {
            $listImageOld = $product->images->pluck('image_link')->toArray();
            $product->images()->delete();
            foreach ($listImageOld as $key => $value) {
                $this->removeImage($value, $path);
            }
            $file = $request->file('image_id');
            foreach ($file as $key => $value) {
                $listImage[]['image_link'] = $this->addImage($value, $path);
            }
            foreach ($listImage as $key => $value) {
                $product->images()->create($value);
            }
        }

        return redirect()->route('product.index')
            ->with('success', __('Cập nhật thành công'));
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

    private function getMessage()
    {
        return 'Sản phẩm đã bị xóa hoặc không tồn tại';
    }

    public function delete(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            $product->delete();

            return response()->json('ok');
        } catch (ModelNotFoundException $e) {
            return response()->json($this->getMessage(), 404, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function delMulProd(Request $request)
    {
        try {
            Product::destroy($request->allVals);

            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('Không thể xóa', 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function restore()
    {
        Product::withTrashed()->restore();

        return redirect()->route('product.index')
            ->with('success', __('Khôi phục lại các sản phẩm đã xóa'));
    }

}
