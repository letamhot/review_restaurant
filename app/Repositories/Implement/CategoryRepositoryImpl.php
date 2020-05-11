<?php

namespace App\Repositories\Implement;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryRepositoryImpl extends EloquentRepository implements CategoryRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Category::class;
    }

    public function create($request)
    {
        try {
            $category = $this->getCategory();
            $category->name = $request->name;
            $category->slug = $request->name;
            $category->save();
        } catch (\Exception $e) {
            return null;
        }

        return true;
    }

    public function update($request, $category)
    {
        try {
            $category->update($request->all());
            // $category->name = $request->name;
            // $category->slug = Str::slug($request->name);
            // create unique slug using the mutator setSlugAttribute() no need Str::slug
            // $category->slug = $request->name;
            // $category->update();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function destroy($id)
    {
        try {
            $category = $this->getCategory()::findOrFail($id);
            // dd($category);
            // update new value for each post before delete category
            $category->posts()->whereCategoryId($id)->update(['category_id' => 1]);
            $category->posts()->detach();
            $category->delete();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * AJAX.
     *
     * @param mixed $request
     */
    public function ajaxIndex($request)
    {
        /* HACKTUT
        return DataTables::of($this->getCategory()::select('*'))
            ->addColumn('Actions', function ($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditProductData" data-id="'.$data->id.'">Edit</button>
                        <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteProductModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true)
                ;
        */
        // $data = $this->getCategory()->onlyTrashed()->get();
        // dd($data);
        if ($request->ajax()) {
            $data = $this->getCategory()::select('*');
            // $data = DB::table('categories')->whereNotNull('deleted_at');
            // $data = $this->getCategory()::select('*')->onlyTrashed();

            return DataTables::of($data)
                ->addColumn('action', 'categories.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true)
            ;
        }

        return view('categories.ajax');
        // dd(datatables()->of($this->getCategory()::select('*'))
        //     ->addColumn('action', 'categories.action')
        //     ->rawColumns(['action'])
        //     ->addIndexColumn()
        //     ->make(true));
        // return view('categories.index');
        // if (request()->ajax()) {
        //     return datatables()->of($this->getCategory()::select('*'))
        //         ->addColumn('Actions', function ($data) {
        //             return '<button type="button" class="btn btn-success btn-sm" id="getEditProductData" data-id="'.$data->id.'">Edit</button>
        //                 <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteProductModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
        //         })
        //         ->rawColumns(['Actions'])
        //         ->make(true)
        //         ;
        // }
    }

    /**
     * Re-define getAll() function for dataTable AJAX.
     *
     * @param mixed $type
     */
    public function getAll($type)
    {
        $data = null;
        switch ($type) {
            case false:
                 $data = $this->getCategory()::select('*')->onlyTrashed();

                break;
            case true:
                 $data = $this->getCategory()::select('*')->withTrashed();

                break;
            default:
                 $data = $this->getCategory()::select('*');

                break;
        }

        return DataTables::of($data)
            ->addColumn('action', 'categories.action_SD')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true)
            ;
    }

    public function getAllOnlyTrashed()
    {
        $data = $this->getCategory()::select('*')->onlyTrashed();

        return DataTables::of($data)
            ->addColumn('action', 'categories.action_SD')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true)
            ;
    }

    public function ajaxStore($request)
    {
        $categoryId = $request->category_id;

        return $this->getCategory()::updateOrCreate(
            ['id' => $categoryId],
            ['name' => $request->name, 'slug' => $request->name]
        );

        // return response()->json($category);
        /*
        try {
            $this->getCategory()::create($request->all());

            // return response()->json($category);
        } catch (\Exception $e) {
            return null;
        }
        */
        /* HACKTUT
        // $this->getCategory()::create($request->all());
        $category = $this->getCategory();
        $category->name = $request->name;
        $category->slug = $request->name;
        $category->save();
        */
    }

    public function ajaxEdit($id)
    {
        $category = $this->getCategory()::findOrFail($id);

        return response()->json($category);
        /* HACKTUT
        $category = $this->findByID($id);
        $html = '<div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="editName" value="'.$category->name.'">
                    </div>';

        return response()->json(['html' => $html]);
        */
    }

    public function ajaxUpdate($request, $id)
    {
        /* HACKTUT
        // $this->update($request, $id);
        $this->findByID($id)->update($request->all());
        */
    }

    public function ajaxDelete($id)
    {
        $category = $this->getCategory()::findOrFail($id);
        // dd($category);
        // update new value for each post before delete category
        // $category->posts()->whereCategoryId($id)->update(['category_id' => 1]);
        // $category->posts()->detach();
        $category->delete();

        // return response()->json(['success' => 'Data is successfully deleted']);
        return response()->json(['success' => 'Item deleted successfully.']);

        return response()->json($category);
    }

    protected function getCategory()
    {
        return app()->make($this->getModel());
    }
}
