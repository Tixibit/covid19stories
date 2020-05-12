<?php
namespace App;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\ConfirmedPasswordField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;

class MemberRegistrationForm extends Form
{
    /**
     * Our constructor only requires the controller and the name of the form
     * method. We'll create the fields and actions in here.
     *
     */
    public function __construct($controller, $name)
    {
        $fields = FieldList::create(
            TextField::create('Nickname'),
            TextField::create('FirstName', 'First Name'),
            TextField::create('Surname', 'Last Name'),
            EmailField::create('Email'),
            ConfirmedPasswordField::create('Password')
        );

        $actions = new FieldList(
            FormAction::create('doRegister', 'Register')
        );

        $required = new RequiredFields([
            'FirstName', 'Surname', 'Email', 'Password',
        ]);

        // now we create the actual form with our fields and actions defined
        // within this class
        parent::__construct($controller, $name, $fields, $actions, $required);

        // any modifications we need to make to the form.
        $this->setFormMethod('POST');

        $this->addExtraClass('no-action-styles');
        $this->loadDataFrom($_REQUEST);
    }

    /**
     * Do register
     *
     * @param [type] $data
     * @param [type] $form
     * @return void
     */
    public function doRegister($data, $form)
    {
        $data = Convert::raw2sql($data);
        $controller = Controller::curr();
        $member = new Member();

        //check and make sure that a user with this email address doenst already exist
        $checkMemberEmail = $member->memberEmailIsUnique($data['Email']);
        if ($checkMemberEmail) {
            // Add a error message
            $form->sessionMessage('Ops, a user with that email address already exits. Please choose another one', "alert alert-danger");
            return $controller->redirectBack();
        }

        $form->saveInto($member);
        //$member->sendMemberWelcomeMail();
        $member->write();
        //Add this member to the  to tBAccount group and log this member in
        $member->addToGroupByCode("Member");
        //$member->sendMemberWelcomeMail();
        Injector::inst()->get(IdentityStore::class)->logIn($member);

        //also mark this member as has signuped

        $controller->setFlashMessage("success", "Congratulations, Welcome to " . SiteConfig::current_site_config()->Title . ". You now access to this and post your COVID-19 Stories.");
        return $controller->redirect('/');
    }
}
