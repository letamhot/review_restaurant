<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Services\TagService;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->tagService->ajaxIndex($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        return  $this->tagService->ajaxStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return  $this->tagService->ajaxUpdate($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    // public function update($id)
    // {

    //     return  $this->tagService->ajaxUpdate($id);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->tagService->AjaxDestroy($id);
    }

    protected function goTo($result)
    {
        if ($result) {

            return redirect()->route('tag.index');
        }

        return back();
    }

    public function showdeletedtags()
    {
        $delete = $this->tagService->showdeleted();
        return view('deletedtags.index', ["delete" => $delete]);
    }

    public function restoreDeletedTags($id)
    {
        $this->tagService->restoreDelete($id);
        return redirect('/tag');
    }

    public function forceDelete($id)
    {
        $this->tagService->forceDestroy($id);
    }
}
