<?php
namespace App;

use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\RequiredFields;

class MemberRegistrationForm extends Form
{
    /**
     * Our constructor only requires the controller and the name of the form
     * method. We'll create the fields and actions in here.
     *
     */
    public function __construct($controller, $name)
    {
        $fields = new FieldList(
            HeaderField::create('Header', 'Step 1. Basics'),
            OptionsetField::create('Type', '', [
                'foo' => 'Search Foo',
                'bar' => 'Search Bar',
                'baz' => 'Search Baz',
            ]),

            CompositeField::create(
                HeaderField::create('Header2', 'Step 2. Advanced '),
                CheckboxSetField::create('Foo', 'Select Option', [
                    'qux' => 'Search Qux',
                ]),

                CheckboxSetField::create('Category', 'Category', [
                    'Foo' => 'Foo',
                    'Bar' => 'Bar',
                ]),

                NumericField::create('Minimum', 'Minimum'),
                NumericField::create('Maximum', 'Maximum')
            )
        );

        $actions = new FieldList(
            FormAction::create('doSearchForm', 'Search')
        );

        $required = new RequiredFields([
            'Type',
        ]);

        // now we create the actual form with our fields and actions defined
        // within this class
        parent::__construct($controller, $name, $fields, $actions, $required);

        // any modifications we need to make to the form.
        $this->setFormMethod('GET');

        $this->addExtraClass('no-action-styles');
        $this->disableSecurityToken();
        $this->loadDataFrom($_REQUEST);
    }
}
