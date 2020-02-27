<?php

namespace App\Repositories;

interface UserRepositoryInterface
{   
    /**
     *  Create a user.
     *
     * @return mixed
     */
    public function createUser(array $data);
}

