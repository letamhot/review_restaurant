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
     * Override method getAll() function for dataTable AJAX.
     * Using for CategoryController@index.
     */
    public function getAllAJAX()
    {
        try {
            $data = $this->getCategory()::select('*');
            $trash = $this->getCategory()::select('id')->onlyTrashed();
            $allCategory = $this->getCategory()::select('id')->withTrashed();

            return DataTables::of($data)
                ->with('all_count', function () use ($allCategory) {
                    return $allCategory->count();
                })
                ->with('trash_count', function () use ($trash) {
                    return $trash->count();
                })
                ->addIndexColumn()
                ->toJson();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Re-define getAllOnlyTrashed() function for dataTable AJAX.
     *  Using for CategoryController@getTrashRecords.
     */
    public function getAllOnlyTrashedAJAX()
    {
        try {
            $data = $this->getCategory()::select('*')->onlyTrashed();
            $allCategory = $this->getCategory()::select('id')->withTrashed();

            return DataTables::of($data)
                ->addIndexColumn()
                ->with('all_count', function () use ($allCategory) {
                    return $allCategory->count();
                })
                ->with('trash_count', function () use ($data) {
                    return $data->count();
                })
                ->toJson();
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
     * Override method destroy() function for dataTable AJAX.
     * Using for CategoryController@destroy.
     *
     * @param mixed $object
     */
    public function destroy($object)
    {
        try {
            // set new category_id for related post before delete
            $object->posts()->whereCategoryId($object->id)->update(['category_id' => 1]);

            return parent::destroy($object);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function categoryStatistic()
    {
        try {
            $categoryStatistic = [];
            $categoryStatistic['all_categories'] = $this->getCategory()->count();
            $categoryStatistic['active_categories'] = $this->getCategory()->whereNull('deleted_at')->count();
            return $categoryStatistic;
        } catch (\Exception $e) {
            return $e->getMessage();
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
