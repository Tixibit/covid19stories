<?php

namespace App;

use Abraham\TwitterOAuth\TwitterOAuth;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\ORM\FieldType\DBDatetime;

class TwitterAPIService implements iTwitterAPIService
{
    use Configurable, Injectable;

    private $apiKey;
    private $apiSecretKey;
    private $accessToken;
    private $accessSecret;
    private $connection;

    public function __construct()
    {
        $this->apiKey = Environment::getEnv('TWITTER_API_KEY');
        $this->apiSecretKey = Environment::getEnv('TWITTER_API_SECRET_KEY');
        $this->accessToken = Environment::getEnv('TWITTER_API_ACCESS_TOKEN');
        $this->accessSecret = Environment::getEnv('TWITTER_API_ACCESS_SECRET');
        $this->connection = new TwitterOAuth(
            $this->apiKey,
            $this->apiSecretKey,
            $this->accessToken,
            $this->accessSecret
        );
    }

    /**
     * Get the value of apiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Get the value of apiSecretKey
     */
    public function getApiSecretKey()
    {
        return $this->apiSecretKey;
    }

    /**
     * Get the value of connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    public function getUserTweets($user, $count)
    {

        // Check user
        if (empty($user)) {
            return null;
        }

        // Call rest api
        $params = [
            'screen_name' => $user,
            'count' => $count,
            'include_rts' => false,
            'exclude_replies' => false,
        ];
        $connection = $this->getConnection();
        $response = $connection->get("statuses/user_timeline", $params);

        // Parse all tweets
        $tweets = array();
        if ($response && is_array($response)) {
            foreach ($response as $tweet) {
                $tweets[] = $this->parseTweet($tweet);
            }
        }

        return $tweets;
    }

    public function searchTweets($query, $count)
    {
        $tweets = array();
        if (!empty($query)) {
            // Call rest api
            $params = [
                'q' => $query . ' -filter:retweets',
                'count' => $count,
                // 'exclude_replies' => true,
                // 'include_rts' => false,
                '-filter' => 'nativeretweets',
                '-filter' => 'replies',
            ];
            $connection = $this->getConnection();
            $response = $connection->get("search/tweets", $params);

            // Parse all tweets
            if ($response) {
                foreach ($response->statuses as $tweet) {
                    $tweets[] = $tweet; // $this->parseTweet($tweet);
                }
            }
        }

        return $tweets;
    }

    /**
     * Inject a hyperlink into the body of a tweet
     *
     * @param array $tokens List of characters/words that make up the tweet body,
     * with each index representing the visible character position of the body text
     * (excluding markup).
     * @param stdClass $entity The link object
     * @param string $link 'href' tag for the link
     * @param string $title 'title' tag for the link
     */
    protected function injectLink(&$tokens, $entity, $link, $title)
    {
        $startPos = $entity->indices[0];
        $endPos = $entity->indices[1];

        // Inject <a tag at the start
        $tokens[$startPos] = sprintf(
            "<a href='%s' title='%s' target='_blank'>%s</a>",
            Convert::raw2att($link),
            Convert::raw2att($title),
            Convert::raw2att($title)
        );
        $characters = $endPos - $startPos - 1;
        array_splice($tokens, $startPos + 1, $characters, array_fill($startPos + 1, $characters, ''));
    }

    /**
     * Inject photo media into the body of a tweet
     *
     * @param array $tokens List of characters/words that make up the tweet body,
     * with each index representing the visible character position of the body text
     * (excluding markup).
     * @param stdClass $entity The photo media object
     */
    protected function injectPhoto(&$tokens, $entity)
    {
        $startPos = $entity->indices[0];
        $endPos = $entity->indices[1];
        $https = "_https";

        // Inject a+image tag at the last token position
        $tokens[$endPos] = sprintf(
            "<a href='%s' title='%s'><img src='%s' width='%s' height='%s' target='_blank' /></a>",
            Convert::raw2att($entity->url),
            Convert::raw2att($entity->display_url),
            Convert::raw2att($entity->{"media_url$https"}),
            Convert::raw2att($entity->sizes->small->w),
            Convert::raw2att($entity->sizes->small->h)
        );

        // now empty-out the preceding tokens
        for ($i = $startPos; $i < $endPos;
            $i++) {
            $tokens[$i] = '';
        }
    }

