<?php
namespace App;

use BaseController;
use SilverStripe\Control\HTTPRequest;

class SubmitStoryController extends BaseController
{
    /**
     * URL Segment used for links
     */
    public $url_segment = 'tell-your-story';

    private static $allowed_actions = [
        'index',
        'AddCovidStroyForm',
    ];

    protected function init()
    {
        parent::init();
    }

    public function index(HTTPRequest $request)
    {
        return [
            'PageTitle' => 'Tell Your Story',
            'addCovidStroyForm' => $this->AddCovidStroyForm(),
        ];
    }

    /**
     * Register Form
     *
     * @return MemberRegistrationForm
     */
    public function addCovidStroyForm()
    {
        return new AddCovidStroyForm($this, __FUNCTION__);
    }
}
