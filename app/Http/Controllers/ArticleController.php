<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ArticleService;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleService;


    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allpost =  $this->articleService->getAll();
        return view('front-end.allpost', compact('allpost'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post_detail =  $this->articleService->showDetail($id);
        // dd($post_detail);
        return view('front-end.page_detail', compact('post_detail'));
    }

    public function getLatestPost($number)
    {
        return $this->articleService->getLatestPost($number);
    }

    /**
     * $days: how many days before from now
     * $number: take how many posts
     * $sort_by: sort by ASC or DESC
     */
    public function getTopReactPost($days, $number, $sort_by)
    {
        return $this->articleService->getTopReactPost($days, $number, $sort_by);
    }

    public function getAllBookmarked()
    {
        $user = Auth::user();
        if ($user) {
            return $this->articleService->getAllBookmarked($user);
        }
        return null;
    }

    public function showLatestArticles($id)
    {
        if ($id === "1") {
            $news = Post::where('created_at', '>=', Carbon::now()->subdays(1))->take(3)->get();
            return response()->json($news);
        } else if ($id === "2") {
            $news = Post::where('created_at', '>=', Carbon::now()->subdays(7))->take(3)->get();
            return response()->json($news);
        } else {
            $news = Post::whereMonth('created_at', '=', Carbon::now()->month)->get();
            return response()->json($news);
        }
    }
}
