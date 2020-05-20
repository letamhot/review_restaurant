<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Services\PostService;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;


class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postService->getAll();
        foreach ($posts as $post) {
            $post['name'] = User::find($post['user_id'])->name;
            $post['category_name'] = Category::find($post['category_id'])->name;

        }
        return response()->json($posts);
    }

    public function getAllCategory(Request $request )
    {
        if ($request->ajax()) {
             return $this->postService->getAllCategory();
        }
       return null;
    }

    // public function showindex()
    // {
    //     $posts = $this->postService->getAll();
    //     return view('post.ajax.index', compact('posts'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.post.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {   
        
        $this->postService->create($request);
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = $this->postService->findByIdWithTrashed($id);
        return response()->json($obj, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj = $this->postService->findByID($id);
        return response()->json($obj, 200);
        // return view('post.edit', compact('post'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $result = $this->postService->update($request, $post);
        $obj = $this->postService->findByID($id);

        try {
            $this->postService->update($request, $obj);
        } catch (\Throwable $th) {
            return back();
        }
       
        return redirect()->route('post.index');
        // return $this->goTo($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $this->postService->destroy($id);

        return redirect()->route('post.index');
    }

    public function getTrashRecords()
    {
        try {
            $post = $this->postService->getAllOnlyTrashed();
            
            if ($post) {
                foreach ($post as $posts) {
                    $posts['name'] = User::find($posts['user_id'])->name;
                    $posts['category_name'] = Category::find($posts['category_id'])->name;
        
                }
                return response()->json($post, 200);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
    }
    public function restoreTrash($id)
    {
        try {
            $result = $this->postService->restoreSoftDelete($id);
            if ($result) {
                return response()->json(['success' => 'Post restored successfully.']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorExceptionMessage();
        }
    }
    public function emptyTrash($id)
    {
        try {
            $result = $this->postService->permanentDestroySoftDeleted($id);

            if ($result) {
                return response()->json(['success' => 'Post permanently deleted successfully']);
            }

            return $this->errorFailMessage();
        } catch (\Exception $e) {
            return $this->errorMessage();
        }
    }

    protected function errorValidateMessage()
    {
        return response()->json(['errors' => PostRequest::errors()->all()]);
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
