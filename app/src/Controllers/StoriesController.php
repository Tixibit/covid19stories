<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;

class StoriesController extends BaseController
{
    /**
     * URL Segment used for links
     */
    public $url_segment = 'stories';

    private static $allowed_actions = [
        'index',
    ];

    protected function init()
    {
        parent::init();
    }

    public function index(HTTPRequest $request)
    {
        return [
            'PageTitle' => 'Stories',
        ];
    }

    public function getStoriesFromTwitter($limit = 50)
    {
        $rawStories = RawCOVIDStory::get()->limit($limit);
        $list = ArrayList::create();
        foreach ($rawStories as $story) {
            $data = json_decode($story->Data);
            $list->push(['Text' => $data->text]);
        }
        return $list;
    }
}
