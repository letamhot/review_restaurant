<?php

namespace App\Repositories\Implement;

use App\Models\Commment;
use App\Repositories\CommmentRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Yajra\DataTables\DataTables;

class CommmentRepositoryImpl extends EloquentRepository implements CommmentRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Commment::class;
    }

    /**
     * Re-define getAllOnlyTrashed() function for dataTable AJAX.
     *  Using for CommmentController@destroy.
     *
     * @param mixed $id
     */
    public function destroy($id)
    {
        try {
            $commment = $this->findById($id);
            // update new value for each post before delete category
            // $Commment->posts()->whereUserId($id)->update(['user_id' => 1]);
            // $Commment->posts()->detach();

            return $commment->delete();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Re-define getAll() function for dataTable AJAX.
     * Using for CommmentController@index.
     */
    public function getAll()
    {
        try {
            $data = $this->getCommment()::select('*');
            $trash = $this->getCommment()::select('*')->onlyTrashed();
            $allCommment = $this->getCommment()::select('*')->withTrashed();

            return DataTables::of($data)
                ->with('all_count', function () use ($allCommment) {
                    return $allCommment->count();
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
     *  Using for CommmentController@getTrashRecords.
     */
    public function getAllOnlyTrashed()
    {
        try {
            $data = $this->getCommment()::select('*')->onlyTrashed();
            $allCommment = $this->getCommment()::select('*')->withTrashed();

            return DataTables::of($data)
                ->addIndexColumn()
                ->with('all_count', function () use ($allCommment) {
                    return $allCommment->count();
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
    // public function ajaxStore($request)
    // {
    //     try {
    //         $CommmentId = $request->Commment_id;

    //         return $this->getCommment()::updateOrCreate(
    //             ['id' => $CommmentId],
    //             ['name' => $request->name, 'description' => $request->description]
    //         );
    //     } catch (\Exception $e) {
    //         return null;
    //     }
    // }

    /**
     * Make Model class.
     */
    protected function getCommment()
    {
        return app()->make($this->getModel());
    }
    
}
