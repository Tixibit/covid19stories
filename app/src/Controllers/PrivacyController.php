<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class PrivacyController extends BaseController
{
    /**
     * URL Segment used for links
     */
    public $url_segment = 'privacy-policy';

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
            'PageTitle' => 'Privacy Policy',
        ];
    }
}
