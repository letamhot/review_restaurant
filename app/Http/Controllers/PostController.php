<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Post_Tag;
use App\Models\Tag;
use Carbon\Carbon;

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

        // $post = Post::find()->tag();
        // $atri = Post_Tag::all();
        // foreach($posts as $a){
        //     $a['tag_name'] = $a->tag()->pluck('name')->toArray();
        // }l


        foreach ($posts as $key => $post) {
            $posts[$key]['name'] = User::find($post['user_id'])->name;
            $posts[$key]['category_name'] = $post->category->name;

            $posts[$key]['tag_name'] = $post->tag;
            $posts[$key]['tag_name'] = implode(', ', $post->tag()->pluck('name')->toArray());
        }

        return response()->json($posts);
    }

    public function getAllCategory(Request $request)
    {
        if ($request->ajax()) {
            return $this->postService->getAllCategory();
        }
        return null;
    }
    public function getAllTag(Request $request)
    {
        if ($request->ajax()) {
            //  return response()->json($this->postService->getAllTag());
            return response()->json(Tag::all());
        }
        return null;
    }

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
        // dd($request->all());
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

    public function showPostDetail($id)
    {
        $post_detail = $this->postService->findById($id);
        // $post_detail['array_tag'] = $post_detail->tag;
        // dd($post_detail);
        return view('front-end.page_detail', compact('post_detail'));
    }
    public function showUser($id)
    {
        $user = $this->postService->findById($id)->user->name;
        return response()->json($user);
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
        $obj->tags = $obj->tag->pluck('id')->toArray();
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
                foreach ($post as $key => $posts) {
                    $post[$key]['name'] = User::find($posts['user_id'])->name;
                    $post[$key]['category_name'] = $posts->category->name;
                    $post[$key]['tag_name'] = implode(', ', $posts->tag()->pluck('name')->toArray());
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
    public function checkstatus()
    {
        return view('backend.post.inactive');
    }
    public function status()
    {
        $posts = $this->postService->status();
        if ($posts) {
            foreach ($posts as $key => $post) {
                $posts[$key]['name'] = User::find($post['user_id'])->name;
                $posts[$key]['category_name'] = $post->category->name;
                $posts[$key]['tag_name'] = implode(', ', $post->tag()->pluck('name')->toArray());
            }
        }
        // dd($posts);
        return response()->json($posts, 200);
    }

    public function user_post()
    {
        return view('backend.post.postUser');
    }
    public function postuser()
    {
        $posts = $this->postService->user_post();
        if ($posts){
            foreach ($posts as $key => $post) {
                $posts[$key]['name'] = User::find($post['user_id'])->name;
                $posts[$key]['category_name'] = $post->category->name;
                $posts[$key]['tag_name'] = implode(', ',$post->tag()->pluck('name')->toArray());

    
            }
        }
        // dd($posts);
        return response()->json( $posts, 200);
    }

    public function check(Request $request, $id)
    {
        $posts = $this->postService->check($request, $id);
        return response()->json($posts, 200);
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
    public function showNewsOfMonth()
    {
        $newsmonth = Post::whereMonth('created_at', '=', Carbon::now()->month)->get();
        return view('front-end.landing-page', compact('newsmonth'));
    }
    public function alllatestnews()
    {
        $alllatestnew = Post::whereMonth('created_at', '=', Carbon::now()->month)->get();
        return view('front-end.latest-news', compact('alllatestnew'));
    }
}
