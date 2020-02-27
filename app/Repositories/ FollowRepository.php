<?php 

namespace App\Repositories;

use App\Follow;

class FollowRepository implements FollowRepositoryInterface
{
    public function follow(array $data)
    {
      return  Follow::create($data);
    }
}