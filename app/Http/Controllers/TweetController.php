<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TweetRepository;
use App\Http\Requests\CreateTweet;

class TweetController extends Controller
{

    protected $tweet;
    /**
     * TweetController constructor.
     *
     * @param TweetRepository $tweet
     */
    public function __construct(TweetRepository $tweet)
    {
        $this->middleware('auth:api');
        $this->tweet = $tweet;
    }

    /**
     * create a tweet.
     *
     * @param  CreateTweet  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTweet $request)
    {
        $array= ['tweet' => $request->get('tweet') , 'user_id' => auth()->user()->id];
        $tweet  = $this->tweet->createTweet($array);
        return self::createResponseFromData(201, ['tweet' => $tweet]);
    }

    /**
     * Delete a tweet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  tweet id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $this->tweet->deleteTweet($id);
        return self::createResponseFromData(200 , ['message' => trans('auth.delete')]);
    }
}
