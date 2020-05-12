<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class MemberRegistrationController extends BaseController
{
    /**
     * URL Segment used for links
     */
    public $url_segment = 'register';

    private static $allowed_actions = [
        'index',
        'registrationForm',
    ];

    protected function init()
    {
        parent::init();
    }

    public function index(HTTPRequest $request)
    {
        return [
            'PageTitle' => 'Member Registration',
            'RegisterationForm' => $this->registrationForm(),
        ];
    }

    /**
     * Register Form
     *
     * @return MemberRegistrationForm
     */
    public function registrationForm()
    {
        return new MemberRegistrationForm($this, __FUNCTION__);
    }
}
