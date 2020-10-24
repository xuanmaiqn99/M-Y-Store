<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slide;
use App\Http\Requests\SlideRequest;
use App\Traits\Upload;

class SlideController extends Controller
{
    use Upload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slide = Slide::all();

        return view('admin.slide.index', compact('slide'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slide.add');
    }

    private function getPath()
    {
        return 'app.slideUrl';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
        $slide = $request->except('avatar');
        $slide['image_link'] = $this->addImage($request->file('avatar'), $this->getPath());
        Slide::create($slide);
        
        return redirect()->route('slide.index')->with('success', __('Thêm slide thành công'));
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
        $slide = Slide::findOrFail($id);

        return view('admin.slide.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);
        $img_old = $slide->image_link;
        $sl = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            $this->removeImage($img_old, $this->getPath());
            $sl['image_link'] = $this->addImage($request->file('avatar'), $this->getPath());
        } else {
           $sl['image_link'] = $img_old;
        }
        $slide->update($sl);

        return redirect()->route('slide.index')->with('success', __('Cập nhật thành công'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $slide = Slide::findOrFail($id);
        $this->removeImage($slide->image_link, $this->getPath());
        $slide->delete();

        return redirect()->route('slide.index')->with('success', __('Xóa thành công'));
    }
}
