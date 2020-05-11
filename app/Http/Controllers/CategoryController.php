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
        $this->categoryService = $categoryService;
        $this->path = 'categories';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view($this->path.'index')->withCategories($this->categoryService->getAll());
        // return view($this->path.'.index');
        return view($this->path.'.ajax');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $result = $this->categoryService->create($request);

        if ($result) {
            return response()->json(['success' => 'Product added successfully']);
        }

        return response()->json(['errors' => CategoryRequest::errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view($this->path.'.edit')->withCategory($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
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
        $result = $this->categoryService->destroy($id);

        return $this->goTo($result);
    }

    public function ajaxIndex(Request $request)
    {
        return $this->categoryService->ajaxIndex($request);
    }

    public function ajaxStore(CategoryRequest $request)
    {
        $result = $this->categoryService->ajaxStore($request);
        if ($result) {
            // toastr()->success('Data has been saved successfully!');

            return response()->json(['success' => 'Category created successfully', 'errors' => false]);
        }
        // toastr()->error('An error has occurred please try again later.');

        return response()->json(['errors' => $request->getContent()]);
        // try {
        //     $result = $this->categoryService->ajaxStore($request);
        //     if ($result) {
        //         return response()->json(['success' => 'Category created successfully']);
        //     }

        //     return $this->errorMessage();
        // } catch (\Exception $e) {
        //     return $this->errorMessage();
        // }
    }

    public function ajaxEdit($id)
    {
        return $this->categoryService->ajaxEdit($id);
    }

    public function ajaxUpdate(CategoryRequest $request, $id)
    {
        $result = $this->categoryService->ajaxUpdate($request, $id);

        return response()->json(['success' => 'Category updated successfully']);
        // try {
        //     $result = $this->categoryService->ajaxUpdate($request, $id);
        //     if ($result) {
        //         return response()->json(['success' => 'Category updated successfully']);
        //     }

        //     return $this->errorMessage();
        // } catch (\Exception $e) {
        //     return $this->errorMessage();
        // }
    }

    public function ajaxDelete($id)
    {
        try {
            $this->categoryService->ajaxDelete($id);

            return response()->json(['success' => 'Category deleted successfully']);
            // return $this->errorMessage();
        } catch (\Exception $e) {
            return $this->errorMessage();
        }
    }

    public function ajaxRestoreDelete($id)
    {
        $this->categoryService->restoreSoftDelete($id);

        return response()->json(['success' => 'Item restored successfully.']);
    }

    // get soft delete record
    public function getTrashRecords()
    {
        return $this->categoryService->getAll();
    }

    public function ajaxHardDelete($id)
    {
        try {
            $this->categoryService->permanentDestroySoftDeleted($id);

            return response()->json(['success' => 'Category permanently deleted successfully']);
            // return $this->errorMessage();
        } catch (\Exception $e) {
            return $this->errorMessage();
        }
    }

    // NOT AJAX
    protected function goTo($result)
    {
        if ($result) {
            // Toastr::success('Successfully! :)', 'Success');

            return redirect()->route($this->path.'.index');
        }
        // Toastr::error('Something went wrong!', 'Error');

        return back();
    }

    protected function errorMessage()
    {
        return response()->json(['errors' => CategoryRequest::errors()->all()]);
    }
}
