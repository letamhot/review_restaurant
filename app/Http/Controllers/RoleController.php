<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;
    protected $path;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->path = 'backend.role.';
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
                return $this->roleService->getAll();
            }

            return view($this->path.'index');
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
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
    public function store(RoleRequest $request)
    {
        try {
            $result = $this->roleService->ajaxStore($request);

            if ($result) {
                return response()->json(['success' => 'Role saved successfully']);
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
    public function show(Role $Role)
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
            $role = $this->roleService->findById($id);
            if ($role) {
                return response()->json($role);
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
    public function update(Request $request, Role $role)
    {
        // NOT AJAX
        $result = $this->roleService->update($request, $role);

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
            $result = $this->roleService->destroy($id);
            if ($result) {
                return response()->json(['success' => 'Role deleted successfully']);
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
            return $this->roleService->getAllOnlyTrashed();
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
            $result = $this->roleService->restoreSoftDelete($id);
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
            $result = $this->roleService->permanentDestroySoftDeleted($id);

            if ($result) {
                return response()->json(['success' => 'Role permanently deleted successfully']);
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
    protected function goTo($result)
    {
        if ($result) {
            // Toastr::success('Successfully! :)', 'Success');

            return redirect()->route($this->path.'index');
        }
        // Toastr::error('Something went wrong!', 'Error');

        return back();
    }

    /**
     * Display validation errors of request.
     */
    protected function errorValidateMessage()
    {
        return response()->json(['errors' => RoleRequest::errors()->all()]);
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
    protected function errorFailMessage()
    {
        $msg = [
            'status' => 500,
            'errors' => ['Failed!', 'Unknown error!'],
            'success' => false,
        ];

        return response()->json($msg);
    }
}
