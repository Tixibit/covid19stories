<?php

namespace App;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;

class MLSearchTerms extends DataObject
{
    /**
     * Human-readable singular name.
     * @var string
     * @config
     */
    private static $singular_name = 'Machine Learning COVID Search Terms';

    /**
     * Human-readable plural name
     * @var string
     * @config
     */
    private static $plural_name = 'Machine Learning COVID Search Termss';

    /**
     * Override table name for this class. If ignored will default to FQN of class.
     * This option is not inheritable, and must be set on each class.
     * If left blank naming will default to the legacy (3.x) behaviour.
     *
     * @var string
     */
    private static $table_name = 'MLSearchTerms';

    private static $db = [
        'Title' => DBVarchar::class,
        'Priority' => DBInt::class,
        'Precision' => DBInt::class,
        'Approved' => 'Boolean(0)',
    ];
}
