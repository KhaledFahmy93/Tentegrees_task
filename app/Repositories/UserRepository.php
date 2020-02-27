<?php

namespace App\Repositories;

use App\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * create a tweet.
     *
     * @param array
     */
    public function createUser(array $data)
    {
        return User::create($data);   
    }
}