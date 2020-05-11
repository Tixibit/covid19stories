<?php

namespace App;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\ArrayData;
use TractorCow\Twitter\Services\ITwitterService;

class TwitterExtension extends Extension
{

    /**
     * @var ITwitterAPIService
     */
    protected $twitterService = null;

    /**
     * Set the service to use for accessing twitter
     * @param ITwitterService $twitterService
     */
    public function setTwitterService(ITwitterAPIService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    /**
     * Retrieves the latest tweets from a user
     * @param string $user
     * @param integer $count
     * @return ArrayData
     */
    public function getLatestTweetsFromUser($user, $count = 10)
    {
        // Check that the twitter user is configured
        if (empty($user)) {
            return null;
        }

        $tweets = $this->twitterService->getUserTweets($user, $count);
        return $this->viewableTweets($tweets);
    }

    /**
     * Retrieves (up to) the last $count favourite tweets.
     *
     * Note: Actual returned number may be less than 10 due to reasons
     *
     * @param integer $count
     * @return ArrayList
     */
    public function getUserFavorites($user, $count = 4)
    {
        //
        // TODO
        //

        // Check that the twitter user is configured
        // if (empty($user)) {
        //     return null;
        // }

        // return new ArrayList($this->twitterService->getFavorites($user, $count));
    }

    /**
     * Converts an array of tweets into a template-compatible format
     *
     * @param array $tweets
     * @return ArrayList
     */
    protected function viewableTweets($tweets)
    {
        $items = new ArrayList();
        foreach ($tweets as $tweet) {
            $tweet['DateObject'] = DBField::create_field('SilverStripe\ORM\FieldType\DBDateTime', $tweet['Date']);
            $tweet['Content'] = DBField::create_field('HTMLText', $tweet['Content']);
            $items->push(new ArrayData($tweet));
        }
        return $items;
    }

    /**
     * Retrieves (up to) the last $count tweets searched by the $query
     *
     * Note: Actual returned number may be less than 10 due to reasons
     *
     * @param string $query Search terms
     * @param integer $count Number of tweets
     * @return ArrayList List of tweets
     */
    public function searchTweets($query, $count = 10)
    {
        if (empty($query)) {
            return null;
        }

        $tweets = $this->twitterService->searchTweets($query, $count);
        return $this->viewableTweets($tweets);
    }
}
