<?php

namespace App\Repositories;

interface TweetRepositoryInterface
{   
    /**
     * Get's a tweets by user ID
     *
     * @param int
     */
    public function getTimeLine($user_id);

    /**
     * Get's all tweet.
     *
     * @return mixed
     */
    public function getAll();

    /**
     *  Create a tweet.
     *
     * @return mixed
     */
    public function createTweet(array $data);

    /**
     * Deletes a tweet.
     *
     * @param int
     */
    public function deleteTweet($post_id);

    /**
     * Updates a tweet.
     *
     * @param int
     * @param array
     */
    public function updateTweet($post_id, array $post_data);
}

