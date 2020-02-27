<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FollowRepository;
use App\Repositories\TweetRepository;

class FollowController extends Controller
{

    protected $follow;
    protected $tweet;
    /**
     * FollowController constructor.
     *
     * @param TweetRepository $post
     * @param FollowRepository $post
     */
    public function __construct(FollowRepository $follow , TweetRepository $tweet)
    {
        $this->middleware('auth:api');
        $this->follow = $follow;
        $this->tweet = $tweet;
    }

    public function follow(Request $request , $id)
    { 
        if($id == auth()->user()->id)
        return self::createResponseFromData(403, ['message' => "Forbidden"]); 
        $data = ['user_id' => $id ,'follower_id' => auth()->user()->id ];
        $this->follow->follow($data); 
        return self::createResponseFromData(201, ['message' => "success"]); 
    }


    public function TimeLine(Request $request)
    {
        $follower_id =auth()->user()->id;
        $timeline = $this->tweet->getTimeLine($follower_id);
        return self::createResponseFromData(200,['timeline' => $timeline]);
    }
}
