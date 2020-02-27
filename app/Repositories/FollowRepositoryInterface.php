<?php

namespace App\Repositories;

interface FollowRepositoryInterface
{   
    /**
     * Get's a tweet by it's ID
     *
     * @param int
     */
    public function follow(array $data);


    
}

