<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class MemberRegistrationController extends BaseController
{
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
            'PageTitle' => 'Member Registration',
        ];
    }
}
