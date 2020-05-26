<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ArticleService;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->articleService->showDetail($id);
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

}
