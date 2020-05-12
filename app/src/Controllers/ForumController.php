<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class ForumController extends BaseController
{
    /**
     * URL Segment used for links
     */
    public $url_segment = 'forums';

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
            'PageTitle' => 'Forums',
        ];
    }
}
