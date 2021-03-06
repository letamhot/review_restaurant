<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $path;

    public function __construct(CategoryService $categoryService)
    {
        // $this->middleware( 'role:Admin' );
        $this->categoryService = $categoryService;
        $this->path = 'backend.categories.';
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
                return $this->categoryService->getAllAJAX();
            }

            return view($this->path . 'index');
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
    }
    public function showAllCategory()
    {
        $categories = $this->categoryService->getAll();
        // $data = Category::all();
        // dd($data);
        return view('front-end.landing-page', compact('categories'));
    }

    public function showdetailcategory($id)
    {

        $category_detail = $this->categoryService->findById($id);

        return view('front-end.categories', compact('category_detail'));
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
    public function store(CategoryRequest $request)
    {
        try {
            if ($request->category_id == '1') {
                return $this->errorFailMessage('Can not modify default resource!');
            }
            $result = $this->categoryService->ajaxStore($request);

            if ($result) {
                return response()->json(['success' => 'Category saved successfully']);
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
    public function show(Category $category)
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
            $category = $this->categoryService->findById($id);
            if ($category) {
                return response()->json($category);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // NOT AJAX
        $result = $this->categoryService->update($request, $category);

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
            if ($id == '1') {
                return $this->errorFailMessage('Can not delete default resource!');
            }

            $category = $this->categoryService->findById($id);
            $result = $this->categoryService->destroy($category);

            if ($result) {
                return response()->json(['success' => 'Category deleted successfully']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorMessage();
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
            return $this->categoryService->getAllOnlyTrashedAJAX();
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
            $result = $this->categoryService->restoreSoftDelete($id);
            if ($result) {
                return response()->json(['success' => 'Item restored successfully.']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
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
            $result = $this->categoryService->permanentDestroySoftDeleted($id);

            if ($result) {
                return response()->json(['success' => 'Category permanently deleted successfully']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorMessage();
        }
    }

    /**
     * True value - return index view
     * False value - return previous page
     * Not for AJAX.
     *
     * @param bool $result
     */
    function goto ($result) {
        if ($result) {
            // Toastr::success('Successfully! :)', 'Success');

            return redirect()->route($this->path . 'index');
        }
        // Toastr::error('Something went wrong!', 'Error');

        return back();
    }

    /**
     * Display validation errors of request.
     */
    protected function errorValidateMessage()
    {
        return response()->json(['errors' => CategoryRequest::errors()->all()]);
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
            'errors' => ['Failed!', $msg ?? 'Unknown error!'],
        ];

        return response()->json($message);
    }
}
