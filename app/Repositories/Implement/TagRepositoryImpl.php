<?php

namespace App\Repositories\Implement;

use App\Models\Tag;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\TagRepository;
use Yajra\DataTables\DataTables;

class TagRepositoryImpl extends EloquentRepository implements TagRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Tag::class;
    }

    /**
     * Override method getAll() function for dataTable AJAX.
     * Using for TagController@index.
     */
    public function getAllAJAX()
    {
        try {
            $data = $this->getTag()::select('*');
            $trash = $this->getTag()::select('id')->onlyTrashed();
            $allTag = $this->getTag()::select('id')->withTrashed();

            return DataTables::of($data)
                ->with('all_count', function () use ($allTag) {
                    return $allTag->count();
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
     *  Using for TagController@getTrashRecords.
     */
    public function getAllOnlyTrashedAJAX()
    {
        try {
            $data = $this->getTag()::select('*')->onlyTrashed();
            $allTag = $this->getTag()::select('id')->withTrashed();

            return DataTables::of($data)
                ->addIndexColumn()
                ->with('all_count', function () use ($allTag) {
                    return $allTag->count();
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
            $tagId = $request->tag_id;

            return $this->getTag()::updateOrCreate(
                ['id' => $tagId],
                ['name' => $request->name, 'slug' => $request->name]
            );
        } catch (\Exception $e) {
            return null;
        }
    }
    /**
     * Re-define getAllOnlyTrashed() function for dataTable AJAX.
     *  Using for TagController@getTrashRecords.
     */
    public function getAllOnlyTrashed()
    {
        try {
            $data = $this->getTag()::select('*')->onlyTrashed();
            $allTag = $this->getTag()::select('id')->withTrashed();

            return DataTables::of($data)
                ->addIndexColumn()
                ->with('all_count', function () use ($allTag) {
                    return $allTag->count();
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
     * Override method destroy() function for dataTable AJAX.
     * Using for TagController@destroy.
     *
     * @param mixed $object
     */
    public function destroy($object)
    {
        try {
            // set new tag_id for related post before delete
            $object->posts()->whereTagId($object->id)->update(['tag_id' => 1]);
            // $object->posts()->detach();

            return parent::destroy($object);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function tagStatistic()
    {
        try {
            $tagStatistic = [];
            $tagStatistic['all_tags'] = $this->getTag()->count();
            $tagStatistic['active_tags'] = $this->getTag()->whereNull('deleted_at')->count();
            return $tagStatistic;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Make Model class.
     */
    protected function getTag()
    {
        return app()->make($this->getModel());
    }
}