<?php
namespace App;

interface iTwitterAPIService
{
    /**
     * Gets tweets from a specific twitter user
     * keys 'Date', 'User' and 'Content'
     *
     * @param string $user Name of user to search for tweets from
     * @param string $count Number of tweets to return
     * @return array Array of nested associative arrays, each representing details of a single tweet
     */
    public function getUserTweets($user, $count);

    /**
     * Search tweets based on a given keywords with a certain limit
     * keys 'Date', 'User' and 'Content'
     *
     * @param string $query Query to use for searching for tweets
     * @param string $count Number of tweets to return
     * @return array Array of nested associative arrays, each representing details of a single tweet
     */
    public function searchTweets($query, $count);
}
