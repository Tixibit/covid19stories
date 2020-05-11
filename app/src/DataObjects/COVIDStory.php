<?php

namespace App;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Member;

class COVIDStory extends DataObject
{
    /**
     * Human-readable singular name.
     * @var string
     * @config
     */
    private static $singular_name = 'COVID Story';

    /**
     * Human-readable plural name
     * @var string
     * @config
     */
    private static $plural_name = 'COVID Stories';

    /**
     * Override table name for this class. If ignored will default to FQN of class.
     * This option is not inheritable, and must be set on each class.
     * If left blank naming will default to the legacy (3.x) behaviour.
     *
     * @var string
     */
    private static $table_name = 'COVIDStory';

    const TWITTER_STORY_TYPE = 'Twitter';
    const YOUTUBE_STORY_TYPE = 'Youtube';
    const INSTAGRAM_STORY_TYPE = 'Instagram';

    private static $db = [
        'Title' => 'Varchar(255)',
        'DateAdded' => DBDatetime::class,
        'Position' => DBInt::class,
        'Type' => "Enum('Twitter, Youtube, Instagram, OnSite', null)",
        'Content' => DBHTMLText::class,
        'User' => DBVarchar::class,
        'SourceURL' => 'Varchar(255)',
        'ProfilePhotoURL' => 'Varchar(255)',
        'Featured' => 'Boolean(0)',
    ];

    private static $has_one = [
        'Owner' => Member::class,
        'RawCOVIDStory' => RawCOVIDStory::class,
    ];
}
