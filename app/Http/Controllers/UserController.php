<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $path;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->path = 'backend.users.';
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
                return $this->userService->getAll();
            }

            return view($this->path . 'index');
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
        // AUTO CREATE NEW USER WHEN LOGED IN WITH OAUTH API
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // USING METHOD loginOrCreateUser()
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // dataTables
    }
    public function post_user($id)
    {
        $post_user = $this->userService->findById($id);
        return view('front-end.post_user', compact('post_user'));
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
            // GET USER INFO ALONG WITH ALL ROLE
            $user = $this->userService->findByIdWithTrashedToEdit($id);
            if ($user) {
                return response()->json($user);
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
    public function update(Request $request)
    {
        try {
            $user = $this->userService->findByIdWithTrashed($request->id);

            $result = $this->userService->update($request->all(), $user);
            if ($result) {
                return response()->json(['success' => 'Update successfully']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
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
            $user = $this->userService->findById($id);
            $result = $this->userService->destroy($user);
            if ($result) {
                return response()->json(['success' => 'User set to inactive successfully']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorMessage();
        }
    }

    /**
     * Display validation errors of request.
     */
    protected function errorValidateMessage()
    {
        return response()->json(['errors' => UserRequest::errors()->all()]);
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
