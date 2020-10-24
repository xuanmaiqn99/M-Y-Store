<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\NewsUpdateRequest;
use App\Traits\Upload;

class NewsController extends Controller
{
    use Upload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.add');
    }

    private function getPath()
    {
        return 'app.newsUrl';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $news = $request->except('avatar');
        $news['avatar'] = $this->addImage($request->file('avatar'), $this->getPath());
        News::create($news);

        return redirect()->route('news.index')->with('success', __('Thêm tin tức thành công'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsUpdateRequest $request, $id)
    {
        $news = News::findOrFail($id);
        $img_old = $news->avatar;
        $ne = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            $this->removeImage($img_old, $this->getPath());
            $ne['avatar'] = $this->addImage($request->file('avatar'), $this->getPath());
        } else {
           $ne['avatar'] = $img_old;
        }
        $news->update($ne);

        return redirect()->route('news.index')->with('success', __('Cập nhật thành công'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $news = News::findOrFail($id);
            $this->removeImage($news->avatar, $this->getPath());
            $news->delete();

           return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('fail');
        }
    }

    public function delMulNews(Request $request)
    {
        try {
            $news = News::find($request->allVals)->toArray();
            News::destroy($request->allVals);
            foreach ($news as $value) {
                $this->removeImage($value->avatar, $this->getPath());
            }

            return response()->json('ok');
        } catch (\Exception $e) {
            return response()->json('fail');
        }
    }
}
