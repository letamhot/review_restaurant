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
     *  Using for CategoryController@destroy.
     *
     * @param mixed $id
     */
    public function destroy($id)
    {
        try {
            $role = $this->findById($id);
            // update new value for each post before delete category
            // $role->posts()->whereUserId($id)->update(['user_id' => 1]);
            // $role->posts()->detach();

            return $role->delete();
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
            $data = $this->getRole()::select('*');

            return DataTables::of($data)
                ->addColumn('action', 'role.btn_action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true)
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
            $data = $this->getRole()::select('*')->onlyTrashed();

            return DataTables::of($data)
                ->addColumn('action', 'role.btn_trash')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true)
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
                ['name' => $request->name, 'description' => $request->description ]
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
