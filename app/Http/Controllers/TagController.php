<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;
    protected $path;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
        $this->path = 'backend.tags.';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->tagService->getAll();
            }

            return view($this->path.'index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // NOT DEFINE YET WHEN USING AJAX
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        try {
            $result = $this->tagService->ajaxStore($request);

            if ($result) {
                return response()->json(['success' => 'Tag saved successfully']);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $Tag)
    {
        // NOT DEFINE YET WHEN USING AJAX
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $tag = $this->tagService->findById($id);
            if ($tag) {
                return response()->json($tag);
            }

            return response()->json($tag);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $Tag)
    {
        // NOT AJAX
        $result = $this->tagService->update($request, $Tag);

        return $this->goTo($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tag = Tag::findById($id);
            // update new value for each post before delete Tag
            $tag->posts()->whereTagId($id)->update(['tag_id' => 1]);
            $tag->posts()->detach();

            $result = $tag->delete();

            $result = $this->tagService->destroy($id);
            if ($result) {
                return response()->json(['success' => 'Tag deleted successfully']);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource (Soft Delete).
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrashRecords()
    {
        try {
            return $this->tagService->getAllOnlyTrashed();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Restore record from SoftDelete.
     *
     * @param mixed $id
     */
    public function restoreTrash($id)
    {
        try {
            $result = $this->tagService->restoreSoftDelete($id);
            if ($result) {
                return response()->json(['success' => 'Item restored successfully.']);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * ForceDelete records which has been deleted by SoftDelete.
     *
     * @param mixed $id
     */
    public function emptyTrash($id)
    {
        try {
            $result = $this->tagService->permanentDestroySoftDeleted($id);

            if ($result) {
                return response()->json(['success' => 'Tag permanently deleted successfully']);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * True value - return index view
     * False value - return previous page
     * Not for AJAX.
     *
     * @param bool $result
     */
    protected function goTo($result)
    {
        if ($result) {
            // Toastr::success('Successfully! :)', 'Success');

            return redirect()->route($this->path.'index');
        }
        // Toastr::error('Something went wrong!', 'Error');

        return back();
    }

    /**
     * Display validation errors of request.
     */
    protected function errorValidateMessage()
    {
        return response()->json(['errors' => TagRequest::errors()->all()]);
    }

    /**
     * Display exception errors of request.
     */
    protected function errorExceptionMessage()
    {
        $msg = [
            'status' => 500,
            'errors' => ['Failed!', 'Something went wrong!'],
            'success' => false,
        ];

        return response()->json($msg);
    }

    /**
     * Display failed errors of request.
     */
    protected function errorFailMessage()
    {
        $msg = [
            'status' => 500,
            'errors' => ['Failed!', 'Unknown error!'],
            'success' => false,
        ];

        return response()->json($msg);
    }
}
