<?php

namespace App\Repositories\Implement;

use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Yajra\DataTables\DataTables;

class RoleRepositoryImpl extends EloquentRepository implements RoleRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Role::class;
    }

    /**
     * Re-define getAllOnlyTrashed() function for dataTable AJAX.
     *  Using for RoleController@destroy.
     *
     * @param mixed $id
     */
    public function destroy($id)
    {
        try {
            $role = $this->findById($id);

            return $role->delete();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Re-define getAll() function for dataTable AJAX.
     * Using for RoleController@index.
     */
    public function getAll()
    {
        try {
            $data = $this->getRole()::select('*');
            $trash = $this->getRole()::select('*')->onlyTrashed();
            $allRole = $this->getRole()::select('*')->withTrashed();

            return DataTables::of($data)
                ->with('all_count', function () use ($allRole) {
                    return $allRole->count();
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
     *  Using for RoleController@getTrashRecords.
     */
    public function getAllOnlyTrashed()
    {
        try {
            $data = $this->getRole()::select('*')->onlyTrashed();
            $allRole = $this->getRole()::select('*')->withTrashed();

            return DataTables::of($data)
                ->addIndexColumn()
                ->with('all_count', function () use ($allRole) {
                    return $allRole->count();
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
            $roleId = $request->role_id;

            return $this->getRole()::updateOrCreate(
                ['id' => $roleId],
                ['name' => $request->name],
                ['description' => $request->description]
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Make Model class.
     */
    protected function getRole()
    {
        return app()->make($this->getModel());
    }
    
}
