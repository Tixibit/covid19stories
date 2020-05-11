<?php
namespace App;

use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBVarchar;

class MemberDataExtension extends DataExtension
{
    private static $db = [
        'Nickname' => DBVarchar::class,
    ];

    private static $has_many = [
        'COVIDStories' => COVIDStory::class,
    ];
}
