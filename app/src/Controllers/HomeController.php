<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class HomeController extends BaseController
{

    private static $allowed_actions = [
        'index',
    ];

    protected function init()
    {
        parent::init();

        //$rawStories = RawCOVIDStory::get();
        // foreach ($rawStories as $story) {
        //     Debug::dump(json_decode($story->Data)->text);
        // }
        // exit();
    }

    public function index(HTTPRequest $request)
    {
        return [
            'PageTitle' => 'Home',
        ];
    }
}
