<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class MemberProfileController extends BaseController
{
    /**
     * URL Segment used for links
     */
    public $url_segment = 'profile';

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
            'PageTitle' => 'Profile',
        ];
    }

}
