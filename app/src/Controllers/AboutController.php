<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class AboutController extends BaseController
{
    /**
     * URL Segment used for links
     */
    public $url_segment = 'about';

    private static $allowed_actions = [
        'index',
    ];

    protected function init()
    {
        parent::init();
    }

    public function index(HTTPRequest $request)
    {
        return [];
    }

    public function getPageTitle()
    {
        return 'About';
    }
}
