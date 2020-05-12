<?php
namespace App;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Convert;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class AddCovidStroyForm extends Form
{
    /**
     * Our constructor only requires the controller and the name of the form
     * method. We'll create the fields and actions in here.
     *
     */
    public function __construct($controller, $name)
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            DatetimeField::create('DateAdded', 'Story Date'),
            HiddenField::create('Type', 'Type', 'OnSite'),
            TextareaField::create('Content')
        );

        $actions = new FieldList(
            FormAction::create('doAdd', 'Submit')
        );

        $required = new RequiredFields([
            'Title', 'Type', 'Content',
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
    public function doAdd($data, $form)
    {
        $data = Convert::raw2sql($data);
        $controller = Controller::curr();
        $story = new COVIDStory();

        $form->saveInto($story);
        //$member->sendMemberWelcomeMail();
        $story->write();

        //also mark this member as has signuped

        $controller->setFlashMessage("success", "Congratulations, your COVID-19 Story has been saved.");
        return $controller->redirect('/stories');
    }
}
