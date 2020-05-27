<?php

namespace App\Services\Implement;

use App\Repositories\MessageRepository;
use App\Services\MessageService;
use Illuminate\Support\Facades\Auth;

class MessageServiceImpl extends BaseServiceImpl implements MessageService
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;

    }
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModelRepository()
    {
        return MessageRepository::class;
    }

    public function getUser()
    {
        // get post instance
        $user = $this->makeRepo()->getUser();

        return $user;

    }

    /**
     * Make Model Class.
     */
    protected function makeRepo()
    {
        return app()->make($this->getModelRepository());
    }

}
