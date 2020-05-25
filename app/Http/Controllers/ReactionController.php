<?php

namespace App\Http\Controllers;

use App\Services\ReactionService;
use Illuminate\Http\Request;

class ReactionController extends Controller
{

    protected $reactionService;

    public function __construct(ReactionService $reactService)
    {
        $this->reactService = $reactService;
    }

    public function react(Request $request)
    {
        return $this->reactionService->react($request);
    }

    public function followTag(Request $request)
    {
        return $this->reactionService->followTag($request);
    }

}
