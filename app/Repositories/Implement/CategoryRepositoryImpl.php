<?php

namespace App\Repositories\Implement;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Str;

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
            $category->slug = Str::slug($request->name);
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

        return true;
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

    protected function getCategory()
    {
        return app()->make($this->getModel());
    }
}
