<?php

namespace App\Repositories\Implement;

use App\Models\Post;
use App\Repositories\MessageRepository;
use App\Repositories\Eloquent\EloquentRepository;

class MessageRepositoryImpl extends EloquentRepository implements MessageRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Messages::class;
    }

    /**
     * Make Model class.
     */
    protected function getMessageModel()
    {
        return app()->make($this->getModel());
    }

    public function getUser()
    {
        return Auth::user()->messages;
    }

}
