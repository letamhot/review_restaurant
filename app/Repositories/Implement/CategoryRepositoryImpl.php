<?php

namespace App\Repositories\Implement;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Eloquent\EloquentRepository;
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

    /**
     * Re-define getAllOnlyTrashed() function for dataTable AJAX.
     *  Using for CategoryController@destroy.
     *
     * @param mixed $id
     */
    public function destroy($id)
    {
        try {
            $category = $this->findById($id);
            // update new value for each post before delete category
            $category->posts()->whereCategoryId($id)->update(['category_id' => 1]);
            $category->posts()->detach();

            return $category->delete();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Re-define getAll() function for dataTable AJAX.
     * Using for CategoryController@index.
     */
    public function getAll()
    {
        try {
            $data = $this->getCategory()::select('*');
            $trash = $this->getCategory()::select('*')->onlyTrashed();
            $allCategory = $this->getCategory()::select('*')->withTrashed();

            return DataTables::of($data)
                ->with('all_count', function () use ($allCategory) {
                    return $allCategory->count();
                })
                ->with('trash_count', function () use ($trash) {
                    return $trash->count();
                })
                ->addIndexColumn()
                ->toJson()
            ;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Re-define getAllOnlyTrashed() function for dataTable AJAX.
     *  Using for CategoryController@getTrashRecords.
     */
    public function getAllOnlyTrashed()
    {
        try {
            $data = $this->getCategory()::select('*')->onlyTrashed();
            $allCategory = $this->getCategory()::select('*')->withTrashed();

            return DataTables::of($data)
                ->addIndexColumn()
                ->with('all_count', function () use ($allCategory) {
                    return $allCategory->count();
                })
                ->with('trash_count', function () use ($data) {
                    return $data->count();
                })
                ->toJson()
            ;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Update or Create new record to database.
     *
     * @param mixed $request
     */
    public function ajaxStore($request)
    {
        try {
            $categoryId = $request->category_id;

            return $this->getCategory()::updateOrCreate(
                ['id' => $categoryId],
                ['name' => $request->name, 'slug' => $request->name]
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Make Model class.
     */
    protected function getCategory()
    {
        return app()->make($this->getModel());
    }
}
