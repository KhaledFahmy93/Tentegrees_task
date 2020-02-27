<?php

namespace App\Repositories;

use App\Follow;
use App\Tweet;

class TweetRepository implements TweetRepositoryInterface
{
    /**
     * Get's a tweet by it's ID
     *
     * @param int
     * @return collection
     */
    public function getTweet($tweet_id)
    {
        return Tweet::find($tweet_id);
    }

    public function getTimeLine($follower_id)
    {
        $ids = Follow::where('follower_id', $follower_id)->select('follower_id')->get();
        return Tweet::with('User:id,name')->whereIn('user_id' , $ids)
                ->latest('updated_at')->paginate(10);
    }

    /**
     * Get's all tweets.
     *
     * @return mixed
     */
    public function getAll()
    {
        return Tweet::all();
    }

    /**
     * Deletes a tweet.
     *
     * @param int
     */
    public function deleteTweet($tweet_id)
    {
        return  Tweet::destroy($tweet_id);
    }

    /**
     * create a tweet.
     *
     * @param array
     */
    public function createTweet(array $data)
    {
        return Tweet::create($data);   
    }

    /**
     * Updates a tweet.
     *
     * @param int
     * @param array
     */
    public function updateTweet($tweet_id, array $tweet_data)
    {
        return Tweet::find($tweet_id)->update($tweet_data);
    }
}