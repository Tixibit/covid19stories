<?php
namespace App;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBText;

class RawCOVIDStory extends DataObject
{
    /**
     * Human-readable singular name.
     * @var string
     * @config
     */
    private static $singular_name = 'RAW COVID Story from Social Media API';

    /**
     * Human-readable plural name
     * @var string
     * @config
     */
    private static $plural_name = 'RAW COVID Stories from Social Media API';

    /**
     * Override table name for this class. If ignored will default to FQN of class.
     * This option is not inheritable, and must be set on each class.
     * If left blank naming will default to the legacy (3.x) behaviour.
     *
     * @var string
     */
    private static $table_name = 'RAWCOVIDStory';

    private static $db = [
        'SourceID' => 'Varchar',
        'Type' => "Enum('Twitter, Youtube, Instagram', null)",
        'Data' => DBText::class,
        'Processed' => DBDatetime::class,
    ];

    private static $has_one = [
        'COVIDStory' => COVIDStory::class,
    ];
}