    /**
     * Parse the tweet object into a HTML block
     *
     * @param stdClass $tweet Tweet object
     * @return string HTML text
     */
    protected function parseText($tweet)
    {
        $rawText = $tweet->text;

        // tokenise into words for parsing (multibyte safe)
        $tokens = preg_split('/(?<!^)(?!$)/u', $rawText);

        // Inject links
        foreach ($tweet->entities->urls as $url) {
            $this->injectLink($tokens, $url, $url->url, $url->display_url);
        }

        // Inject hashtags
        foreach ($tweet->entities->hashtags as $hashtag) {
            $link = 'https://twitter.com/search?src=hash&q=' . Convert::raw2url('#' . $hashtag->text);
            $text = "#" . $hashtag->text;

            $this->injectLink($tokens, $hashtag, $link, $text);
        }

        // Inject mentions
        foreach ($tweet->entities->user_mentions as $mention) {
            $link = 'https://twitter.com/' . Convert::raw2url($mention->screen_name);
            $this->injectLink($tokens, $mention, $link, '@' . $mention->name);
        }

        // Inject photos
        // unlike urls & hashtags &tc, media is not always defined
        if (property_exists($tweet->entities, 'media')) {
            foreach ($tweet->entities->media as $med_item) {
                if ($med_item->type == 'photo') {
                    $this->injectPhoto($tokens, $med_item);
                }
            }
        }

        // Re-combine tokens
        return implode('', $tokens);
    }

    /**
     * Calculate the time ago in days, hours, whichever is the most significant
     *
     * @param integer $time Input time as a timestamp
     * @param integer $detail Number of time periods to display. Increasing provides greater time detail.
     * @return string
     */
    public static function determineTimeAgo($time, $detail = 1)
    {
        $difference = time() - $time;

        if ($difference < 1) {
            return _t('Date.LessThanMinuteAgo', 'less than a minute');
        }

        $periods = array(
            365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'min',
            1 => 'sec',
        );

        $items = array();

        foreach ($periods as $seconds => $description) {
            // Break if reached the sufficient level of detail
            if (count($items) >= $detail) {
                break;
            }

            // If this is the last element in the chain, round the value.
            // Otherwise, take the floor of the time difference
            $quantity = $difference / $seconds;
            if (count($items) === $detail - 1) {
                $quantity = round($quantity);
            } else {
                $quantity = intval($quantity);
            }

            // Check that the current period is smaller than the current time difference
            if ($quantity <= 0) {
                continue;
            }

            // Append period to total items and continue calculation with remainder
            if ($quantity !== 1) {
                $description .= 's';
            }
            $items[] = $quantity . ' ' . _t("Date." . strtoupper($description), $description);
            $difference -= $quantity * $seconds;
        }
        $time = implode(' ', $items);
        return _t(
            'Date.TIMEDIFFAGO',
            '{difference} ago',
            'Time since tweet',
            array('difference' => $time)
        );
    }

    /**
     * Converts a tweet response into a simple associative array of fields
     *
     * @param stdClass $tweet Tweet object
     * @return array Array of fields with Date, User, and Content as keys
     */
    public function parseTweet($tweet)
    {
        $profileLink = "https://twitter.com/" . Convert::raw2url($tweet->user->screen_name);
        $tweetID = $tweet->id_str;
        $https = "_https";

        //
        // Date format.
        //

        $tweetDate = \DateTime::createFromFormat('D M j H:i:s O Y', $tweet->created_at);
        $d = DBDatetime::create()->setValue($tweetDate->getTimestamp());

        return array(
            'ID' => $tweetID,
            'Date' => $d,
            'TimeAgo' => self::determineTimeAgo($tweetDate->getTimestamp()),
            'Name' => $tweet->user->name,
            'User' => $tweet->user->screen_name,
            'AvatarUrl' => $tweet->user->{"profile_image_url$https"},
            'Content' => $this->parseText($tweet),
            'Link' => "{$profileLink}/status/{$tweetID}",
            'ProfileLink' => $profileLink,
            'ReplyLink' => "https://twitter.com/intent/tweet?in_reply_to={$tweetID}",
            'RetweetLink' => "https://twitter.com/intent/retweet?tweet_id={$tweetID}",
            'FavouriteLink' => "https://twitter.com/intent/favorite?tweet_id={$tweetID}",
        );
    }

    /**
     * Get the value of accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get the value of accessSecret
     */
    public function getAccessSecret()
    {
        return $this->accessSecret;
    }
}
