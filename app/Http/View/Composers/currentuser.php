<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
// use App\Repositories\UserRepository;
use App\User;

class currentuser
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function compose(View $view)
    {
        $view->with('loggedInUser', $this->user);
    }
}