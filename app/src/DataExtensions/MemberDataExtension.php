<?php
namespace App;

use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;

class MemberDataExtension extends DataExtension
{
    private static $db = [
        'Nickname' => DBVarchar::class,
    ];

    private static $has_many = [
        'COVIDStories' => COVIDStory::class,
    ];

    /**
     * Member Email is unique
     * Check that this members email address is unique
     * @param [type] $email
     * @param boolean $editMode
     * @param string $memberID
     * @return void
     */
    public function memberEmailIsUnique($email, $editMode = false, $memberID = '')
    {
        if ($editMode == false) {
            if (Member::get()->filter('Email', $email)->first()) {
                return true;
            }
            return false;
        } else {
            if (Member::get()->filter('Email', $email)->exclude('ID', $memberID)->first()) {
                return true;
            }
            return false;
        }
    }

    /**
     * Add default records to database. This function is called whenever the
     * database is built, after the database tables have all been created. Overload
     * this to add default records when the database is built, but make sure you
     * call parent::requireDefaultRecords().
     *
     * @uses DataExtension->requireDefaultRecords()
     */
    public function requireDefaultRecords()
    {
        // Add a member group if one does not already exist
        $memberGroup = Group::get()->filter('Code', 'member')->first();
        if (!$memberGroup) {
            $memberGroup = new Group();
            $memberGroup->Code = 'member';
            $memberGroup->Title = 'Members';
            $memberGroup->Sort = 1;
            $memberGroup->write();
            DB::alteration_message('Member Group Created', 'created');
        }
    }
}
