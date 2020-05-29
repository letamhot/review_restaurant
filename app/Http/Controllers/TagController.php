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
                return $this->tagService->getAllAJAX();
            }

            return view($this->path.'index');
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        try {
            if ($request->tag_id == '1') {
                return $this->errorFailMessage('Can not modify default resource!');
            }

            $result = $this->tagService->ajaxStore($request);

            if ($result) {
                return response()->json(['success' => 'Tag saved successfully']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @param mixed           $id
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

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag          $tag
     * @param mixed                    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        // USING store() METHOD - createOrUpdate
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tag $tag
     * @param mixed           $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($id == '1') {
                return $this->errorFailMessage('Can not delete default resource!');
            }
            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorMessage();
            $tag = $this->tagService->findById($id);
            $result = $this->tagService->destroy($tag);

            if ($result) {
                return response()->json(['success' => 'Tag deleted successfully']);
            }

            return $this->errorFailMessage();
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
     * Display a listing of the resource (Soft Delete).
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrashRecords()
    {
        try {
            return $this->tagService->getAllOnlyTrashedAJAX();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
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

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
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
    protected function errorFailMessage($msg = null)
    {
        $message = [
            'status' => 500,
            'errors' => ['Failed!', $msg],
            'success' => false,
        ];

        return response()->json($message);
    }
}