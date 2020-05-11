<?php

namespace App;

class COVIDStoryOnSite extends COVIDStory
{
    /**
     * Override table name for this class. If ignored will default to FQN of class.
     * This option is not inheritable, and must be set on each class.
     * If left blank naming will default to the legacy (3.x) behaviour.
     *
     * @var string
     */
    private static $table_name = 'COVIDStoryOnSite';
}
