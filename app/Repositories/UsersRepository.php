<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    /**
     * create new instance
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;         
    }
    
    
}